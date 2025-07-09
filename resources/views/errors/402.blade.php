@extends('errors::minimal')

@section('title', 'Error 402 - Pago requerido')
@section('code', '402')
@section('icon')
<svg xmlns="http://www.w3.org/2000/svg"
    class="w-24 h-24 text-amber-500 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" width="24"
    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
    stroke-linejoin="round">
    <rect width="20" height="14" x="2" y="5" rx="2"></rect>
    <line x1="2" x2="22" y1="10" y2="10"></line>
</svg>
@endsection
@section('message', 'Se requiere un pago para acceder a este contenido o servicio. Por favor, actualiza tu suscripción.')
