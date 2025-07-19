@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Cadastrar Manutenção</h1>

        <form action="{{ route('manutencoes.store') }}" method="POST">
            @csrf
            @include('manutencoes.form')

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('manutencoes.index') }}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
@endsection
