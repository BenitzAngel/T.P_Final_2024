<?php 
include_once("../../db/conexion.php");

$datos = $base_de_datos-> query("SELECT * FROM producto");
$producto = $datos->fetchAll(PDO::FETCH_OBJ);
?>

<!-- Agrega este script al final de tu archivo listar.php -->
<script>
    function agregarProducto() {
      // console.log("Función agregarProducto() llamada.")
        // Realiza una petición AJAX para obtener el contenido del formulario
        $.get("modulos/productos/formulario.php", function(data) {
          // console.log("Contenido del formulario recibido:", data);
            // Inserta el contenido del formulario en el cuerpo de la ventana modal
            $("#nuevo_productoModal").modal("show");
        });
    }

    function editarProducto(idproducto) {
      console.log("ID del producto:", idproducto);
      // Construye la URL con el parámetro id
      const url = `modulos/productos/editar.php?id=${idproducto}`;
      // console.log("URL construida:", url);

      // esta parte es la antigua &&&&&&&&&&&&&&&&&&&
      // console.log("Función agregarProducto() llamada.")
      // Realiza una petición AJAX para obtener el contenido del formulario

      // $.get("modulos/productos/editar.php?id=", { id: idproducto },function(data) {
        // console.log("Contenido del formulario recibido:", data);
            // Inserta el contenido del formulario en el cuerpo de la ventana modal
            // $("#modificarModal").modal("show");
      //}).fail(function() {
      //alert("Error al cargar el formulario.");
      // });
      //   }&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

      // Realiza una petición AJAX para obtener el contenido del formulario
      $.get(url, function(data) {
        // console.log("Contenido del formulario recibido:", data);
        // Inserta el contenido del formulario en el cuerpo de la ventana modal
        $("#modificarModal .modal-body").html(data);
        // Muestra el modal
        $("#modificarModal").modal("show");
      }).fail(function() {
        alert("Error al cargar el formulario.");
      });
    }

    function eliminarProducto(idproducto, nombreProducto) {
      console.log("ID del producto:", idproducto, nombreProducto);
		// Utiliza SweetAlert en lugar de confirm y alert
		Swal.fire({
			title: '¿Estás seguro?',
			text: `¿Estás seguro de que deseas eliminar el producto "${nombreProducto}"?`,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Sí, eliminar',
			cancelButtonText: 'Cancelar'
		}).then((result) => {
			if (result.isConfirmed) {
        console.log("AJAX GET URL:", "modulos/productos/eliminar.php?id=" + idproducto);
				$.get("modulos/productos/eliminar.php?id=" + idproducto, function (data) {
          console.log("Response from server:", data);
					try {
						var response = JSON.parse(data);

						if (response.status === "success") {
							// La eliminación fue exitosa, actualizar la vista
							console.log("Operacion exitosa");
							$.get("modulos/productos/listar.php", function (data) {
								$("#workspace").html(data);
							});
						} else {
							// Hubo un error, mostrar el mensaje de error con SweetAlert
							console.error("Error al eliminar producto:", response.message);
							Swal.fire({
								icon: 'error',
								title: 'Error',
								text: 'Error al eliminar producto. ' + response.message
							});
						}
					} catch (error) {
						// Manejar errores al analizar JSON con SweetAlert
						console.error("Error al analizar respuesta JSON:", error);
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: 'Error al analizar respuesta JSON.'
						});
					}
				});
			}
		});
	}
</script>





<div class="col-xs-12">
		<h1>Productos</h1>
		<div>

        <button type = "botton" id="btnAbrirModal" onclick="agregarProducto()" class="btn btn-success" >
				Nuevo Producto </i>
			</button>
			
			
		</div>
		<br>
		<table class="table table-bordered">
			<thead class="table-dark" >
				<tr>
          <th>ID</th>
					<th>Nombre</th>
          <th>Descripción</th>
					<th>Fecha de Elaboración</th>
					<th>Cantidad (kg)</th>
          <th>Precio de Venta</th>
          <!-- <th>Stock</th> -->
					<th>Editar</th>
					<th>Eliminar</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($producto as $producto){ ?>
				<tr>
                    <td><?php echo $producto->id_producto; ?></td>
                    <td><?php echo $producto->nombre ?></td>
                    <td><?php echo $producto->descripcion ?></td>
                    <td><?php echo $producto->fecha_ingreso ?></td>
					          <td><?php echo $producto->cantidad ?></td>
					          <td><?php echo $producto->precio?></td>
                    
                    
					<td>

            <!-- <button type = "botton" class="btn btn-primary" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modificarModal">Modificar</button> -->
           
            <button id="editarProducto" onclick="editarProducto(<?php echo $producto->id_producto; ?>)" class="btn btn-primary">
							<i>Modificar</i>
						</button>
					</td>


					<td>

          <!-- <button type = "botton" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarModal">Eliminar</button> -->

          <button id="eliminarProducto" onclick="eliminarProducto(<?php echo $producto->id_producto; ?>, '<?php echo htmlspecialchars($producto->nombre, ENT_QUOTES, 'UTF-8'); ?>')" class="btn btn-primary">
							<i>Eliminar</i>
						</button>
						
					</td>
				</tr>
				<?php } ?>
			</tbody>

		</table>
	</div>

<!-- ventanas modal -->

<!-- Ventana modal para nuevo producto -->
<div class="modal fade" id="nuevo_productoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Producto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Aquí se incluye directamente el formulario.php -->
                <?php include("formulario.php"); ?>
            </div>
        </div>
    </div>
</div>


<!-- agregar

    <div class="modal fade" id="nuevo_productoModal" tabindex="-1" aria-labelledby="nuevo_productoModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Producto</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form id="formulario" onsubmit="return validarFormulario()">
        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name= "nombre">
          </div>

          <div class="mb-3">
            <label for="message-text" class="col-form-label">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
          </div>

          <div class="mb-3">
            <label for="fecha" class="col-form-label">Fecha de Elaboración:</label>
            <input type="date" class="form-control" id="fecha" name="fecha">
          </div>

          <div class="mb-3">
            <label for="cantidad" class="col-form-label">Cantidad (kg):</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad">
          </div>

          <div class="mb-3">
            <label for="precio_venta" class="col-form-label">Precio de Venta:</label>
            <input type="number" step="0.01" class="form-control" id="precio_venta" name="precio_venta">
         </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="cancelarBtn" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" id="guardarBtn" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- modificar -->
<div class="modal fade" id="modificarModal" tabindex="-1" aria-labelledby="modificarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 " id="exampleModalLabel">Modificar</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Aquí se incluye directamente el formulario.php -->
        <?php include("editar.php");?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Actualizar</button>
      </div>
    </div>
  </div>
</div>


<!-- eliminar -->
<div class="modal fade" id="eliminarModal" tabindex="-1"  aria-labelledby="eliminarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 " id="exampleModalLabel">¿Estás seguro que quieres eliminar este producto?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">


          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name= "nombre">
          </div>

          <div class="mb-3">
            <label for="message-text" class="col-form-label">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
          </div>

          <div class="mb-3">
            <label for="precio_venta" class="col-form-label">Precio de Venta:</label>
            <input type="number" step="0.01" class="form-control" id="precio_venta" name="precio_venta">
         </div>

         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger">Eliminar</button>
      </div>
    </div>
  </div>
</div>


