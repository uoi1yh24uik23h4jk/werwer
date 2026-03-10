@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Заголовок --}}
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2">Каталог аккаунтов</h1>
        </div>
    </div>

    {{-- Фильтры --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                       
                        <div class="col-md-2">
                            <input type="number" name="min_price" class="form-control" placeholder="Мин. цена" value="{{ request('min_price') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="max_price" class="form-control" placeholder="Макс. цена" value="{{ request('max_price') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="release_date" class="form-control" placeholder="Дата выхода" value="{{ request('release_date') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="rating" class="form-select">
                                <option value="">Рейтинг</option>
                                @for($i=1; $i<=5; $i++)
                                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }}+</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" type="submit">Применить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Сетка игр --}}
    <div class="row">
        @foreach($games as $game)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                <div style="height: 200px; overflow: hidden; background-color: #f8f9fa;">
                    <img src="{{ asset('public/img/' . ($game->cover_image ?? 'phon.png')) }}" 
                         class="card-img-top" 
                         alt="{{ $game->title }}"
                         style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $game->title }}</h5>
                    <p class="card-text mb-1">{{ $game->genre ?? 'Без жанра' }}</p>
                    <p class="card-text mb-1"><strong>{{ number_format($game->price, 2) }} ₽</strong></p>
                    <p class="card-text mb-2"><small class="text-muted">{{ $game->release_date->format('d.m.Y') }}</small></p>
                    <a href="{{ route('games.show', $game) }}" class="btn btn-outline-primary w-100">Подробнее</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Пагинация --}}
    @if ($games->hasPages())
    <div class="row mt-4">
        <div class="col-12">
            <nav>
                <ul class="pagination justify-content-center">
                    {{-- Previous Page Link --}}
                    @if ($games->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">«</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $games->previousPageUrl() }}" rel="prev">«</a></li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($games->getUrlRange(1, $games->lastPage()) as $page => $url)
                        @if ($page == $games->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($games->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $games->nextPageUrl() }}" rel="next">»</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">»</span></li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
    @endif
</div>
@endsection