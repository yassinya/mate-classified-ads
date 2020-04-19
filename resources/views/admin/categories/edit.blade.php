@extends('templates.admin')

@section('content')
<div class="container">
    <h1 class="h3 mb-4 text-gray-800">Manage categories</h1>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5>Edit Category</h5>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    @if (\Session::has('success'))   
                        <div class="alert alert-success">
                            {{ \Session::get('success') }}   
                        </div>  
                    @endif
                    <form method="POST" action="{{ route('admin.categories.update.submit') }}">
                        <div class="form-group">
                            <label for="category_name">Name</label>
                            <input type="text" class="form-control" id="category_name" name="category_name"
                                placeholder="Iphone"
                                required
                                value="{{ $category->name }}">
                        </div>
                        <div class="form-group">
                            <label for="category_color">Color</label>
                            <input type="color" class="form-control" id="category_color" name="category_color"
                                placeholder="#ffffff"
                                required
                                value="{{ $category->color_hex }}">
                        </div>
                        <div class="form-group">
                            <label for="parent">Parent category</label>
                            <select class="form-control" id="parent" name="parent_id">
                                <option value="-" selected>Not under any category</option>
                                @foreach ($categories as $mainCategory)
                                    @if ($category->id !== $mainCategory->id)
                                    <option {{ $category->parent_id == $mainCategory->id ? 'selected' : null }} value="{{ $mainCategory->id }}">{{ $mainCategory->name }}</option>  
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        {{ csrf_field() }}
                        <input type="hidden" name="category_id" value="{{ $category->id }}">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-modal" >Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('admin.categories.delete', ['id' => $category->id]) }}" method="POST">
                <div class="modal-body">
                    <p>Do you really want to delete {{ $category->name }} category?</p>
                </div>
                <div class="modal-footer">
                    {{ csrf_field() }}
                    <input type="hidden" name="category_id" value="{{ $category->id }}">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" >Confirm</a>
                </div>
            </form>
          </div>
        </div>
    </div>
@endsection
