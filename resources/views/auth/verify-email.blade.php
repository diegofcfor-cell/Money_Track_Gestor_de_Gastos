<x-guest-layout>
    <div class="w-full sm:max-w-md p-6">
        <div class="text-center mb-8">
            <svg class="w-14 h-14 mx-auto text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            <h1 class="text-xl font-bold text-gray-900 mt-4">Verificá tu Email</h1>
            <p class="text-sm text-gray-500 mt-2">Gracias por registrarte. Antes de empezar, verificá tu email haciendo clic en el link que te enviamos.</p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 p-3 bg-emerald-50 text-emerald-700 rounded-lg text-sm">
                Se envió un nuevo link de verificación al email que usaste al registrarte.
            </div>
        @endif

        <div class="space-y-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-primary w-full justify-center">
                    Reenviar Email de Verificación
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-center text-sm text-gray-500 hover:text-gray-900 underline py-2">
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
