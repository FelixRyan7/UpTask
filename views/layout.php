<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UpTask | <?php echo $titulo ?? ''; ?> </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&family=Open+Sans&display=swap" rel="stylesheet"> 
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="build/css/app.css">
</head>

<body>
<?php if($barraprincipal) {?>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    
    <div class="mx-4 p-3 gap-3 container-fluid">
  <a class="navbar-brand text-warning fw-bolder" style="font-size: 3rem; "href="/">UpTask</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon" style="height: 3.5rem; width: 3.5rem;"></span>
  </button>
  
  <div class="collapse navbar-collapse mr-5" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link mx-3" href="#">Inicio</a>
      </li>
      <li class="nav-item">
        <a class="nav-link mx-3" href="#">Nuestros Planes</a>
      </li>
      <li class="nav-item">
        <a class="nav-link mx-3" href="#">Contacto</a>
      </li>
    </ul>
  </div>
  </div>
</nav>
<?php } ?>



<div <?php echo $esPaginaPrincipal ? 'class="fondo-principal paginas-principales"' : ($contenidoCentrado ? 'class="paginas-principales"' : ''); ?>>
    <?php echo $contenido; ?>
    <?php echo $script ?? ''; ?>
    
</div>

<?php if($barraprincipal) {?>
<footer class="footer seccion bg-light">
      <div class="contenedor contenedor-footer navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link mx-3" href="#">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-3" href="#">Nuestros Planes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link mx-3" href="#">Contacto</a>
            </li>
        </ul>
      </div>

        <p class="copyright text-center">Todos los derechos Reservados <?php echo date('Y'); ?></p>
  </footer>



<?php } ?>
</body>
</html>