<aside class="sidebar">
    <div class="contenedor-sidebar">
        <h1>Uptask</h1>

        <div class="cerrar-menu">
            <img id="cerrar-menu" src="build/img/cerrar.svg" alt="imagen cerrar">
        </div>
    </div>
    <nav class="sidebar-nav">
        <a class="<?php echo ($titulo === 'proyectos') ? 'activo' : ''; ?>" href="/dashboard">Proyectos</a>
        <a class="<?php echo ($titulo === 'Crear proyecto') ? 'activo' : ''; ?>" href="/crear-proyecto">Crear Proyecto</a>
        <a class="<?php echo ($titulo === 'Perfil') ? 'activo' : ''; ?>" href="/perfil">Perfil</a>
    </nav>    

    <div class="cerrar-sesion-mobile">
        <a href="/logout" class="cerrar-sesion">Cerrar Sesión</a>
    </div>
</aside>