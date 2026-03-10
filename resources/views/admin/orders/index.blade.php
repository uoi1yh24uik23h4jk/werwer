@extends('layouts.admin')

@section('title', 'Управление заказами')
@section('header', 'Заказы')

@section('content')
<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Фильтры -->
        <div class="row mb-4">
            <div class="col-md-12">
                <form action="{{ route('admin.orders.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="user" class="form-control" placeholder="Поиск по пользователю" value="{{ request('user') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="min_price" class="form-control" placeholder="Мин. сумма" value="{{ request('min_price') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="max_price" class="form-control" placeholder="Макс. сумма" value="{{ request('max_price') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_from" class="form-control" placeholder="Дата от" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="date_to" class="form-control" placeholder="Дата до" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Статистика заказов -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6 class="card-title">Всего заказов</h6>
                        <h3 class="mb-0">{{ $orders->total() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6 class="card-title">Общая выручка</h6>
                        <h3 class="mb-0">{{ number_format($orders->sum('total'), 0, '.', ' ') }} ₽</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h6 class="card-title">Средний чек</h6>
                        <h3 class="mb-0">{{ $orders->count() > 0 ? number_format($orders->sum('total') / $orders->count(), 0, '.', ' ') : 0 }} ₽</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h6 class="card-title">За сегодня</h6>
                        <h3 class="mb-0">{{ $ordersToday ?? 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Таблица заказов -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Пользователь</th>
                        <th>Email</th>
                        <th>Сумма</th>
                        <th>Товаров</th>
                        <th>Дата заказа</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>
                            {{ $order->user->name ?? 'Неизвестно' }}
                            <br>
                            <small class="text-muted">ID: {{ $order->user_id }}</small>
                        </td>
                        <td>{{ $order->user->email ?? '—' }}</td>
                        <td>
                            <span class="fw-bold text-success">
                                {{ number_format($order->total, 0, '.', ' ') }} ₽
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-info">
                                {{ $order->items_count ?? $order->items->count() }} шт.
                            </span>
                        </td>
                        <td>
                            {{ $order->created_at->format('d.m.Y H:i') }}
                            <br>
                            <small class="text-muted">{{ $order->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.orders.show', $order) }}" 
                                   class="btn btn-sm btn-info" 
                                   title="Просмотр">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <form action="{{ route('admin.orders.destroy', $order) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Вы уверены, что хотите удалить заказ #{{ $order->id }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Удалить">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-cart-x" style="font-size: 3rem;"></i>
                            <h4 class="mt-3">Заказов пока нет</h4>
                            <p class="text-muted">Когда пользователи начнут оформлять заказы, они появятся здесь</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Пагинация -->
        @if($orders->hasPages())
        <div class="mt-4 d-flex justify-content-center">
            {{ $orders->withQueryString()->links() }}
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
.card {
    border: none;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}
</style>
@endsection