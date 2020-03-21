@extends('templates.base')
@section('breadcrumbs', Breadcrumbs::render('single-category', $category) )

@section('content')
<section class="container">
    @if($category)
        <h5 class="mb-3">Showing {{ strtolower($category->name) }} related ads</h5>
        @if($category->ads->count() > 0)
            <div class="single-category">
                @foreach ($category->ads as $ad)
                    @include('partials.ad', ['ad' => $ad])
                @endforeach
            </div>
        @else
            <p class="text-center mt-5">No ads</p>
        @endif
    @endif
</section>
@endsection