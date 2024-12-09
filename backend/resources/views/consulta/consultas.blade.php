@extends('layout.main')

@section('title', 'Consultas - SimplificaMed')

@section('content')

    <div id="consulta-create-container" class="col-md-6 offsef-md-3">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1>Crie sua Consulta</h1>
        <form action="{{route('agenda')}}" method="POST">
            @csrf

            <!-- Título da consulta -->
            <div class="form-group mb-3">
                <label for="title">Título da Consulta</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <!-- Nome do paciente -->
            <div class="form-group mb-3">
                <label for="name">Nome do Paciente</label>
                <input type="text" name="name" class="form-control" value="{{Auth::user()->name}}" required disabled>
            </div>

            <!-- Idade -->
            <div class="form-group mb-3">
                <label for="idade">Idade</label>
                <input type="number" name="idade" class="form-control" value="{{old('idade')}}" required>
            </div>

            <!-- Endereço -->
            <div class="form-group mb-3">
                <label for="endereco">Endereço</label>
                @if(Auth::user()->endereco)
                    <input type="text" name="endereco" class="form-control" value="{{ Auth::user()->endereco }}" disabled>
                @else
                    <input type="text" name="endereco" class="form-control" value="Endereço de usuário não cadastrado" disabled>
                @endif
            </div>

            <!-- Descrição -->
            <div class="form-group mb-3">
                <label for="descricao">Descrição da Consulta</label>
                <textarea name="descricao" class="form-control" rows="5" required></textarea>
            </div>

            <!-- Data da Consulta -->
            <div class="form-group mb-3">
                <label for="data">Data da Consulta</label>
                <input type="date" name="data" class="form-control" required>
            </div>

            <!-- Horário da Consulta -->
            <div class="form-group mb-3">
                <label for="horario">Horário da Consulta</label>
                <input type="time" name="horario" class="form-control" required>
            </div>

            <!-- Botão de submissão -->
            <button type="submit" class="btn btn-primary">Cadastrar Consulta</button>
        </form>
    </div>

@endsection