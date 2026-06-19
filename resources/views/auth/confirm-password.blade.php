<x-guest-layout>
    <div class="w-full sm:max-w-md p-6">
        <div class="text-center mb-8">
            <svg class="w-14 h-14 mx-auto text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            <h1 class="text-xl font-bold text-gray-900 mt-4">Confirmar Contraseña</h1>
            <p class="text-sm text-gray-500 mt-1">Esta es un área segura. Confirmá tu contraseña para continuar.</p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="password" :value="'Contraseña'" class="form-label" />
                <x-text-input id="password" class="form-input mt-1" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <button type="submit" class="btn-primary w-full justify-center">
                Confirmar
            </button>
        </form>
    </div>
</x-guest-layout>
