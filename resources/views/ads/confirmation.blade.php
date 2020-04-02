@extends('templates.base',['isAuth' => true])
@section('breadcrumbs', Breadcrumbs::render('ad-confirmation') )

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-12 offset-md-3">
                <div class="text-center">
                    {{ $msg }}
                </div>
            </div>
        </div>
    </div>
@endsection