@extends('templates.admin')

@section('content')
<div class="container">
    <h1>Settings</h1>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5 class="mb-4">Update settings</h5>
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
                    <form method="POST" action="{{ route('admin.settings.update.submit') }}">
                        <div class="form-group">
                            <label for="ad_revision">
                                <input type="checkbox" id="ad_revision" name="require_ads_revision"
                                placeholder="Iphone"
                                value="{{ $setting->require_ads_revision }}"
                                {{ $setting->require_ads_revision ? 'checked' : null }}>
                                Require manual revision for ads
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="ad_max_image_upload">Max image upload per ad</label>
                            <input type="number" class="form-control" id="ad_max_image_upload" name="ad_max_img_upload"
                            placeholder="Iphone"
                            required
                            value="{{ $setting->ad_max_img_upload }}">
                        </div>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
