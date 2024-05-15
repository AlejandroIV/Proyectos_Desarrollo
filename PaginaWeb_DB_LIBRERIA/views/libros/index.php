<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale = 1.0">
    <title>Librería</title>
</head>
<body onload="ocultarTodosLosDivsDeConfirmacion()">
    <?php require 'views/header.php'; ?>
    
    <!-- Seccion de busqueda y filtro de libros -->
    <div id="main">
        <h1 class="center seccion">Modificar Libros</h1>
        
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
    <div class="center">
        <table width="100%" id="tablaDetallesLibros">
            <thead>
                <tr>
                    <th>Libro</th>
                    <th>Imagen</th>
                    <th>Detalles</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($this->datos as $libro){
                ?>
                <tr class="libroItem" data-categoria="<?php echo strtolower($libro->vcCategoria); ?>"
                    data-editorial="<?php echo strtolower($libro->vcEditorial); ?>"
                    data-cantidadDisponible="<?php echo strtolower($libro->siCantidadDisponible); ?>"
                    data-idUbicacion="<?php echo strtolower($libro->vcIdUbicacion); ?>"
                    data-cantidadVenta="<?php echo strtolower($libro->siCantidadParaVenta); ?>"
                    data-precio="<?php echo strtolower($libro->decPrecioUnitario); ?>">
                    <td width="400px">
                        <strong>Título: </strong><?php echo $libro->vcTitulo; ?><br>
                        <strong>Categoría: </strong><?php echo $libro->vcCategoria; ?><br>
                        <strong>Autores: </strong><?php echo $libro->vcAutores; ?><br>
                        <strong>Año de Publicación: </strong><?php echo $libro->siAnhoPublicacion; ?><br>
                        <strong>Ciudad de Publicación: </strong><?php echo $libro->vcCiudadPublicacion; ?><br>
                        <strong>Editorial: </strong><?php echo $libro->vcEditorial; ?><br>
                        <strong>Edición: </strong><?php echo $libro->tiEdicion; ?><br> <!-- Faltaba un '<' -->
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
                    <td width="400px">
                        <strong><a class="button-like" href="<?php echo constant('URL') . 'libros/verDetallesLibro/' . urlencode($libro->vcTitulo) . '/' . urlencode($libro->vcDescripcionUbicacion) . '/' . $libro->vcIdLibro . '/' . $libro->vcIdUbicacion . '/' . $libro->siCantidadDisponible . '/' . $libro->siCantidadParaVenta . '/' . $libro->decPrecioUnitario ?>">Editar</a></strong><br>
                        <button onclick="confirmarEliminar('<?php echo $libro->vcIdLibro . "_" . $libro->vcIdUbicacion; ?>')">Eliminar</button>
                        
                        <div class="espacio"></div>
                        
                        <div id="confirmacion_<?php echo $libro->vcIdLibro . "_" . $libro->vcIdUbicacion; ?>">
                            <label>¿Estás seguro?</label><br>
                            <a class="button-like" href="<?php echo constant('URL') . 'libros/eliminarDetallesLibro/' . $libro->vcIdLibro . '/' . $libro->vcIdUbicacion ?>">Si</a>
                            <button onclick="cancelarEliminar('<?php echo $libro->vcIdLibro . "_" . $libro->vcIdUbicacion; ?>')">No</button>
                        </div>
                        
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    
    <script src="<?php echo constant('URL'); ?>public/js/libros.js"></script>
    
    <?php require 'views/footer.php'; ?>
    
    <script>
        function ocultarTodosLosDivsDeConfirmacion(){
            var confirmaciones = document.querySelectorAll("[id^='confirmacion_']");
            confirmaciones.forEach(function(confirmacion) {
                confirmacion.style.display = "none";
            });
        }
        
        function confirmarEliminar(id) {
            // Ocultar todos los divs de confirmacion
            var confirmaciones = document.querySelectorAll("[id^='confirmacion_']");
            confirmaciones.forEach(function(confirmacion) {
                confirmacion.style.display = "none";
            });

            // Mostrar solamente con el div perteneciente al boton para eliminar
            document.getElementById("confirmacion_" + id).style.display = "block";
        }

        function cancelarEliminar(id) {
            // Oculta la parte de confirmacion del div perteneciente al boton para eliminar (al presionar no)
            document.getElementById("confirmacion_" + id).style.display = "none";
        }
    </script>
</body>
</html>