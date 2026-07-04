@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Restablecer Contraseña</h2>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Nueva contraseña:</label>
        <input type="password" name="password" required>

        <label>Confirmar contraseña:</label>
        <input type="password" name="password_confirmation" required>

        <button type="submit">Restablecer contraseña</button>
    </form>
</div>
@endsection
