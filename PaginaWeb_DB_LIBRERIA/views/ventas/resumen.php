<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale = 1.0">
    <title>Librería</title>
</head>
<body>
    <?php require 'views/header.php'; ?>
    
    <h1 class="center seccion">Resumen de la venta</h1>
    
    <!-- Tabla de los detalles de los libros -->
    <form class="center" id="tablaLibrosVentas" action="<?php echo constant('URL'); ?>ventas/verResumenVenta" method="POST">
        <div>
            <div>
                <button type="submit" name="accion" value="regresar">Regresar</button>
                <button type="submit" name="accion" value="continuar">Continuar</button>
            </div>

            <div class="espacio"></div>

            <table width="70%">
                <thead>
                  <tr>
                    <th>Libro</th>
                    <th>Imagen</th>
                    <th>Detalles</th>
                    <th>Cantidad</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                        $cont = 0;
                        $cantidadLibrosTotal = 0;
                        $precioTotal = 0;

                        foreach($this->datos as $libro){
                            // Aqui se hace la suposicion de que al momento de hacer la consulta se tendra el mismo orden
                            $libroSeleccionado = explode("_", isset($_SESSION['ids_libros_seleccionados'][$cont]) ? $_SESSION['ids_libros_seleccionados'][$cont] : 'stock_venta_cantidad');
                            $libroStock = $libroSeleccionado[0];
                            $lbroVenta = $libroSeleccionado[1];
                            $libroCantidad = $libroSeleccionado[2];

                            if($libro->iIdStock == $libroStock && $libro->cIdLibroVenta == $lbroVenta){
                                // Calcula el precio total y la cantidad de libros en total de forma acumulada en cada iteracion
                                $cantidadLibrosTotal = $cantidadLibrosTotal + intval($libroCantidad);
                                $precioTotal = $precioTotal + (intval($libroCantidad) * floatval($libro->decPrecioUnitario));
                    ?>
                        <tr class="libroItem">
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
                            <input type="number" name="cantidadesVenta[]" id="cantidadesVenta" value="<?php echo intval($libroCantidad); ?>" readonly>
                        </td>
                    </tr>
                    <?php 
                                $cont = $cont + 1;
                            }
                        } ?>
                </tbody>
            </table>
        </div>
      </form>
    
    <div id="resumen" class="center">
        <p>Cantidad de libros en total: <span id="cantidadLibrosTotal"><?php echo $cantidadLibrosTotal; ?></span></p>
        <p>Total: $<span id="totalVenta"><?php echo $precioTotal; ?></span></p>
    </div>

    <?php require 'views/footer.php'; ?>
    
    <script>
        document.getElementById('tablaLibrosVentas').addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar el envio del formulario

            var accion = event.submitter.value; // Obtener el valor del boton que se presiono

            if (accion === 'regresar') {
                window.location.href = "<?php echo constant('URL'); ?>ventas/render/" + "<?php echo implode('/', $_SESSION['ids_libros_seleccionados']); ?>";
            } else if (accion === 'continuar') {
                window.location.href = "<?php echo constant('URL'); ?>ventas/registrarVenta/" + "<?php echo implode('/', $_SESSION['ids_libros_seleccionados']); ?>";
            }
        });
    </script>
</body>
</html>