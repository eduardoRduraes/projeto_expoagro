    @extends('layouts.app')

    @section('content')
        <div class="container-fluid">
            {{-- Título e botão fixos --}}

            <div class="sticky-top bg-white py-3" style="z-index: 1020;">
                <h1 class="mb-2">Lista de Máquinas</h1>
                <a href="{{ route('maquinas.create') }}" class="btn btn-primary mb-2">Cadastrar Nova Máquina</a>
                @if(session('success'))
                    <div class="alert alert-success mt-2 mb-0">{{ session('success') }}</div>
                @endif

            </div>

                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th style="background: white;">ID</th>
                        <th style="background: white;">Nome</th>
                        <th style="background: white;">Modelo</th>
                        <th style="background: white;">Nº Série</th>
                        <th style="background: white;">Tipo</th>
                        <th style="background: white;">Ano</th>
                        <th style="background: white;">Status</th>
                        <th style="background: white;">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($maquinas as $maquina)
                        <tr>
                            <td>{{ $maquina->id }}</td>
                            <td>{{ $maquina->nome }}</td>
                            <td>{{ preg_replace('/([a-zA-Z]+)(\d+)/', '$1-$2', $maquina->modelo) }}</td>
                            <td>{{ preg_replace('/(\d{3})([a-zA-Z]{3})(\d{3})/', '$1-$2-$3', $maquina->numero_serie) }}</td>
                            <td>{{ ucfirst($maquina->tipo) }}</td>
                            <td>{{ $maquina->ano }}</td>
                            <td>
                                @switch($maquina->status)
                                    @case('livre')
                                        <span class="badge bg-success" style="min-width: 100px;">LIVRE</span>
                                        @break
                                    @case('em_servico')
                                        <span class="badge bg-warning text-dark" style="min-width: 100px;">EM-SERVIÇO</span>
                                        @break
                                    @case('inativo')
                                        <span class="badge bg-secondary" style="min-width: 100px;">INATIVO</span>
                                        @break
                                    @case('manutencao')
                                        <span class="badge bg-info text-dark" style="min-width: 100px;">MANUTENÇÃO</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <a href="{{ route('maquinas.show', $maquina->id) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('maquinas.edit', $maquina->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('maquinas.destroy', $maquina->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
        </div>
    @endsection
