@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">История заказов</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($orders->count())
        @foreach($orders as $order)
            <div class="card mb-3">
                <div class="card-header">
                    Заказ #{{ $order->id }} | Дата: {{ $order->created_at->format('d.m.Y H:i') }} | Сумма: ${{ number_format($order->total, 2) }}
                </div>
                <ul class="list-group list-group-flush">
                    @foreach($order->items as $item)
                        <li class="list-group-item">
                            {{ $item->game->title }} — ${{ number_format($item->game->price, 2) }} × {{ $item->quantity }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    @else
        <p>Вы еще не делали заказов.</p>
        <a href="{{ route('games.index') }}" class="btn btn-primary">Перейти к играм</a>
    @endif
</div>
@endsection