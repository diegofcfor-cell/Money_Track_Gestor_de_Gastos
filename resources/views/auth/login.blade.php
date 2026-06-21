<x-guest-layout>

<style>
body {
    margin: 0;
    min-height: 100vh;
    font-family: 'Inter', sans-serif;
    overflow: hidden;
    background: #0f172a;
}

/* Fondo animado */
.bg-animated {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    z-index: 0;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 30%, #0f172a 70%, #020617 100%);
    overflow: hidden;
}

.bg-animated::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse at 20% 50%, rgba(217, 119, 6, 0.1) 0%, transparent 50%),
        radial-gradient(ellipse at 80% 20%, rgba(5, 150, 105, 0.06) 0%, transparent 50%),
        radial-gradient(ellipse at 50% 80%, rgba(217, 119, 6, 0.05) 0%, transparent 50%);
}

/* Círculos flotantes */
.floating-circle {
    position: absolute;
    border-radius: 50%;
    opacity: 0.12;
}
.floating-circle:nth-child(1) {
    width: 500px; height: 500px;
    background: radial-gradient(circle, #d97706, transparent);
    top: -150px; left: -150px;
    animation: float1 25s ease-in-out infinite;
}
.floating-circle:nth-child(2) {
    width: 400px; height: 400px;
    background: radial-gradient(circle, #059669, transparent);
    bottom: -100px; right: -100px;
    animation: float2 20s ease-in-out infinite;
}
.floating-circle:nth-child(3) {
    width: 300px; height: 300px;
    background: radial-gradient(circle, #d97706, transparent);
    top: 50%; left: 60%;
    animation: float3 18s ease-in-out infinite;
}
.floating-circle:nth-child(4) {
    width: 200px; height: 200px;
    background: radial-gradient(circle, #3b82f6, transparent);
    top: 10%; right: 15%;
    animation: float4 22s ease-in-out infinite;
}
@keyframes float1 {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(80px, 60px) scale(1.1); }
    66% { transform: translate(-40px, 100px) scale(0.9); }
}
@keyframes float2 {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(-70px, -50px) scale(1.15); }
    66% { transform: translate(50px, -80px) scale(0.85); }
}
@keyframes float3 {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50% { transform: translate(60px, -80px) scale(1.1); }
}
@keyframes float4 {
    0%, 100% { transform: translate(0, 0) scale(1); }
    50% { transform: translate(-100px, 40px) scale(1.2); }
}

/* Parrilla de puntos */
.dots-grid {
    position: absolute;
    inset: 0;
    background-image: radial-gradient(rgba(255,255,255,0.04) 1px, transparent 1px);
    background-size: 40px 40px;
}

/* Monedas entre el fondo y el card */
.coins-front {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    z-index: 5;
    pointer-events: none;
    overflow: hidden;
}
.coin {
    position: absolute;
    /* opacity: 0.15; */
    animation: caer linear infinite;
    filter: drop-shadow(0 0 6px rgb(255, 222, 35));
}
@keyframes caer {
    0% { transform: translateY(0) rotate(0deg); }
    100% { transform: translateY(110vh) rotate(720deg); }
}

/* Card */
.login-card {
    position: relative;
    z-index: 10;
    width: 100%;
    max-width: 520px;
    margin: 0 auto;
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    padding: 48px 40px;
    box-shadow:
        0 25px 60px rgba(0, 0, 0, 0.4),
        0 0 0 1px rgba(255, 255, 255, 0.06);
}

.login-card .icon-wrap {
    width: 80px;
    height: 80px;
    margin: 0 auto 24px;
    background: linear-gradient(135deg, #fbbf24, #d97706);
    border-radius: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 8px 24px rgba(217, 119, 6, 0.25);
}

.login-card h1 {
    font-size: 26px;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.5px;
    margin: 0 0 4px;
}
.login-card .subtitle {
    color: #64748b;
    font-size: 15px;
    margin: 0 0 28px;
}
.login-card .divider {
    width: 40px;
    height: 3px;
    background: linear-gradient(90deg, #d97706, #fbbf24);
    border-radius: 2px;
    margin: 0 auto 28px;
}

.login-card .form-group {
    margin-bottom: 20px;
    text-align: left;
}
.login-card .form-group label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}
.login-card .form-group input[type="email"],
.login-card .form-group input[type="password"] {
    width: 100%;
    padding: 12px 16px;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    font-size: 15px;
    color: #0f172a;
    background: #f8fafc;
    transition: all 0.2s;
    box-sizing: border-box;
}
.login-card .form-group input:focus {
    outline: none;
    border-color: #d97706;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.1);
}
.login-card .form-group input::placeholder {
    color: #94a3b8;
}

.remember-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
}
.remember-row label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #64748b;
    cursor: pointer;
}
.remember-row input[type="checkbox"] {
    width: 16px;
    height: 16px;
    accent-color: #d97706;
}
.remember-row a {
    font-size: 13px;
    color: #d97706;
    text-decoration: none;
    font-weight: 600;
}
.remember-row a:hover { text-decoration: underline; }

.login-btn {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #0f172a, #1e293b);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 700;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: all 0.3s;
    text-transform: uppercase;
}
.login-btn:hover {
    box-shadow: 0 8px 24px rgba(15, 23, 42, 0.3);
    transform: translateY(-1px);
}
.login-btn:active { transform: translateY(0); }

.register-link {
    text-align: center;
    margin-top: 20px;
    font-size: 14px;
    color: #64748b;
}
.register-link a {
    color: #d97706;
    font-weight: 700;
    text-decoration: none;
}
.register-link a:hover { text-decoration: underline; }

.login-card::before {
    content: '';
    position: absolute;
    inset: -1px;
    border-radius: 25px;
    background: linear-gradient(135deg, rgba(217,119,6,0.15), transparent 40%, transparent 60%, rgba(5,150,105,0.1));
    z-index: -1;
}

.login-card .status-msg {
    background: #f0fdf4;
    color: #166534;
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 13px;
    margin-bottom: 20px;
    border: 1px solid #bbf7d0;
}
</style>

<div class="bg-animated">
    <div class="dots-grid"></div>
    <div class="floating-circle"></div>
    <div class="floating-circle"></div>
    <div class="floating-circle"></div>
    <div class="floating-circle"></div>
</div>

<div class="coins-front">
    <img src="https://cdn-icons-png.flaticon.com/512/138/138292.png" class="coin" style="left:5%; animation-duration:11s; width:30px; top:-10%;">
    <img src="https://cdn-icons-png.flaticon.com/512/138/138292.png" class="coin" style="left:15%; animation-duration:8s; width:22px; top:-45%;">
    <img src="https://cdn-icons-png.flaticon.com/512/138/138292.png" class="coin" style="left:28%; animation-duration:13s; width:34px; top:-80%;">
    <img src="https://cdn-icons-png.flaticon.com/512/138/138292.png" class="coin" style="left:42%; animation-duration:9s; width:24px; top:-25%;">
    <img src="https://cdn-icons-png.flaticon.com/512/138/138292.png" class="coin" style="left:55%; animation-duration:12s; width:32px; top:-60%;">
    <img src="https://cdn-icons-png.flaticon.com/512/138/138292.png" class="coin" style="left:68%; animation-duration:10s; width:20px; top:-90%;">
    <img src="https://cdn-icons-png.flaticon.com/512/138/138292.png" class="coin" style="left:80%; animation-duration:14s; width:28px; top:-5%;">
    <img src="https://cdn-icons-png.flaticon.com/512/138/138292.png" class="coin" style="left:92%; animation-duration:9s; width:26px; top:-35%;">
</div>

<div style="position:fixed; z-index:10; top:0; left:0; width:100%; height:100vh; display:flex; align-items:center; justify-content:center; padding:24px; box-sizing:border-box;">
    <div class="login-card">

        <div class="icon-wrap">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        <h1 style="text-align:center;">MoneyTrack</h1>
        <p class="subtitle" style="text-align:center;">Controlá tus finanzas personales</p>
        <div class="divider"></div>

        <x-auth-session-status class="status-msg" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="email" placeholder="tu@email.com">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="remember-row">
                <label>
                    <input type="checkbox" name="remember">
                    Recordarme
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                @endif
            </div>

            <button type="submit" class="login-btn">Ingresar</button>
        </form>

        <p class="register-link">
            ¿No tenés cuenta? <a href="{{ route('register') }}">Crear cuenta nueva</a>
        </p>

    </div>
</div>

</x-guest-layout>
