@extends('default')
@section('title', 'Connexion')

@php
    $routes = [
        'register' => route('register'),
        'password_request' => route('password.request'),
    ];
@endphp

@section('main-content')
    <login-form :routes="{{ json_encode($routes) }}" :csrf_token="'{{ csrf_token() }}'" :old-values="{{ json_encode(count(old()) ? old() : new stdClass()) }}"></login-form>
@endsection
