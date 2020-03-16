@extends('templates.base',['isAuth' => true])
@section('breadcrumbs', Breadcrumbs::render('register') )

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12 offset-md-3">
                <div class="form-wrapper">
                    <form action="{{ route('register.post') }}" method="POST">
                        <div class="text-center mb-5">
                            <h4>Create an account</h4>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <i class="fas fa-info"></i> {{ $error }}<br>
                                @endforeach       
                            </div>
                        @endif
                        <div class="form-group">
                            <input type="text" name="first_name" id="first=bame" placeholder="First name" value="{{ old('first_name') }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" name="last_name" id="first=name" placeholder="Last name" value="{{ old('last_name') }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" id="email" placeholder="John.p@example.com" value="{{ old('email') }}" required class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" name="phone_number" id="phone-number" placeholder="Enter a phone number" value="{{ old('phone_number') }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" id="password" placeholder="Password" required class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password_confirmation" id="password-confirmation" placeholder="confirm password" required class="form-control">
                        </div>
                        {{ csrf_field() }}                    
                        <button type="submit" class="btn btn-primary">Sign up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection