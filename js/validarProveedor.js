function validarFormularioProveedor() {
    var nombre = document.getElementById('nombre').value;
    var email = document.getElementById('email').value;
    var telefono = document.getElementById('telefono').value;

    if (nombre == "" || telefono == "") {
        alert("Los campos Nombre y Teléfono son obligatorios.");
        return false;
    }

    return true;
}