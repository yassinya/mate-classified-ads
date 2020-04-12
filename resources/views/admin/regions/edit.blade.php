@extends('templates.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Manage regions</h1>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5>Edit region</h5>
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
                    <form method="POST" action="{{ route('admin.regions.update.submit') }}">
                        <div class="form-group">
                            <label for="region_name">Name</label>
                            <input type="text" class="form-control" id="region_name" name="region_name"
                                placeholder="Iphone"
                                required
                                value="{{ $region->name }}">
                        </div>
                        {{ csrf_field() }}
                        <input type="hidden" name="region_id" value="{{ $region->id }}">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-modal" >Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" >Delete</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('admin.regions.delete', ['id' => $region->id]) }}" method="POST">
                <div class="modal-body">
                    <p>Do you really want to delete {{ $region->name }} region?</p>
                </div>
                <div class="modal-footer">
                    {{ csrf_field() }}
                    <input type="hidden" name="region_id" value="{{ $region->id }}">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" >Confirm</a>
                </div>
            </form>
          </div>
        </div>
    </div>
@endsection
