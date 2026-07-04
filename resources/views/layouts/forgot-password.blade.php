@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Recuperar Contraseña</h2>

    @if (session('status'))
        <div>{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <label>Email:</label>
        <input type="email" name="email" required>
        <button type="submit">Enviar enlace de recuperación</button>
    </form>
</div>
@endsection
