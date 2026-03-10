@extends('layouts.app')

@section('content')
<div class="container-fluid py-5" style="background-color: #0d0d0d;">
    <div class="container my-4">
        {{-- Хлебные крошки --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-transparent p-0 mb-3">
                <li class="breadcrumb-item"><a href="{{ route('games.index') }}" class="text-success fw-semibold">Каталог аккаунтов</a></li>
                <li class="breadcrumb-item active text-white fw-semibold" aria-current="page">{{ $game->name ?? 'Аккаунт' }}</li>
            </ol>
        </nav>

        {{-- Основной блок — изображение и описание под ним --}}
        <div class="bg-dark rounded-4 shadow-lg overflow-hidden">
            {{-- Изображение --}}
            <div class="w-100" style="max-height: 700px;">
                <img src="{{ asset('public/img/' . ($game->cover_image ?? 'phon.png')) }}" 
                     alt="{{ $game->name }}" 
                     class="w-100 object-fit-cover object-position-center transition-transform hover-zoom">
            </div>
            {{-- Описание и информация под изображением --}}
            <div class="p-4 text-white position-relative" style="background-color: #222;">
                <h1 class="display-3 fw-bold mb-3">{{ $game->name ?? 'Аккаунт' }}</h1>
                <p class="lead mb-4 text-muted">{{ $game->genre ?? 'Без жанра' }} | Рейтинг: {{ $game->rating ?? 'N/A' }}/5</p>
                <div class="mb-4">
                    <span class="display-4 fw-bold text-success">{{ number_format($game->price, 2) }} ₽</span>
                </div>
                <div class="mb-4">
                    <h5 class="fw-semibold mb-2">Дата выхода</h5>
                    <p>{{ $game->release_date->format('d.m.Y') }}</p>
                </div>
                @if($game->description)
                <div class="mb-4">
                    <h5 class="fw-semibold mb-2">Описание</h5>
                    <p>{{ $game->description }}</p>
                </div>
                @endif
                {{-- Кнопка покупки --}}
                @auth
                <form action="{{ route('orders.add', $game->id) }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 py-3 fs-5 fw-semibold rounded-3 shadow hover-scale">Добавить в корзину</button>
                </form>
                @else
                <div class="alert alert-info text-center rounded-3 mt-4">
                    <a href="{{ route('login') }}" class="text-success fw-semibold">Войдите</a> или 
                    <a href="{{ route('register') }}" class="text-success fw-semibold">зарегистрируйтесь</a>, чтобы купить
                </div>
                @endauth
            </div>
        </div>

        {{-- Блок отзывов --}}
        <div class="mt-5 bg-dark rounded-4 p-4 shadow-lg text-white">
            <h3 class="fw-bold mb-4">Отзывы покупателей</h3>
            {{-- Сообщения --}}
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Отзыв от пользователя --}}
            @auth
            @php
                $canReview = auth()->user()->orders()->whereHas('items', function($q) use ($game) {
                    $q->where('game_id', $game->id);
                })->exists();
            @endphp

            @if($canReview)
            <form action="{{ route('reviews.store', $game->id) }}" method="POST" class="mb-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Ваш отзыв</label>
                    <textarea name="content" class="form-control bg-secondary text-white rounded-3" rows="4" placeholder="Напишите, что вы думаете об игре...">{{ old('content') }}</textarea>
                    @error('content')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-success fw-semibold px-4 py-2 rounded-3 hover-zoom">Оставить отзыв</button>
            </form>
            @else
            <div class="mb-3 text-muted">Вы можете оставить отзыв только после покупки аккаунта</div>
            @endif
            @endauth

            {{-- Список отзывов --}}
            @if($game->reviews->count())
            @foreach($game->reviews as $review)
            <div class="review p-3 mb-3 bg-secondary rounded-3 border border-muted">
                <div class="d-flex justify-content-between mb-2">
                    <strong>{{ $review->user->name }}</strong>
                    <small class="text-muted">{{ $review->created_at->format('d.m.Y H:i') }}</small>
                </div>
                <p class="mb-0">{{ $review->content }}</p>
            </div>
            @endforeach
            @else
            <div class="text-center py-4 text-muted">Пока нет отзывов. Будьте первым, кто оставит отзыв!</div>
            @endif
        </div>
    </div>
</div>

{{-- Эффекты и стили --}}
<style>
/* Масштаб при наведении на изображение */
.transition-transform {
    transition: transform 0.3s ease;
}
.hover-zoom:hover {
    transform: scale(1.05);
}
/* Масштаб для кнопок при наведении */
.hover-scale:hover {
    transform: scale(1.02);
}
</style>
@endsection