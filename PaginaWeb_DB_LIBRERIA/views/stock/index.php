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
        <h1 class="center seccion">Registrar Stock</h1>

        <div class="center <?php echo $this->exito ? 'verde' : 'rojo'; ?>"><?php echo $this->mensaje; ?></div>

        <form action="<?php echo constant('URL'); ?>stock/registrarStock" method="POST" id="stockForm">

            <div id="stockContainer">
                <div class="stockItem">
                    <div>
                        <label for="libros">ID-Libro</label><br>
                        <input type="text" name="libros[]" required>
                    </div>

                    <div class="espacio"></div>

                    <div>
                        <label for="ubicaciones">Ubicacion</label><br>
                        <select name="ubicaciones[]" required>
                            <option value="ZN1">Almacén 1 - Capacidad: 120</option>
                            <option value="ZN2">Almacén 2 - Capacidad: 120</option>
                            <option value="ZN3">Almacén 3 - Capacidad: 120</option>
                            <option value="PA">Pasillo A - Capacidad: 40</option>
                            <option value="PB">Pasillo B - Capacidad: 40</option>
                            <option value="PC">Pasillo C - Capacidad: 40</option>
                            <option value="PD">Pasillo D - Capacidad: 40</option>
                            <option value="PE">Pasillo E - Capacidad: 40</option>
                            <option value="PF">Pasillo F - Capacidad: 40</option>
                            <option value="PG">Pasillo G - Capacidad: 40</option>
                            <option value="PH">Pasillo H - Capacidad: 40</option>
                            <option value="PI">Pasillo I - Capacidad: 40</option>
                            <option value="E1">Estante 1 - Capacidad: 20</option>
                            <option value="E2">Estante 2 - Capacidad: 20</option>
                            <option value="E3">Estante 3 - Capacidad: 20</option>
                            <option value="E4">Estante 4 - Capacidad: 20</option>
                            <option value="E5">Estante 5 - Capacidad: 20</option>
                            <option value="E6">Estante 6 - Capacidad: 20</option>
                            <option value="E7">Estante 7 - Capacidad: 20</option>
                            <option value="E8">Estante 8 - Capacidad: 20</option>
                            <option value="E9">Estante 9 - Capacidad: 20</option>
                            <option value="E10">Estante 10 - Capacidad: 20</option>
                            <option value="E11">Estante 11 - Capacidad: 20</option>
                            <option value="E12">Estante 12 - Capacidad: 20</option>
                            <option value="E13">Estante 13 - Capacidad: 20</option>
                            <option value="E14">Estante 14 - Capacidad: 20</option>
                            <option value="E15">Estante 15 - Capacidad: 20</option>
                            <option value="E16">Estante 16 - Capacidad: 20</option>
                            <option value="E17">Estante 17 - Capacidad: 20</option>
                            <option value="E18">Estante 18 - Capacidad: 20</option>
                        </select>
                    </div>


                    <div class="espacio"></div>

                    <div>
                        <label for="cantidades">Cantidad</label><br>
                        <input type="text" name="cantidades[]" required>
                    </div>

                    <div class="espacio"></div>
                </div>
            </div>

            <button type="button" id="agregarStock">Agregar más</button>
            <button type="button" id="eliminarUltimo">Eliminar último</button>

            <div>
                <button type="submit">Registrar stock</button>
            </div>
        </form>
    </div>
    
    <!-- Seccion de busqueda y filtro de libros -->
    <div id="main">
        <h2 class="center">Buscar Libros</h2>
        
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

            <button type="button" onclick="filtrarLibros()">Buscar</button>
            <button type="button" onclick="mostrarTodos()">Mostrar Todos</button>
        </form>
    </div>


    <!-- Tabla de libros -->
    <div class="center">
        <table width="70%" id="tablaLibros">
            <thead>
                <tr>
                    <th>Libro</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($this->datos as $libro){
                ?>
                <tr class="libroItem" data-categoria="<?php echo strtolower($libro->vcCategoria); ?>" data-editorial="<?php echo strtolower($libro->vcEditorial); ?>">
                    <td>
                        <strong>ID: </strong><?php echo $libro->vcIdLibro; ?><br>
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
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="<?php echo constant('URL'); ?>public/js/stock.js"></script>
    
    <?php require 'views/footer.php'; ?>
</body>
</html>