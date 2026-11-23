<?php
/** @var array $productos */
use App\Services\AuthService;
$admin = AuthService::esAdmin();
$cliente = AuthService::esCliente();

// Obtener categorías únicas presentes en los productos
$categorias = [];
foreach ($productos as $p) {
    $cat = trim($p->_categoria ?? '');
    if (!empty($cat) && !in_array($cat, $categorias)) {
        $categorias[] = $cat;
    }
}
sort($categorias);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require __DIR__ . '/../layout/head.php'; ?>
    <style>
        .barra-filtros {
            background: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 12px;
            padding: 1.2rem 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }
        html[data-theme="dark"] .barra-filtros {
            background: #1e1e1e !important;
            border-color: #333333 !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.4) !important;
        }
        .input-busqueda-wrap {
            flex: 2;
            min-width: 240px;
            position: relative;
        }
        .input-filtro {
            width: 100%;
            height: 40px;
            padding: 0 14px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 0.95rem;
            box-sizing: border-box;
            background: #fafafa;
        }
        html[data-theme="dark"] .input-filtro {
            background: #2a2a2a !important;
            border-color: #444 !important;
            color: #ffffff !important;
        }
        .badge-stock-agotado {
            background: #ffebee;
            color: #c62828;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 12px;
            border: 1px solid #ffcdd2;
        }
        html[data-theme="dark"] .badge-stock-agotado {
            background: #381515 !important;
            color: #ff8a80 !important;
            border-color: #b71c1c !important;
        }
        .badge-stock-alerta {
            background: #fff3e0;
            color: #e65100;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 12px;
            border: 1px solid #ffe0b2;
        }
        html[data-theme="dark"] .badge-stock-alerta {
            background: #3e2723 !important;
            color: #ffb74d !important;
            border-color: #e65100 !important;
        }
        .badge-stock-ok {
            background: #e8f5e9;
            color: #2e7d32;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 12px;
        }
        html[data-theme="dark"] .badge-stock-ok {
            background: #1b381e !important;
            color: #81c784 !important;
        }
    </style>
