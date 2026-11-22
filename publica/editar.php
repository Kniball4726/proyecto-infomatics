<!DOCTYPE html>
<html lang="es">
    <head>
    <meta charset="UTF-8">
    <title>Editor PHP</title>
    <link rel="stylesheet" href="https://gorosito.red/dame/simple.php?color=purple">
    <style>
.chico {
    width:60px!important;
    transition: 1s all ;
}
#barra {
    background: skyblue ;
}
#app {
    display: flex;
    width: 100%;
    height: 100dvh;
}
#app.grabado {
    animation: grabado 1s ;
}
@keyframes grabado {
    0% {background:green}
    100% {background:none}
}

#explorador {
    width: 240px;
    border-right: 1px solid #ccc;
    display: flex;
    flex-direction: column;
}
#archivos {
    flex: 1;
    overflow: auto;
    padding: 5px;
}
.archivo {
    padding: 6px;
    cursor: pointer;
    overflow: ellipsis ;
    width: 100% ;
    user-select: none ;
}
.archivo:hover {
    background: #ccc;
}
.archivo.activo {
    background: #ddd;
    font-weight: bold;
}
.directorio {
    padding: 6px;
    font-weight: bold;
}
#idEditor {
    flex: 1;
}
#idNombreArchivo {
    position: fixed ;
    top: 0 ;
    right: 0 ;
    transform: scale(0.5) translate(0, -10px);
}
        </style>
    </head>
    <body>
        <div id="app">
            <aside id="explorador">
                <div id="barra">
                    <button onclick="nuevoArchivo()">＋</button>
                    <button onclick="eliminarArchivo()">－</button>
                    <button onclick="guardar()">💾</button>
                    <button onclick="location.reload()">🔄</button>
                </div>
                <div id="archivos"></div>
            </aside>
            <div id="idNombreArchivo" >Ningún archivo abierto</div>
            <main id="idEditor"></main>
        </div>
        <script src="https://gorosito.red/dame/uutiles.js"></script>
        <script>
            fnCargarMonaco(idEditor).then(function(x){
                editor = x
                editor.getDomNode().addEventListener("wheel", function(e) {
                    e.preventDefault() ;
                    if( e.ctrlKey )
                    fnCambiarFuente( -Math.sign(e.deltaY) );
                })
            }) ;
            let editor, _tamanioFuente = 14 ;
            let archivoActual = null;


            async function api(datos = {}) {
                const form = new FormData();
                for (const clave in datos) form.append(clave, datos[clave]);
                const respuesta = await fetch(
                    'apieditar.php',
                    { method: 'POST', body: form }
                );
                return await respuesta.json();
            }
            async function cargarArchivos() {
                const resultado = await api({
                    accion: 'listar'
                });
                if (!resultado.ok) return alert(resultado.error);
                archivos.innerHTML = '';
                mostrarArbol(
                    resultado.archivos,
                    archivos
                );
            }
            function mostrarArbol(lista, contenedor, nivel = 0) {
                for (const item of lista) {
                    if (item.tipo === 'directorio') {
                        const div = document.createElement('div');
                        div.className = 'directorio';
                        div.style.paddingLeft = (nivel * 15 + 5) + 'px';
                        div.style.boxShadow = `${ nivel*10 }px 10px 4px hsl(${ nivel*45 }deg, 50%, 60%)`
                        if(nivel>0) div.style.borderLeft = "purple 2px solid" ;
                        div.textContent = '├📁 ' + item.nombre;
                        contenedor.appendChild(div);
                        mostrarArbol(
                            item.hijos,
                            contenedor,
                            nivel + 1
                        );
                    } else {
                        const div = document.createElement('div');
                        div.className = 'archivo';
                        div.style.paddingLeft = (nivel * 15 + 5) + 'px';
                        div.style.borderLeft = (nivel > 0 ? "purple 2px solid" :"")
                        div.textContent = '📄 ├' + item.nombre;
                        div.dataset.ruta = item.ruta;
                        div.ondblclick = function () {
                            abrirArchivo(item.ruta);
                        };
                        div.oncontextmenu = function(e) {
                            e.preventDefault() ;
                            if(e.ctrlKey) window.open("/"+item.ruta) ;
                        }
                        contenedor.appendChild(div);
                    }
                }
            }
            async function abrirArchivo(ruta) {
                const resultado = await fetch(
                    'apieditar.php?accion=leer&ruta=' +
                    encodeURIComponent(ruta)
                );
                const datos = await resultado.json();
                if (!datos.ok) return alert(datos.error);
                idNombreArchivo.innerHTML = "<button onclick='window.open(`https://gorosito.red/apps/sqlite`)' >SQLite</button><strong>Abierto </strong><mark>" + ruta + "</mark>";
                archivoActual = ruta;
                editor.setValue(datos.contenido);
                establecerLenguaje(ruta);
                document
                    .querySelectorAll('.archivo')
                    .forEach(elemento => {
                        elemento.classList.toggle(
                            'activo',
                            elemento.dataset.ruta === ruta
                        );
                    });
            }
            function establecerLenguaje(ruta) {
                const extension = ruta.split('.').pop().toLowerCase();
                const lenguajes = {
                    php: 'php',
                    html: 'html',
                    htm: 'html',
                    css: 'css',
                    js: 'javascript',
                    json: 'json',
                    xml: 'xml',
                    sql: 'sql',
                    md: 'markdown',
                    txt: 'plaintext'
                };
                const lenguaje = lenguajes[extension] || 'plaintext';
                monaco.editor.setModelLanguage(
                    editor.getModel(),
                    lenguaje
                );
            }
            function fnCambiarFuente( _delta ) {
                _tamanioFuente = Math.max( 8, Math.min(48, _tamanioFuente + _delta) );
                editor.updateOptions( { fontSize: _tamanioFuente } );

            }
            async function guardar() {
                if (!archivoActual) return alert('No hay ningún archivo abierto');
                const resultado = await api({
                    accion: 'guardar',
                    ruta: archivoActual,
                    contenido: editor.getValue()
                });
                if (!resultado.ok) return alert(resultado.error);
                console.log('Archivo guardado');
            }

            async function nuevoArchivo() {
                const ruta = prompt(
                    'Ruta del nuevo archivo:',
                    'nuevo.php'
                );
                if (!ruta) return;
                const resultado = await api({
                    accion: 'crear',
                    ruta: ruta,
                    contenido: ''
                });
                if (!resultado.ok) return alert(resultado.error);
                await cargarArchivos();
                await abrirArchivo(ruta);
            }
            async function eliminarArchivo() {
                if (!archivoActual) return alert('No hay ningún archivo seleccionado');
                if (!confirm( '¿Eliminar ' + archivoActual + '?')) return;
                const resultado = await api({
                    accion: 'eliminar',
                    ruta: archivoActual
                });
                if (!resultado.ok) return alert(resultado.error);
                archivoActual = null;
                editor.setValue('');
                await cargarArchivos();
            }
            document.addEventListener("keydown", function (t) {
                if( !t.ctrlKey ) return ;
                if( t.code!="KeyS" ) return ;
                t.preventDefault();
                app.classList.add("grabado") ;
                setTimeout(x=>app.classList.remove("grabado"), 1000);
                guardar();
            });
            cargarArchivos();

            barra.oncontextmenu = function(e) {
                e.preventDefault();
                explorador.classList.toggle("chico");
            }
        </script>
    </body>
</html>