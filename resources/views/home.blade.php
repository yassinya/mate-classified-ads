@extends('templates.base')
@section('breadcrumbs', Breadcrumbs::render('home') )

@section('content')
<section class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="category-wrapper">
                    <div class="category-header" style="background: #43a047">
                        <h6>Fashion</h6>
                    </div>
                    <div class="category-posts">
                        @for ($i = 0; $i < 3; $i++)
                            @include('partials.ad')
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection