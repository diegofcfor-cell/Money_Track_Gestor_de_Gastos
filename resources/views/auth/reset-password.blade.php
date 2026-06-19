<x-guest-layout>
    <div class="w-full sm:max-w-md p-6">
        <div class="text-center mb-8">
            <svg class="w-14 h-14 mx-auto text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            <h1 class="text-xl font-bold text-gray-900 mt-4">Restablecer Contraseña</h1>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <x-input-label for="email" :value="'Email'" class="form-label" />
                <x-text-input id="email" class="form-input mt-1" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password" :value="'Nueva Contraseña'" class="form-label" />
                <x-text-input id="password" class="form-input mt-1" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="'Confirmar Contraseña'" class="form-label" />
                <x-text-input id="password_confirmation" class="form-input mt-1" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <button type="submit" class="btn-primary w-full justify-center">
                Restablecer Contraseña
            </button>
        </form>
    </div>
</x-guest-layout>
