function validarFormulario() {
    var nombre = document.getElementById('nombre').value;
    var descripcion = document.getElementById('descripcion').value;
    var precio = document.getElementById('precio').value;
    var stock = document.getElementById('stock').value;
    var unidad = document.getElementById('unidad').value;

    if (nombre == "" || descripcion == "" || precio == "" || stock == "" || unidad == "") {
        alert("Todos los campos son obligatorios.");
        return false;
    }

    return true;
}