@extends('layout.main')

@section('title', 'Editar Consulta')

@section('content')

<div class="container mt-5">
    <h2>Editar Consulta</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('update_consulta', $consulta->id) }}" method="post">
        @csrf

        <div class="form-group mb-3">
            <label for="title">Título</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $consulta->title) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="idade">Idade</label>
            <input type="number" name="idade" class="form-control" value="{{ old('idade', $consulta->idade) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="endereco">Endereço</label>
            <input type="text" name="endereco" class="form-control" value="{{ old('endereco', $consulta->user->endereco) }}">
        </div>

        <div class="form-group mb-3">
            <label for="descricao">Descrição</label>
            <textarea name="descricao" class="form-control">{{ old('descricao', $consulta->descricao) }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="data">Data da Consulta</label>
            <input type="date" name="data" class="form-control" value="{{ old('data', $consulta->data) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="horario">Horário da Consulta</label>
            <input type="time" name="horario" class="form-control" value="{{ old('horario', $consulta->horario) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
            @if ($consulta->status == 1)
                <option value="1" selected>Pendente</option>
                <option value="4">Cancelar consulta</option>
            @else
                @if ($consulta->status == 2)
                    <option value="2" selected>Confirmado</option>
                @elseif ($consulta->status == 3)
                    <option value="3" selected>Rejeitado</option>
                @elseif ($consulta->status == 4)
                    <option value="4" selected>Consulta cancelada</option>
                @elseif ($consulta->status == 5)
                    <option value="5" selected>Finalizado</option>
                @elseif ($consulta->status == 6)
                    <option value="6" selected>Cliente ausente</option>
                @endif
            @endif
            </select>
        </div>
        @if ($consulta->status == 1)
            <button type="submit" class="btn btn-primary">Atualizar Consulta</button>
        @endif
    </form>
    <a href="{{ route('consultas') }}" class="btn btn-secondary">Voltar</a>
</div>

@endsection
