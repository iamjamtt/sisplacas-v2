@extends('errors::minimal')

@section('title', 'Error 401 - No autorizado')
@section('code', '401')
@section('icon')
<svg xmlns="http://www.w3.org/2000/svg"
    class="w-24 h-24 text-amber-500 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" width="24"
    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
    stroke-linejoin="round">
    <path d="M12 16h.01"></path>
    <path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20z"></path>
    <path d="m14.9 9.5-5.5 5.5"></path>
    <path d="m9.5 9.5 5.5 5.5"></path>
</svg>
@endsection
@section('message', 'No tienes permiso para acceder a esta página. Por favor, inicia sesión o contacta con el administrador.')
