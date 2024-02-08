<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="contenedor-sm">
    <div class="contenedor-nueva-tarea d-flex justify-content-center">
        <button
            type="button"
            class="boton-formulario mt-3 p-4 border-0 rounded text-light"
            data-bs-toggle="modal"
            data-bs-target="#modalAgregarTarea"
        >
        &#43; Nueva Tarea</button>
    </div>

    <div id="filtros" class="filtros container bg-light shadow-sm mt-5 p-3 mb-5  rounded ">
        <div class="filtros-inputs">
            <h3>Filtros:</h3>
            <div class="campo">
                <label for="todas">Todas</label>
                    <input 
                        type="radio"
                        id="todas"
                        name="filtro"
                        value=""
                        checked
                    />
            </div>
        
            
            <div class="campo">
                <label for="completadas">Completadas</label>
                    <input 
                        type="radio"
                        id="completadas"
                        name="filtro"
                        value="1"
                        
                    />
            </div>
    
            
            <div class="campo">
                <label for="pendientes">Pendientes</label>
                    <input 
                        type="radio"
                        id="pendientes"
                        name="filtro"
                        value="0"
                        
                    />
            </div>
        </div>
    </div>
        
          
    <completadas
    <ul id="listado-tareas" class="listado-tareas"></ul>
</div>

<!-- Modal  solo se muestra al clickar en el boton de Nueva Tarea -->
<div class="modal fade" id="modalAgregarTarea" tabindex="-1" aria-labelledby="modalAgregarTareaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-light" style="background: linear-gradient(to right, #6157ff, #EE49FD);">
                <h5 class="modal-title fw-bold fs-4" id="modalAgregarTareaLabel">Añade una nueva Tarea</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="formulario nueva-tarea">
                    <div class="campo mb-3">
                        <label for="tarea" class="form-label">Tarea</label>
                        <input 
                            type="text"
                            name="tarea"
                            placeholder="Añadir tarea a<?php echo $titulo; ?>..."
                            id="tarea"
                            class="form-control"
                        />
                       
                    </div>
                    
                    <div class="opciones d-flex gap-4 mt-3">
                        <button type="button" class="btn boton-tarea boton-formulario-modal text-light w-75 p-3">Añadir Tarea</button>
                        <button type="button" class="btn btn-secondary w-25 p-3" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include_once __DIR__ . '/footer-dashboard.php'; ?>

<?php
$script = '
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="build/js/tareas.js"></script>
<script src="build/js/app.js"></script>
';
?>