<x-guest-layout>
    <div class="w-full sm:max-w-md p-6">
        <div class="text-center mb-8">
            <svg class="w-16 h-16 mx-auto text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <h1 class="text-2xl font-bold text-gray-900 mt-4">Crear Cuenta</h1>
            <p class="text-sm text-gray-500 mt-1">Registrate para empezar a controlar tus gastos</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="name" :value="'Nombre'" class="form-label" />
                <x-text-input id="name" class="form-input mt-1" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Tu nombre" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="email" :value="'Email'" class="form-label" />
                <x-text-input id="email" class="form-input mt-1" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="tu@email.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="'Contraseña'" class="form-label" />
                <x-text-input id="password" class="form-input mt-1" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="'Confirmar Contraseña'" class="form-label" />
                <x-text-input id="password_confirmation" class="form-input mt-1" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <button type="submit" class="btn-primary w-full justify-center">
                Registrarse
            </button>

            <p class="text-center text-sm text-gray-500">
                ¿Ya tenés cuenta?
                <a href="{{ route('login') }}" class="text-gray-900 font-semibold hover:underline">Iniciar Sesión</a>
            </p>
        </form>
    </div>
</x-guest-layout>
