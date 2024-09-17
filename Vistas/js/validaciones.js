function validarFormulario() {
    var nombre = document.querySelector('input[name="nombre"]').value;
    var apellido = document.querySelector('input[name="apellido"]').value;
    var documento = document.querySelector('input[name="documento"]').value;
    var telefono = document.querySelector('input[name="telefono"]').value;

    // Expresión regular actualizada para permitir letras con acentos y "Ñ"
    var nombreRegex = /^[A-Za-zÀ-ÿÑñ\s]+$/;
    var documentoRegex = /^\d{8}$/;
    var telefonoRegex = /^\d{9}$/;

    if (!nombreRegex.test(nombre)) {
        alert("El nombre solo debe contener letras, espacios y caracteres especiales.");
        return false;
    }

    if (!nombreRegex.test(apellido)) {
        alert("El apellido solo debe contener letras, espacios y caracteres especiales.");
        return false;
    }

    if (!documentoRegex.test(documento)) {
        alert("El documento debe tener 8 dígitos.");
        return false;
    }

    if (!telefonoRegex.test(telefono)) {
        alert("El teléfono debe tener 9 dígitos.");
        return false;
    }

    return true;
}

function validarFormularioEditar() {
    var nombre = document.getElementById('nombreE').value;
    var apellido = document.getElementById('apellidoE').value;
    var documento = document.getElementById('documentoE').value;
    var telefono = document.getElementById('telefonoE').value;

    // Expresión regular actualizada para permitir letras con acentos y "Ñ"
    var nombreRegex = /^[A-Za-zÀ-ÿÑñ\s]+$/;
    var documentoRegex = /^\d{8}$/;
    var telefonoRegex = /^\d{9}$/;

    if (!nombreRegex.test(nombre)) {
        alert("El nombre solo debe contener letras, espacios y caracteres especiales.");
        return false;
    }

    if (!nombreRegex.test(apellido)) {
        alert("El apellido solo debe contener letras, espacios y caracteres especiales.");
        return false;
    }

    if (!documentoRegex.test(documento)) {
        alert("El documento debe tener 8 dígitos.");
        return false;
    }

    if (!telefonoRegex.test(telefono)) {
        alert("El teléfono debe tener 9 dígitos.");
        return false;
    }

    return true;
}

function confirmarEliminacion() {
    return confirm('¿Estás seguro de que deseas eliminar esta asignación?');
}

function generarUsuario() {
    // Obtener el nombre del doctor desde el input
    var nombre = document.querySelector('input[name="nombre"]').value;

    // Eliminar los espacios del nombre
    nombre = nombre.replace(/\s+/g, '');

    // Generar 2 dígitos aleatorios para el usuario
    var digitosUsuario = Math.floor(10 + Math.random() * 90); // Genera un número de 2 dígitos
    var usuario = nombre + "D" + digitosUsuario;

    // Asignar el usuario generado al campo de input correspondiente
    document.querySelector('input[name="usuario"]').value = usuario;
}

function generarContraseña() {
    // Obtener el usuario generado desde el input
    var usuario = document.querySelector('input[name="usuario"]').value;

    // Verificar si el usuario ha sido generado
    if (!usuario) {
        alert("Por favor, genere primero el usuario.");
        return;
    }

    // Generar 5 dígitos aleatorios para la contraseña
    var digitosContraseña = Math.floor(10 + Math.random() * 90); // Genera un número de 5 dígitos
    var contraseña = usuario + digitosContraseña;

    // Asignar la contraseña generada al campo de input correspondiente
    document.querySelector('input[name="clave"]').value = contraseña;
}

