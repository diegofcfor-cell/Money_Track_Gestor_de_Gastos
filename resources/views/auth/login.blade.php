<x-guest-layout>

<style>
body {
    background: linear-gradient(to right, #e0f2fe, #f1f5f9);
    overflow: hidden;
}

/* Fondo monedas */
.coins-bg {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    z-index: 0;
}

/* Monedas */
.coin {
    position: absolute;
    width: 35px;
    opacity: 0.6;
    animation: caer linear infinite;
}

/* Animación */
@keyframes caer {
    0% {
        transform: translateY(-100px) rotate(0deg);
    }
    100% {
        transform: translateY(110vh) rotate(360deg);
    }
}

/* Formulario encima */
.login-box {
    position: relative;
    z-index: 10;
}
</style>

<!-- 💰 LLUVIA DE MONEDAS -->
<div class="coins-bg">
    <img src="https://cdn-icons-png.flaticon.com/512/138/138292.png" class="coin" style="left:10%; animation-duration:8s;">
    <img src="https://cdn-icons-png.flaticon.com/512/138/138292.png" class="coin" style="left:25%; animation-duration:6s;">
    <img src="https://cdn-icons-png.flaticon.com/512/138/138292.png" class="coin" style="left:40%; animation-duration:7s;">
    <img src="https://cdn-icons-png.flaticon.com/512/138/138292.png" class="coin" style="left:55%; animation-duration:5s;">
    <img src="https://cdn-icons-png.flaticon.com/512/138/138292.png" class="coin" style="left:70%; animation-duration:9s;">
    <img src="https://cdn-icons-png.flaticon.com/512/138/138292.png" class="coin" style="left:85%; animation-duration:6s;">
</div>

<div class="login-box">

    <div style="text-align:center; margin-bottom:20px;">

        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135706.png" width="90">

        <h1 style="font-size:26px; font-weight:bold;">
            CONTROL DE GASTOS
        </h1>

        <p style="color:gray;">
            The Great Calculator
        </p>

    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required autofocus />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="'Contraseña'" />
            <x-text-input id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required />
        </div>

        <!-- Recordar -->
        <div class="block mt-4">
            <label>
                <input type="checkbox" name="remember">
                Recordarme
            </label>
        </div>

        <!-- Botones -->
        <div style="text-align:center; margin-top:15px;">

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   style="color:#2563eb; display:block;">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif

            <button type="submit"
                style="margin-top:10px; padding:8px 20px; background:#1f2937; color:white; border-radius:5px;">
                INGRESAR
            </button>

            <br>

            <a href="{{ route('register') }}"
               style="color:#2563eb; font-weight:bold; text-decoration:underline; display:block; margin-top:10px;">
                Crear cuenta nueva
            </a>

        </div>

    </form>

</div>

</x-guest-layout>
