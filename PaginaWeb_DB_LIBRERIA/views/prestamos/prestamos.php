<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport" content = "width=device-width, initial-scale = 1.0">
    <title>Librería</title>
</head>
<body>
    <?php require 'views/header.php'; ?>
    
    <div id="main">
        <h1 class="center seccion">Lista de préstamos</h1>
    </div>
    
    <!-- Seccion de busqueda y filtro de usuarios -->
    <div id="main">
        <h2 class="center">Buscar Usuarios</h2>
        
        <div class="espacio"></div>
        
        <form id="searchForm">
            <div>
                <label for="nombre">Nombre del usuario</label>
                <input type="text" name="nombre" id="nombre">
            </div>
            
            <div class="espacio"></div>

            <button type="button" onclick="filtrarUsuarios()">Buscar</button>
            <button type="button" onclick="mostrarTodos()">Mostrar Todos</button>
        </form>
    </div>


    <!-- Tabla de prestamos -->
    <form class="center" id="tablaPrestamos" action="<?php echo constant('URL'); ?>prestamos/verPrestamosActivos" method="POST">
        <div>
            <div>
                <button type="submit">Realizar devolución</button>
            </div>
            
            <div class="espacio"></div>
            
            <table width="100%" id="tablaUsuarios">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Libro</th>
                        <th>Imagen</th>
                        <th>Nombre completo</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($this->datos as $prestamo){
                    ?>
                    <tr class="prestamoItem" data-nombre="<?php echo strtolower($prestamo->vcNombreCompleto); ?>">
                        <td>
                            <input type="checkbox" id="<?php echo $prestamo->vcIdPrestamo; ?>" name="ids[]" value="<?php echo $prestamo->vcIdPrestamo; ?>"><br>
                        </td>
                        <td width="30%">
                            <strong>Título: </strong><?php echo $prestamo->vcTitulo; ?><br>
                            <strong>Categoría: </strong><?php echo $prestamo->vcCategoria; ?><br>
                            <strong>Autores: </strong><?php echo $prestamo->vcAutores; ?><br>
                            <strong>Año de Publicación: </strong><?php echo $prestamo->siAnhoPublicacion; ?><br>
                            <strong>Ciudad de Publicación: </strong><?php echo $prestamo->vcCiudadPublicacion; ?><br>
                            <strong>Editorial: </strong><?php echo $prestamo->vcEditorial; ?><br>
                            <strong>Edición: </strong><?php echo $prestamo->tiEdicion; ?><br>
                            <strong>ISBN: </strong><?php echo $prestamo->cIsbn; ?>
                        </td>
                        <td><img src="<?php echo constant('URL') . 'imagenes/ISBN' . $prestamo->cIsbn ?>.png" onerror="this.onerror=null;this.src='<?php echo constant('URL') . 'Libro' ?>.png';" width="300px"></td>
                        <td>
                            <?php echo $prestamo->vcNombreCompleto; ?>
                        </td>
                        <td width="17%">
                            <strong>Fecha de préstamo: </strong><?php echo $prestamo->dFechaPrestamo; ?><br>
                            <strong>Fecha límite: </strong><?php echo $prestamo->dFechaDevolucion; ?><br>
                            <strong>Estado: </strong><?php echo $prestamo->vcEstado; ?><br>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </form>
    
    <!-- Filtrar la tabla de prestamos por usuario -->
    <script>
        function filtrarUsuarios(){
            var nombre = document.getElementById('nombre').value.trim().toLowerCase();

            var usuarios = document.querySelectorAll('.prestamoItem');
            usuarios.forEach(function(usuario){
                var nombreUsuario = usuario.dataset.nombre.toLowerCase();

                var nombreCoincide = nombreUsuario.includes(nombre);

                if(nombreCoincide){
                    usuario.style.display = 'table-row';
                }
                else{
                    usuario.style.display = 'none';
                }
            });
        }

        function mostrarTodos(){
            var usuarios = document.querySelectorAll('.prestamoItem');
            usuarios.forEach(function(usuario) {
                usuario.style.display = 'table-row';
            });
        }
    </script>
    
    <script>
        const formUsuarios = document.getElementById("tablaPrestamos");

        formUsuarios.addEventListener("submit", function(event){
            // Prevenir el comportamiento por defecto del formulario (recargar la pagina)
            event.preventDefault();

            // Obtener los checkboxes seleccionados
            var checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');

            // Obtener los IDs de los prestamos seleccionados
            var prestamosSeleccionados = [];
            checkboxes.forEach(function(checkbox){
                prestamosSeleccionados.push(checkbox.value);
            });
            
            // Convertir el array de IDs en una cadena separada por '/'
            const idsCadena = prestamosSeleccionados.join('/');

            window.location.href = "<?php echo constant('URL'); ?>prestamos/realizarDevolucion/" + idsCadena;
        });
    </script>



    <?php require 'views/footer.php'; ?>
</body>
</html>