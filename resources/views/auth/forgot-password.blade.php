<x-guest-layout>
    <div class="w-full sm:max-w-md p-6">
        <div class="text-center mb-8">
            <svg class="w-14 h-14 mx-auto text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            <h1 class="text-xl font-bold text-gray-900 mt-4">¿Olvidaste tu contraseña?</h1>
            <p class="text-sm text-gray-500 mt-1">Ingresá tu email y te enviaremos un link para restablecerla</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="email" :value="'Email'" class="form-label" />
                <x-text-input id="email" class="form-input mt-1" type="email" name="email" :value="old('email')" required autofocus placeholder="tu@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <button type="submit" class="btn-primary w-full justify-center">
                Enviar Link de Restablecimiento
            </button>

            <p class="text-center text-sm text-gray-500">
                <a href="{{ route('login') }}" class="text-gray-900 font-semibold hover:underline">Volver al Login</a>
            </p>
        </form>
    </div>
</x-guest-layout>
