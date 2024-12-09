@extends('layout.main')

@section('title', 'Cadastro - SimplificaMed')

@section('content')

<header>
            <h1>Pagina de  Cadastro</h1>
            <form action="{{route('perfil_register')}}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Nome">
                <input type="email" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Senha">
                <input type="password" name="password_confirmation" placeholder="Confirme a Senha">
                <button type="submit">Cadastrar</button>
            </form>
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <a href="{{route('login')}}">Já tem uma conta? Faça login!</a>
    </header>

@endsection
