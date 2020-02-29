@extends('templates.base')
@section('breadcrumbs', Breadcrumbs::render('ad', $ad) )

@section('content')
    <h4>{{ $ad->title }}</h4>
@endsection