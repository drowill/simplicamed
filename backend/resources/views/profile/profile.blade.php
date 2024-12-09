@extends('layout.main')

@section('title', 'Perfil - SimplificaMed')

@section('content')
<div class="container mt-5">
    <h2>Perfil do Usuário</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nome -->
        <div class="form-group mb-3">
            <label for="name">Nome</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- CPF -->
        <div class="form-group mb-3">
            <label for="cpf">CPF</label>
            @if (auth()->user()->cpf)
                <input type="text" name="cpf" class="form-control" value="{{auth()->user()->cpf}}">
            @else
                <input type="text" name="cpf" class="form-control" value="{{ old('cpf', auth()->user()->cpf) }}">
                @error('cpf')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            @endif
        </div>

        <!-- Data de Nascimento -->
        <div class="form-group mb-3">
            <label for="data_nascimento">Data de Nascimento</label>
            
            <input type="date" name="data_nascimento" class="form-control" value="{{ old('data_nascimento', auth()->user()->data_nascimento) }}">
            @error('data_nascimento')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            
        </div>

        <!-- Endereço -->
        <div class="form-group mb-3">
            <label for="endereco">Endereço</label>
            
            <input type="text" name="endereco" class="form-control" value="{{ old('endereco', auth()->user()->endereco) }}">
            @error('endereco')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            
        </div>

        <!-- Telefone -->
        <div class="form-group mb-3">
            <label for="telefone">Telefone</label>
            
            <input type="text" name="telefone" class="form-control" value="{{ old('telefone', auth()->user()->telefone) }}">
            @error('telefone')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            
        </div>

        <!-- Botão para atualizar -->
        <button type="submit" class="btn btn-primary">Atualizar Perfil</button>
    </form>
</div>
@endsection
