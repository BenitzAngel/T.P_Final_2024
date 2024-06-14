<?php
include_once("../../db/conexion.php");

try {
    $consulta = "SELECT * FROM productos";
    $resultado = $base_de_datos->query($consulta);

    if ($resultado->rowCount() > 0) {
        $producto = $resultado->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $producto = [];
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}

try {
    $consulta = "SELECT * FROM ingredientes";
    $resultado = $base_de_datos->query($consulta);

    if ($resultado->rowCount() > 0) {
        $ingredientes = $resultado->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $ingredientes = [];
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}
?>

<form id="formulario">

    <div class="mb-3">
    <label for="producto" class="col-form-label">Producto:</label>
        <select name="producto" id="producto" class="form-control  ">
            <option value="0" selected disabled>Seleccione un producto</option>
            <?php
            if ($producto) {
                foreach ($producto as $productos) {
                    echo '<option value="' . $productos['id'] . '">' . $productos['nombre'] . '</option>';
                }
            } else {
                echo '<option value="" disabled>No hay producto cargado en el sistema</option>';
            }
            ?>
        </select>
        <div id="errorProducto" class="text-danger"></div>
    </div>

    <div id="ingredientes-container">
        <div class="ingrediente-group">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="ingrediente" class="col-form-label">Ingrediente:</label>
                    <select name="ingredientes[]" class="form-control">
                        <option value="0" selected disabled>Seleccione un ingrediente</option>
                        <?php
                        foreach ($ingredientes as $ingrediente) {
                            echo '<option value="' . $ingrediente['id'] . '">' . $ingrediente['nombre'] . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-3 mb-3">
                    <label for="cantidad" class="col-form-label">Cantidad:</label>
                    <input type="text" class="form-control" name="cantidades[]">
                </div>

                <div class="col-md-3 mb-3">
                    <label for="unidad" class="col-form-label">Unidad:</label>
                    <select class="form-control" name="unidades[]">
                        <option value="kg">Kilogramos</option>
                        <option value="cm3">Centímetros Cúbicos</option>
                        <option value="g">Gramos</option>
                        <option value="docenas">Docenas</option>
                        <option value="unidad">Unidad</option>
                    </select>

                    </div>
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-ingrediente">Eliminar</button>
                </div>
            </div>
            <hr>
        </div>
    </div>

    <button type="button" class="btn btn-success" id="add-ingrediente">Añadir Ingrediente</button>

   <div class="modal-footer mt-3">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</form>



<script>

$(document).ready(function() {
    var ingredientesOptions = `<?php
    foreach ($ingredientes as $ingrediente) {
        echo '<option value="' . $ingrediente['id'] . '">' . $ingrediente['nombre'] . '</option>';
    }
?>`;

    $("#add-ingrediente").click(function() {
        $("#ingredientes-container").append(`
            <div class="ingrediente-group">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="ingrediente" class="col-form-label">Ingrediente:</label>
                        <select name="ingredientes[]" class="form-control">
                            <option value="0" selected disabled>Seleccione un ingrediente</option>
                            ${ingredientesOptions}
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="cantidad" class="col-form-label">Cantidad:</label>
                        <input type="text" class="form-control" name="cantidades[]">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="unidad" class="col-form-label">Unidad:</label>
                        <select class="form-control" name="unidades[]">
                            <option value="kg">Kilogramos</option>
                            <option value="cm3">Centímetros Cúbicos</option>
                            <option value="g">Gramos</option>
                            <option value="docenas">Docenas</option>
                            <option value="unidad">Unidad</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-ingrediente w-100">Eliminar</button>
                    </div>
                </div>
                <hr>
            </div>
        `);
    });

    $(document).on("click", ".remove-ingrediente", function() {
        $(this).closest(".ingrediente-group").remove();
    });

    $("#formulario").submit(function(event) {
        event.preventDefault();

        
        // Validación de campos
        var producto = $("#producto").val();
        var ingredientes = $("select[name='ingredientes[]']").map(function(){ return $(this).val(); }).get();
        var cantidades = $("input[name='cantidades[]']").map(function(){ return $(this).val().trim(); }).get();
        var unidades = $("select[name='unidades[]']").map(function(){ return $(this).val(); }).get();

        // Verificar si hay algún campo obligatorio vacío
        if (producto === "0" || ingredientes.includes("0") || cantidades.includes("") || unidades.includes("0")) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Todos los campos son obligatorios. Por favor, completa todos los campos.'
            });
            return false; // Detiene el envío del formulario
        }


        // Imprimir el valor del campo producto en la consola
    console.log("ID del producto seleccionado:", $("#producto").val());
        var formData = $(this).serializeArray();
        

        console.log(formData);  // Verificar los datos que se están enviando

        $.ajax({
            type: "POST",
            url: "modulos/recetas/nuevo.php",
            data: $.param(formData),
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    console.log("Operación exitosa");
                    $.get("modulos/recetas/listar_recetas.php", function(data) {
                        $("#workspace").html(data);
                    });
                    $("#nuevo_recetaModal").modal("hide");
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
});
    </script>