# InfoMatics Computación

Aplicación web de catálogo y carrito de compras para una tienda de componentes y productos de computación. Está construida con PHP y SQLite y se ejecuta localmente con el servidor web integrado de PHP.

## Funcionalidades

- Catálogo público de productos con ficha de detalle.
- Inicio y cierre de sesión.
- Roles de cliente y administrador.
- Carrito individual por cliente, con cantidades, subtotales y total.
- Operaciones de administración de productos: alta, edición y eliminación.
- Rutas JSON para consultar productos y usuarios.
- Módulos de gestión de usuarios disponibles por separado.

### Roles

- **Visitante:** puede recorrer el catálogo y ver el detalle de los productos.
- **Cliente:** puede agregar productos al carrito, modificar cantidades y simular la finalización de la compra.
- **Administrador:** puede crear, editar y eliminar productos. El rol se determina por el campo `_nivel` de la tabla `TUsuarios`: un valor mayor que `1` indica administrador; los valores `1` o menores indican cliente.

La pantalla de finalización del carrito es una demostración: no procesa pagos, no genera una orden persistida y no descuenta stock.

## Requisitos

- Windows con PHP CLI; el iniciador incluido espera encontrarlo en `C:\xampp\php\php.exe`.
- Extensión PDO SQLite habilitada en PHP (`PDO_SQLITE`).
- Navegador web.
- Conexión a Internet para cargar la hoja de estilos externa usada por algunas páginas.

## Iniciar la aplicación

### Con el iniciador de Windows

1. Abre `iniciar.bat` desde el Explorador de archivos o una terminal.
2. En el menú, elige `1) Iniciar servidor`.
3. Abre `http://localhost:3000/` en el navegador.
4. Para detener el servidor, cierra la ventana de terminal que ejecuta PHP.

El iniciador usa `servidor.php`, que arranca el servidor integrado de PHP con `publica/` como raíz web.

### Desde una terminal

Desde la carpeta raíz del proyecto:

```powershell
C:\xampp\php\php.exe -S 127.0.0.1:3000 -t publica
```

Luego visita `http://localhost:3000/`. Si PHP está instalado en otra ubicación, sustituye la ruta al ejecutable. Confirma que PDO SQLite esté habilitado.

## Manual de usuario

### Explorar el catálogo

1. Abre `http://localhost:3000/`.
2. Revisa la lista de productos, que muestra el nombre y precio.
3. Selecciona **Más info** para consultar descripción, categoría, precio y stock registrado.

### Crear una cuenta de cliente

El formulario de registro está en `http://localhost:3000/usuarios/nuevo/`. Completa nombre, apellido, correo electrónico y contraseña. Las cuentas creadas desde ese formulario son clientes.

### Iniciar o cerrar sesión

1. Selecciona **Iniciar sesión**.
2. Ingresa el correo electrónico o nombre de usuario y la contraseña.
3. Para salir, selecciona **Cerrar sesión**.

### Usar el carrito

1. Inicia sesión como cliente.
2. Selecciona **Agregar al carrito** desde una tarjeta o ficha de producto.
3. Abre el carrito para revisar cantidades y total.
4. Usa `+` o `-` para ajustar la cantidad; **Quitar** elimina ese producto del carrito.
5. **Finalizar Compra** solo muestra una confirmación simulada; no realiza un pago.

### Administrar productos

Inicia sesión con una cuenta cuyo `_nivel` sea mayor que `1`. Desde el catálogo se habilitan las acciones de producto; el encabezado también ofrece **Nuevo Producto**. Al crear o editar, se pueden indicar nombre, descripción, categoría, precio, stock e imagen mediante URL.

## Guía para desarrolladores

### Estructura del proyecto

