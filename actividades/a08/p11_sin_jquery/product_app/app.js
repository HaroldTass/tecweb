$(document).ready(function () {
  obtenerProductos();

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
    if (validateForm()) {
      const postData = {
        id: $('#productId').val(),
        nombre: $('#name').val(),
        marca: $('#marca').val(),
        modelo: $('#modelo').val(),
        precio: $('#precio').val(),
        detalles: $('#detalles').val(),
        unidades: $('#unidades').val(),
        imagen: $('#imagen').val(),
      };

      const url = postData.id ? 'backend/product-update.php' : 'backend/product-add.php';

      $.ajax({
        url: url,
        type: 'POST',
        data: JSON.stringify(postData),
        contentType: 'application/json',
        success: function (response) {
          let respuesta = JSON.parse(response);
          let message = '';

          if (respuesta.status === 'success') {
            message = 'Producto actualizado correctamente';
            $('#product-form').trigger('reset');
            obtenerProductos();
          } else if (respuesta.status === 'error') {
            message = respuesta.message || 'Hubo un error en la actualización';
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
          console.error('Error al actualizar el producto:', error);
          let template_bar = `
            <li style="list-style: none;">status: error</li>
            <li style="list-style: none;">message: Error al actualizar el producto. Por favor, intenta de nuevo.</li>
          `;
          $('#container-resultados').html(template_bar);
          $('#product-result').removeClass('d-none');
        },
      });
    } else {
      alert('Por favor, complete todos los campos requeridos.');
    }
  });

  $(document).on('click', '.product-delete', function () {
    if (confirm('Estás seguro de borrar este producto?')) {
      let element = $(this).closest('tr');
      let id = element.attr('productoID');
      $.post('backend/product-delete.php', { id }, function () {
        obtenerProductos();
      });
    }
  });

  $(document).on('click', '.product-item', function () {
    let element = $(this)[0].parentElement.parentElement;
    let id = $(element).attr('productoID');
    $.post('backend/product-get.php', { id }, function (response) {
      let producto = JSON.parse(response);
      $('#productId').val(producto.id);
      $('#name').val(producto.nombre);
      $('#marca').val(producto.marca);
      $('#modelo').val(producto.modelo);
      $('#precio').val(producto.precio);
      $('#detalles').val(producto.detalles);
      $('#unidades').val(producto.unidades);
      $('#imagen').val(producto.imagen);
    });
  });

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

  function mostrarNombresEnBarraEstado(productos) {
    let template_bar = '<ul>';
    productos.forEach(producto => {
      template_bar += `<li>${producto.nombre}</li>`;
    });
    template_bar += '</ul>';
    $('#container-resultados').html(template_bar);
  }

  function validateField(fieldId, statusId) {
    const field = document.getElementById(fieldId);
    const status = document.getElementById(statusId);
    if (field.value.trim() === '') {
      status.textContent = `${fieldId} es requerido.`;
      return false;
    } else {
      status.textContent = '';
      return true;
    }
  }

  function validateForm() {
    const fields = ['name', 'marca', 'modelo', 'precio', 'unidades'];
    let isValid = true;
    fields.forEach(field => {
      if (!validateField(field, `${field}-status`)) {
        isValid = false;
      }
    });
    return isValid;
  }

  document.getElementById('name').addEventListener('blur', function() {
    validateField('name', 'name-status');
    checkProductName();
  });

  document.getElementById('marca').addEventListener('blur', function() {
    validateField('marca', 'marca-status');
  });

  document.getElementById('modelo').addEventListener('blur', function() {
    validateField('modelo', 'modelo-status');
  });

  document.getElementById('precio').addEventListener('blur', function() {
    validateField('precio', 'precio-status');
  });

  document.getElementById('unidades').addEventListener('blur', function() {
    validateField('unidades', 'unidades-status');
  });

  function checkProductName() {
    const name = document.getElementById('name').value;
    $.ajax({
      url: 'backend/product-check-name.php',
      type: 'POST',
      data: { name },
      success: function(response) {
        const result = JSON.parse(response);
        const status = document.getElementById('name-status');
        if (result.exists) {
          status.textContent = 'El nombre del producto ya existe.';
        } else {
          status.textContent = '';
        }
      }
    });
  }
});