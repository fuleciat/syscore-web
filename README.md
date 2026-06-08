# SysCore Solutions — Sitio web corporativo

Sitio web estático de la empresa ficticia **SysCore Solutions**, desarrollado para el
Proyecto Intermodular de 1.º ASIR (IES Camp de Morvedre).

## Hosting

- **Pública (exterior):** GitHub Pages — `https://TU_USUARIO.github.io/syscore-web/`
- **Interna (intranet):** servidor Apache de la DMZ (`http://10.0.0.20`)

## Integración con la base de datos (sin PHP)

El catálogo de productos procede de la base de datos **MySQL** del servidor de
almacenamiento (10.0.0.10). Como GitHub Pages solo sirve ficheros estáticos, los datos
se integran así:

1. MySQL exporta la tabla `ARTICULO` a un fichero **XML bien formado**:
   ```
   sudo mysql -X almacen -e "SELECT cod_articulo, nombre, precio_u, stock, licencia FROM ARTICULO ORDER BY cod_articulo" > catalogo.xml
   ```
   (o ejecutando `exportar_catalogo.sh`).
2. El `catalogo.xml` se sube al repositorio junto a la web.
3. La página `catalogo.html` carga `catalogo.xml` con `fetch()` mediante `catalogo.js`,
   lo parsea con `DOMParser` y muestra la tabla en el navegador.

> El catálogo refleja el estado de la base de datos en el momento de la última
> exportación. Para actualizarlo: re-exportar el XML y hacer `git push`.

## Estructura

| Fichero | Descripción |
|---|---|
| `index.html` | Página de inicio |
| `servicios.html`, `empresa.html`, `contacto.html`, `tienda.html`, `ficha-seguridad.html`, `planes.html` | Páginas del sitio |
| `catalogo.html` | Catálogo dinámico (carga `catalogo.xml`) |
| `catalogo.js` | Lógica de carga y render del XML |
| `catalogo.xml` | Datos del catálogo exportados de MySQL |
| `styles.css` | Hoja de estilos común |
| `imagenes/` | Recursos gráficos |

## Actualizar el catálogo

```bash
# En el ServidorAlmacenamiento (10.0.0.10):
bash exportar_catalogo.sh ~/catalogo.xml
# Llevar el XML a la copia local del repo y publicar:
git add catalogo.xml
git commit -m "Actualiza catalogo"
git push
```
