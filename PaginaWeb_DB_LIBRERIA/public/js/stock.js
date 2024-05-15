<!-- Agregar o eliminar formulario -->
document.getElementById('agregarStock').addEventListener('click', function() {
    var stockContainer = document.getElementById('stockContainer');
    var stockItem = document.createElement('div');
    stockItem.classList.add('stockItem');

    stockItem.innerHTML = `
        <div>
            <label for="libros">ID-Libro</label><br>
            <input type="text" name="libros[]" required>
        </div>

        <div class="espacio"></div>

        <div>
            <label for="ubicaciones">ID-Ubicacion</label><br>
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
    `;

    stockContainer.appendChild(stockItem);
});

document.getElementById('eliminarUltimo').addEventListener('click', function() {
    var stockContainer = document.getElementById('stockContainer');
    var stockItems = stockContainer.getElementsByClassName('stockItem');

    // Elimina el ultimo elemento si existen elementos para eliminar
    if (stockItems.length > 0) {
        stockContainer.removeChild(stockItems[stockItems.length - 1]);
    }
});

<!-- Filtrar la tabla de libros -->
function filtrarLibros(){
    var titulo = document.getElementById('titulo').value.trim().toLowerCase();
    var categoria = document.getElementById('categoria').value.toLowerCase();
    var editorial = document.getElementById('editorial').value.trim().toLowerCase();

    var libros = document.querySelectorAll('.libroItem');
    libros.forEach(function(libro){
        var tituloLibro = libro.querySelector('td').textContent.toLowerCase();
        var categoriaLibro = libro.dataset.categoria.toLowerCase();
        var editorialLibro = libro.dataset.editorial.toLowerCase();

        var tituloCoincide = tituloLibro.includes(titulo);
        var categoriaCoincide = categoria === "" || categoriaLibro === categoria;
        var editorialCoincide = editorialLibro.includes(editorial);

        if(tituloCoincide && categoriaCoincide && editorialCoincide){
            libro.style.display = 'table-row';
        }
        else{
            libro.style.display = 'none';
        }
    });
}

function mostrarTodos(){
    var libros = document.querySelectorAll('.libroItem');
    libros.forEach(function(libro) {
        libro.style.display = 'table-row';
    });
}