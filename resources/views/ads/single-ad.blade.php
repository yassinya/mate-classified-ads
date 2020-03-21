@extends('templates.base')
@section('breadcrumbs', Breadcrumbs::render('ad', $ad) )

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-sm-12">
                <div class="ad-details">
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
@endsection