@extends('admin.layout.main')

@section('seo-title')
<title>{{ __('Create page') }} {{ config('app.seo-separator') }} {{ config('app.name') }}</title>
@endsection

@section('custom-css')

@endsection

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">{{ __('Create new page') }}</h1>
<div class='row'>
    <div class="offset-lg-2 col-lg-8">
        <!-- Basic Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('New page details') }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('pages.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Title *</label>
                        <input type="text" name='title' value='{{ old("title") }}' class="form-control">
                        @if($errors->has('title'))
                        <div class='text text-danger'>
                            {{ $errors->first('title') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Description *</label>
                        <textarea name='description' class="form-control">{{ old('description') }}</textarea>
                        @if($errors->has('description'))
                        <div class='text text-danger'>
                            {{ $errors->first('description') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Image *</label>
                        <input type="file" name='image' class="form-control">
                        @if($errors->has('image'))
                        <div class='text text-danger'>
                            {{ $errors->first('image') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Content *</label>
                        <textarea id='page-content' name='content' class="form-control">{{ old('content') }}</textarea>
                        @if($errors->has('content'))
                        <div class='text text-danger'>
                            {{ $errors->first('content') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Layout *</label>
                        <select name='layout' class="form-control">
                            <option value=''>-- Choose page layout --</option>
                            <option value='fullwidth' {{ (old('layout') == 'fullwidth') ? 'selected':'' }}>Width 100%</option>
                            <option value='leftaside' {{ (old('layout') == 'leftaside') ? 'selected':'' }}>With left sidebar</option>
                            <option value='rightaside' {{ (old('layout') == 'rightaside') ? 'selected':'' }}>With right aside</option>
                        </select>
                        @if($errors->has('layout'))
                        <div class='text text-danger'>
                            {{ $errors->first('layout') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label>Contact form</label>
                        <label><input type="radio" name='contact_form' value='0' {{ (old('contact_form', 0) == 0) ? 'checked':'' }} class="form-control">No</label>
                        <label><input type="radio" name='contact_form' value='1' {{ (old('contact_form', 0) == 1) ? 'checked':'' }} class="form-control">Yes</label>
                        @if($errors->has('contact_form'))
                        <div class='text text-danger'>
                            {{ $errors->first('contact_form') }}
                        </div>
                        @endif
                    </div>
                    <div class="form-group text-right">
                        <button type='submit' class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@section('custom-js')
<script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#page-content' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
@endsection

