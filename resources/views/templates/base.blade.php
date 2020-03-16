<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex" />
    <title>@yield('title', 'Fastest Classifieds in Slovenia') - {{ env('APP_NAME') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">

</head>

<body>
    @include('partials.header')
    <div class="container">
        <div class="row breadcrumb">
            <div class="col-12">
                @yield('breadcrumbs')
            </div>
        </div>
    </div>
    <div class="container d-md-none mb-5">
        <a href="{{ route('ads.create') }}" class="btn btn-outline"> <i class="fas fa-plus"></i> Post</a>
        <button class="btn btn-outline" id="filter-ads-btn"><i class="fas fa-filter"></i> Filter</button>
        <form class="filter-ads">
            <div class="form-group">
                <label for="region">Region</label>
                <select name="region" class="form-control" id="region-selector">
                    <option {{ request()->has('region') && request()->region == 'all' ? 'selected' : null }} value="all">All Region</option>
                    @foreach ($regions as $region)
                        <option {{ request()->has('region') && request()->region == $region->slug ? 'selected' : null }} value="{{ $region->slug }}">{{ ucfirst($region->name) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="city-selector">City</label>
                <select name="city" class="form-control" id="city-selector" disabled>
                    <option {{ request()->has('city') && request()->city == 'all' ? 'selected' : null }} data-region="all" value="all">All cities</option>
                    @foreach ($regions as $region)
                        @foreach ($region->cities as $city)
                            <option class="cities" {{ request()->has('city') && request()->city == $city->slug ? 'selected' : null }} data-region="{{ $region->slug }}" value="{{ $city->slug }}">{{ ucfirst($city->name) }}</option>
                        @endforeach
                    @endforeach
                </select>
            </div>
            <span id="cities-container" style="visibility: hidden; position:absolute;"></span>
            <button class="btn btn-primary" type="submit">Filter</button>
            <a class="btn btn-default" href="{{ url()->current() }}">Reset</a>
        </form>
    </div>
    @if(! isset($isAuth))
        <section class="container mt-5 mb-5">
            <div class="row filters">
                <div class="col-md-8 col-sm-12 align-self-center d-none d-md-block">
                    <p> *Stats* Today (32) Yesterday (125) Last week (1277)</p>
                </div>
                <div class="col-md-4 col-sm-12">
                    <form action="">
                        <div class="form-group">
                            <select id="category-filter" class="form-control">
                                <option value="-">All categories</option>
                                @foreach ($categories as $mainCategory)
                                    @if (count($mainCategory->children) > 0)
                                        @if (count($mainCategory->children) > 0)
                                            <optgroup label="{{ $mainCategory->name }}">
                                                @foreach ($mainCategory->children as $subCategory)
                                                    <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                                @endforeach                                        
                                            </optgroup>
                                        @endif 
                                    @else
                                        <option value="{{ $mainCategory->id }}">{{ $mainCategory->name }}</option>
                                    @endif    
                                @endforeach 
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    @endif
    @yield('content')
    @include('partials.footer')

    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
