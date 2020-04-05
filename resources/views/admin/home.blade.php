@extends('templates.admin')

@section('content')
    <div class="container">
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
        </div>
    </div>
@endsection