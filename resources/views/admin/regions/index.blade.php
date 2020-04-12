@extends('templates.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Manage regions</h1>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5>All regions</h5>
                    @if (count($regions) > 0)
                    <div class="just-padding">
                        <div class="list-group list-group-root">
                            @foreach ($regions as $region)
                            <a href="{{ route('admin.regions.show', ['id' => $region->id]) }}"
                                class="list-group-item list-group-item-action">
                                <strong>{{ $region->name }} </strong>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="text-center">
                        <strong>There are no regions</strong>
                        <p><i>You haven't added any region yet</i></p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5>Add a new region</h5>
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
                    <form method="POST" action="{{ route('admin.regions.create.submit') }}">
                        <div class="form-group">
                            <label for="region_name">Name</label>
                            <input type="text" class="form-control" id="region_name" name="region_name"
                                placeholder="Region name"
                                required>
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
