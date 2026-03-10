@extends('layouts.app')

@section('content')
    {{-- Темная эффектная hero секция --}}
    <section class="dark-hero d-flex align-items-center justify-content-center text-center py-5" style="background: linear-gradient(135deg, #0f2027, #203a43, #2c5364); min-height: 700px;">
        <div class="container px-4">
            <h1 class="display-2 fw-bold mb-4 text-white">Создай свой уникальный аккаунт</h1>
            <p class="lead mb-4 text-white-75">Покупай готовые аккаунты с историей или создавай свои с нуля. Быстрый старт — уже сегодня!</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('games.index') }}" class="btn btn-outline-light btn-lg px-4 py-3 fw-semibold rounded-pill shadow-lg">Купить аккаунт</a>
                <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4 py-3 fw-semibold rounded-pill shadow-lg">Создать аккаунт</a>
            </div>
        </div>
    </section>

    {{-- Темная секция преимуществ --}}
    <section class="py-5 bg-dark text-white">
        <div class="container text-center">
            <h2 class="fw-bold mb-5">Почему выбирают нас?</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-md-3">
                    <div class="card bg-secondary border-0 rounded-4 p-4 h-100 hover-zoom">
                        <div class="mb-3">
                            <div class="display-4 mb-3">🚀</div>
                        </div>
                        <h5 class="fw-semibold mb-2">Мгновенная доставка</h5>
                        <p class="text-muted">Получайте аккаунты сразу после оплаты, без задержек.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-secondary border-0 rounded-4 p-4 h-100 hover-zoom">
                        <div class="mb-3">
                            <div class="display-4 mb-3">🛡️</div>
                        </div>
                        <h5 class="fw-semibold mb-2">Безопасность</h5>
                        <p class="text-muted">Гарантируем безопасность сделок и защиту покупателя.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-secondary border-0 rounded-4 p-4 h-100 hover-zoom">
                        <div class="mb-3">
                            <div class="display-4 mb-3">💎</div>
                        </div>
                        <h5 class="fw-semibold mb-2">Лучшие аккаунты</h5>
                        <p class="text-muted">Проверенные, уникальные предметы, история и достижения.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Темная секция с популярными аккаунтами --}}
    <section class="py-5 bg-dark">
        <div class="container">
            <h2 class="text-center fw-bold mb-5 text-white">Обзор популярных аккаунтов</h2>
            <div class="row g-4">
                @php
                    $accounts = App\Models\Game::take(6)->get();
                @endphp

                @foreach($accounts as $account)
                <div class="col-md-4">
                    <div class="card bg-secondary text-white border-0 rounded-4 shadow hover-zoom2 h-100">
                        <div class="overflow-hidden rounded-top" style="height: 250px;">
                            <img src="{{ asset('public/img/' . ($account->cover_image ?? 'phon.png')) }}" class="img-fluid w-100 h-100 object-fit-cover" alt="{{ $account->name }}">
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between p-4">
                            <div>
                                <h5 class="card-title mb-3">{{ $account->name }}</h5>
                                <p class="mb-3 fs-6">Уровень: {{ rand(10, 100) }} | Достижения: {{ rand(1, 50) }}</p>
                                <p class="text-warning fw-semibold fs-5">{{ number_format($account->price, 2) }} ₽</p>
                            </div>
                            <a href="{{ route('games.show', $account) }}" class="btn btn-primary btn-sm fw-semibold mt-3">Подробнее</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('games.index') }}" class="btn btn-outline-light btn-lg px-5">Посмотреть все аккаунты</a>
            </div>
        </div>
    </section>
@endsection

{{-- Стиль для темной темы и эффектов --}}
<style>
.dark-hero {
    background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
    min-height: 700px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.hover-zoom {
    transition: transform 0.3s ease;
}
.hover-zoom:hover {
    transform: scale(1.05);
}
.hover-zoom2 {
    transition: transform 0.3s ease;
}
.hover-zoom2:hover {
    transform: translateY(-10px) scale(1.02);
}
</style>