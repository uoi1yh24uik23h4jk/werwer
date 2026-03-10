@extends('layouts.admin')

@section('title', 'Управление играми')
@section('header', 'Игры')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.games.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Добавить игру
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Жанр</th>
                    <th>Цена</th>
                    <th>Рейтинг</th>
                    <th>Отзывов</th>
                    <th>Дата выхода</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @forelse($games as $game)
                <tr>
                    <td>{{ $game->id }}</td>
                    <td>{{ $game->title }}</td>
                    <td>{{ $game->genre }}</td>
                    <td>{{ number_format($game->price, 0, '.', ' ') }} ₽</td>
                    <td>
                        @if($game->rating)
                            {{ $game->rating }}/10
                        @else
                            <span class="text-muted">Нет</span>
                        @endif
                    </td>
                    <td>{{ $game->reviews_count ?? 0 }}</td>
                    <td>{{ $game->release_date ? $game->release_date->format('d.m.Y') : 'Не указана' }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.games.edit', $game) }}" class="btn btn-sm btn-primary" title="Редактировать">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.games.destroy', $game) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Удалить" 
                                        onclick="return confirm('Вы уверены, что хотите удалить игру {{ $game->title }}?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <i class="bi bi-controller" style="font-size: 3rem;"></i>
                        <p class="mt-2">Игр пока нет</p>
                        <a href="{{ route('admin.games.create') }}" class="btn btn-primary">Добавить первую игру</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        @if($games->hasPages())
        <div class="mt-3 d-flex justify-content-center">
            {{ $games->links() }}
        </div>
        @endif
    </div>
</div>

<style>
.btn-group .btn {
    margin: 0 2px;
}
.table td {
    vertical-align: middle;
}
</style>
@endsection