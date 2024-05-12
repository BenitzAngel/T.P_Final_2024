


<!-- ventana Modal -->
<!-- midificar id,  aria-labelledby -->

<!-- agregar -->

   <!-- agregar -->
<!-- poner el onsubmit para la validacion <form id="formulario" onsubmit="return validarFormulario()"> -->
        <form id="formulario">
        <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name= "nombre">
            <div id="errorNombre" class="text-danger"></div> <!-- Mensaje de error para el nombre -->
          </div>

          <div class="mb-3" >
            <label for="message-text" class="col-form-label">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
            <div id="errorDescripcion" class="text-danger"></div> <!-- Mensaje de error para la descripción -->
          </div>

          <div class="mb-3">
            <label for="fecha" class="col-form-label">Fecha de Elaboración:</label>
            <input type="date" class="form-control" id="fecha" name="fecha">
            <div id="errorFecha" class="text-danger"></div> <!-- Mensaje de error para la fecha -->
          </div>

          <div class="mb-3">
            <label for="cantidad" class="col-form-label">Cantidad (kg):</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad">
            <div id="errorCantidad" class="text-danger"></div> <!-- Mensaje de error para la cantidad -->
          </div>

          <div class="mb-3">
            <label for="precio_venta" class="col-form-label">Precio de Venta:</label>
            <input type="number" step="0.01" class="form-control" id="precio_venta" name="precio_venta">
            <div id="errorPrecioVenta" class="text-danger"></div> <!-- Mensaje de error para el precio de venta -->
         </div>

         <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit"  class="btn btn-primary">Guardar</button>
            </div>
        </form>



 <!-- <script>
                $(document).ready(function() {
                    $("#cancelarBtn").click(function() {
                        $.get("modulos/productos/listar.php", function(data) {
                            $("#workspace").html(data);
                        });
                    });
                });

                $("#formulario").submit(function(event) {
                    event.preventDefault();

                    var formData = $(this).serialize();

                    $.ajax({
                        type: "POST",
                        url: "modulos/productos/nuevo.php",
                        data: formData,
                        dataType: "json", // Esperamos una respuesta en formato JSON
                        success: function(response) {
                            if (response.status === "success") {
                                // Éxito: manejar según necesidades
                                console.log("Operacion exitora")
                                $.get("modulos/productos/listar.php", function(data) {
                                    $("#workspace").html(data);
                                });
                            } else {
                                // Error: manejar según necesidades
                                console.error("Error en el servidor:", response.message);
                                alert("Error en el servidor: " + response.message);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            // Error de conexión o error no esperado
                            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                            alert("Error en la solicitud AJAX. Por favor, inténtalo de nuevo.");
                        }
                    });
                });
            </script> 
 -->


    <script>
$("#formulario").submit(function(event) {
    event.preventDefault();
    ("Formulario enviado"); // Agregado para verificar si el evento se activa correctamente
    var formData = $(this).serialize();
    
    $.ajax({
        type: "POST",
        url: "modulos/productos/nuevo.php",
        data: formData,
        dataType: "json",
        success: function(response) {
            if (response.status === "success") {
                // Éxito: manejar según necesidades
                console.log("Operación exitosa");
                $.get("modulos/productos/listar.php", function(data) {
                    $("#workspace").html(data);
                });
                // Cerrar la ventana modal después de guardar
                $("#nuevo_productoModal").modal("hide");
            } else {
                // Error: manejar según necesidades
                console.error("Error en el servidor:", response.message);
                alert("Error en el servidor: " + response.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Error de conexión o error no esperado
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            alert("Error en la solicitud AJAX. Por favor, inténtalo de nuevo.");
        }
    });
});
</script>