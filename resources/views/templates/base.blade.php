<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <section class="container mt-5">
        <div class="row filters">
            <div class="col-md-8 col-sm-12 align-self-center">
                <p> *Stats* Today (32) Yesterday (125) Last week (1277)</p>
            </div>
            <div class="col-md-4 col-sm-12">
                <form action="" class="form-inline">
                    <div class="form-group">
                        <label for="category-filter" class="mr-1">Catrgories </label>
                        <select id="category-filter" class="form-control">
                            <option value="-">All categories</option>
                            <optgroup label="Electronics">
                                <option value="volvo">Samsungs Phones</option>
                                <option value="saab">Iphones</option>
                            </optgroup>
                            <optgroup label="German Cars">
                                <option value="mercedes">Mercedes</option>
                                <option value="audi">Audi</option>
                            </optgroup>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </section>
    @yield('content')
    @include('partials.ad-creation-modal')
    @include('partials.register-modal')
    @include('partials.footer')

    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
