<div class="container">
    <div class="row d-flex align-items-center justify-content-center">
    <?php include_once __DIR__ .'/../templates/nombre-sitio.php'; ?>

        <div class="col-md-7">
            <div class="formulario-registrar contenedor-sm shadow p-3 rounded text-white" style=" background-color: rgba(250, 250, 250, 0.10);">
                    <p class="descripcion-pagina text-center">Crea tu Cuenta en UpTask</p>

                    <?php include_once __DIR__ .'/../templates/alertas.php'; ?>

                    <form class="formulario" method="POST" action="/crear">
                    <div class="mb-3">
                            <label for="nombre" class="form-label text-dark">Nombre</label>
                            <input 
                                type="text"
                                class="form-control"
                                id="nombre"
                                placeholder="Tu Nombre"
                                name="nombre"
                                value="<?php echo $usuario->nombre; ?>"
                            />
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label text-dark">Email</label>
                            <input 
                                type="email"
                                class="form-control"
                                id="email"
                                placeholder="Tu Email"
                                name="email"
                                value="<?php echo $usuario->email; ?>"
                            />
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label text-dark">Contraseña</label>
                            <input 
                                type="password"
                                class="form-control"
                                id="password"
                                placeholder="Tu Contraseña"
                                name="password"
                            />
                        </div>

                        <div class="mb-5">
                            <label for="password2" class="form-label text-dark">Repite tu Contraseña</label>
                            <input 
                                type="password"
                                class="form-control"
                                id="password2"
                                placeholder="Repite tu contraseña"
                                name="password2"
                            />
                        </div>

                        <button type="submit" class="btn btn-outline-primary w-100 p-4 mt-2 fs-5 fw-bold">Registrarme</button>

                    </form>
                    

                    <div class="acciones mt-3 d-flex justify-content-center mb-4">
                        <a href="/" class="text-dark ">Ya Tienes Cuenta? <span class="text-primary fw-bold">inicia Sesion</span></a> 
                    </div>
            </div>
        </div>
    </div>
</div>