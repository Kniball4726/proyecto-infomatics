-- =============================================
-- InfoMatics Database Initialization Schema
-- Generado automáticamente para auto-despliegue
-- =============================================

-- Estructura de tabla para TCarrito
DROP TABLE IF EXISTS TCarrito;
CREATE TABLE TCarrito (
    _id INTEGER PRIMARY KEY AUTOINCREMENT,
    _idUsuario INTEGER NOT NULL REFERENCES TUsuarios(_id),
    _idProducto INTEGER NOT NULL REFERENCES TProductos(_id),
    _cantidad INTEGER NOT NULL DEFAULT 1,
    _fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (_idUsuario, _idProducto)
);

-- Datos iniciales para TCarrito
INSERT INTO TCarrito (_id, _idUsuario, _idProducto, _cantidad, _fecha) VALUES ('4', '2', '5', '1', '2026-11-22 21:20:10');
INSERT INTO TCarrito (_id, _idUsuario, _idProducto, _cantidad, _fecha) VALUES ('5', '3', '2', '1', '2026-11-22 21:20:10');
INSERT INTO TCarrito (_id, _idUsuario, _idProducto, _cantidad, _fecha) VALUES ('6', '3', '3', '1', '2026-11-22 21:20:10');
INSERT INTO TCarrito (_id, _idUsuario, _idProducto, _cantidad, _fecha) VALUES ('7', '4', '1', '1', '2026-11-22 21:20:10');
INSERT INTO TCarrito (_id, _idUsuario, _idProducto, _cantidad, _fecha) VALUES ('8', '4', '5', '2', '2026-11-22 21:20:10');
INSERT INTO TCarrito (_id, _idUsuario, _idProducto, _cantidad, _fecha) VALUES ('9', '5', '3', '2', '2026-11-22 21:20:10');
INSERT INTO TCarrito (_id, _idUsuario, _idProducto, _cantidad, _fecha) VALUES ('10', '5', '4', '1', '2026-11-22 21:20:10');
INSERT INTO TCarrito (_id, _idUsuario, _idProducto, _cantidad, _fecha) VALUES ('14', '2', '8', '1', '2026-11-22 21:46:02');

-- Estructura de tabla para TProductos
DROP TABLE IF EXISTS TProductos;
CREATE TABLE TProductos (
    _id INTEGER PRIMARY KEY AUTOINCREMENT,
    _nombre TEXT NOT NULL,
    _descripcion TEXTAREA,
    _categoria TEXT NOT NULL,
    _precio REAL NOT NULL,
    _stock INTEGER NOT NULL DEFAULT 0,
    _imagen URL,
    _activo INTEGER DEFAULT 1
);

-- Datos iniciales para TProductos
INSERT INTO TProductos (_id, _nombre, _descripcion, _categoria, _precio, _stock, _imagen, _activo) VALUES ('1', 'Teclado mecánico RGB', 'Teclado USB retroiluminado', 'Periféricos', '65000', '15', NULL, '1');
INSERT INTO TProductos (_id, _nombre, _descripcion, _categoria, _precio, _stock, _imagen, _activo) VALUES ('2', 'Mouse gamer', 'Mouse óptico de 7200 DPI', 'Periféricos', '28000', '20', NULL, '1');
INSERT INTO TProductos (_id, _nombre, _descripcion, _categoria, _precio, _stock, _imagen, _activo) VALUES ('3', 'Auriculares USB', 'Auriculares con micrófono', 'Audio', '42000', '12', NULL, '1');
INSERT INTO TProductos (_id, _nombre, _descripcion, _categoria, _precio, _stock, _imagen, _activo) VALUES ('4', 'Memoria RAM 16 GB', 'Memoria DDR4', 'Componentes', '95000', '8', NULL, '1');
INSERT INTO TProductos (_id, _nombre, _descripcion, _categoria, _precio, _stock, _imagen, _activo) VALUES ('5', 'SSD 480 GB', 'Unidad de almacenamiento SATA', 'Componentes', '85000', '10', NULL, '1');
INSERT INTO TProductos (_id, _nombre, _descripcion, _categoria, _precio, _stock, _imagen, _activo) VALUES ('6', 'Webcam Full HD', 'Cámara USB 1080p', 'Accesorios', '55000', '7', NULL, '1');
INSERT INTO TProductos (_id, _nombre, _descripcion, _categoria, _precio, _stock, _imagen, _activo) VALUES ('7', 'Monitor 24 pulgadas', 'Monitor LED Full HD', 'Monitores', '220000', '5', NULL, '1');
INSERT INTO TProductos (_id, _nombre, _descripcion, _categoria, _precio, _stock, _imagen, _activo) VALUES ('8', 'Parlantes USB', 'Parlantes estéreo compactos', 'Audio', '32000', '18', NULL, '1');
INSERT INTO TProductos (_id, _nombre, _descripcion, _categoria, _precio, _stock, _imagen, _activo) VALUES ('9', 'PlayStation 5', 'Consola de juegos', 'consolas', '1600000', '10', '', '1');

