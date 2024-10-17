// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

// FUNCIÓN CALLBACK DE BOTÓN "Buscar Producto"
function buscarProductos(e) {
    e.preventDefault();
    var search = document.getElementById('search').value;
    console.log('Search term:', search); // Mensaje de depuración
    var client = getXMLHttpRequest();
    client.open('POST', './backend/read.php', true);
    client.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            console.log('[CLIENTE]\n' + client.responseText); // Mensaje de depuración
            let productos = JSON.parse(client.responseText);
            console.log('Productos encontrados:', productos); // Mensaje de depuración
            let template = '';
            if (productos.length > 0) {
                productos.forEach(producto => {
                    let descripcion = '';
                    descripcion += '<li>precio: ' + producto.precio + '</li>';
                    descripcion += '<li>unidades: ' + producto.unidades + '</li>';
                    descripcion += '<li>modelo: ' + producto.modelo + '</li>';
                    descripcion += '<li>marca: ' + producto.marca + '</li>';
                    descripcion += '<li>detalles: ' + producto.detalles + '</li>';
                    template += `
                        <tr>
                            <td>${producto.id}</td>
                            <td>${producto.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                        </tr>
                    `;
                });
                document.getElementById("productos").innerHTML = template;
            } else {
                document.getElementById("productos").innerHTML = '<tr><td colspan="3">No se encontraron productos</td></tr>';
            }
        }
    };
    client.send("search=" + encodeURIComponent(search));
}

// FUNCIÓN CALLBACK DE BOTÓN "Agregar Producto" CON VALIDACIONES
function agregarProducto(e) {
    e.preventDefault();
    
    // Obtener y validar los datos del formulario
    var nombre = document.getElementById('name').value;
    if (nombre.trim() === '' || nombre.length > 100) {
        return alert('El nombre del producto es obligatorio y debe tener 100 caracteres o menos.');
    }

    var descripcion = document.getElementById('description').value;
    var producto;
    try {
        producto = JSON.parse(descripcion);
    } catch (e) {
        return alert('El JSON del producto no es válido.');
    }

    // Validaciones adicionales
    if (producto.marca.trim() === '' || producto.marca.length > 25) {
        return alert('La marca del producto es obligatoria y debe tener 25 caracteres o menos.');
    }

    if (producto.modelo.trim() === '' || !/^[a-zA-Z0-9]*$/.test(producto.modelo) || producto.modelo.length > 25) {
        return alert('El modelo del producto es obligatorio, debe ser texto alfanumérico y tener 25 caracteres o menos.');
    }

    if (isNaN(producto.precio) || producto.precio <= 99.99) {
        return alert('El precio debe ser un número válido mayor a 99.99.');
    }

    if (producto.detalles && producto.detalles.length > 250) {
        return alert('Los detalles deben tener 250 caracteres o menos.');
    }

    if (!Number.isInteger(producto.unidades) || producto.unidades < 0) {
        return alert('Las unidades deben ser un número entero mayor o igual a 0.');
    }

    producto.nombre = nombre;
    var productoJsonString = JSON.stringify(producto, null, 2);

    // Enviar datos al servidor
    var client = getXMLHttpRequest();
    client.open('POST', './backend/create.php', true);
    client.setRequestHeader('Content-Type', "application/json;charset=UTF-8");
    client.onreadystatechange = function () {
        if (client.readyState == 4 && client.status == 200) {
            console.log(client.responseText);
            let response = JSON.parse(client.responseText);
            window.alert(response.message);
        }
    };
    client.send(productoJsonString);
}

// SE CREA EL OBJETO DE CONEXIÓN COMPATIBLE CON EL NAVEGADOR
function getXMLHttpRequest() {
    var objetoAjax;
    try {
        objetoAjax = new XMLHttpRequest();
    } catch (err1) {
        try {
            objetoAjax = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (err2) {
            try {
                objetoAjax = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (err3) {
                objetoAjax = false;
            }
        }
    }
    return objetoAjax;
}

function init() {
    var JsonString = JSON.stringify(baseJSON, null, 2);
    document.getElementById("description").value = JsonString;
}
