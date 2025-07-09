@extends('errors::minimal')

@section('title', 'Error 500 - Error del servidor')
@section('code', '500')
@section('icon')
<svg xmlns="http://www.w3.org/2000/svg"
    class="w-24 h-24 text-red-500 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" width="24"
    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
    stroke-linejoin="round">
    <rect width="20" height="8" x="2" y="2" rx="2" ry="2"></rect>
    <rect width="20" height="8" x="2" y="14" rx="2" ry="2"></rect>
    <line x1="6" x2="6.01" y1="6" y2="6"></line>
    <line x1="6" x2="6.01" y1="18" y2="18"></line>
</svg>
@endsection
@section('message', 'Ha ocurrido un error en el servidor. Estamos trabajando para solucionarlo. Por favor, inténtalo de nuevo más tarde.')
