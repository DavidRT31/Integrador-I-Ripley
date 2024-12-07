<?php include('header.php') ?>

<main class="container mt-4 form-section">
    <section class="jumbotron text-center mb-4">
        <h1 class="display-4">Registro</h1>
        <p class="lead">Aquí puede hacer uso del registro manual del cliente, o registrar a un nuevo administrador</p>
    </section>

    <form id="registroForm" action="procesar.php" method="POST">
        <div class="row mb-3">
            <div class='col-md-6'>
                <label for='nombre' class='form-label'><i class='bi bi-person-fill'></i> Nombre Completo</label>
                <input type='text' class='form-control' id='nombre' name="nombre" required placeholder='Ingrese su nombre completo'>
            </div>
            <div class='col-md-6'>
                <label for='correo' class='form-label'><i class='bi bi-envelope-fill'></i> Correo Electrónico</label>
                <input type='email' class='form-control' id='correo' name="correo" required placeholder='Ingrese su correo electrónico'>
            </div>
            <div class='col-md-6'>
                <label for='dni' class='form-label'><i class='bi bi-card-text'></i> DNI</label>
                <input type='number' class='form-control' id='dni' name="dni" required placeholder='Ingrese su DNI'>
            </div>
            <div class='col-md-6'>
                <label for='direccion' class='form-label'><i class='bi bi-house-fill'></i> Dirección</label>
                <input type='text' class='form-control' id='direccion' name="direccion" required placeholder='Ingrese su dirección'>
            </div>
            <div class='col-md-6'>
                <label for='telefono' class='form-label'><i class='bi bi-phone-fill'></i> Teléfono</label>
                <input type='number' class='form-control' id='telefono' name="telefono" required placeholder='Ingrese su teléfono'>
            </div>
            <div class='col-md-6'>
                <label for='contraseña' class='form-label'><i class='bi bi-key-fill'></i> Contraseña</label>
                <input type='password' class='form-control' id='contraseña' name="contrasena" required placeholder='Ingrese su contraseña'>
            </div>
            <div class='col-md-6'>
                <label for='rol' class='form-label'><i class='bi bi-shield-fill'></i> Rol</label>
                <select class="form-select" id="rol" name="rol" required>
                    <option value="cliente" selected>Cliente</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
        </div>
        <div class="btn-container">
            <button type="submit" id="enviarBtn" class="btn btn-success">Aceptar</button>
        </div>
    </form>
</main>
<div class="modal fade" id="modalClave" tabindex="-1" aria-labelledby="modalClaveLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalClaveLabel">Clave Generada</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="redirectLogin()"></button>
            </div>
            <div class="modal-body">
                <p>La clave de acceso del usuario es: <strong id="claveGenerada"></strong></p>
                <button class="btn btn-outline-primary" onclick="copiarClave()">Copiar Clave</button>
                <div id="copyMessage">Clave copiada correctamente</div> <!-- Mensaje temporal -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="redirectLogin()">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts de Bootstrap -->
<script src='https://code.jquery.com/jquery-3.2.1.slim.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>

<script>
    document.getElementById('enviarBtn').addEventListener('click', function(e) {
        e.preventDefault(); // Evita el envío normal del formulario

        const formData = new FormData(document.getElementById('registroForm'));

        // Enviar datos al servidor
        fetch('procesar.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mostrar la clave en el modal
                    document.getElementById('claveGenerada').textContent = data.clave;
                    const modal = new bootstrap.Modal(document.getElementById('modalClave'));
                    modal.show();

                    // Redirigir al login después de cerrar el modal
                    const cerrarBtn = document.querySelector('.modal-footer .btn-secondary');
                    cerrarBtn.addEventListener('click', () => {
                        window.location.href = '/ripley/admin/registrar.php';
                    });
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Error:', error));
    });

    // Función para copiar la clave al portapapeles con mensaje temporal
    function copiarClave() {
        const clave = document.getElementById('claveGenerada').textContent;
        navigator.clipboard.writeText(clave).then(() => {
            const mensaje = document.createElement('p');
            mensaje.textContent = 'Clave copiada al portapapeles';
            mensaje.className = 'text-success mt-2';
            document.querySelector('.modal-body').appendChild(mensaje);

            // Quitar el mensaje después de 2 segundos
            setTimeout(() => {
                mensaje.remove();
            }, 2000);
        });
    }
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>