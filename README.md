# Money Track - Gestor de Gastos

Aplicación web para gestionar ingresos y egresos personales con categorías, subcategorías, gráficos interactivos y exportación a PDF.

## Requisitos

| Herramienta | Versión |
|---|---|
| PHP | 8.3+ |
| Composer | última |
| Node.js | 20+ |
| npm | última |
| MySQL | 8+ |

## Stack Tecnológico

| Capa | Tecnología |
|---|---|
| Backend | Laravel 13 + PHP 8.3+ |
| Base de datos | MySQL |
| Frontend | Tailwind CSS, Blade templates |
| Assets | Vite |
| Gráficos | Chart.js |
| PDF | barryvdh/laravel-dompdf |
| Autenticación | Laravel Breeze (login, registro, password reset, verificación email) |

## Funcionalidades

- **Autenticación** — Login, registro, recuperación de contraseña, confirmación de email
- **Dashboard** — Resumen de ingresos/egresos/saldo con filtros por tipo y fecha
- **Gráfico** — Tortas de egresos agrupados por categoría y subcategoría (Chart.js)
- **CRUD de movimientos** — Crear, editar y eliminar movimientos con categorías y subcategorías
- **Filtros** — Por tipo (ingreso/egreso), rango de fechas y categoría
- **PDF** — Descarga del historial completo de movimientos
- **Impresión** — Vista optimizada para impresión del dashboard

## Modelo de Datos

```
usuarios (id, name, email, password, ...)
  |
  +-- movimientos (id, user_id, tipo, monto, fecha, categoria_id, subcategoria_id)
        |
        +-- categorias (id, nombre)
        |     |
        |     +-- subcategorias (id, nombre, categoria_id)
```

## Instalación

```bash
# Clonar
git clone https://github.com/diegofcfor-cell/Money_Track_Gestor_de_Gastos.git
cd Money_Track_Gestor_de_Gastos

# Dependencias PHP
composer install

# Dependencias JS
npm install && npm run build

# Configurar BD
cp .env.example .env
# Editar .env con credenciales de MySQL (DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# Crear la base de datos en MySQL
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS gestor_dinero"

# Migrar y seedear con datos de ejemplo
php artisan migrate

# Cargar datos de ejemplo (Fernando Nieva, categorías, movimientos, etc.)
php artisan db:seed

# Iniciar servidor
php artisan serve
```

Acceder a `http://127.0.0.1:8000` y registrar un usuario nuevo.

## Rutas principales

| Ruta | Método | Descripción |
|---|---|---|
| `/dashboard` | GET | Panel principal con resumen, gráfico y tabla |
| `/movimientos/create` | GET | Formulario nuevo movimiento |
| `/movimientos` | POST | Guardar movimiento |
| `/movimientos/{id}/edit` | GET | Editar movimiento |
| `/movimientos/{id}` | PUT | Actualizar movimiento |
| `/movimientos/{id}` | DELETE | Eliminar movimiento |
| `/movimientos/pdf` | GET | Descargar PDF de movimientos |
| `/login` | GET/POST | Iniciar sesión |
| `/register` | GET/POST | Registro de usuario |
