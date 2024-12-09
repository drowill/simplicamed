@extends('layout.main')

@section('title', 'Acesso - SimplificaMed')

@section('content')

<header>
        <h1>Simplifica Med</h1>
        <nav>
            <a href="#">
                <img src="user-icon.svg" alt="Ícone de usuário">
            </a>
        </nav>

        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <main>
            <form action="{{route('perfil_login')}}" method="POST">
                @csrf
                <h2>Entrar</h2>
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Insira o e-mail">
                </div>
                <div>
                    <label for="password">Senha</label>
                    <input type="password" name="password" placeholder="Insira a senha">
                    <a href="#">Esqueceu a senha?</a>
                </div> 
                <button type="submit">Entrar</button>
            </form>
            
        </main>
    </header>
@endsection