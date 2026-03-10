@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Вход</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" 
                                required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input id="password" type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">
                                    Запомнить меня
                                </label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Войти
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ route('register') }}" class="text-decoration-none">Нет аккаунта?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection