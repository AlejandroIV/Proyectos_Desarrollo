<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale = 1.0">
    <title>Librería</title>
</head>
<body>
    <?php require 'views/header.php'; ?>
    
    <h1 class="center seccion">Resumen del préstamo</h1>
    
    <!-- Tabla de los detalles de los libros -->
    <form class="center" id="tablaLibrosPrestamos" action="<?php echo constant('URL'); ?>prestamos/verResumenPrestamo" method="POST">
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
                  </tr>
                </thead>
                <tbody>
                    <?php
                        $cont = 0;
                        $cantidadLibrosTotal = 0;

                        foreach($this->datos as $libro){
                            // Aqui se hace la suposicion de que al momento de hacer la consulta se tendra el mismo orden
                            $libroStock = isset($_SESSION['ids_libros_seleccionados'][$cont]) ? $_SESSION['ids_libros_seleccionados'][$cont] : 'stock';

                            if($libro->iIdStock == $libroStock){
                    ?>
                        <tr class="libroItem">
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
                          <strong>Cantidad Total: </strong><?php echo $libro->siCantidadTotal; ?><br>
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
        <p>Cantidad de libros en total: <span id="cantidadLibrosTotal"><?php echo $cont; ?></span></p>
    </div>

    <?php require 'views/footer.php'; ?>
    
    <script>
        document.getElementById('tablaLibrosPrestamos').addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar el envio del formulario

            var accion = event.submitter.value; // Obtener el valor del boton que se presiono
            
            // Obtener el valor del ID usuario
            //var idUsuario = document.getElementById('usuario').value.trim();

            if (accion === 'regresar') {
                window.location.href = "<?php echo constant('URL'); ?>prestamos/verLibrosStock/" + "<?php echo $this->seleccion[0]->vcIdUsuario; ?>/" + "<?php echo implode('/', $_SESSION['ids_libros_seleccionados']); ?>";
            } else if (accion === 'continuar') {
                window.location.href = "<?php echo constant('URL'); ?>prestamos/registrarPrestamo/" + "<?php echo $this->seleccion[0]->vcIdUsuario; ?>/" + "<?php echo implode('/', $_SESSION['ids_libros_seleccionados']); ?>";
            }
        });
    </script>
</body>
</html>