<!-- Filtrar la tabla de los detalles de los libros -->
function filtrarLibros(){
    var titulo = document.getElementById('titulo').value.trim().toLowerCase();
    var categoria = document.getElementById('categoria').value.toLowerCase();
    var editorial = document.getElementById('editorial').value.trim().toLowerCase();
    var cantidadDisponible = parseInt(document.getElementById('cantidadDisponible').value);
    var ubicacion = document.getElementById('ubicacion').value.toLowerCase();
    var cantidadVenta = parseInt(document.getElementById('cantidadVenta').value);
    var precioMin = parseFloat(document.getElementById('precioMin').value);
    var precioMax = parseFloat(document.getElementById('precioMax').value);

    var libros = document.querySelectorAll('.libroItem');
    libros.forEach(function(libro){
        var tituloLibro = libro.querySelector('td').textContent.toLowerCase();
        var categoriaLibro = libro.dataset.categoria.toLowerCase();
        var editorialLibro = libro.dataset.editorial.toLowerCase();
        var cantidadDisponibleLibro = parseInt(libro.dataset.cantidaddisponible);
        var ubicacionLibro = libro.dataset.idubicacion.toLowerCase();
        var cantidadVentaLibro = parseInt(libro.dataset.cantidadventa);
        var precioLibro = parseFloat(libro.dataset.precio);

        var tituloCoincide = tituloLibro.includes(titulo);
        var categoriaCoincide = categoria === "" || categoriaLibro === categoria;
        var editorialCoincide = editorialLibro.includes(editorial);
        var cantidadDisponibleCoincide = isNaN(cantidadDisponible) || (cantidadDisponible === cantidadDisponibleLibro);
        var ubicacionCoincide = ubicacion === "" || ubicacionLibro === ubicacion;
        var cantidadVentaCoincide = isNaN(cantidadVenta) || (cantidadVenta === cantidadVentaLibro);
        var precioCoincide = (isNaN(precioMin) || isNaN(precioMax)) || (precioLibro >= precioMin && precioLibro <= precioMax);

        if(tituloCoincide && categoriaCoincide && editorialCoincide && cantidadDisponibleCoincide && ubicacionCoincide && cantidadVentaCoincide && precioCoincide){
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