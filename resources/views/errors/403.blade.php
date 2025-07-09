@extends('errors::minimal')

@section('title', 'Error 403 - Acceso prohibido')
@section('code', '403')
@section('icon')
<svg xmlns="http://www.w3.org/2000/svg"
    class="w-24 h-24 text-red-500 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" width="24"
    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
    stroke-linejoin="round">
    <circle cx="12" cy="12" r="10"></circle>
    <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
</svg>
@endsection
@section('message', $exception->getMessage() ?: 'No tienes permiso para acceder a este recurso. Contacta con el administrador si crees que esto es un error.')
