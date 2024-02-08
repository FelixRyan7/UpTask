<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="bg-light contenedor-sm shadow p-3 rounded bg-primary text-white">
    <?php include __DIR__ . '/../templates/alertas.php'; ?>

    <a href="/cambiar-password" class="enlace">Cambiar Contraseña</a>

    <form class="formulario" method="POST" action="/perfil">
        <div class="campo">
            <label for="nombre" class="form-label text-dark">Nombre</label>
            <input
                type="text"
                class="form-control"
                value=" <?php echo $usuario->nombre; ?>"
                name="nombre"
                placeholder="Tu nombre"
            />    
        </div>
        <div class="campo">
            <label for="nombre" class="form-label text-dark">Email</label>
            <input
                type="email"
                class="form-control"
                value="<?php echo $usuario->email; ?>"
                name="email"
                placeholder="Tu email"
            />    
        </div>

        <button type="submit" class="btn btn-primary w-100 p-4 mt-3 fs-5 fw-bold" >Guardar Cambios</button>
        
    </form>
    
</div>


<?php include_once __DIR__ . '/footer-dashboard.php'; ?>