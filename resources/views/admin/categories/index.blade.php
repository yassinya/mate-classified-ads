@extends('templates.admin')

@section('content')
<div class="container">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Manage categories</h1>
    <!-- DataTales Example -->
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5>All categories</h5>
                    @if (count($categories) > 0)
                    <div class="just-padding">
                        <div class="list-group list-group-root">
                            @foreach ($categories as $category)
                            <a href="{{ route('admin.categories.update', ['id' => $category->id]) }}"
                                class="list-group-item list-group-item-action">
                                <strong>{{ $category->name }} </strong>
                            </a>

                            <div class="list-group">
                                @foreach ($category->children as $subcategory)
                                <a href="{{ route('admin.categories.update', ['id' => $subcategory->id]) }}"
                                    class="list-group-item list-group-item-action">
                                    {{ $subcategory->name }}
                                </a>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="text-center">
                        <strong>There are no categories</strong>
                        <p><i>You haven't added any category yet</i></p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5>Add a new Category</h5>
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
                    <form method="POST" action="{{ route('admin.categories.create.submit') }}">
                        <div class="form-group">
                            <label for="category_name">Name</label>
                            <input type="text" class="form-control" id="category_name" name="category_name"
                                placeholder="Iphone"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="category_color">Color</label>
                            <input type="text" class="form-control" id="category_color" name="category_color"
                                placeholder="#ffffff"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="parent">Parent category</label>
                            <select class="form-control" id="parent" name="parent_id">
                                <option value="-" selected>Not under any category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
