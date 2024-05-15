<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale = 1.0">
    <title>Librería</title>
</head>
<body>
    <?php require 'views/header.php'; ?>
    
    <!-- Seccion de busqueda y filtro de libros -->
    <div id="main">
        <h1 class="center seccion">Registrar Venta</h1>
        
        <div class="center <?php echo $this->exito ? 'verde' : 'rojo'; ?>"><?php echo $this->mensaje; ?></div>

        <div class="espacio"></div>

        <form id="searchForm">
            <div>
                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo">
            </div>

            <div class="espacio"></div>

            <div>
                <label for="categoria">Categoría</label>
                <select name="categoria" id="categoria">
                    <option value=""></option>
                    <option value="Artístico e ilustrativo">Artístico e ilustrativo: Catálogos de museo y libros de fotografía</option>
                    <option value="Divulgativo">Divulgativo: Biografías o libros de divulgación científica</option>
                    <option value="Literatura">Literatura: Cuentos, poemarios y novelas</option>
                    <option value="Prácticos">Prácticos: Recetarios, instructivos y manuales</option>
                    <option value="Referencia">Referencia: Diccionarios, enciclopedias y atlas</option>
                    <option value="Técnico o especializado">Técnico o especializado: Documentación y libros de temas especializados</option>
                    <option value="Texto">Texto: Otros</option>
                </select>
            </div>

            <div>
                <label for="editorial">Editorial</label>
                <input type="text" name="editorial" id="editorial">
            </div>
            
            <div class="espacio"></div>

            <div>
                <label for="cantidadDisponible">Cantidad Disponible</label>
                <input type="number" name="cantidadDisponible" id="cantidadDisponible">
            </div>

            <div>
                <label for="ubicacion">Ubicación</label>
                <select name="ubicacion" id="ubicacion">
                    <option value=""></option>
                    <option value="ZN1">Almacén 1</option>
                    <option value="ZN2">Almacén 2</option>
                    <option value="ZN3">Almacén 3</option>
                    <option value="PA">Pasillo A</option>
                    <option value="PB">Pasillo B</option>
                    <option value="PC">Pasillo C</option>
                    <option value="PD">Pasillo D</option>
                    <option value="PE">Pasillo E</option>
                    <option value="PF">Pasillo F</option>
                    <option value="PG">Pasillo G</option>
                    <option value="PH">Pasillo H</option>
                    <option value="PI">Pasillo I</option>
                    <option value="E1">Estante 1</option>
                    <option value="E2">Estante 2</option>
                    <option value="E3">Estante 3</option>
                    <option value="E4">Estante 4</option>
                    <option value="E5">Estante 5</option>
                    <option value="E6">Estante 6</option>
                    <option value="E7">Estante 7</option>
                    <option value="E8">Estante 8</option>
                    <option value="E9">Estante 9</option>
                    <option value="E10">Estante 10</option>
                    <option value="E11">Estante 11</option>
                    <option value="E12">Estante 12</option>
                    <option value="E13">Estante 13</option>
                    <option value="E14">Estante 14</option>
                    <option value="E15">Estante 15</option>
                    <option value="E16">Estante 16</option>
                    <option value="E17">Estante 17</option>
                    <option value="E18">Estante 18</option>
                </select>
            </div>

            <div>
                <label for="cantidadVenta">Cantidad para Venta</label>
                <input type="number" name="cantidadVenta" id="cantidadVenta">
            </div>

            <div>
                <label for="precioMin">Precio Mínimo</label>
                <input type="number" name="precioMin" id="precioMin">
            </div>

            <div>
                <label for="precioMax">Precio Máximo</label>
                <input type="number" name="precioMax" id="precioMax">
            </div>

            <button type="button" onclick="filtrarLibros()">Buscar</button>
            <button type="button" onclick="mostrarTodos()">Mostrar Todos</button>
        </form>
    </div>
    
    <!-- Tabla de los detalles de los libros -->
    <form class="center" id="tablaLibrosVentas" action="<?php echo constant('URL'); ?>ventas/verResumenVenta" method="POST">
        <div>
            <div>
              <button type="submit">Registrar venta</button>
            </div>

            <div class="espacio"></div>

            <table width="100%">
              <thead>
                <tr>
                  <th>Selección</th>
                  <th>Libro</th>
                  <th>Imagen</th>
                  <th>Detalles</th>
                  <th>Cantidad</th>
                </tr>
              </thead>
                <tbody>
                  <?php
                    $cont = 0;
                    
                    foreach($this->datos as $libro){
                        $libroSeleccionado = explode("_", isset($this->elegidos[$cont]) ? $this->elegidos[$cont] : 'stock_venta_cantidad');
                        if($libroSeleccionado[0] == $libro->iIdStock && $libroSeleccionado[1] == $libro->cIdLibroVenta):
                            $checkbox = 1;
                            $cantidadElegida = intval($libroSeleccionado[2]);
                            $cont = $cont + 1;
                        else:
                            $checkbox = 0;
                            $cantidadElegida = 1;
                        endif;
                  ?>
                <tr class="libroItem" data-titulo="<?php echo strtolower($libro->vcTitulo); ?>"
                            data-categoria="<?php echo strtolower($libro->vcCategoria); ?>"
                            data-editorial="<?php echo strtolower($libro->vcEditorial); ?>"
                            data-cantidadDisponible="<?php echo strtolower($libro->siCantidadDisponible); ?>"
                            data-idUbicacion="<?php echo strtolower($libro->vcIdUbicacion); ?>"
                            data-cantidadVenta="<?php echo strtolower($libro->siCantidadParaVenta); ?>"
                            data-precio="<?php echo strtolower($libro->decPrecioUnitario); ?>">
                    <td>
                        <input type="checkbox" id="<?php echo $libro->iIdStock . '_' . $libro->cIdLibroVenta; ?>" name="ids[]" value="<?php echo $libro->iIdStock . '_' . $libro->cIdLibroVenta; ?>" <?php if($checkbox == 1): echo "checked"; endif; ?>><br>
                    </td>
                    <td width="400px">
                        <strong>Título: </strong><?php echo $libro->vcTitulo; ?><br>
                        <strong>Categoría: </strong><?php echo $libro->vcCategoria; ?><br>
                        <strong>Autores: </strong><?php echo $libro->vcAutores; ?><br>
                        <strong>Año de Publicación: </strong><?php echo $libro->siAnhoPublicacion; ?><br>
                        <strong>Ciudad de Publicación: </strong><?php echo $libro->vcCiudadPublicacion; ?><br>
                        <strong>Editorial: </strong><?php echo $libro->vcEditorial; ?><br>
                        <strong>Edición: </strong><?php echo $libro->tiEdicion; ?><br>
                        <strong>ISBN: </strong><?php echo $libro->cIsbn; ?>
                    </td>
                    <td><img src="<?php echo constant('URL') . 'imagenes/ISBN' . $libro->cIsbn ?>.png" onerror="this.onerror=null;this.src='<?php echo constant('URL') . 'Libro' ?>.png';" width="300px"></td>
                    <td width="400px">
                        <strong>Cantidad Disponible: </strong><?php echo $libro->siCantidadDisponible; ?><br>
                        <strong>Ubicación: </strong><?php echo $libro->vcDescripcionUbicacion; ?><br>
                        <strong>Cantidad para Venta: </strong><?php echo $libro->siCantidadParaVenta; ?><br>
                        <strong>Precio Unitario: </strong><?php echo $libro->decPrecioUnitario; ?><br>
                        <strong>Cantidad Total: </strong><?php echo $libro->siCantidadTotal; ?><br>
                    </td>
                    <td width="300px">
                        <input type="number" class="cantidadInput" name="cantidadesVenta[]" id="<?php echo $libro->iIdStock . '_' . $libro->cIdLibroVenta; ?>" value="<?php if($checkbox == 1): echo "$cantidadElegida"; else: echo "1"; endif; ?>" <?php if($checkbox != 1): echo "disabled"; endif; ?>>
                    </td>
                </tr>
                  <?php } ?>
                </tbody>
            </table>
        </div>
    </form>

    <?php require 'views/footer.php'; ?>
    
    <!-- Filtrar la tabla de los detalles de los libros -->
    <script>
        function filtrarLibros(){
            var titulo = document.getElementById('titulo').value.trim().toLowerCase();
            var categoria = document.getElementById('categoria').value.toLowerCase();
            var editorial = document.getElementById('editorial').value.trim().toLowerCase();
            var cantidadDisponible = parseInt(document.getElementById('cantidadDisponible').value);
            var ubicacion = document.getElementById('ubicacion').value.toLowerCase();
            var cantidadVenta = parseInt(document.getElementById('cantidadVenta').value);
            var precioMin = parseFloat(document.getElementById('precioMin').value);
            var precioMax = parseFloat(document.getElementById('precioMax').value);

            var libros = document.querySelectorAll('.libroItem');
            libros.forEach(function(libro){
                var tituloLibro = libro.dataset.titulo.toLowerCase();
                var categoriaLibro = libro.dataset.categoria.toLowerCase();
                var editorialLibro = libro.dataset.editorial.toLowerCase();
                var cantidadDisponibleLibro = parseInt(libro.dataset.cantidaddisponible);
                var ubicacionLibro = libro.dataset.idubicacion.toLowerCase();
                var cantidadVentaLibro = parseInt(libro.dataset.cantidadventa);
                var precioLibro = parseFloat(libro.dataset.precio);

                var tituloCoincide = tituloLibro.includes(titulo);
                var categoriaCoincide = categoria === "" || categoriaLibro === categoria;
                var editorialCoincide = editorialLibro.includes(editorial);
                var cantidadDisponibleCoincide = isNaN(cantidadDisponible) || (cantidadDisponible === cantidadDisponibleLibro);
                var ubicacionCoincide = ubicacion === "" || ubicacionLibro === ubicacion;
                var cantidadVentaCoincide = isNaN(cantidadVenta) || (cantidadVenta === cantidadVentaLibro);
                var precioCoincide = (isNaN(precioMin) || isNaN(precioMax)) || (precioLibro >= precioMin && precioLibro <= precioMax);

                if(tituloCoincide && categoriaCoincide && editorialCoincide && cantidadDisponibleCoincide && ubicacionCoincide && cantidadVentaCoincide && precioCoincide){
                    libro.style.display = 'table-row';
                }
                else{
                    libro.style.display = 'none';
                }
            });
        }
        
        function mostrarTodos(){
            var libros = document.querySelectorAll('.libroItem');
            libros.forEach(function(libro) {
                libro.style.display = 'table-row';
            });
        }
    </script>

    <!-- LLamar al metodo para renderizar la vista del resumen de la venta -->
    <script>
        const formLibros = document.getElementById("tablaLibrosVentas");

        formLibros.addEventListener("submit", function(event){
          // Prevenir el comportamiento por defecto del formulario (recargar la pagina)
          event.preventDefault();

          // Obtener solamente los registros con los checkboxes seleccionados
          const checkboxesSeleccionados = document.querySelectorAll('input[name="ids[]"]:checked');
          const cantidadesSeleccionadas = document.querySelectorAll('input[name="cantidadesVenta[]"]:enabled');

          const librosSeleccionados = [];

          // Recorrer los checkboxes seleccionados y obtener sus valores (IDs)
          checkboxesSeleccionados.forEach(function(checkbox, index){
            librosSeleccionados.push(checkbox.value + '_' + cantidadesSeleccionadas[index].value); // Incluye la cantidad
          });

          // Convertir el array de IDs en una cadena separada por '/'
          const idsCadena = librosSeleccionados.join('/');

          // Redirigir al metodo para renderizar el resumen de la venta y confirmarla con los IDs como parametros
          window.location.href = "<?php echo constant('URL'); ?>ventas/verResumenVenta/" + idsCadena;
        });
    </script>
  
    <!-- Habilitar los inputs en las filas donde los checkboxes estan marcados -->
    <script>
        // Obtener todos los checkboxes
         const checkboxes = document.querySelectorAll('input[name="ids[]"]');

         // Agregar un evento de cambio a cada checkbox
         checkboxes.forEach(function(checkbox){
             checkbox.addEventListener('change', function() {
                 // Obtener el input asociado al checkbox
                 const inputCantidad = this.closest('tr').querySelector('.cantidadInput');
                 // Habilitar o deshabilitar el input según el estado del checkbox
                 inputCantidad.disabled = !this.checked;
             });
         });
    </script>
</body>
</html>