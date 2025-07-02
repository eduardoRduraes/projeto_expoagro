@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Cadastrar Máquina</h1>

        <form action="{{ route('maquinas.store') }}" method="POST">
            @csrf
            @include('maquinas.form')

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('maquinas.index') }}" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
@endsection

