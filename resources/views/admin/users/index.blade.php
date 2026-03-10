@extends('layouts.admin')

@section('title', 'Управление пользователями')
@section('header', 'Пользователи')

@section('content')
<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Роль</th>
                    <th>Заказов</th>
                    <th>Дата регистрации</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role == 'admin')
                            <span class="badge bg-danger">Администратор</span>
                        @elseif($user->role == 'manager')
                            <span class="badge bg-warning">Менеджер</span>
                        @else
                            <span class="badge bg-secondary">Клиент</span>
                        @endif
                    </td>
                    <td>{{ $user->orders_count ?? 0 }}</td>
                    <td>{{ $user->created_at->format('d.m.Y') }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil"></i> Редактировать
                        </a>
                        
                        @if(auth()->id() != $user->id)
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Вы уверены?')">
                                <i class="bi bi-trash"></i> Удалить
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection