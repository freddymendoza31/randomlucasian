@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Restablecer Contraseña</h2>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <label>Email:</label>
        <input type="email" name="email"  placeholder="Email" required>

        <label>Nueva contraseña:</label>
        <input type="password" name="password" placeholder="Password"  required>
        @error('password')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <label>Confirmar contraseña:</label>
        <input type="password" name="password_confirmation" placeholder="Password"  required>
        @error('password_confirmation')
        <div class="text-danger">{{ $message }}</div>
        @enderror
        <button type="submit">Restablecer contraseña</button>
    </form>
</div>
@endsection
