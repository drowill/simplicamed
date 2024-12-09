@extends('layout.main')

@section('title', 'profissionals - SimplificaMed')

@section('content')

    <div id="profissional-create-container" class="col-md-6 offsef-md-3">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1>Cadastre um profissional</h1>
        <form action="{{route('cadastrar_profissional')}}" method="POST">
            @csrf

            <!-- Título da profissional -->
            <div class="form-group mb-3">
                <label for="name">Nome</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <!-- Email -->
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>

            <!-- Email -->
            <div class="form-group mb-3">
                <label for="password">Senha</label>
                <input type="password" name="password" class="form-control" placeholder="Senha" required>
            </div>
            
            <!-- Endereço -->
            <div class="form-group mb-3">
                <label for="endereco">Endereço</label>
                <input type="text" name="endereco" class="form-control" value="{{ old('endereco') }}" required>
            </div>

            <!-- CPF -->
            <div class="form-group mb-3">
                <label for="cpf">CPF</label>
                <input type="text" name="cpf" class="form-control" value="{{old('cpf')}}">
                @error('cpf')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Telefone -->
            <div class="form-group mb-3">
                <label for="telefone">Telefone</label>
                
                <input type="text" name="telefone" class="form-control" value="{{ old('telefone') }}">
                @error('telefone')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tipo -->
            <div class="form-group mb-3">
                <label for="tipo">tipo</label>
                
                <input type="text" name="tipo" class="form-control" value="{{ old('tipo') }}">
                @error('tipo')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Botão de submissão -->
            <button type="submit" class="btn btn-primary">Cadastrar profissional</button>
        </form>
    </div>

@endsection