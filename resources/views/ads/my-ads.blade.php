@extends('templates.base')
@section('breadcrumbs', Breadcrumbs::render('my-ads') )

@section('content')
<section class="container">
    <h5 class="mb-3">My ads</h5>
    <ul class="nav nav-pills mb-2">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#approved-ads">Approved</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pending-ads">Pending</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#suspended-ads">Suspended</a></li>
    </ul>

    <div class="tab-content">
        <div id="approved-ads" class="tab-pane fade in show active">
            @if($approvedAds)
                @if($approvedAds->count() > 0)
                    <div class="single-category">
                        @foreach ($approvedAds as $ad)
                            @include('partials.ad', ['ad' => $ad])
                        @endforeach
                    </div>
                @else
                    <p class="text-center mt-5">You have no approved ads</p>
                @endif
            @endif
        </div>
        <div id="pending-ads" class="tab-pane fade in">
            @if($pendingAds)
                @if($pendingAds->count() > 0)
                    <div class="single-category">
                        @foreach ($pendingAds as $ad)
                            @include('partials.ad', ['ad' => $ad])
                        @endforeach
                    </div>
                @else
                    <p class="text-center mt-5">You have no pending ads</p>
                @endif
            @endif
        </div>
        <div id="suspended-ads" class="tab-pane fade in">
            @if($suspendedAds)
                @if($suspendedAds->count() > 0)
                    <div class="single-category">
                        @foreach ($suspendedAds as $ad)
                            @include('partials.ad', ['ad' => $ad])
                        @endforeach
                    </div>
                @else
                    <p class="text-center mt-5">You have no suspended or rejected ads</p>
                @endif
            @endif
        </div>
    </div>
</section>
<img src="" alt="" id="thumb-preview">
@endsection
