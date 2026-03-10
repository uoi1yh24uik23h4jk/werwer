@extends('layouts.admin')  {{-- Изменено с admin.layouts.admin на layouts.admin --}}

@section('title', 'Дашборд')
@section('header', 'Панель управления')

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Пользователи</h5>
                <h2>{{ $stats['users_count'] ?? 0 }}</h2>
            </div>
        </div>
    </div>
    <!-- остальной код -->
</div>
@endsection