<?php
include_once("../../db/conexion.php");

$id_producto = $_GET['id'];

// Obtener información del producto y sus ingredientes
$consulta = $base_de_datos->prepare("
    SELECT p.nombre AS producto, i.nombre AS ingrediente, pi.cantidad_ingrediente AS cantidad, pi.unidad, pi.id_ingrediente
    FROM ProductosIngredientes pi
    JOIN Productos p ON pi.id_producto = p.id
    JOIN Ingredientes i ON pi.id_ingrediente = i.id
    WHERE p.id = :id_producto
");
$consulta->bindParam(':id_producto', $id_producto, PDO::PARAM_INT);
$consulta->execute();
$receta = $consulta->fetchAll(PDO::FETCH_OBJ);

// Obtener todos los ingredientes para la selección
$ingredientesConsulta = $base_de_datos->query("SELECT * FROM Ingredientes");
$ingredientes = $ingredientesConsulta->fetchAll(PDO::FETCH_OBJ);
?>

<h4>Producto: <?php echo $receta[0]->producto; ?></h4>
<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Ingrediente</th>
            <th>Cantidad</th>
            <th>Unidad</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody id="recetaBody">
        <?php foreach($receta as $item){ ?>
            <tr>
                <td>
                    <select class="form-control-plaintext" name="ingrediente[]" readonly>
                        <?php foreach ($ingredientes as $ing) { ?>
                            <option value="<?php echo $ing->id; ?>" <?php echo ($ing->id == $item->id_ingrediente) ? 'selected' : ''; ?>>
                                <?php echo $ing->nombre; ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control-plaintext" name="cantidad[]" value="<?php echo $item->cantidad; ?>" readonly>
                </td>
                <td>
                    <select class="form-control-plaintext" name="unidad[]" readonly>
                        <option value="kg" <?php echo ($item->unidad == 'kg') ? 'selected' : ''; ?>>Kilogramos</option>
                        <option value="cm3" <?php echo ($item->unidad == 'cm3') ? 'selected' : ''; ?>>Centímetros Cúbicos</option>
                        <option value="g" <?php echo ($item->unidad == 'g') ? 'selected' : ''; ?>>Gramos</option>
                        <option value="docenas" <?php echo ($item->unidad == 'docenas') ? 'selected' : ''; ?>>Docenas</option>
                        <option value="unidad" <?php echo ($item->unidad == 'unidad') ? 'selected' : ''; ?>>Unidad</option>
                    </select>
                    <input type="hidden" name="id_ingrediente[]" value="<?php echo $item->id_ingrediente; ?>">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-remove-ingrediente" style="display: none;">Eliminar</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<button type="button" id="editarReceta" class="btn btn-warning">Modificar</button>
<button type="button" id="guardarCambios" class="btn btn-primary" style="display: none;">Guardar cambios</button>
<button type="button" id="agregarIngrediente" class="btn btn-success" style="display: none;">Agregar Ingrediente</button>

<script>
    $(document).ready(function() {
        $('#editarReceta').click(function() {
            $('select, input').prop('readonly', false).removeClass('form-control-plaintext').addClass('form-control');
            $('.btn-remove-ingrediente').show();
            $('#guardarCambios, #agregarIngrediente').show();
            $(this).hide();
        });

        $('#recetaBody').on('change', 'select[name="ingrediente[]"]', function() {
            var selected = $(this).val();
            if (selected === "nuevo") {
                $(this).siblings('.nuevo-ingrediente').show();
            } else {
                $(this).siblings('.nuevo-ingrediente').hide();
            }
        });

        $('#guardarCambios').click(function() {
            var ingredientes = [];
            var cantidades = [];
            var unidades = [];
            var id_ingredientes = [];

            $('select[name="ingrediente[]"]').each(function() {
                ingredientes.push($(this).val());
            });
            $('input[name="cantidad[]"]').each(function() {
                cantidades.push($(this).val());
            });
            $('select[name="unidad[]"]').each(function() {
                unidades.push($(this).val());
            });
            $('input[name="id_ingrediente[]"]').each(function() {
                id_ingredientes.push($(this).val());
            });

            if (ingredientes.length > 0 && cantidades.length > 0 && unidades.length > 0 && id_ingredientes.length > 0) {
                $.ajax({
                    type: "POST",
                    url: "modulos/recetas/guardar_cambios.php",
                    data: {
                        id_producto: <?php echo $id_producto; ?>,
                        cantidades: cantidades,
                        unidades: unidades,
                        ingredientes: ingredientes,
                        id_ingredientes: id_ingredientes
                    },
                    dataType: "json",
                    success: function(response) {
                        // alert("Cambios guardados correctamente");
                        if (response.status === "success") {
                            $('#verRecetaModal').modal('hide');
                        } else {
                            alert("Error al guardar los cambios: " + response.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Error en la solicitud AJAX. Por favor, inténtalo de nuevo.");
                    }
                });
            } else {
                alert("Debe completar todos los campos antes de guardar.");
            }
        });

        $('#agregarIngrediente').click(function() {
            var nuevaFila = `
                <tr>
                    <td>
                        <select class="form-control" name="ingrediente[]">
                            <?php foreach ($ingredientes as $ing) { ?>
                                <option value="<?php echo $ing->id; ?>">
                                    <?php echo $ing->nombre; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="cantidad[]" placeholder="Cantidad">
                    </td>
                    <td>
                        <select class="form-control" name="unidad[]">
                            <option value="kg">Kilogramos</option>
                            <option value="cm3">Centímetros Cúbicos</option>
                            <option value="g">Gramos</option>
                            <option value="docenas">Docenas</option>
                            <option value="unidad">Unidad</option>
                        </select>
                        <input type="hidden" name="id_ingrediente[]" value="">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-remove-ingrediente">Eliminar</button>
                    </td>
                </tr>
            `;
            $('#recetaBody').append(nuevaFila);
        });

        $('#recetaBody').on('click', '.btn-remove-ingrediente', function() {
            $(this).closest('tr').remove();
        });
    });
</script>