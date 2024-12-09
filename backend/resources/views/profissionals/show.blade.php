@extends('layout.main')

@section('title', 'Detalhes da/do profissional')

@section('content')

<div class="container mt-5">
    <h2>Detalhes da profissional</h2>

    <div class="card">
        <div class="card-header">
            <h3>{{ $profissional->title }}</h3>
        </div>
        <div class="card-body">
            <p><strong>Nome do/da Profisisonal</strong> {{ $profissional->name }}</p>
            <p><strong>Especialização:</strong> {{ $profissional->tipo }}</p>
            <p><strong>Endereço:</strong> {{ $profissional->endereco }}</p>
            <p><strong>CPF:</strong> {{ $profissional->cpf }}</p>
            <p><strong>Telefone:</strong> {{ $profissional->telefone }}</p>
        </div>
    
    </div>
            
    <!-- Botão de voltar -->
    <a href="{{url()->previous()}}" class="btn btn-primary mt-3">Voltar</a>
    <form id="deleteForm" action="{{ route('deletar_profissional', $profissional->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Deletar</button>
    </form>
</div>

@endsection
