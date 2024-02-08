<div class="container">
    <div class="row d-flex align-items-center justify-content-center">

<?php include_once __DIR__ .'/../templates/nombre-sitio.php'; ?>

        <div class="col-md-8">
        
        
        
            <?php if($mostrar) {?>
            <div class="contenedor-sm shadow p-3 rounded text-white" style=" background-color: rgba(250, 250, 250, 0.10);">
            <?php include_once __DIR__ .'/../templates/alertas.php'; ?>
                    <p class="descripcion-pagina text-center">Asigna una nueva contraseña</p>
                    <form class="formulario" method="POST">
                        

                        <div class="">
                            <label for="password" class="form-label text-dark">Contraseña</label>
                            <input 
                                type="password"
                                class="form-control"
                                id="password"
                                placeholder="Tu Contraseña"
                                name="password"
                            />
                        </div>

                        

                        <button type="submit" class="btn btn-primary w-100 p-4 mt-3 fs-5 fw-bold" >Guardar Contraseña</button>

                    </form>

                    <div class="acciones mt-3 d-flex justify-content-center">
                        <a href="/crear" class="text-dark ">Aun no eres miembro? <span class="text-primary fw-bold">Registrate</span></a> 
                    </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>