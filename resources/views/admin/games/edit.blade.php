@extends('layouts.admin')

@section('title', 'Редактирование игры')
@section('header', 'Редактирование: ' . $game->title)

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.games.update', $game) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="title" class="form-label">Название аккаунта <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('title') is-invalid @enderror" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $game->title) }}" 
                           required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="genre" class="form-label">Жанр <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('genre') is-invalid @enderror" 
                           id="genre" 
                           name="genre" 
                           value="{{ old('genre', $game->genre) }}" 
                           required>
                    @error('genre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Описание <span class="text-danger">*</span></label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" 
                          name="description" 
                          rows="5" 
                          required>{{ old('description', $game->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="price" class="form-label">Цена (₽) <span class="text-danger">*</span></label>
                    <input type="number" 
                           step="0.01" 
                           min="0" 
                           class="form-control @error('price') is-invalid @enderror" 
                           id="price" 
                           name="price" 
                           value="{{ old('price', $game->price) }}" 
                           required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="rating" class="form-label">Рейтинг (0-10)</label>
                    <input type="number" 
                           step="0.1" 
                           min="0" 
                           max="10" 
                           class="form-control @error('rating') is-invalid @enderror" 
                           id="rating" 
                           name="rating" 
                           value="{{ old('rating', $game->rating) }}">
                    <small class="text-muted">Необязательное поле</small>
                    @error('rating')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="release_date" class="form-label">Дата выхода <span class="text-danger">*</span></label>
                    <input type="date" 
                           class="form-control @error('release_date') is-invalid @enderror" 
                           id="release_date" 
                           name="release_date" 
                           value="{{ old('release_date', $game->release_date ? $game->release_date->format('Y-m-d') : '') }}" 
                           required>
                    @error('release_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Сохранить изменения
                </button>
                <a href="{{ route('admin.games.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Отмена
                </a>
            </div>
        </form>
    </div>
</div>
@endsection