-- Estructura de tabla para TUsuarios
DROP TABLE IF EXISTS TUsuarios;
CREATE TABLE TUsuarios (
    _id INTEGER PRIMARY KEY AUTOINCREMENT,
    _nombre TEXT NOT NULL,
    _apellido TEXT NOT NULL,
    _email EMAIL NOT NULL UNIQUE,
    _clave PASSWORD NOT NULL,
    _fechaRegistro DATETIME DEFAULT CURRENT_TIMESTAMP
, _nivel INTEGER);

-- Datos iniciales para TUsuarios
INSERT INTO TUsuarios (_id, _nombre, _apellido, _email, _clave, _fechaRegistro, _nivel) VALUES ('1', 'Carlos', 'Gorosito', 'carlos.gorosito@gmail.com', '123abc', '2026-11-16 15:46:03', '10');
INSERT INTO TUsuarios (_id, _nombre, _apellido, _email, _clave, _fechaRegistro, _nivel) VALUES ('2', 'Tormenta', 'Xavier', 'tormenta@xmen.com', 'wolverine', '2026-11-16 15:48:52', '1');
INSERT INTO TUsuarios (_id, _nombre, _apellido, _email, _clave, _fechaRegistro, _nivel) VALUES ('3', 'Juan', 'Perez', 'juan.perez@gmail.com', '123456', '2026-11-22 21:20:10', '1');
INSERT INTO TUsuarios (_id, _nombre, _apellido, _email, _clave, _fechaRegistro, _nivel) VALUES ('4', 'Maria', 'Lopez', 'maria.lopez@gmail.com', 'maria2026', '2026-11-22 21:20:10', '1');
INSERT INTO TUsuarios (_id, _nombre, _apellido, _email, _clave, _fechaRegistro, _nivel) VALUES ('5', 'Lucas', 'Diaz', 'lucas.diaz@gmail.com', 'clave123', '2026-11-22 21:20:10', '1');
INSERT INTO TUsuarios (_id, _nombre, _apellido, _email, _clave, _fechaRegistro, _nivel) VALUES ('6', 'Admin', 'InfoMatics', 'admin@infomatics.com', 'admin123', '2026-11-22 21:20:10', '10');
INSERT INTO TUsuarios (_id, _nombre, _apellido, _email, _clave, _fechaRegistro, _nivel) VALUES ('8', 'Gregory', 'DUQUE', 'gduque@iiconcepcion.edu.ar', '1713', '2026-11-22 22:21:23', '10');

-- Estructura de tabla para TPedidos
DROP TABLE IF EXISTS TPedidos;
CREATE TABLE TPedidos (
    _id INTEGER PRIMARY KEY AUTOINCREMENT,
    _idUsuario INTEGER NOT NULL REFERENCES TUsuarios(_id),
    _total REAL NOT NULL,
    _estado TEXT NOT NULL DEFAULT 'Completado',
    _fecha DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Estructura de tabla para TDetallePedido
DROP TABLE IF EXISTS TDetallePedido;
CREATE TABLE TDetallePedido (
    _id INTEGER PRIMARY KEY AUTOINCREMENT,
    _idPedido INTEGER NOT NULL REFERENCES TPedidos(_id) ON DELETE CASCADE,
    _idProducto INTEGER NOT NULL REFERENCES TProductos(_id),
    _cantidad INTEGER NOT NULL,
    _precioUnitario REAL NOT NULL,
    _subtotal REAL NOT NULL
);

