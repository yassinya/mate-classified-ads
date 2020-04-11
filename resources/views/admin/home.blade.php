@extends('templates.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-4">
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="card-text text-xs text-uppercase text-bold mb-1">New users ({{ date('F') }})</div>
                    <h4 class="mb-0">{{ $numberOfCurrentMonthSignUps }}</h4>
                </div>
            </div>
        </div>
        <div class="col-4">
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="card-text text-xs text-uppercase text-bold mb-1">Number of submitted ads ({{ date('F') }})</div>
                    <h4 class="mb-0">{{ $numberOfCurrentMonthAds }}</h4>
                </div>
            </div>
        </div>
        <div class="col-4">
            <!-- Card -->
            <div class="card">
                <div class="card-body">
                    <div class="card-text text-xs text-uppercase text-bold mb-1">Number of uploaded images ({{ date('F') }})</div>
                    <h4 class="mb-0">{{ $numberOfCurrentImgs }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="card-columns">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Pending ads</h5>
                    @if ($pendingAds->count() > 0)
                    @foreach ($pendingAds as $ad)
                    <p class="card-text">
                        <a href="{{ route('ads.show.single', ['slug' => $ad->slug]) }}">{{ $ad->title }}</a>
                        <br>
                        <i class="fas fa-clock"></i> {{ $ad->created_at->diffForHumans() }}
                    </p>
                    @endforeach
                    @else
                    <p class="card-text">There are no pending ads</p>
                    @endif

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Latest sign ups</h5>
                    @if ($users->count() > 0)
                    @foreach ($users as $user)
                    <p class="card-text">
                        {{ $user->first_name }} created an account
                        {{ $user->created_at->diffForHumans() }}
                    </p>
                    @endforeach
                    @else
                    <p class="card-text">There are no sign ups</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
