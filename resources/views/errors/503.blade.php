@extends('errors::minimal')

@section('title', 'Error 503 - Servicio no disponible')
@section('code', '503')
@section('icon')
<svg xmlns="http://www.w3.org/2000/svg"
    class="w-24 h-24 text-red-500 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" width="24"
    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
    stroke-linejoin="round">
    <path d="M5 12.55a11 11 0 0 1 14.08 0"></path>
    <path d="M1.42 9a16 16 0 0 1 21.16 0"></path>
    <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path>
    <line x1="12" y1="20" x2="12.01" y2="20"></line>
</svg>
@endsection
@section('message', 'El servicio está temporalmente no disponible o en mantenimiento. Por favor, inténtalo de nuevo más tarde.')
