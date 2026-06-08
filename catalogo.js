// ============================================================
// catalogo.js - Carga el catalogo desde catalogo.xml (sin PHP)
// La BBDD MySQL exporta la tabla ARTICULO a catalogo.xml; esta
// pagina lo descarga con fetch() y lo pinta en el navegador.
// Funciona en GitHub Pages (solo ficheros estaticos).
// ASIR - Proyecto Intermodular - Fran Ulecia
// ============================================================

document.addEventListener('DOMContentLoaded', function () {
    var estado = document.getElementById('estado');
    var tabla = document.getElementById('tabla-catalogo');
    var cuerpo = document.getElementById('cuerpo-catalogo');

    estado.textContent = 'Cargando catálogo...';

    fetch('catalogo.xml')
        .then(function (resp) {
            if (!resp.ok) throw new Error('No se pudo cargar catalogo.xml (HTTP ' + resp.status + ')');
            return resp.text();
        })
        .then(function (texto) {
            // Parsear el XML que genera "mysql -X": <resultset><row><field name="...">valor</field>...
            var xml = new DOMParser().parseFromString(texto, 'application/xml');
            if (xml.querySelector('parsererror')) throw new Error('El fichero catalogo.xml no es XML bien formado.');

            var filas = xml.getElementsByTagName('row');
            if (filas.length === 0) {
                estado.textContent = 'No hay artículos en el catálogo.';
                return;
            }

            // Helper: obtener el valor de un <field name="campo"> dentro de una fila
            function campo(fila, nombre) {
                var fields = fila.getElementsByTagName('field');
                for (var i = 0; i < fields.length; i++) {
                    if (fields[i].getAttribute('name') === nombre) return fields[i].textContent;
                }
                return '';
            }

            var html = '';
            for (var i = 0; i < filas.length; i++) {
                var f = filas[i];
                var precio = parseFloat(campo(f, 'precio_u') || '0')
                    .toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                html += '<tr>'
                    + celda(campo(f, 'cod_articulo'), 'left')
                    + celda(campo(f, 'nombre'), 'left')
                    + celda(precio + ' &euro;', 'right')
                    + celda(campo(f, 'stock'), 'center')
                    + celda(campo(f, 'licencia'), 'center')
                    + '</tr>';
            }
            cuerpo.innerHTML = html;
            tabla.style.display = '';
            estado.textContent = '';
        })
        .catch(function (err) {
            estado.innerHTML = '<span style="color:#c0392b;">Error: ' + err.message + '</span>';
        });

    function celda(valor, align) {
        return '<td style="padding:0.6rem; border-bottom:1px solid #eee; text-align:' + align + ';">'
            + valor + '</td>';
    }
});
