<nav class="navbar navbar-expand-lg navbar-light bg-light d-md-none">
        <a class="navbar-brand" href="{{ route('home') }}">{{ env('APP_NAME') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
              @if (auth()->check())
                  <li class="nav-item active">
                    <a class="nav-link" href="{{ route('account.ads') }}">My ads</a>
                    <a class="nav-link" href="{{ route('admin') }}">Dashboard</a>
                    <hr>
                    <a class="nav-link logout" href="#">Logout</a>
                  </li>
              @else
                  <li class="nav-item active">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                    <a class="nav-link" href="{{ route('register') }}">Sign up</a>
                  </li>
              @endif
          </ul>
        </div>
      </nav>
<section class="container d-none d-md-block">
    <div class="row header">
        <div class="col-md-2 brand d-none d-md-block">
            <a href="{{ route('home') }}"><h5>{{ env('APP_NAME') }}</h5></a>
            <span>Prodam kot bi prdnil</span>
        </div>
        <div class="text-center col-md-7">
            <ul class="justify-content-center nav nav-pills mb-2">
                <li class="nav-item">
                    <a class="nav-link {{ request()->has('region') && request()->region == 'all' ? 'active ' : null}}" href="{{ request()->fullUrlWithQuery(['region' => 'all', 'city' => 'all']) }}">All regions</a>
                </li>
                @foreach ($regions as $region)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->has('region') && request()->region == $region->slug ? 'active ' : null}}" href="{{ request()->fullUrlWithQuery(['region' => $region->slug, 'city' => 'all']) }}">{{ ucfirst($region->name) }}</a>
                    </li>
                @endforeach

            </ul>
            <hr>
            <ul class="justify-content-center nav nav-pills ">
                <li class="nav-item">
                    <a class="nav-link {{ request()->has('city') && request()->city == 'all' ? 'active ' : null}}" href="{{ request()->fullUrlWithQuery(['city' => 'all']) }}">All cities</a>
                </li>
                @foreach ($regions as $region)
                    @foreach ($region->cities as $city)
                        @if (request()->has('region') && request()->region == $region->slug)
                            <li class="nav-item">
                                <a class="nav-link {{ request()->has('city') && request()->city == $city->slug ? 'active ' : null}}" href="{{ request()->fullUrlWithQuery(['city' => $city->slug]) }}">{{ ucfirst($city->name) }}</a>
                            </li>
                        @endif
                    @endforeach
                @endforeach
            </ul>
        </div>
        <div class="col-md-3 trailing  d-none d-md-block">
            <span>Fastest Classifieds in Slovenia</span>
            <span class="d-block mb-1"><strong>42,646</strong> ads, <strong>2,738</strong> images</span>
            @if (isset($category))
                <a href="{{ route('ads.create', ['cat-slug' => $category->slug]) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus-square"></i> Post your ad</a>
            @else
                <a href="{{ route('ads.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus-square"></i> Post your ad</a>
            @endif
            @if (auth()->check())
                <div class="dropdown d-inline ml-2">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>{{ ucfirst(auth()->user()->first_name) }}</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('account.ads') }}">My ads</a>
                        @if (auth()->user()->hasRole('admin'))
                            <a class="dropdown-item" href="{{ route('admin') }}">Dashboard</a>
                        @endif
                        <hr>
                        <a class="dropdown-item logout" href="#">Logout</a>
                    </div>
                </div>
            @else                
                <p class="d-inline"> | <a href="{{ route('login') }}">login</a> or <a href="{{ route('register') }}">Register</a></p>
            @endif
        </div>
    </div>
</section>

