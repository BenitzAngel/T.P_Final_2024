<?php
include_once("../../db/conexion.php");

$id = '';
$descripcion = '';
$monto = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM Gastos WHERE id = ?";
    $stmt = $base_de_datos->prepare($sql);
    $stmt->execute([$id]);
    $gasto = $stmt->fetch(PDO::FETCH_OBJ);

    $descripcion = $gasto->descripcion;
    $monto = $gasto->monto;
}
?>

<form id="formGasto" method="POST" action="modulos/gastos/<?php echo $id ? 'editar.php' : 'agregar.php'; ?>">
    <?php if ($id): ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
    <?php endif; ?>
    <div class="mb-3">
        <label for="descripcion" class="col-form-label">Descripción:</label>
        <textarea class="form-control" id="descripcion" name="descripcion" required><?php echo $descripcion; ?></textarea>
    </div>
    <div class="mb-3">
        <label for="monto" class="col-form-label">Monto:</label>
        <input type="number" step="0.01" class="form-control" id="monto" name="monto" value="<?php echo $monto; ?>" required>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary"><?php echo $id ? 'Actualizar' : 'Guardar'; ?></button>
    </div>
</form>
