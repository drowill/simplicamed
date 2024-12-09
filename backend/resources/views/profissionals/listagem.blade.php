@extends('layout.main')

@section('title', 'Detalhes da Consulta')

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <section class="appointments">
        
        <div class="container">
            <div class="row">
                
                <!-- Listagem de profissionais -->
                <div class="col-md-6">
                    <div class="col-md-12 d-flex justify-content-between align-items-center mb-3">
                        <h3>Profissionais cadastrados</h3>
                        <a href="{{ route('cadastrar_profissional') }}" class="btn btn-primary">Cadastrar</a>
                    </div>
                    
                    <div id="profissionals-list">
                        @include('profissionals-list', ['profissionals' => $profissionals])
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection