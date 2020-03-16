@extends('templates.base',['isAuth' => true])
@section('breadcrumbs', Breadcrumbs::render('login') )

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12 offset-md-3">
                <div class="form-wrapper">
                    <form action="{{ route('login.post') }}" method="POST">
                        <div class="text-center mb-5">
                            <h4>Login to your account</h4>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <i class="fas fa-info"></i> {{ $error }}<br>
                                @endforeach       
                            </div>
                        @endif
                        <div class="form-group">
                            <input type="email" name="email" id="email" placeholder="John.p@example.com" value="{{ old('email') }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" id="password" placeholder="Password" required class="form-control">
                        </div>
                        {{ csrf_field() }}                    
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection