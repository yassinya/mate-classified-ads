<nav class="navbar navbar-expand-lg navbar-dark bg-primary d-md-none ">
    <a class="navbar-brand" href="#">{{ env('APP_NAME') }}</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="">Sign in</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="">Sign up</a>
            </li>
        </ul>
    </div>
</nav>
<section class="container">
    <div class="row header">
        <div class="col-md-2 brand d-none d-md-block">
            <h5>PRDEC</h5>
            <span>Prodam kot bi prdnil</span>
        </div>
        <div class="text-center col-md-7">
            <ul class="justify-content-center nav nav-pills mb-2">
                <li class="nav-item">
                    <a class="nav-link" href="#">All regions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#">Stajerska</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Gorenjska</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Koroska</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Savinjska</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Podravska</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Primorska</a>
                </li>
            </ul>
            <ul class="justify-content-center nav nav-pills ">
                <li class="nav-item">
                    <a class="nav-link active" href="#">All cities</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Velenje</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Celje</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Mozirje</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Sostanj</a>
                </li>
            </ul>
        </div>
        <div class="col-md-3 trailing  d-none d-md-block">
            <span>Fastest Classifieds in Slovenia</span>
            <span class="d-block mb-1"><strong>42,646</strong> ads, <strong>2,738</strong> images</span>
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#post-ad-modal">
            <i class="fas fa-plus-square"></i> Post your ad</button>
            @if (auth()->check())
                <div class="dropdown d-inline ml-2">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>{{ ucfirst(auth()->user()->first_name) }}</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a id="logout" class="dropdown-item" href="#">Logout</a>
                    </div>
                </div>
            @else                
                <p class="d-inline"> | <a href="#" data-toggle="modal" data-target="#login-modal">login</a> or <a href="#" data-toggle="modal" data-target="#register-modal">Register</a></p>
            @endif
        </div>
    </div>
</section>
