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
        <h3 class="center">Detalles del libro</h3>
        
        <form action="<?php echo constant('URL'); ?>libros/actualizarDetallesLibro" method="POST" id="detallesLibroForm">
            <label>Título</label>
            <input type="text" value="<?php echo $this->datos[0]; ?>" readonly><br>
            
            <div class="espacio"></div>
            
            <label>Ubicación</label>
            <input type="text" value="<?php echo $this->datos[1]; ?>" readonly><br>
            
            <div class="espacio"></div>
            
            <input type="hidden" name="idLibro" id="idLibro" value="<?php echo $this->datos[2]; ?>">
            <input type="hidden" name="idUbicacion" id="idUbicacion" value="<?php echo $this->datos[3]; ?>">
            
            <label for="cantidadDisponible">Cantidad Disponible</label>
            <input type="number" name="cantidadDisponible" id="cantidadDisponible" value="<?php echo $this->datos[4]; ?>" required><br>

            <label for="cantidadVenta">Cantidad para Venta</label>
            <input type="number" name="cantidadVenta" id="cantidadVenta" value="<?php echo $this->datos[5]; ?>" required><br>

            <label for="precio">Precio</label>
            <input type="number" name="precio" id="precio" step="any" value="<?php echo $this->datos[6]; ?>" required><br>

            <button type="submit">Editar</button>
        </form>
    </div>
    
    <?php require 'views/footer.php'; ?>
</body>
</html>