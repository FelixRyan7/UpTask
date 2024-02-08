<div class="container">
    <div class="row d-flex align-items-center justify-content-center">

    <?php include_once __DIR__ .'/../templates/nombre-sitio.php'; ?>

        <div class="col-md-8">

        
            
            <div class="formulario-registrar contenedor-sm shadow p-3 rounded text-white" style=" background-color: rgba(250, 250, 250, 0.10);">
            <?php include_once __DIR__ .'/../templates/alertas.php'; ?>
                    <p class="descripcion-pagina text-center">Reestablecer contraseña</p>
                    <form class="formulario" method="POST" action="/olvide" novalidate>
                        <div class="mb-3">
                            <label for="email" class="form-label text-dark">Email</label>
                            <input 
                                type="email"
                                class="form-control"
                                id="email"
                                placeholder="Tu Email"
                                name="email"
                            />
                        </div>

                        <div class="acciones mb-3">
                            <a href="/" class="text-dark fs-5">Ya tienes una cuenta? Inicia Sesion</a>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 p-4 mt-3 fs-5 fw-bold" >Enviar Instrucciones</button>

                    </form>

                    <div class="acciones mt-3 d-flex justify-content-center">
                        <a href="/crear" class="text-dark ">Aun no eres miembro? <span class="text-primary fw-bold">Registrate</span></a> 
                    </div>
            </div>
        </div>
    </div>
</div>