<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librería</title>
</head>
<body>
    <?php require 'views/header.php'; ?>
    
    <div id = "main">
        <h1 class="center error"><?php echo $this->mensaje; ?></h1>
    </div>
    
    <?php require 'views/footer.php'; ?>
</body>
</html>