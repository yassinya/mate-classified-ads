<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a href="{{ route('admin') }}" class="nav-link">Overview</a></li>
        </ul>
        <ul class="navbar-nav ml-auto">
            @if (auth()->check())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">Go back</a>
            </li>
            <hr>
            <li class="nav-item ">
                <a class="nav-link logout" href="#">Logout</a>
            </li>
            @endif
        </ul>
    </div>
</nav>
