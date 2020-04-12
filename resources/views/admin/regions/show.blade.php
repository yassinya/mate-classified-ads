@extends('templates.admin')

@section('content')
<div class="container">
    <div class="mb-4 d-flex justify-content-between">
        <div>
            <h1>Manage regions</h1>
            <h4>{{ ucfirst($region->name) }}</h4>
        </div>
        <div>
            <a href="{{ route('admin.regions.update', ['id' => $region->id]) }}" class="btn btn-primary">Edit</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5>Cities under {{ ucfirst($region->name) }} region</h5>
                    @if (count($region->cities) > 0)
                    <div class="just-padding">
                        <div class="list-group list-group-root">
                            @foreach ($region->cities as $city)
                            <a href="{{ route('admin.cities.update', ['id' => $city->id]) }}"
                                class="list-group-item list-group-item-action">
                                <strong>{{ $city->name }} </strong>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="text-center">
                        <strong>There are no cities</strong>
                        <p><i>You haven't added any city to {{ ucfirst($region->name) }} yet</i></p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5>Add a new city for {{ ucfirst($region->name) }}</h5>
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
                    <form method="POST" action="{{ route('admin.cities.create.submit') }}">
                        <div class="form-group">
                            <label for="city_name">Name</label>
                            <input type="text" class="form-control" id="city_name" name="city_name"
                                placeholder="City name"
                                required>
                        </div>
                        {{ csrf_field() }}
                        <input type="hidden" name="region_id" value="{{ $region->id }}">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
