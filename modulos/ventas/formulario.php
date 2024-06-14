<?php
include_once("../../db/conexion.php");

$id = '';
$id_cliente = '';
$total = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM Ventas WHERE id = ?";
    $stmt = $base_de_datos->prepare($sql);
    $stmt->execute([$id]);
    $venta = $stmt->fetch(PDO::FETCH_OBJ);

    $id_cliente = $venta->id_cliente;
    $total = $venta->total;
}

$clientes = $base_de_datos->query("SELECT * FROM Clientes")->fetchAll(PDO::FETCH_OBJ);
?>

<form id="formVenta" method="POST" action="modulos/ventas/<?php echo $id ? 'editar.php' : 'agregar.php'; ?>">
    <?php if ($id): ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
    <?php endif; ?>
    <div class="mb-3">
        <label for="id_cliente" class="col-form-label">Cliente:</label>
        <select class="form-control" id="id_cliente" name="id_cliente" required>
            <?php foreach ($clientes as $cliente): ?>
                <option value="<?php echo $cliente->id; ?>" <?php echo $cliente->id == $id_cliente ? 'selected' : ''; ?>>
                    <?php echo $cliente->nombre . ' ' . $cliente->apellido; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="total" class="col-form-label">Total:</label>
        <input type="number" step="0.01" class="form-control" id="total" name="total" value="<?php echo $total; ?>" required>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary"><?php echo $id ? 'Actualizar' : 'Guardar'; ?></button>
    </div>
</form>
