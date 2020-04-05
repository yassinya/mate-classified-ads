@extends('templates.base')
@section('breadcrumbs', Breadcrumbs::render('ad', $ad) )

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if (session()->has('success-msg'))
                    <div class="alert alert-success">
                        {{ session()->get('success-msg') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-sm-12">
                <div class="ad-details">
                    <div class="d-flex mb-1">
                        @if(auth()->check() && auth()->user()->hasRole('admin'))
                            <div>
                                @if (! $ad->confirmed_at)
                                    <span class="text-danger"><i class="fas fa-info"></i> User haven't confirmed this ad</span><br>
                                @endif
                                @if (! $ad->reviewed_at && ! $ad->is_suspended)
                                    <span class="text-info"><i class="fas fa-info"></i> This ad is awaiting review</span><br>
                                @endif
                                @if ($ad->is_suspended == 1)
                                    <span class="text-danger"><i class="fas fa-info"></i> This ad is suspended</span>
                                @endif
                            </div>
                        @endif
                        @if (auth()->check() && auth()->user()->hasRole('admin') || $ad->user_id == auth()->id())
                            <div class="ml-auto">
                                <div class="dropdown ml-2">
                                    <i class="fa fa-ellipsis-v menu-more" data-toggle="dropdown"></i>
                                    <div class="dropdown-menu" aria-labelledby="my-dropdown">
                                        @if (auth()->check() && auth()->user()->hasRole('admin') || $ad->user_id == auth()->id())
                                            <a class="dropdown-item" href="{{ route('ads.edit', ['slug' => $ad->slug]) }}">Edit</a>
                                        @endif
                                        @if (auth()->check() && auth()->user()->hasRole('admin'))
                                            @if (! $ad->reviewed_at && ! $ad->is_suspended)
                                                <button type="button" class="dropdown-item" data-toggle="modal" data-target="#review-modal">Review</button>
                                            @endif

                                            @if ($ad->reviewed_at && ! $ad->is_suspended)
                                                <a href="{{ route('admin.toggle-suspension.ad', ['adId' => $ad->id, 'suspended' => 1]) }}" class="dropdown-item">Suspend</a>
                                            @endif
                                            @if ($ad->reviewed_at && $ad->is_suspended)
                                                <a href="{{ route('admin.toggle-suspension.ad', ['adId' => $ad->id, 'suspended' => 0]) }}" class="dropdown-item">Unsuspend</a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <h2 id="title">{{ $ad->title }}</h2>
                    <div class="images">
                        <div class="slider-for">
                            @foreach ($ad->images as $img)
                                <div><img class="img-fluid" src="{{ asset('storage/images/'.$img->sizes->where('type', 'slider')->first()->name) }}" alt=""></div>
                            @endforeach
                        </div>
                    </div>
                    <div class="content">
                        <p>{{ $ad->description }}</p>
                    </div>
                    <div class="footer d-flex justify-content-start">
                        <div>
                            <span><i class="fas fa-clock"></i> {{ caRelativeDate($ad->created_at) }}</span>
                        </div>
                        <div>
                            <span><i class="fas fa-map"></i> {{ $ad->city->name }}</span>
                        </div>
                        <div>
                            <span><i class="fas fa-envelope"></i> {{ $ad->email }}</span>
                        </div>
                        @if ($ad->phone_number)
                            <div>
                                <span><i class="fas fa-phone"></i> {{ $ad->phone_number }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                @php
                    $similarAds = $ad->category->ads->where('id', '!=', $ad->id);
                @endphp
                @if($similarAds->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold">Similar ads</h6>
                        </div>
                        <div class="card-body">
                            @foreach ($similarAds as $similarAd)
                                <p><a href="{{ route('ads.show.single', ['slug' => $similarAd->slug]) }}">{{ mb_substr($similarAd->title, 0, 100) }} </a> {{ caRelativeDate($similarAd->created_at) }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if (auth()->check() && auth()->user()->hasRole('admin'))
        <div class="modal fade" id="review-modal" tabindex="-1">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Review</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                    <form action="{{ route('admin.review.ad') }}" method="POST">
                        <div class="modal-body">
                            <p>Approve or suspend/reject ad</p>
                            <div class="form-group">
                                <select name="suspend" class="form-control">
                                    <option value="0">Approve</option>
                                    <option value="1">Suspend/Reject</option>
                                </select>
                            </div>         
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" class="form-control" name="ad_id" value="{{ $ad->id }}">                     
                            {{ csrf_field() }}
                            <button type="button" class="btn btn-dedault" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
              </div>
            </div>
        </div>
    @endif
@endsection