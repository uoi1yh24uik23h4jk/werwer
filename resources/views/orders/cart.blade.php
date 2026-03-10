@extends('layouts.app')

@section('content')
<div class="container py-5" style="background-color: #ffffff;">
    <h2 class="text-center mb-5 text-primary fw-bold">Моя Корзина</h2>

    {{-- Сообщения --}}
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    {{-- Проверка наличия товаров --}}
    @if($cartItems->count())
        <div class="card shadow-sm border-0 rounded-3 mb-4">
            <div class="card-body p-4">
                @foreach($cartItems as $item)
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('public/img/' . $item->game->cover_image) }}" alt="{{ $item->game->title }}" class="rounded" style="width: 100px; height: auto; object-fit: cover;">
                            <div class="ms-3">
                                <h5 class="mb-1 fw-semibold text-dark">{{ $item->game->title }}</h5>
                                <p class="mb-0 text-muted">Цена: ${{ number_format($item->game->price, 2) }}</p>
                            </div>
                        </div>
                        <div class="text-center mx-3" style="width: 120px;">
                            <span class="fw-semibold fs-5">{{ $item->quantity }}</span>
                        </div>
                        <div class="text-end me-4" style="width: 140px;">
                            <h5 class="mb-0 text-dark">${{ number_format($item->game->price * $item->quantity, 2) }}</h5>
                        </div>
                        <form action="{{ route('orders.remove', $item->id) }}" method="POST" onsubmit="return confirm('Удалить этот товар?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm" title="Удалить">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                    <hr>
                @endforeach
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <h4 class="fw-bold mb-0 text-dark">Общая сумма:</h4>
                    <h3 class="text-primary fw-bold">${{ number_format($total, 2) }}</h3>
                </div>
            </div>
        </div>

        {{-- Кнопка оформления заказа --}}
        <div class="d-flex justify-content-end">
            <form action="{{ route('orders.checkout') }}" method="POST">
                @csrf
                <button class="btn btn-success btn-lg px-5 py-3 fw-semibold hover-scale" type="submit">
                    Оформить заказ
                </button>
            </form>
        </div>
    @else
        {{-- Пустая корзина --}}
        <div class="d-flex flex-column align-items-center justify-content-center p-5 bg-light rounded-3 shadow-sm text-center">
            <h3 class="mb-3 text-secondary fw-semibold">Ваша корзина пуста</h3>
            <p class="mb-4 text-muted">Добавьте аккаунты, чтобы оформить заказ</p>
            <a href="{{ route('games.index') }}" class="btn btn-primary btn-lg fw-semibold px-4 py-2">Перейти к аккаунтам</a>
        </div>
    @endif
</div>

{{-- Эффекты при наведении --}}
<style>
.hover-scale {
    transition: transform 0.3s ease;
}
.hover-scale:hover {
    transform: scale(1.05);
}
</style>
@endsection