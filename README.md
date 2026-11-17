# InfoMatics

Aplicación web de catálogo para una tienda de productos de computación. Permite consultar productos sin iniciar sesión, autenticarse y acceder a opciones adicionales según el nivel de la cuenta. Está desarrollada en PHP y usa SQLite para guardar productos, usuarios y una tabla destinada al carrito.

## Funcionalidades actuales

- Catálogo público con nombre y precio de los productos.
- Vista de detalle con descripción, categoría, precio, stock, imagen y estado.
- Inicio y cierre de sesión.
- Acceso de administración según el nivel de la cuenta.
- Consulta de usuarios y formulario administrativo para crear cuentas.
- Formulario para agregar productos.

La aplicación está en desarrollo: las pantallas y acciones para editar o borrar productos y usuarios están vacías. Aunque existe una tabla `TCarrito` y se muestran enlaces y botones relacionados con el carrito, no están implementadas las rutas y acciones necesarias para usarlo.

## Requisitos

- Windows.
- PHP CLI disponible en `PATH` o instalado en `C:\php\php.exe`.
- Extensión `PDO_SQLite` de PHP.
- Navegador web (el iniciador intenta abrir Chrome).

La base de datos utilizada por la aplicación es `infomatics.db`, ubicada en la carpeta raíz del proyecto. `base.db` no es la base de datos que usan las páginas actuales.

## Cómo iniciar

1. Abre la carpeta del proyecto.
2. Ejecuta `iniciar.bat` (por ejemplo, con doble clic).
3. En el menú, elige **1) Iniciar servidor**. Se iniciará el servidor integrado de PHP en el puerto `3000` y se abrirá `http://localhost:3000/` en Chrome.
4. Para detenerlo, cierra la ventana donde se está ejecutando el servidor o interrúmpelo allí con `Ctrl+C`.

El archivo `iniciar.bat` busca PHP primero en `PATH` y luego en `C:\php\php.exe`. El iniciador también intenta habilitar `pdo_sqlite` si la extensión está disponible junto a PHP. Si PHP no encuentra la extensión, habilita `pdo_sqlite` en el `php.ini` activo y vuelve a iniciar la aplicación. La opción **6) Abrir php.ini** del menú permite localizar ese archivo.

Otras opciones del menú permiten abrir la página en Chrome, abrir el proyecto en VS Code o en el Explorador, y abrir una consola.

## Manual de uso por rol

### Visitante (sin sesión)

1. Abre la dirección de la aplicación.
2. Recorre el catálogo de productos que aparece en la página principal.
3. Selecciona **Más info** para consultar los datos de un producto.
4. Pulsa **Iniciar sesión** si ya tienes una cuenta.

El catálogo actual consulta los registros de `TProductos` sin filtrar por el campo de estado (`_activo`).

### Usuario autenticado

1. En **Iniciar sesión**, ingresa el email y la contraseña de tu cuenta.
2. En la página principal puedes seguir consultando los productos y cerrar la sesión mediante **Cerrar sesión**.
3. La interfaz también muestra **Ver carrito** y, en el detalle de producto, **Agregar al carrito**. Estas opciones todavía no completan una operación: el carrito no está implementado.

No hay un formulario público para registrarse; las cuentas se crean desde la administración.

### Administrador

La interfaz muestra las opciones **Productos** y **Usuarios** para una cuenta cuyo nivel sea `10` o superior.

**Productos**

- **Ver todos** presenta la lista con nombre y precio.
- **Más info** muestra los datos disponibles del producto.
- **Agregar nuevo producto** permite cargar nombre, descripción, categoría, precio, stock, URL de imagen y estado.
- Las opciones de edición y borrado aparecen en el subsistema, pero sus páginas y acciones aún no están implementadas.

**Usuarios**

- **Ver todos** muestra las cuentas registradas; **Más info** abre el detalle de una cuenta.
- **Agregar nuevo usuario** solicita nombre, apellido, email, contraseña y nivel. El formulario ofrece nivel `1` (usuario estándar) y nivel `10` (administrador).
- El email debe ser único. Las contraseñas nuevas se guardan usando el mecanismo de hash de PHP.
- Las opciones de edición y borrado de usuarios todavía no están implementadas.

## Datos y limitaciones

- Las cuentas se autentican mediante email (sin distinguir mayúsculas y minúsculas) y contraseña.
- La interfaz determina el rol administrador a partir del nivel de cuenta. La implementación actual no aplica controles de autorización consistentes en todas las rutas; ocultar opciones en pantalla no equivale a proteger una operación.
- El servidor integrado de PHP que inicia el menú escucha en todas las interfaces de red (`0.0.0.0:3000`). Úsalo solo en un entorno de desarrollo y en una red de confianza; no publiques este servidor en Internet ni lo uses como servidor de producción.
- Los estilos de algunas páginas se cargan desde servicios externos, por lo que su apariencia puede variar si no hay conexión a Internet.

## Estructura principal

```text
.
├── iniciar.bat                 # Iniciador para Windows
├── servidor.php                # Menú y arranque del servidor PHP
├── infomatics.db               # Base de datos SQLite utilizada
└── publica/
    ├── index.php               # Inicio y selección de vista según sesión
    ├── formulario-login.php    # Inicio de sesión
    ├── formulario-logout.php   # Cierre de sesión
    ├── productos/              # Catálogo y operaciones de productos
    ├── usuarios/               # Administración de usuarios
    └── recursos/               # Imágenes y otros recursos
```
