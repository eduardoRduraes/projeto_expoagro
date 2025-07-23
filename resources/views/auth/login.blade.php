@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h1 class="h4 mb-3">Entrar</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input id="password" class="form-control" type="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
@endsection
