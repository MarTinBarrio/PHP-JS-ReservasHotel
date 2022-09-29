<!-- CONTACTENOS -->
<div class="contactenos container-fluid bg-white py-4" id="contactenos">
        <div class="container text-center">
            <h1 class="py-sm-4">CONTACTENOS</h1>
            <form method="post">
                <div class="input-group input-group-lg">
                    <input type="text" class="form-control mb-3 mr-2 form-control-lg" placeholder="Nombre" name="nombreContactenos" required>
                    <input type="text" class="form-control mb-3 ml-2 form-control-lg" placeholder="Apellido" name="apellidoContactenos" required>
                </div>
                <div class="input-group input-group-lg">
                    <input type="text" class="form-control mb-3 mr-2 form-control-lg" placeholder="Móvil" name="movilContactenos" required>
                    <input type="text" class="form-control mb-3 ml-2 form-control-lg" placeholder="Correo" name="emailContactenos" required>
                </div>
                <textarea class="form-control" rows="6" placeholder="Escribe aquí tu mensaje" name="mensajeContactenos" required></textarea>
                <input type="submit" class="btn btn-dark my-4 btn-lg py-3 text-uppercase w-50" value="Enviar">
                <?php
                $contactenos = new ControladorUsuario();
                $contactenos -> ctrlFormularioContactenos();
                ?>
            </form>
        </div>
    </div>
