<?php
include_once("../../db/conexion.php");

$id = '';
$nombre = '';
$apellido = '';
$email = '';
$telefono = '';
$direccion = '';
$altura = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM clientes WHERE id = ?";
    $stmt = $base_de_datos->prepare($sql);
    $stmt->execute([$id]);
    $cliente = $stmt->fetch(PDO::FETCH_OBJ);

    $nombre = $cliente->nombre;
    $apellido = $cliente->apellido;
    $email = $cliente->email;
    $telefono = $cliente->telefono;
    $direccion = $cliente->direccion;
    $altura = $cliente->altura;
}
?>

<form id="formCliente"  method="POST" action="modulos/clientes/<?php echo $id ? 'editar.php' : 'agregar.php'; ?>">
    <?php if ($id): ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
    <?php endif; ?>
    <div class="mb-3">
        <label for="nombre" class="col-form-label">Nombre:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
    </div>
    <div class="mb-3">
        <label for="apellido" class="col-form-label">Apellido:</label>
        <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $apellido; ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="col-form-label">Email:</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
    </div>
    <div class="mb-3">
        <label for="telefono" class="col-form-label">Teléfono:</label>
        <input type="tel" class="form-control" id="telefono" name="telefono" value="<?php echo $telefono; ?>" required>
    </div>
    <div class="mb-3">
        <label for="direccion" class="col-form-label">Dirección:</label>
        <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion; ?>" required>
    </div>
    <div class="mb-3">
        <label for="altura" class="col-form-label">Altura:</label>
        <input type="number" class="form-control" id="altura" name="altura" value="<?php echo $altura; ?>" required>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary"><?php echo $id ? 'Actualizar' : 'Guardar'; ?></button>
    </div>
</form>



<script>
    // Script AJAX para enviar el formulario
    $("#formCliente").submit(function(event) {
        event.preventDefault();
        var nombre = $("#nombre").val().trim();
        var apellido = $("#apellido").val().trim();
        var telefono = $("#telefono").val().trim();
        var direccion = $("#direccion").val().trim();
        var altura = $("#altura").val().trim();

        var letrasRegex = /^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+$/;
        var numerosRegex = /^[0-9]+$/;

       // Validación para nombre
       if (!nombre.match(letrasRegex)) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El campo Nombre solo debe contener letras y espacios.'
            });
            return false;
        }

        // Validación para apellido
        if (!apellido.match(letrasRegex)) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El campo Apellido solo debe contener letras y espacios.'
            });
            return false;
        }

        // Validación para teléfono
        if (!telefono.match(numerosRegex)) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El campo Teléfono solo debe contener números.'
            });
            return false;
        }

        // Validación para dirección 
        if (direccion !== "" && !direccion.match(letrasRegex) && !direccion.match(numerosRegex)) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El campo Dirección solo debe contener letras y números.'
            });
            return false;
        }

        // Validación para altura
        if (altura !== "" && !altura.match(numerosRegex)) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'El campo Altura solo debe contener números.'
            });
            return false;
        }


        var formData = $(this).serialize();
        
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: formData,
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    console.log("Operación exitosa");
                    // ventana de exito
                    Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Gasto guardado exitosamente.',
                    timer: 2000, // Tiempo en milisegundos antes de cerrar automáticamente
                    showConfirmButton: false // Ocultar el botón de confirmación
            });

                    $.get("modulos/clientes/listar.php", function(data) {
                        $("#workspace").html(data);
                    });
                    //cierre del modal
                    $("#nuevo_clienteModal").modal("hide");
                    $("#modificarModal").modal("hide");
                } else {
                    console.error("Error en el servidor:", response.message);
                    alert("Error en el servidor: " + response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                alert("Error en la solicitud AJAX. Por favor, inténtalo de nuevo.");
            }
        });
    });

    // Limpiar contenido del modal cuando se cierra evita que aga copias
    $('#nuevo_clienteModal, #modificarModal').on('hidden.bs.modal', function () {
        $(this).find('.modal-body').html('');
    });
</script>