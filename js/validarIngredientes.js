function validarFormulario() {
    var nombre = document.getElementById('nombre').value;
    var descripcion = document.getElementById('descripcion').value;
    var stock = document.getElementById('stock').value;

    if (nombre == "" || stock == "") {
        alert("Nombre y stock son campos obligatorios.");
        return false;
    }

    return true;
}