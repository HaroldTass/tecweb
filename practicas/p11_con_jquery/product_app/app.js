// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

// Inicializa la página cargando el JSON y los productos
function init() {
    var JsonString = JSON.stringify(baseJSON, null, 2);
    $('#description').val(JsonString);
    listarProductos();
}

// Función para listar productos no eliminados
function listarProductos(filtro = '') {
    $.ajax({
        url: './backend/product-list.php',
        method: 'GET',
        success: function(response) {
            let productos = JSON.parse(response);
            let template = '';

            // Filtrar productos no eliminados y que coincidan con el filtro
            productos = productos.filter(producto => !producto.eliminado && producto.nombre.toLowerCase().includes(filtro.toLowerCase()));

            if (productos.length > 0) {
                productos.forEach(producto => {
                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td contenteditable="true" class="editable nombre">${producto.nombre}</td>
                            <td contenteditable="true" class="editable descripcion">${producto.detalles}</td>
                            <td>
                                <button class="product-edit btn btn-warning">Guardar Cambios</button>
                                <button class="product-delete btn btn-danger">Eliminar</button>
                            </td>
                        </tr>
                    `;
                });

                $('#products').html(template);
            } else {
                $('#products').html('<tr><td colspan="4">No se encontraron productos.</td></tr>');
            }
        }
    });
}

// Función para buscar productos mientras se escribe
function buscarProducto() {
    let search = $('#search').val();
    listarProductos(search);
}

// Función para agregar un producto
function agregarProducto(e) {
    e.preventDefault();
    let productoJsonString = $('#description').val();
    let finalJSON = JSON.parse(productoJsonString);
    finalJSON['nombre'] = $('#name').val();

    $.ajax({
        url: './backend/product-add.php',
        method: 'POST',
        data: JSON.stringify(finalJSON),
        contentType: 'application/json;charset=UTF-8',
        success: function(response) {
            let respuesta = JSON.parse(response);
            alert(respuesta.message); // Mostrar mensaje con el resultado de la operación
            listarProductos();
        }
    });
}

// Función para eliminar un producto
function eliminarProducto() {
    if (confirm("¿De verdad deseas eliminar el Producto?")) {
        let id = $(event.target).closest('tr').attr('productId');

        $.ajax({
            url: './backend/product-delete.php',
            method: 'GET',
            data: { id: id },
            contentType: 'application/x-www-form-urlencoded',
            success: function(response) {
                let respuesta = JSON.parse(response);
                alert(respuesta.message); // Mostrar mensaje con el resultado de la operación
                listarProductos();
            }
        });
    }
}

// Función para guardar cambios de un producto
function guardarCambiosProducto() {
    let id = $(event.target).closest('tr').attr('productId');
    let nombre = $(event.target).closest('tr').find('.nombre').text();
    let descripcion = $(event.target).closest('tr').find('.descripcion').text();

    let finalJSON = {
        id: id,
        nombre: nombre,
        detalles: descripcion
    };

    $.ajax({
        url: './backend/product-edit.php',
        method: 'POST',
        data: JSON.stringify(finalJSON),
        contentType: 'application/json;charset=UTF-8',
        success: function(response) {
            let respuesta = JSON.parse(response);
            alert(respuesta.message); // Mostrar mensaje con el resultado de la operación
            listarProductos(); // Recargar la lista de productos
        }
    });
}

// Inicialización del documento
$(document).ready(function() {
    init();

    // Event listeners
    $('#search').on('input', buscarProducto);
    $('#product-form').on('submit', agregarProducto);
    $('#products').on('click', '.product-edit', guardarCambiosProducto);
    $('#products').on('click', '.product-delete', eliminarProducto);
});
