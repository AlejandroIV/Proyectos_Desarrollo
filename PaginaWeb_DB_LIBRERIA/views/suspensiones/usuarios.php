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
        <h1 class="center <?php echo $this->exito ? 'verde' : 'vino'; ?>"><?php if($this->exito){ echo "Usuarios Habilitados"; } else { echo "Usuarios Suspendidos"; }; ?></h1>

        <form action="<?php echo constant('URL'); ?>prestamos/verLibrosStock" method="POST" id="userForm">

            <div class="userItem">
                <div>
                    <label for="usuario">ID-Usuario</label><br>
                    <input type="text" name="usuario" id="usuario" required>
                </div>
            </div>

            <div class="espacio"></div>
            
            <button type="submit" id="seleccionarUsuario"><?php if($this->exito){ echo "Aplicar suspensión"; } else { echo "Cancelar suspensión"; }; ?></button>
        </form>
    </div>
    
    <!-- Seccion de busqueda y filtro de usuarios -->
    <div id="main">
        <h2 class="center">Buscar Usuarios</h2>
        
        <div class="espacio"></div>
        
        <form id="searchForm">
            <div>
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre">
            </div>
            
            <div class="espacio"></div>

            <button type="button" onclick="filtrarUsuarios()">Buscar</button>
            <button type="button" onclick="mostrarTodos()">Mostrar Todos</button>
        </form>
    </div>


    <!-- Tabla de usuarios -->
    <div class="center">
        <table width="40%" id="tablaUsuarios">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($this->datos as $usuario){
                        // Usuarios habilitados
                        if($this->exito && $usuario->iIdEstado == '1'){
                ?>
                <tr class="usuarioItem" data-nombre="<?php echo strtolower($usuario->vcNombreCompleto); ?>">
                    <td width="30%">
                        <?php echo $usuario->vcIdUsuario; ?>
                    </td>
                    <td>
                        <?php echo $usuario->vcNombreCompleto; ?>
                    </td>
                </tr>
                <?php 
                        }
                        elseif(!$this->exito && $usuario->iIdEstado == '3'){
                ?>
                <tr class="usuarioItem" data-nombre="<?php echo strtolower($usuario->vcNombreCompleto); ?>">
                    <td width="30%">
                        <?php echo $usuario->vcIdUsuario; ?>
                    </td>
                    <td>
                        <?php echo $usuario->vcNombreCompleto; ?>
                    </td>
                </tr>
                <?php            
                        }
                    } ?>
            </tbody>
        </table>
    </div>
    
    <!-- Filtrar la tabla de usuarios -->
    <script>
        function filtrarUsuarios(){
            var nombre = document.getElementById('nombre').value.trim().toLowerCase();

            var usuarios = document.querySelectorAll('.usuarioItem');
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
            var usuarios = document.querySelectorAll('.usuarioItem');
            usuarios.forEach(function(usuario) {
                usuario.style.display = 'table-row';
            });
        }
    </script>
    
    <script>
        const formUsuarios = document.getElementById("userForm");

        formUsuarios.addEventListener("submit", function(event){
            // Prevenir el comportamiento por defecto del formulario (recargar la pagina)
            event.preventDefault();

            // Obtener el valor actualizado del ID de usuario
            var idUsuario = document.getElementById('usuario').value.trim();
            
            // Se escoge el metodo de acuerdo a que vista se este cargando
            <?php if ($this->exito): ?>
                window.location.href = "<?php echo constant('URL'); ?>suspensiones/registrarSuspension/" + idUsuario;
            <?php else: ?>
                window.location.href = "<?php echo constant('URL'); ?>suspensiones/cancelarSuspension/" + idUsuario;
            <?php endif; ?>
        });
    </script>


    <?php require 'views/footer.php'; ?>
</body>
</html>