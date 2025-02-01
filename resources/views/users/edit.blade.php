@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Editar Usuário</h1>

    <!-- Formulário para editar nome e e-mail -->
    <form action="{{ route('users.update', $user) }}" method="POST" class="mb-4">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>

    <!-- Formulário para atualizar a função (role) -->
    <form action="{{ route('users.updateRole', $user->id) }}" method="POST" class="mb-4">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="role" class="form-label">Função</label>
            <select name="role" class="form-select" required>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="bibliotecario" {{ $user->role == 'bibliotecario' ? 'selected' : '' }}>Bibliotecário</option>
                <option value="cliente" {{ $user->role == 'cliente' ? 'selected' : '' }}>Cliente</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar Função</button>
    </form>
</div>
@endsection