</head>
<body>
    <?php require __DIR__ . '/../layout/header_completo.php'; ?>
    <main>
        <!-- Barra Interactiva de Búsqueda y Filtros -->
        <section class="barra-filtros">
            <div class="input-busqueda-wrap">
                <input type="text" id="filtroTexto" class="input-filtro" placeholder="🔍 Buscar por nombre o descripción..." oninput="filtrarCatalogo()">
            </div>

            <div style="flex: 1; min-width: 170px;">
                <select id="filtroCategoria" class="input-filtro" onchange="filtrarCatalogo()">
                    <option value="">Todas las categorías</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="flex: 1; min-width: 180px;">
                <select id="filtroOrden" class="input-filtro" onchange="filtrarCatalogo()">
                    <option value="recientes">Más recientes</option>
                    <option value="precio_asc">Precio: Menor a Mayor</option>
                    <option value="precio_desc">Precio: Mayor a Menor</option>
                    <option value="nombre_asc">Nombre: A - Z</option>
                </select>
            </div>

            <button type="button" class="btn btn-secondary" onclick="limpiarFiltros()" title="Limpiar filtros">
                ✕ Limpiar
            </button>
        </section>

        <section style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 10px;">
            <h2 style="margin: 0; font-size: 1.6rem;">Catálogo de Productos Disponibles</h2>
            <span id="contadorResultados" style="color: #666; font-size: 0.95rem; font-weight: 600;">
                Mostrando <?= count($productos) ?> de <?= count($productos) ?> productos
            </span>
        </section>

        <?php if (empty($productos)): ?>
            <p>No hay productos disponibles en este momento.</p>
        <?php else: ?>
            <div id="gridProductos" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.2rem;">
                <?php foreach ($productos as $cadaRegistro): 
                    $stock = (int)($cadaRegistro->_stock ?? 0);
                    $precio = (float)($cadaRegistro->_precio ?? 0);
                    $categoria = $cadaRegistro->_categoria ?? '';
                ?>
                    <article class="tarjeta-producto" 
                             id="idArticulo_<?= $cadaRegistro->_id ?>" 
                             data-nombre="<?= htmlspecialchars(mb_strtolower($cadaRegistro->_nombre ?? '')) ?>"
                             data-descripcion="<?= htmlspecialchars(mb_strtolower($cadaRegistro->_descripcion ?? '')) ?>"
                             data-categoria="<?= htmlspecialchars($categoria) ?>"
                             data-precio="<?= $precio ?>"
                             data-id="<?= $cadaRegistro->_id ?>"
                             style="background: #ffffff; border: 1px solid #e0e0e0; border-radius: 8px; padding: 1.2rem; box-shadow: 0 2px 6px rgba(0,0,0,0.04); display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <?php if (!empty($cadaRegistro->_imagen)): ?>
                                <div style="text-align: center; margin-bottom: 0.8rem; background: #fafafa; border-radius: 6px; padding: 0.8rem; min-height: 140px; display: flex; align-items: center; justify-content: center;">
                                    <img src="<?= htmlspecialchars($cadaRegistro->_imagen) ?>" alt="<?= htmlspecialchars($cadaRegistro->_nombre) ?>" style="max-height: 120px; max-width: 100%; object-fit: contain;">
                                </div>
                            <?php endif; ?>

                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem; gap: 6px;">
                                <span style="font-size: 0.8rem; color: #888; text-transform: uppercase; font-weight: 600;">
                                    <?= htmlspecialchars($categoria) ?>
                                </span>

                                <?php if ($stock <= 0): ?>
                                    <span class="badge-stock-agotado">Agotado</span>
                                <?php elseif ($stock <= 3): ?>
                                    <span class="badge-stock-alerta">⚡ ¡Últimas <?= $stock ?> u.!</span>
                                <?php else: ?>
                                    <span class="badge-stock-ok">Stock: <?= $stock ?></span>
                                <?php endif; ?>
                            </div>

                            <h2 style="margin: 0 0 0.4rem; font-size: 1.25rem;"><?= htmlspecialchars($cadaRegistro->_nombre) ?></h2>
                            <p style="margin: 0.3rem 0; font-size: 1.25rem; font-weight: bold; color: #d32f2f;">
                                $ <?= number_format($precio, 2, ',', '.') ?>
                            </p>
                        </div>

                        <nav style="display: flex; gap: 8px; align-items: center; flex-wrap: wrap; margin-top: 12px;">
                            <button type="button" class="btn btn-secondary" onclick="location.href='/productos/ver?id=<?= $cadaRegistro->_id ?>'">
                                ℹ️ Más info
                            </button>
                            
                            <?php if ($cliente): ?>
                                <?php if ($stock > 0): ?>
                                    <button type="button" class="btn btn-primary" onclick="location.href='/carrito/agregar/?id=<?= $cadaRegistro->_id ?>'">
                                        🛒 Agregar
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-secondary" disabled style="opacity: 0.5; cursor: not-allowed;" title="Producto sin stock disponible">
                                        Sin stock
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if ($admin): ?>
                                <button type="button" class="btn btn-info" onclick="location.href='/productos/editar/?id=<?= $cadaRegistro->_id ?>'">
                                    ✏️ Modificar
                                </button>
                                <button type="button" class="btn btn-danger" onclick="if(confirm('¿Seguro que deseas eliminar <?= addslashes($cadaRegistro->_nombre) ?>?')) location.href='/productos/borrar/procesar.php?id=<?= $cadaRegistro->_id ?>'">
                                    🗑️ Eliminar
                                </button>
                            <?php endif; ?>
                        </nav>
                    </article>
                <?php endforeach; ?>
            </div>

            <div id="mensajeSinResultados" style="display: none; text-align: center; padding: 3rem 1rem; background: #fafafa; border-radius: 12px; border: 1px dashed #ccc; margin-top: 1rem;">
                <p style="font-size: 1.25rem; color: #666; margin-bottom: 1rem;">No se encontraron productos que coincidan con tu búsqueda.</p>
                <button type="button" class="btn btn-secondary" onclick="limpiarFiltros()">Restablecer búsqueda</button>
            </div>
        <?php endif; ?>
    </main>

    <script>
        function filtrarCatalogo() {
            var texto = (document.getElementById('filtroTexto').value || '').trim().toLowerCase();
            var categoria = document.getElementById('filtroCategoria').value;
            var orden = document.getElementById('filtroOrden').value;
            var contenedor = document.getElementById('gridProductos');
            if (!contenedor) return;

            var articulos = Array.from(contenedor.querySelectorAll('.tarjeta-producto'));
            var visibles = 0;

            articulos.forEach(function(card) {
                var cardNombre = card.getAttribute('data-nombre') || '';
                var cardDesc = card.getAttribute('data-descripcion') || '';
                var cardCat = card.getAttribute('data-categoria') || '';

                var coincideTexto = !texto || cardNombre.indexOf(texto) !== -1 || cardDesc.indexOf(texto) !== -1;
                var coincideCat = !categoria || cardCat === categoria;

                if (coincideTexto && coincideCat) {
                    card.style.display = 'flex';
                    visibles++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Ordenamiento dinámico
            articulos.sort(function(a, b) {
                var precioA = parseFloat(a.getAttribute('data-precio')) || 0;
                var precioB = parseFloat(b.getAttribute('data-precio')) || 0;
                var nombreA = a.getAttribute('data-nombre') || '';
                var nombreB = b.getAttribute('data-nombre') || '';
                var idA = parseInt(a.getAttribute('data-id')) || 0;
                var idB = parseInt(b.getAttribute('data-id')) || 0;

                if (orden === 'precio_asc') return precioA - precioB;
                if (orden === 'precio_desc') return precioB - precioA;
                if (orden === 'nombre_asc') return nombreA.localeCompare(nombreB);
                return idB - idA; // recientes por defecto
            });

            articulos.forEach(function(card) {
                contenedor.appendChild(card);
            });

            // Actualizar contadores y cartel de sin resultados
            var contador = document.getElementById('contadorResultados');
            if (contador) {
                contador.textContent = 'Mostrando ' + visibles + ' de ' + articulos.length + ' productos';
            }

            var sinResultados = document.getElementById('mensajeSinResultados');
            if (sinResultados) {
                sinResultados.style.display = (visibles === 0) ? 'block' : 'none';
            }
        }

        function limpiarFiltros() {
            document.getElementById('filtroTexto').value = '';
            document.getElementById('filtroCategoria').value = '';
            document.getElementById('filtroOrden').value = 'recientes';
            filtrarCatalogo();
        }
    </script>
</body>
</html>
