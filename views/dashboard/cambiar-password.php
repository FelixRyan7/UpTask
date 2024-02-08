<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="bg-light contenedor-sm shadow p-3 rounded bg-primary text-white">
    <?php include __DIR__ . '/../templates/alertas.php'; ?>

    <a href="/perfil" class="enlace">Volver a Perfil</a>

    <form class="formulario" method="POST" action="/cambiar-password">
        <div class="campo mb-4">
            <label for="nombre" class="form-label text-dark">Contraseña Actual</label>
            <input
                type="password"
                class="form-control"
                name="password_actual"
                placeholder="Tu Contraseña Actual"
            />    
        </div>
        
        <div class="campo">
            <label for="nombre" class="form-label text-dark">Nueva Contraseña</label>
            <input
                type="password"
                class="form-control"
                name="password_nuevo"
                placeholder="Tu Contraseña Nueva"
            />    
        </div>

        <button type="submit" class="btn btn-primary w-100 p-4 mt-3 fs-5 fw-bold" >Guardar Cambios</button>
        
    </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>