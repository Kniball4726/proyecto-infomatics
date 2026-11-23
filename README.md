# InfoMatics Computación — Plataforma de E-Commerce y Gestión

Aplicación web modular de catálogo, carrito de compras y gestión administrativa para una tienda de informática y tecnología. Desarrollada con **PHP 8.x** y base de datos relacional **SQLite 3**, diseñada para ejecutarse localmente mediante el servidor web integrado de PHP.

---

## Índice

1. [Novedades y Características](#novedades-y-características)
2. [Roles y Control de Acceso](#roles-y-control-de-acceso)
3. [Usuarios de Prueba](#usuarios-de-prueba)
4. [Requisitos del Sistema](#requisitos-del-sistema)
5. [Cómo Iniciar y Detener el Servidor](#cómo-iniciar-y-detener-el-servidor)
6. [Manual de Usuario (Clientes)](#manual-de-usuario-clientes)
7. [Manual de Administración](#manual-de-administración)
8. [Arquitectura y Guía para Desarrolladores](#arquitectura-y-guía-para-desarrolladores)
9. [Mapa de Rutas y Endpoints](#mapa-de-rutas-y-endpoints)
10. [Esquema de Base de Datos](#esquema-de-base-de-datos)
11. [Informe de Cumplimiento de Consignas (PDF)](#informe-de-cumplimiento-de-consignas-pdf)

---

## Novedades y Características

- **Catálogo Dinámico Ordenado:** Productos mostrados con los más recientes primero (`ORDER BY _id DESC`).
- **Carrito de Compras Exclusivo para Clientes:**
  - Badge interactivo en la barra superior con contador de unidades y monto acumulado en tiempo real.
  - Modificación granular de cantidades (`+` y `-`).
  - Eliminación directa de ítems (`Quitar`) y vaciado de orden.
- **Gestión Integral de Clientes (CRUD Admin):** El administrador puede listar clientes registrados, dar de alta nuevos usuarios, editar sus datos/roles/contraseñas y eliminarlos con confirmación.
- **Gestión Integral de Productos (CRUD Admin):** Creación, modificación y eliminación de productos con vista previa de imagen y alertas estilizadas.
- **Modo Oscuro / Claro Persistente (`Dark Mode`):**
  - Alternador `🌙 Modo Oscuro` / `☀️ Modo Claro` accesible desde todas las páginas.
  - Sincronización instantánea en `localStorage`.
  - Script temprano anti-parpadeo blanco (FOUC).
- **Tarjeta de Inicio de Sesión Moderna:** Rediseñada con estética oscura carbón, anillo de foco en color corporativo, integración de marca y validación de errores.
- **Inicio Silencioso sin Consola:** Posibilidad de arrancar el servidor en segundo plano sin ventanas negras mediante VBScript nativo y detenerlo en un solo clic.
- **Arquitectura Modular (`includes/`):** Separación estricta entre la capa de acceso a datos / lógica de negocio (`includes/`) y las vistas de presentación (`publica/`).

---

## Roles y Control de Acceso

El sistema segmenta estrictamente las capacidades según el campo `_nivel` en la tabla `TUsuarios`:

| Rol | Valor `_nivel` | Permisos y Capacidades |
| :--- | :---: | :--- |
| **Visitante** | *No autenticado* | Explora el catálogo general y consulta fichas técnicas de detalle. No tiene carrito ni acceso administrativo. |
| **Cliente** | `_nivel == 1` | Compra en la tienda, agrega productos al carrito, ajusta unidades y simula el cierre de orden. No ve botones de gestión ni accede a paneles administrativos. |
| **Administrador** | `_nivel > 1` *(ej. 10)* | Gestión total de la plataforma: alta, edición y baja de **productos** y de **clientes**. No utiliza carrito de compras. |

---

## Usuarios de Prueba

Para verificar y evaluar los distintos roles, la base de datos `infomatics.db` cuenta con las siguientes cuentas precargadas:

| Rol | Nombre | Email | Contraseña | Nivel |
| :--- | :--- | :--- | :--- | :---: |
| **Administrador** | Carlos | `carlos.gorosito@gmail.com` | `123abc` | 10 |
| **Administrador** | Admin | `admin@infomatics.com` | `admin123` | 10 |
| **Cliente** | Tormenta | `tormenta@xmen.com` | `wolverine` | 1 |
| **Cliente** | Juan | `juan.perez@gmail.com` | `123456` | 1 |
| **Cliente** | Maria | `maria.lopez@gmail.com` | `maria2026` | 1 |

> [!NOTE]
> El inicio de sesión acepta indistintamente el **Email** o el **Nombre** del usuario.

---

## Requisitos del Sistema

- **Sistema Operativo:** Windows 10 / 11 (o cualquier SO compatible con PHP CLI).
- **PHP:** Versión 8.0 o superior (instalado típicamente en `C:\xampp\php\php.exe`).
- **Extensiones PHP:** `pdo_sqlite` y `sqlite3` habilitadas.
- **Navegador Web:** Chrome, Edge, Firefox, Brave o Safari.

---

## Cómo Iniciar y Detener el Servidor

Se ofrecen tres alternativas según el flujo de trabajo deseado:

### Método 1: Inicio 100% Silencioso (Recomendado)
- **Iniciar:** Haz doble clic sobre [iniciar_servidor.vbs](iniciar_servidor.vbs).
  - El servidor se inicia en segundo plano sin ninguna ventana de consola negra.
  - Se abre automáticamente tu navegador web en `http://localhost:3000/`.
- **Detener:** Haz doble clic sobre [detener_servidor.bat](detener_servidor.bat) para liberar el puerto 3000 y apagar el proceso.

### Método 2: Panel Interactivo de Control
1. Ejecuta [iniciar.bat](iniciar.bat) para abrir el panel de control en consola.
2. Selecciona la opción `1) Iniciar servidor` (inicia en segundo plano sin abrir consolas adicionales).
3. Selecciona la opción `2) Detener servidor` cuando desees apagarlo.
4. También dispones de accesos rápidos para abrir VS Code (`3`), la carpeta del proyecto (`4`) o `php.ini` (`7`).

### Método 3: Comando Manual desde Terminal
Desde la raíz del proyecto en PowerShell o CMD:
```powershell
c:\xampp\php\php.exe -S 0.0.0.0:3000 -t publica/
```
Luego ingresa a `http://localhost:3000/` en tu navegador. Para detenerlo, presiona `Ctrl + C`.

---

## Manual de Usuario (Clientes)

### 1. Navegar por el Catálogo
1. Ingresa a `http://localhost:3000/`.
2. Observa la cuadrícula de productos, cada uno con su imagen, precio y categoría.
3. Haz clic en **"Más info"** para ingresar a la ficha técnica del producto donde verás su descripción completa y stock disponible.

### 2. Iniciar Sesión como Cliente
1. Haz clic en **"Iniciar sesión"** en el margen superior derecho.
2. Ingresa tus credenciales (por ejemplo: `tormenta@xmen.com` y clave `wolverine`).
3. El sistema te redireccionará al catálogo reconociéndote con una insignia: `👤 Tormenta (Cliente)` y habilitará el botón del carrito.

### 3. Gestionar el Carrito de Compras
1. En cualquier tarjeta o ficha de producto, haz clic en **"🛒 Agregar al carrito"**.
2. Observa cómo el botón del carrito en el encabezado actualiza automáticamente la cantidad de ítems y el importe acumulado: ej. `🛒 Carrito (2) - $ 79.998`.
3. Haz clic en el botón del carrito para ver el desglose detallado:
   - Presiona `[ + ]` para incrementar la cantidad de un producto.
   - Presiona `[ - ]` para decrementar la cantidad (si llega a 0, se remueve automáticamente).
   - Presiona `[ 🗑️ Quitar ]` para eliminar todas las unidades de ese producto.
4. Haz clic en **"Finalizar Compra"** para simular el cierre del pedido.

### 4. Alternar Modo Oscuro / Modo Claro
- Haz clic en el botón `🌙 Modo Oscuro` ubicado en el encabezado.
- La interfaz adoptará instantáneamente el esquema de alto contraste oscuro (tarjetas carbón `#1e1e1e`, fondo `#121212` y textos claros).
- Tu preferencia queda guardada en tu navegador para todas las sesiones.

---

## Manual de Administración

### 1. Iniciar Sesión como Administrador
1. Accede a `/formulario-login.php`.
2. Ingresa con una cuenta de nivel 10 (ej: `carlos.gorosito@gmail.com` y clave `123abc`).
3. La barra de navegación mostrará la insignia `👤 Carlos (Admin)` y desplegará los accesos exclusivos: **"➕ Nuevo Producto"** y **"👥 Clientes"**.

### 2. Administración de Productos
- **Crear Producto:** Haz clic en **"➕ Nuevo Producto"** (`/productos/nuevo/`), completa el nombre, descripción, categoría, precio, stock y URL de la imagen, y guarda el formulario.
- **Modificar Producto:** En el catálogo o en el detalle del producto, pulsa el botón azul **"✏️ Modifica"** (`/productos/editar/?id=X`), ajusta los valores deseados y pulsa **"Guardar Cambios"**.
- **Eliminar Producto:** En la ficha del producto, pulsa el botón rojo **"🗑️ Eliminar"**. El sistema solicitará confirmación antes de eliminar el registro de la base de datos.

### 3. Administración de Clientes
- **Listar Clientes:** Haz clic en **"👥 Clientes"** (`/usuarios/todos/`) para ver la tabla completa de usuarios registrados con su ID, nombre, email, fecha de registro y rol.
- **Registrar Nuevo Cliente:** Haz clic en **"➕ Nuevo Cliente"** (`/usuarios/nuevo/`), define nombre, apellido, correo electrónico, clave y rol (`Cliente` o `Administrador`), y pulsa **"Crear Cliente"**.
- **Editar Cliente:** En la tabla de usuarios, haz clic en **"Editar"** (`/usuarios/editar/?id=X`). Puedes modificar los datos de contacto, rol y asignar una nueva contraseña (o dejarla vacía para conservar la actual).
- **Eliminar Cliente:** Haz clic en **"Borrar"** en la fila del cliente. Tras confirmar el diálogo, el usuario será dado de baja de la base de datos.

---

## Arquitectura y Guía para Desarrolladores

El proyecto aplica una **Arquitectura en Capas (Layered MVC Architecture)** que separa de forma estricta las vistas, los controladores, la lógica de negocio y la base de datos:

```text
proyecto-infomatics/
├── app/                                    # NÚCLEO DE LA APLICACIÓN (LÓGICA PRIVADA)
│   ├── bootstrap.php                       # Autocargador PSR-4 y arranque de sesión
│   │
│   ├── Database/                           # 1. CAPA DE PERSISTENCIA Y BASE DE DATOS
│   │   ├── Connection.php                  # Conexión Singleton con auto-inicialización
│   │   └── schema.sql                      # DDL y semillas para autogenerar la BD si no existe
│   │
│   ├── Services/                           # 2. CAPA DE LÓGICA DE NEGOCIO Y DOMINIO
│   │   ├── AuthService.php                 # Control de sesión, autenticación y reglas de roles
│   │   ├── ProductoService.php             # Operaciones del catálogo y validación de productos
│   │   ├── CarritoService.php              # Cálculos de subtotales, totales y agregaciones SQL
│   │   └── UsuarioService.php              # Gestión de clientes, credenciales y permisos
│   │
│   ├── Views/                              # 3. CAPA DE VISTAS (PRESENTACIÓN DESACOPLADA)
│   │   ├── View.php                        # Motor de renderizado de vistas
│   │   ├── layout/                         # Componentes comunes (head, navbar, hero, header)
│   │   ├── auth/                           # Vista de inicio de sesión con soporte Dark Mode
│   │   ├── productos/                      # Catálogo, ficha de detalle y formularios
│   │   ├── carrito/                        # Tabla interactiva del carrito y checkout
│   │   └── usuarios/                       # Listado y formularios de gestión de clientes
│   │
│   └── Controllers/                        # 4. CAPA DE CONTROLADORES
│       ├── AuthController.php              # Orquestación de login, logout y validación de accesos
│       ├── ProductoController.php          # Orquestación del catálogo, detalle, CRUD y API JSON
│       ├── CarritoController.php           # Orquestación de adición, decremento y checkout
│       └── UsuarioController.php           # Orquestación del panel de clientes, CRUD y API JSON
│
├── publica/                                # RAÍZ WEB EXPUESTA (DOCUMENT ROOT)
│   ├── index.php                           # Despachador principal al catálogo
│   ├── formulario-login.php                # Despachador a AuthController::login()
│   ├── formulario-login-procesar.php       # Despachador a AuthController::procesarLogin()
│   ├── formulario-logout.php               # Despachador a AuthController::logout()
│   ├── productos/                          # Puntos de entrada HTTP delegados a ProductoController
│   ├── carrito/                            # Puntos de entrada HTTP delegados a CarritoController
│   ├── usuarios/                           # Puntos de entrada HTTP delegados a UsuarioController
│   └── recursos/                           # Activos estáticos públicos (logo.png, portada.png)
│
├── docs/                                   # DOCUMENTACIÓN DEL PROYECTO
│   └── Informe_Cumplimiento_Consignas_InfoMatics.pdf  # Informe formal en PDF
│
├── scripts/                                # UTILIDADES Y PANEL DE CONTROL
│   └── servidor.php                        # Menú interactivo de control del servidor PHP
│
├── includes/                               # PUENTES DE COMPATIBILIDAD HACIA ATRÁS
│   ├── db.php                              # Delegado a App\Database\Connection
│   ├── auth.php                            # Delegado a App\Services\AuthService
│   ├── layout.php                          # Delegado a app/Views/layout/
│   ├── productos.php                       # Delegado a App\Services\ProductoService
│   ├── carrito.php                         # Delegado a App\Services\CarritoService
│   └── usuarios.php                        # Delegado a App\Services\UsuarioService
│
├── infomatics.db                           # Base de datos SQLite activa (ignorada en git)
├── iniciar_servidor.vbs                    # Lanzador 100% silencioso para Windows (sin consola)
├── detener_servidor.bat                    # Script para detener el servidor en un clic
├── iniciar.bat                             # Lanzador por consola (ejecuta scripts/servidor.php)
├── .gitignore                              # Reglas de exclusión de binarios y temporales
└── README.md                               # Documentación integral del proyecto
```

---

## Mapa de Rutas y Endpoints

| Ruta | Método | Nivel Requerido | Propósito |
| :--- | :---: | :---: | :--- |
| `/` | `GET` | Público | Catálogo principal de productos |
| `/productos/ver/?id=X` | `GET` | Público | Ficha de detalle de producto con acciones contextuales |
| `/productos/nuevo/` | `GET / POST` | Administrador (`>1`) | Formulario y alta de nuevo producto |
| `/productos/editar/?id=X` | `GET / POST` | Administrador (`>1`) | Edición de producto existente |
| `/productos/borrar/procesar.php?id=X` | `GET / POST` | Administrador (`>1`) | Baja física de un producto |
| `/productos/api/` | `GET` | Público | Retorno JSON de productos |
| `/carrito/todos/` | `GET` | Cliente (`==1`) | Vista completa del carrito de compras |
| `/carrito/agregar/?id=X` | `GET / POST` | Cliente (`==1`) | Suma una unidad del producto al carrito |
| `/carrito/quitar/?id=X[&todo=1]` | `GET / POST` | Cliente (`==1`) | Resta 1 unidad (`todo=1` elimina el producto) |
| `/carrito/finalizar/` | `GET` | Cliente (`==1`) | Pantalla de confirmación de pedido simulado |
| `/usuarios/todos/` | `GET` | Administrador (`>1`) | Listado y administración de clientes |
| `/usuarios/nuevo/` | `GET / POST` | Administrador (`>1`) | Registro y alta de cliente |
| `/usuarios/editar/?id=X` | `GET / POST` | Administrador (`>1`) | Modificación de datos y clave de cliente |
| `/usuarios/borrar/procesar.php?id=X` | `GET / POST` | Administrador (`>1`) | Baja de cuenta de cliente |
| `/formulario-login.php` | `GET` | Público | Pantalla de autenticación |
| `/formulario-login-procesar.php` | `POST` | Público | Verificación de credenciales |
| `/formulario-logout.php` | `GET` | Autenticado | Cierre de sesión seguro |

---

## Esquema de Base de Datos

La base relacional `infomatics.db` implementa las siguientes tablas e índices:

### Tabla `TUsuarios`
```sql
CREATE TABLE TUsuarios (
    _id INTEGER PRIMARY KEY AUTOINCREMENT,
    _nombre TEXT NOT NULL,
    _apellido TEXT NOT NULL,
    _email TEXT NOT NULL UNIQUE,
    _clave TEXT NOT NULL,
    _fechaRegistro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    _nivel INTEGER DEFAULT 1
);
```

### Tabla `TProductos`
```sql
CREATE TABLE TProductos (
    _id INTEGER PRIMARY KEY AUTOINCREMENT,
    _nombre TEXT NOT NULL,
    _descripcion TEXT,
    _categoria TEXT,
    _precio REAL NOT NULL,
    _stock INTEGER DEFAULT 0,
    _imagen TEXT,
    _activo INTEGER DEFAULT 1
);
```

### Tabla `TCarrito`
```sql
CREATE TABLE TCarrito (
    _id INTEGER PRIMARY KEY AUTOINCREMENT,
    _idUsuario INTEGER NOT NULL,
    _idProducto INTEGER NOT NULL,
    _cantidad INTEGER NOT NULL DEFAULT 1,
    _fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (_idUsuario) REFERENCES TUsuarios(_id),
    FOREIGN KEY (_idProducto) REFERENCES TProductos(_id),
    UNIQUE(_idUsuario, _idProducto)
);
```

---

## Informe de Cumplimiento de Consignas (PDF)

El proyecto incluye el documento compilado en la carpeta de documentación: [docs/Informe_Cumplimiento_Consignas_InfoMatics.pdf](docs/Informe_Cumplimiento_Consignas_InfoMatics.pdf), que detalla punto por punto el cumplimiento de las consignas educativas (puntos 1 al 18), indicando los archivos, funciones, consultas SQL y justificaciones técnicas aplicadas.

---
*InfoMatics &copy; 2026 — Plataforma de Comercio y Gestión.*
