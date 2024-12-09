@if($profissionals->count() === 0)
    <p>Nenhum profissional cadastrado ainda</p>
@else
    <ul class="list-group">
        @foreach($profissionals as $profissional)
            <li class="list-group-item">
                <strong>{{ $profissional->name }}</strong> ---
                <span class="badge text-bg-primary">{{$profissional->tipo}}</span>

                <span class="truncate">Telefone: {{ $profissional->telefone }}</span>

                <small class="text-muted">CPF: {{ $profissional->cpf }}</small>
                <div class="d-flex justify-content-end">
                    <a href="{{route('exibir_profissional', $profissional->id)}}" class="btn btn-primary me-2">Visualizar</a>
                </div>
            </li>
        @endforeach
    </ul>

@endif
