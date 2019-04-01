<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersController extends Controller
{
    
    public function __construct() {
        $this->middleware('auth')->except('login');
        $this->middleware('isadmin')->only(['index', 'create', 'store', 'changestatus', 'delete']);
        $this->middleware('guest')->only('login');
    }
    
    public function index(){
        //$users = User::where('deleted', 0)->where('age', '>', 18)->get();
        
        $users = User::notdeleted()->get();
        
        return view('admin.users.index', compact('users'));
    }
    
    public function login(){
        
        if(request()->isMethod('post')){
            // validacija forme
            request()->validate([
                'email' => 'required|string|email',
                'password' => 'required'
            ]);
            // proba logovanja
            if(Auth::attempt([
                'email' => request('email'),
                'password' => request('password'),
                'active' => 1,
                'deleted' => 0
            ])){
                // TRUE - redirect na welcome ili tamo gde je hteo da ode ranije
                return redirect()->intended( route('users.welcome') );
            }else{ 
                // FALSE - redirect back sa greskom da je los email ili lozinka
                return redirect( route('users.login') )
                        ->withErrors(['email' => trans('auth.failed')])
                        ->withInput(['email' => request('email')]);
            }
        }
            
        
        return view('admin.users.login');
    }
    
    public function welcome(){
        
        return view('admin.users.welcome');
    }
    
    public function create(){
        
        return view('admin.users.create');
    }
    
    public function store(){
        //validacija
        $data = request()->validate([
            'name' => 'required|string|min:3|max:191',
            'email' => 'required|string|email|unique:users|max:191',
            'password' => 'required|string|min:5|max:191|confirmed',
            'role' => 'required|string|in:administrator,moderator',
            'phone' => 'nullable|string|min:5|max:191',
            'address' => 'nullable|string|min:5|max:191',
        ]);
        
        // dopuna $data
        $data['active'] = 1;
        $data['password'] = Hash::make($data['password']);
        
        User::create($data);
        
        
        session()->flash('message-type', 'success');
        session()->flash('message-text', 'Successfully created user!!!');
        
        return redirect()->route('users.index');
    }
    
    public function edit(User $user){
        $this->chechPrivilegies($user);
        
        return view('admin.users.edit', compact('user'));
    }
    
    public function update(User $user){
        $this->chechPrivilegies($user);
        
        //validacija
        request()->validate([
            'name' => 'required|string|min:3|max:191',
            'role' => 'required|string|in:administrator,moderator',
            'phone' => 'nullable|string|min:5|max:191',
            'address' => 'nullable|string|min:5|max:191',
        ]);
        
        $user->name = request()->name;
        
        $user->phone = request()->phone;
        $user->address = request()->address;
        
        if(auth()->user()->role == User::ADMINISTRATOR){
            $user->role = request()->role;
        }
        
        $user->save();
        
        if(auth()->user()->role == User::ADMINISTRATOR){
            return redirect()->route('users.index');
        } else {
            return redirect()->route('users.welcome');
        }
        
        
    }
    
    public function changestatus(User $user){
        if($user->active == 1){
            $user->active = 0;
        } else {
            $user->active = 1;
        }
        
        $user->save();
        
        session()->flash('message-type', 'success');
        session()->flash('message-text', 'Successfully changed status for user ' . $user->name . '!!!');
        
        return redirect()->route('users.index');
        
    }
    
    public function changepassword(User $user){
        $this->chechPrivilegies($user);
        
        if(request()->isMethod('post')){
            // only on form submit
            request()->validate([
                'password' => 'required|string|min:5|max:191|confirmed'
            ]);
            
            $user->password = Hash::make(request('password'));
            
            $user->save();
            
            session()->flash('message-type', 'success');
            session()->flash('message-text', 'Successfully changed password!!!');
        
            
            if(auth()->user()->role == User::ADMINISTRATOR){
                return redirect()->route('users.index');
            } else {
                return back();
            }
            
        }
        
        return view('admin.users.changepassword', compact('user'));
    }
    
    public function delete(User $user){
        
        // hard delete
        //$user->delete();
        
        // soft delete
        $user->deleted = 1;
        $user->deleted_by = auth()->user()->id;
        $user->save();
        
        return redirect()->route('users.index');
    }
    
    public function logout(){
        // uradi logout
        Auth::logout();
        
        // nakon toga uradi redirect tamo gde zeli vlasnik portala
        return redirect()->route('users.login')->withErrors(['message' => 'Thank you, come again!!!']);
    }
    
    protected function chechPrivilegies(User $user){
        if(auth()->user()->role == User::MODERATOR  && auth()->id() != $user->id){
            abort(403, 'Unauthorized action.');
        }
    }
}
