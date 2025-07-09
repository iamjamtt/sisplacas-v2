@extends('errors::minimal')

@section('title', 'Error 419 - Sesión expirada')
@section('code', '419')
@section('icon')
<svg xmlns="http://www.w3.org/2000/svg"
    class="w-24 h-24 text-amber-500 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" width="24"
    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
    stroke-linejoin="round">
    <circle cx="12" cy="12" r="10"></circle>
    <polyline points="12 6 12 12 16 14"></polyline>
</svg>
@endsection
@section('message', 'Tu sesión ha expirado. Por favor, vuelve a iniciar sesión para continuar.')
