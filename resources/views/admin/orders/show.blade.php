@extends('layouts.admin')

@section('title', 'Заказ #' . $order->id)
@section('header', 'Детали заказа #' . $order->id)

@section('content')
<div class="row">
    <div class="col-md-8">
        <!-- Информация о заказе -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Состав заказа</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Товар</th>
                            <th>Количество</th>
                            <th>Цена</th>
                            <th>Сумма</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->game->title ?? 'Неизвестно' }}</strong>
                                @if($item->game)
                                <br>
                                <small class="text-muted">{{ $item->game->genre }}</small>
                                @endif
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 0, '.', ' ') }} ₽</td>
                            <td class="fw-bold">{{ number_format($item->price * $item->quantity, 0, '.', ' ') }} ₽</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-dark">
                        <tr>
                            <td colspan="3" class="text-end"><strong>Итого:</strong></td>
                            <td><strong>{{ number_format($order->total, 0, '.', ' ') }} ₽</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Информация о покупателе -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Покупатель</h5>
            </div>
            <div class="card-body">
                <p><strong>Имя:</strong> {{ $order->user->name ?? 'Неизвестно' }}</p>
                <p><strong>Email:</strong> {{ $order->user->email ?? '—' }}</p>
                <p><strong>ID пользователя:</strong> {{ $order->user_id }}</p>
                <p><strong>Роль:</strong> 
                    @if($order->user)
                        <span class="badge bg-{{ $order->user->role == 'admin' ? 'danger' : ($order->user->role == 'manager' ? 'warning' : 'secondary') }}">
                            {{ $order->user->role }}
                        </span>
                    @else
                        <span class="badge bg-secondary">Неизвестно</span>
                    @endif
                </p>
            </div>
        </div>
        
        <!-- Детали заказа -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Детали заказа</h5>
            </div>
            <div class="card-body">
                <p><strong>Дата заказа:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                <p><strong>Обновлен:</strong> {{ $order->updated_at->format('d.m.Y H:i') }}</p>
                <p><strong>Количество товаров:</strong> {{ $order->items->sum('quantity') }}</p>
                <p><strong>Уникальных товаров:</strong> {{ $order->items->count() }}</p>
            </div>
        </div>
        
        <!-- Действия -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Действия</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary w-100 mb-2">
                    <i class="bi bi-arrow-left"></i> Назад к списку
                </a>
                
                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100" 
                            onclick="return confirm('Вы уверены, что хотите удалить заказ #{{ $order->id }}?')">
                        <i class="bi bi-trash"></i> Удалить заказ
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection