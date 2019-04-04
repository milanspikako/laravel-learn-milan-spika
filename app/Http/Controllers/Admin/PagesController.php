<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Page;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Page $page)
    {
        if(empty($page->id)) {
         $rows = Page::notdeleted()->toplevel()->get();   
        } else {
         $rows = Page::notdeleted()->customlevel($page->id)->get();     
        }
        
        
        return view('admin.pages.index', compact('rows','page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pagesTopLevel = Page::topLevel()
                ->notdeleted()
                ->get();
        return view('admin.pages.create', compact('pagesTopLevel'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pagesIds = Page::pluck('id')->all();
        $pagesIds[] = 0;
        $pagesIds = implode(",", $pagesIds);
        $data = request()->validate([
            'page_id' => 'required|integer|in:'.$pagesIds,
            'title' => 'required|string|min:3|max:191',
            'description' => 'required|string|max:191',
            'image' => 'required|image|mimes:jpeg,bmp,png,jpg',
            'content' => 'required|string|min:3|max:65000',
            'layout' => 'required|string|in:fullwidth,leftaside,rightaside',
            'contact_form' => 'required|boolean',
            'header' => 'required|boolean',
            'aside' => 'required|boolean',
            'footer' => 'required|boolean',
            'active' => 'required|boolean',
        ]);
        
        $row = new Page();
        
        unset($data['image']);
        foreach ($data as $key => $value) {
            $row->$key = $value;
        }
        
        $row->image = "";
        // provera da li uopste dolazi 'image' kroz request
        if(request()->has('image')){
            $file = request()->image;
            $fileExtension = $file->getClientOriginalExtension();
            
            $fileName = $file->getClientOriginalName();
            $fileName = pathinfo($fileName, PATHINFO_FILENAME);
            $fileName = config('app.seo-image-prefiks') . Str::slug(request('title'), '-') . '-' . Str::slug(now(), '-') . '.' . $fileExtension;
            
            //echo public_path('/upload/images/');
            $file->move(public_path('/upload/images/'), $fileName);
            
            $row->image = '/upload/images/' . $fileName;
            
            // intervetion
            // xl velicina
            $intervetionImage = Image::make(public_path('/upload/images/').$fileName);
            $intervetionImage->resize(1140, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $fileNameXL = '/upload/images/' . config('app.seo-image-prefiks') . Str::slug(request('title'), '-') . '-' . Str::slug(now(), '-') . '-xl.' . $fileExtension;
            $intervetionImage->save(public_path($fileNameXL));
            
            // m velicina
            $intervetionImage = Image::make(public_path('/upload/images/').$fileName);
            $intervetionImage->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $fileNameM = '/upload/images/' . config('app.seo-image-prefiks') . Str::slug(request('title'), '-') . '-' . Str::slug(now(), '-') . '-m.' . $fileExtension;
            $intervetionImage->save(public_path($fileNameM));
            
            // s velicina
            $intervetionImage = Image::make(public_path('/upload/images/').$fileName);
            $intervetionImage->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $fileNameS = '/upload/images/' . config('app.seo-image-prefiks') . Str::slug(request('title'), '-') . '-' . Str::slug(now(), '-') . '-s.' . $fileExtension;
            $intervetionImage->save(public_path($fileNameS));
        }
        
        $row->save();
        
        session()->flash('message-type', 'success');
        session()->flash('message-text', 'Successfully created page' . $row->title . '!!!');
        
        return redirect()->route('pages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
                $pagesTopLevel = Page::topLevel()
                ->notdeleted()
                ->notthisid($page->id)
                ->get();
             
        return view('admin.pages.edit', compact('pagesTopLevel','page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
         $pagesIds = Page::pluck('id')->where('id', '!=', $page->id)->all();
        $pagesIds[] = 0;
        $pagesIds = implode(",", $pagesIds);
        $data = request()->validate([
            'page_id' => 'required|integer|in:'.$pagesIds,
            'title' => 'required|string|min:3|max:191',
            'description' => 'required|string|max:191',
            'image' => 'image|mimes:jpeg,bmp,png,jpg',
            'content' => 'required|string|min:3|max:65000',
            'layout' => 'required|string|in:fullwidth,leftaside,rightaside',
            'contact_form' => 'required|boolean',
            'header' => 'required|boolean',
            'aside' => 'required|boolean',
            'footer' => 'required|boolean',
            'active' => 'required|boolean',
        ]);

        
        unset($data['image']);
        foreach ($data as $key => $value) {
            $page->$key = $value;
        }
        //slika ostaje ista
        
        // provera da li uopste dolazi 'image' kroz request
        //ako dolazi menja se slika
        if(request()->has('image')){
            $file = request()->image;
            $fileExtension = $file->getClientOriginalExtension();
            
            $fileName = $file->getClientOriginalName();
            $fileName = pathinfo($fileName, PATHINFO_FILENAME);
            $fileName = config('app.seo-image-prefiks') . Str::slug(request('title'), '-') . '-' . Str::slug(now(), '-') . '.' . $fileExtension;
            
            //echo public_path('/upload/images/');
            $file->move(public_path('/upload/images/'), $fileName);
            
            $page->image = '/upload/images/' . $fileName;
            
            // intervetion
            // xl velicina
            $intervetionImage = Image::make(public_path('/upload/images/').$fileName);
            $intervetionImage->resize(1140, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $fileNameXL = '/upload/images/' . config('app.seo-image-prefiks') . Str::slug(request('title'), '-') . '-' . Str::slug(now(), '-') . '-xl.' . $fileExtension;
            $intervetionImage->save(public_path($fileNameXL));
            
            // m velicina
            $intervetionImage = Image::make(public_path('/upload/images/').$fileName);
            $intervetionImage->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $fileNameM = '/upload/images/' . config('app.seo-image-prefiks') . Str::slug(request('title'), '-') . '-' . Str::slug(now(), '-') . '-m.' . $fileExtension;
            $intervetionImage->save(public_path($fileNameM));
            
            // s velicina
            $intervetionImage = Image::make(public_path('/upload/images/').$fileName);
            $intervetionImage->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $fileNameS = '/upload/images/' . config('app.seo-image-prefiks') . Str::slug(request('title'), '-') . '-' . Str::slug(now(), '-') . '-s.' . $fileExtension;
            $intervetionImage->save(public_path($fileNameS));
        }
        
        $page->save();
        
        session()->flash('message-type', 'success');
        session()->flash('message-text', 'Successfully edited page to ' . $page->title . '!!!');
        
        return redirect()->route('pages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Page $page)
    {
   
        
        $page->deleted = 1;
        $page->deleted_at = now();
        $page->save();
        return redirect()->route('pages.index');
    }
}
