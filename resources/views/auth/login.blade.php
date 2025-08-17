<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium mb-2">
                <i class="fas fa-envelope me-2"></i>Email
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" 
                   required autofocus autocomplete="username" 
                   placeholder="Digite seu email">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium mb-2">
                <i class="fas fa-lock me-2"></i>Senha
            </label>
            <input id="password" type="password" name="password" 
                   required autocomplete="current-password" 
                   placeholder="Digite sua senha">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="me-2">
                <span class="text-sm">Lembrar de mim</span>
            </label>
            
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm">
                    Esqueceu a senha?
                </a>
            @endif
        </div>

        <!-- Buttons -->
        <div class="space-y-3">
            <button type="submit" class="w-full">
                <i class="fas fa-sign-in-alt me-2"></i>Entrar
            </button>
            
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="w-full block text-center">
                    <button type="button" class="w-full secondary">
                        <i class="fas fa-user-plus me-2"></i>Criar Conta
                    </button>
                </a>
            @endif
        </div>

        <!-- Credenciais de Teste -->
        <div class="mt-6 p-4 bg-gray-50 rounded-lg text-sm">
            <h4 class="font-semibold text-gray-700 mb-2">
                <i class="fas fa-info-circle me-2"></i>Credenciais de Teste:
            </h4>
            <div class="space-y-1 text-gray-600">
                <p><strong>Admin:</strong> admin@gestor.com / password</p>
                <p><strong>Usuário:</strong> user@gestor.com / password</p>
            </div>
        </div>
    </form>
</x-guest-layout>
