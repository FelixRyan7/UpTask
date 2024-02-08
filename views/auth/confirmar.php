<div class="container">
    <div class="row d-flex align-items-center justify-content-center">

        <?php include_once __DIR__ .'/../templates/nombre-sitio.php'; ?>

        <div class="col-md-6">
        <?php include_once __DIR__ .'/../templates/alertas.php'; ?>
            
        <?php if (isset($alertas['exito'])): ?>
    <div class="acciones text-white text-center">
        <a class="btn btn-primary p-3 rounded fs-1" href="/">Iniciar Sesión</a>
    </div>
<?php endif; ?>
            
        </div>
    </div>
</div>