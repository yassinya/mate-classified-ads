@extends('templates.base')
@section('breadcrumbs', Breadcrumbs::render('home') )

@section('content')
<section class="container">
    @if($categoriesWithAds->count() > 0)
        <div class="grid">
            @foreach($categoriesWithAds as $mainCategory)
                @if($mainCategory->childrenAds->count() > 0 || $mainCategory->ads->count())
                    <div class="grid-item">
                        <div class="category-wrapper">
                            <div class="category-header" style="background: {{ $mainCategory->color_hex }}">
                                <a href="{{ route('categories.show.single', ['slug' => $mainCategory->slug]) }}"><h6>{{ $mainCategory->name }}</h6></a>
                            </div>
                            <div class="category-posts">
                                @foreach ($mainCategory->childrenAds as $ad)
                                    @include('partials.ad', ['ad' => $ad])
                                @endforeach
                                @foreach ($mainCategory->ads as $ad)
                                    @include('partials.ad', ['ad' => $ad])
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <p class="text-center">No ads</p>
    @endif
</section>
<img src="" alt="" id="thumb-preview">
@endsection