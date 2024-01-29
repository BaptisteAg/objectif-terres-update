@extends('default')

@section('title', 'Accueil')

@section('head-script')
@endsection


@section('main-content')
    <advanced-search :productions="{{$productionGenres}}" :regions="{{ $regionsWithAll }}"></advanced-search>
@endsection