```text
.
├── iniciar.bat                 # Iniciador de Windows
├── servidor.php                # Menú y arranque del servidor PHP local
├── infomatics.db               # Base SQLite utilizada por la aplicación principal
├── includes/
│   ├── db.php                  # Conexión PDO SQLite
│   ├── auth.php                # Sesión, autenticación y roles
│   ├── layout.php              # Encabezado, barra de navegación y estilos
│   ├── productos.php           # Consultas y operaciones de productos
│   └── carrito.php             # Operaciones y resúmenes del carrito
└── publica/
    ├── index.php               # Entrada del sitio y catálogo
    ├── formulario-login*.php   # Inicio de sesión
    ├── formulario-logout.php   # Cierre de sesión
    ├── productos/              # Catálogo, CRUD y API de productos
    ├── carrito/                # Acciones y vista del carrito
    ├── usuarios/               # Registro, gestión y API de usuarios
    └── recursos/               # Logo e imagen de portada
```

El servidor usa `publica/` como raíz web, así que las rutas que empiezan con `/` corresponden a archivos dentro de esa carpeta. La conexión principal, definida en `includes/db.php`, abre `infomatics.db` en la raíz del proyecto. `base.db` no es la base seleccionada por esa función.

### Componentes principales

- `includes/db.php`: `getDB()` crea y reutiliza la conexión PDO, usa SQLite y activa excepciones para errores de base de datos.
- `includes/auth.php`: consulta y mantiene la sesión, autentica y proporciona `requerirAuth()`, `requerirAdmin()` y `requerirCliente()`.
- `includes/productos.php`: funciones para listar, consultar, crear, actualizar y eliminar productos.
- `includes/carrito.php`: funciones de consulta del carrito, suma de unidades y eliminación de unidades o productos.
- `includes/layout.php`: genera los metadatos comunes y la navegación según el estado de sesión y rol.
- `publica/index.php`: página de entrada; incluye el listado de `publica/productos/todos/`.

### Rutas principales

| Ruta | Uso |
| --- | --- |
| `/` | Catálogo principal |
| `/productos/ver?id=ID` | Detalle de un producto |
| `/productos/nuevo/` | Formulario para crear producto (administrador) |
| `/productos/editar/?id=ID` | Formulario para editar producto (administrador) |
| `/productos/borrar/procesar.php?id=ID` | Elimina un producto (administrador) |
| `/productos/api/` | Respuesta JSON con productos |
| `/usuarios/nuevo/` | Registro de cliente |
| `/usuarios/api/` | Respuesta JSON del módulo de usuarios |
| `/carrito/todos` | Carrito del cliente autenticado |
| `/carrito/agregar/?id=ID` | Agrega una unidad al carrito |
| `/carrito/quitar/?id=ID` | Resta una unidad; `&todo=1` elimina el producto del carrito |
| `/formulario-login.php` | Formulario de inicio de sesión |
| `/formulario-logout.php` | Cierre de sesión |

### Base de datos

La aplicación principal usa estas tablas en `infomatics.db`:

- **`TUsuarios`**: `_id`, `_nombre`, `_apellido`, `_email`, `_clave`, `_fechaRegistro`, `_nivel`.
- **`TProductos`**: `_id`, `_nombre`, `_descripcion`, `_categoria`, `_precio`, `_stock`, `_imagen`, `_activo`.
- **`TCarrito`**: `_id`, `_idUsuario`, `_idProducto`, `_cantidad`, `_fecha`; tiene una restricción única por usuario y producto.

Las operaciones de la aplicación principal se apoyan en `includes/`. Para una nueva funcionalidad, agrega o reutiliza funciones de servicio allí y mantén las páginas/rutas bajo `publica/`. Usa consultas preparadas para valores SQL y escapa los datos al renderizar HTML.

### Consideraciones antes de desplegar

Este proyecto está preparado para desarrollo local, no para exponerse directamente a Internet. Antes de un despliegue real, se deben revisar, entre otros aspectos:

- Las contraseñas se comparan directamente con `_clave`; implementar almacenamiento con `password_hash()` y validación con `password_verify()`.
- El formulario de registro actual envía datos mediante GET; cambiarlo a POST.
- Proteger y limitar las API. En particular, `/usuarios/api/` devuelve registros de usuario y no debe publicarse sin filtrar campos privados y aplicar autorización.
- Añadir protección CSRF y controles de autorización consistentes en todas las rutas de escritura.
- Implementar un flujo real de órdenes, pagos y actualización de stock si se necesita vender.
- Usar HTTPS y un servidor de producción configurado para PHP en vez del servidor integrado de desarrollo.

