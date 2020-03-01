@extends('templates.base')
@section('breadcrumbs', Breadcrumbs::render('home') )

@section('content')
<section class="container">
        <div class="row">
            @foreach($categories as $mainCategory)
                @if($mainCategory->children->count() > 0 || $mainCategory->ads->count() > 0)
                    <div class="col-md-3">
                        <div class="category-wrapper">
                            <div class="category-header" style="background: {{ $mainCategory->color_hex }}">
                                <h6>{{ $mainCategory->name }}</h6>
                            </div>
                            <div class="category-posts">
                                @if($mainCategory->children->count() > 0)
                                    @foreach($mainCategory->children as $subCategory)
                                        @foreach ($subCategory->ads as $ad)
                                            @include('partials.ad')
                                        @endforeach
                                    @endforeach
                                @else
                                    @foreach ($mainCategory->ads as $ad)
                                        @include('partials.ad')
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>
@endsection