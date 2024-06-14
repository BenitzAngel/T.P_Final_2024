function validarFormularioCliente() {
    var nombre = document.getElementById('nombre').value.trim();
    var apellido = document.getElementById('apellido').value.trim();
    var telefono = document.getElementById('telefono').value.trim();
    var direccion = document.getElementById('direccion').value.trim();
    var altura = document.getElementById('altura').value.trim();

    // Expresión regular para validar que solo hay letras y espacios
    var letrasRegex = /^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+$/;

    // Expresión regular para validar que solo hay números
    var numerosRegex = /^[0-9]+$/;

    // Validación para nombre
    if (!nombre.match(letrasRegex)) {
        alert("El campo Nombre solo debe contener letras y espacios.");
        return false;
    }

    // Validación para apellido
    if (!apellido.match(letrasRegex)) {
        alert("El campo Apellido solo debe contener letras y espacios.");
        return false;
    }

    // Validación para teléfono
    if (!telefono.match(numerosRegex)) {
        alert("El campo Teléfono solo debe contener números.");
        return false;
    }

    // Validación para dirección (opcional)
    if (direccion !== "" && !direccion.match(letrasRegex) && !direccion.match(numerosRegex)) {
        alert("El campo Dirección solo debe contener letras y números.");
        return false;
    }

    // Validación para altura (opcional)
    if (altura !== "" && !altura.match(numerosRegex)) {
        alert("El campo Altura solo debe contener números.");
        return false;
    }

    // Si todo está correcto, retornar true
    return true;
}

