@extends('templates.base',['isAuth' => true])
@section('breadcrumbs', Breadcrumbs::render('submit-ad') )

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12 offset-md-3">
                <div class="form-wrapper">
                    <form action="{{ route('ads.edit.post') }}" method="POST" id="ad-updating-form">
                        <div class="text-center mb-5">
                            <h4>Edit ad</h4>
                        </div>
                            <div id="errors-wrapper">
                                        
                            </div>
                        @if (session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        <div class="form-group">
                            <input type="text" value="{{ $ad->title }}" required name="title" id="title" placeholder="Post title" class="form-control">
                        </div>
                        @if(auth()->check() && auth()->user()->hasRole('admin'))
                            <div class="form-group">
                                <input type="text" value="{{ $ad->slug }}" required name="ad_slug" id="slug" placeholder="Post slug" class="form-control">
                            </div>
                        @endif
                        <div class="form-group">
                            <textarea rows="4" required name="description" id="description" placeholder="Post description"
                                class="form-control">{{ $ad->description }}</textarea>
                        </div>
                        <div class="form-group">
                           <select class="form-control" name="type_id">
                               @foreach ($adTypes as $type)
                                   <option {{ $ad->type_id && $ad->type_id == $type->id ? 'selected' : null }} value="{{ $type->id }}">{{ ucfirst($type->name) }}</option>
                               @endforeach
                           </select>
                        </div>
                        <div class="form-group">
                            <select name="category_id" id="category" class="form-control">
                                @foreach ($categories as $mainCategory)
                                    @if ($mainCategory->children->count() > 0)
                                       <optgroup label="{{ $mainCategory }}">
                                           @foreach ($mainCategory->children as $subCategory)                                            
                                               <option {{ $ad->category_id && $ad->category_id == $subCategory->id || request()->has('cat-slug') && request()->get('cat-slug') == $subCategory->slug ? 'selected' : null }} value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                           @endforeach
                                       </optgroup>
                                    @else
                                       <option {{ $ad->category_id && $ad->category_id == $mainCategory->id || request()->has('cat-slug') && request()->get('cat-slug') == $mainCategory->slug? 'selected' : null }} value="{{ $mainCategory->id }}">{{ $mainCategory->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                           <select class="form-control" name="city_id">
                               @foreach ($regions as $region)
                                   @foreach ($region->cities as $city)
                                       <option {{ $ad->city_id && $ad->city_id == $city->id ? 'selected' : null }} value="{{ $city->id }}">{{ ucfirst($city->name) }}</option>
                                   @endforeach
                               @endforeach
                           </select>
                        </div>
                        <div class="form-group">
                            <input type="email" value="{{ $ad->email }}" required name="email" id="email" placeholder="Enter your email address" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" value="{{ $ad->phone_number }}" name="phone_number" id="phone-number" placeholder="Enter a phone number (Optional)" class="form-control">
                        </div>
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $ad->id }}" name="ad_id">
                        <div id="dropzone" class="dropzone"></div>             
                        <button type="button" id="update-btn" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection