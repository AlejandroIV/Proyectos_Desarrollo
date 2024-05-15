<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librería</title>
</head>
<body>
    <?php require 'views/header.php'; ?>
    
    <div id="main">
        <img src="<?php echo constant('URL') . 'Libro' ?>.png" onerror="this.onerror=null;this.src='<?php echo constant('URL') . 'PNG' ?>.png';" style="height: 100px; float: left; margin-right: 20px;">
        <h1 class="titulo"><?php echo $this->mensaje; ?></h1>
    </div>
    
    <div class="espacio-grande"></div>
    
    <?php require 'views/footer.php'; ?>
</body>
</html>