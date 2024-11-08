// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    precio: 0.0,
    unidades: 1,
    modelo: 'XX-000',
    marca: 'NA',
    detalles: 'NA',
    imagen: 'default.png',
  };
  
  var edit = false; // Variable para identificar si estamos editando un producto
  
  function init() {
    // Convierte el JSON a string para poder mostrarlo en el formulario
    var JsonString = JSON.stringify(baseJSON, null, 2);
    document.getElementById('description').value = JsonString;
  }
  
  $(document).ready(function () {
    obtenerProductos(); // Obtiene la lista de productos al cargar la página
  
    $('#search').keyup(function (e) {
      let search = $('#search').val();
      if (search.length > 0) {
        $.ajax({
          url: 'backend/product-search.php',
          type: 'POST',
          data: { search },
          success: function (response) {
            let products = JSON.parse(response);
            mostrarNombresEnBarraEstado(products);
            if (products.length > 0) {
              $('#product-result').removeClass('d-none');
              mostrarProductosEnTabla(products);
            } else {
              $('#product-result').addClass('d-none');
              $('#container-resultados').html('');
            }
          },
        });
      } else {
        obtenerProductos();
        $('#product-result').addClass('d-none');
        $('#container-resultados').html('');
      }
    });
  
    // Función para agregar o editar un producto
    $('#product-form').submit(function (e) {
      e.preventDefault();
      let descriptionJSON;
      try {
        descriptionJSON = JSON.parse($('#description').val());
      } catch (error) {
        console.error('Error en el JSON:', error);
        alert('El formato del JSON es inválido');
        return;
      }
  
      const postData = {
        id: $('#productId').val(),
        nombre: $('#name').val(),
        marca: descriptionJSON.marca,
        modelo: descriptionJSON.modelo,
        precio: descriptionJSON.precio,
        detalles: descriptionJSON.detalles,
        unidades: descriptionJSON.unidades,
        imagen: descriptionJSON.imagen,
      };
  
      const url = edit ? 'backend/product-update.php' : 'backend/product-add.php'; // URL según si estamos editando o agregando
  
      $.ajax({
        url: url,
        type: 'POST',
        data: JSON.stringify(postData),
        contentType: 'application/json',
        success: function (response) {
          let respuesta = JSON.parse(response);
          let message = '';
  
          if (respuesta.status === 'success') {
            message = edit ? 'Producto actualizado correctamente' : 'Producto agregado correctamente';
            $('#product-form').trigger('reset');  // Limpia el formulario
            init(); // Reinicia el formulario con los valores por defecto
            obtenerProductos(); // Vuelve a cargar la lista de productos
          } else if (respuesta.status === 'error') {
            message = respuesta.message || 'Hubo un error en la operación';
          } else {
            message = 'Error inesperado en la operación';
          }
  
          let template_bar = `
            <li style="list-style: none;">status: ${respuesta.status}</li>
            <li style="list-style: none;">message: ${message}</li>
          `;
          $('#container-resultados').html(template_bar);
          $('#product-result').removeClass('d-none');
        },
        error: function (xhr, status, error) {
          console.error('Error al procesar la solicitud:', error);
          let template_bar = `
            <li style="list-style: none;">status: error</li>
            <li style="list-style: none;">message: Error al procesar la solicitud. Por favor, intenta de nuevo.</li>
          `;
          $('#container-resultados').html(template_bar);
          $('#product-result').removeClass('d-none');
        },
      });
    });
  
    // Función para eliminar un producto
    $(document).on('click', '.product-delete', function () {
      if (confirm('Estás seguro de borrar este producto?')) {
        let element = $(this).closest('tr');
        let id = element.attr('productoID');
        $.post('backend/product-delete.php', { id }, function () {
          obtenerProductos(); // Vuelve a obtener la lista de productos después de eliminar uno
        });
      }
    });
  
    // Función para cargar los datos de un producto para editar
    $(document).on('click', '.product-item', function () {
      let element = $(this)[0].parentElement.parentElement;
      let id = $(element).attr('productoID');
      $.post('backend/product-get.php', { id }, function (response) {
        let producto = JSON.parse(response);
        $('#productId').val(producto.id);
        $('#name').val(producto.nombre);
        let descriptionJSON = {
          precio: producto.precio,
          unidades: producto.unidades,
          modelo: producto.modelo,
          marca: producto.marca,
          detalles: producto.detalles,
          imagen: producto.imagen,
        };
        $('#description').val(JSON.stringify(descriptionJSON, null, 2));
  
        edit = true;  // Cambia el estado a edición
        $('#product-form button[type="submit"]').text('Actualizar Producto'); // Cambia el texto del botón
      });
    });
  
    // Función para obtener la lista de productos
    function obtenerProductos() {
      $.ajax({
        url: 'backend/product-list.php',
        type: 'GET',
        success: function (response) {
          let productos = JSON.parse(response);
          mostrarProductosEnTabla(productos);
        },
      });
    }
  
    // Función para mostrar los productos en la tabla
    function mostrarProductosEnTabla(productos) {
      let template = '';
      productos.forEach((producto) => {
        let descripcion = '';
        descripcion += '<li>precio: ' + producto.precio + '</li>';
        descripcion += '<li>unidades: ' + producto.unidades + '</li>';
        descripcion += '<li>modelo: ' + producto.modelo + '</li>';
        descripcion += '<li>marca: ' + producto.marca + '</li>';
        descripcion += '<li>detalles: ' + producto.detalles + '</li>';
        template += `
          <tr productoID="${producto.id}">
            <td>${producto.id}</td>
            <td><a href="#" class="product-item">${producto.nombre}</a></td>
            <td><ul>${descripcion}</ul></td>
            <td>
              <button class="product-delete btn btn-danger">
                Eliminar
              </button>
            </td>
          </tr>
        `;
      });
      $('#products').html(template);
    }
  
    // Función para mostrar los nombres de productos en la barra de estado
    function mostrarNombresEnBarraEstado(productos) {
      let template_bar = '<ul>';
      productos.forEach(producto => {
        template_bar += `<li>${producto.nombre}</li>`;
      });
      template_bar += '</ul>';
      $('#container-resultados').html(template_bar);
    }
  
    // Inicializa el formulario con valores por defecto al cargar la página
    init();
  });
  