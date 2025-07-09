@extends('errors::minimal')

@section('title', 'Error 429 - Demasiadas solicitudes')
@section('code', '429')
@section('icon')
<svg xmlns="http://www.w3.org/2000/svg"
    class="w-24 h-24 text-amber-500 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" width="24"
    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
    stroke-linejoin="round">
    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
    <path d="M12 9v4"></path>
    <path d="M12 17h.01"></path>
</svg>
@endsection
@section('message', 'Has realizado demasiadas solicitudes en poco tiempo. Por favor, espera un momento antes de intentarlo de nuevo.')
