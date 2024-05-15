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
        <h1 class="center seccion">Suspensiones</h1>
        
        <div class="center <?php echo $this->exito ? 'verde' : 'rojo'; ?>"><?php echo $this->mensaje; ?></div>
    
        <div class="container">
            <form class="center" id="tablaLibrosVentas" method="POST">
                <button class="button-large" type="submit" formaction="<?php echo constant('URL'); ?>suspensiones/verUsuariosHabilitados">Aplicar suspensión</button><br>
                <button class="button-large" type="submit" formaction="<?php echo constant('URL'); ?>suspensiones/verUsuariosSuspendidos">Cancelar suspensión</button>
            </form>
        </div>

        <div class="espacio"></div>
    </div>

    <?php require 'views/footer.php'; ?>
</body>
</html>