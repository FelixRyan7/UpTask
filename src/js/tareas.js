//esta funcion hace que el modal aparezca o desaparezca cada vez que se clicka en el boton
(function(){

    obtenerTareas();
    let tareas = [];
    let filtradas = [];

    const nuevaTareaBtn = document.querySelector('.boton-formulario');
    nuevaTareaBtn.addEventListener('click', function(){
        mostrarFormulario(false);
    });

    //filtros de busqueda
    const filtros = document.querySelectorAll('#filtros input[type="radio"')
    filtros.forEach( radio => {
        radio.addEventListener('input', filtrarTareas);
    })

    function filtrarTareas(e){
        const filtro = e.target.value;

        if(filtro !== ''){
           filtradas = tareas.filter(tarea => tarea.estado === filtro);
        } else{
            filtradas = [];
        }
        mostrarTareas();
    }

    async function obtenerTareas(){
        try{
            const id = obtenerProyecto();
            const  url = `/api/tareas?url=${id}`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();
             tareas = resultado.tareas;
             mostrarTareas();
            console.log(tareas);

        } catch (error){
            console.log(error);
        }
    }

    function mostrarTareas(){
        limpiarTareas();
        totalPendientes();
        totalCompletas();

        const arrayTareas = filtradas.length ? filtradas : tareas;
        
        if(arrayTareas.length === 0){
            const contenedorTareas = document.querySelector('#listado-tareas');
            const textoNoTarea = document.createElement('LI');
            textoNoTarea.textContent = 'No hay Tareas';
            textoNoTarea.classList.add('no-tareas');

            contenedorTareas.appendChild(textoNoTarea)
            return;
        }


        const estados= {
            0: 'Pendiente',
            1: 'Completa'
        }
        arrayTareas.forEach(tarea => {
            const contenedorTarea = document.createElement('LI');
            contenedorTarea.dataset.tareaId = tarea.id;
            contenedorTarea.classList.add('tarea');

            const nombreTarea = document.createElement('P');
            nombreTarea.textContent = tarea.nombre;
            nombreTarea.ondblclick = function(){
                mostrarFormulario(true);
            }

            const opcionesDiv = document.createElement('DIV');
            opcionesDiv.classList.add('opciones');

            //botones
            const btnEstadoTarea = document.createElement('BUTTON');
            btnEstadoTarea.classList.add('btn', 'estado-tarea');
            btnEstadoTarea.classList.add(`${estados[tarea.estado].toLowerCase()}`);
            btnEstadoTarea.textContent = estados[tarea.estado];
            btnEstadoTarea.dataset.estadoTarea = tarea.estado;
            btnEstadoTarea.ondblclick = function() {
                cambiarEstadoTarea({...tarea});
                
            }
            // Agregar clases de Bootstrap según el estado de la tarea
            if (tarea.estado === '0') {
                btnEstadoTarea.classList.add('btn-warning'); // Clases para tareas pendientes
            } else if (tarea.estado === '1') {
                btnEstadoTarea.classList.add('btn-primary'); // Clases para tareas completas
            }

            const btnEliminarTarea = document.createElement('BUTTON');
            btnEliminarTarea.classList.add('eliminar-tarea');
            btnEliminarTarea.classList.add('btn', 'btn-danger');
            btnEliminarTarea.dataset.idTarea = tarea.id;
            btnEliminarTarea.textContent = 'Eliminar';
            btnEliminarTarea.onclick = function(){
                confirmarEliminarTarea({...tarea});
            }

            opcionesDiv.appendChild(btnEstadoTarea);
            opcionesDiv.appendChild(btnEliminarTarea);

            contenedorTarea.appendChild(nombreTarea);
            contenedorTarea.appendChild(opcionesDiv);

            const listadoTareas = document.querySelector('#listado-tareas');
            listadoTareas.appendChild(contenedorTarea);

            
        })
    }

    function totalPendientes(){
        const totalPendientes = tareas.filter(tarea => tarea.estado === "0");
        const pendientesRadio = document.querySelector('#pendientes');

        if(totalPendientes.length === 0){
            pendientesRadio.disabled = true;
        } else{
            pendientesRadio.disabled = false;
        }
    }

    function totalCompletas(){
        const totalCompletas = tareas.filter(tarea => tarea.estado === "1");
        const completasRadio = document.querySelector('#completadas');

        if(totalCompletas.length === 0){
            completasRadio.disabled = true;
        } else{
            completasRadio.disabled = false;
        }
    }



    function mostrarFormulario(editar = false){
        $('#modalAgregarTarea').modal('show');
        console.log(editar)
    }



    const agregarTareaBtn = document.querySelector('.boton-tarea');
            agregarTareaBtn.addEventListener('click', () => {
                
                submitFormularioNuevaTarea();
            });




    function submitFormularioNuevaTarea(){
        const tarea = document.querySelector('#tarea').value.trim();
        if(tarea === '') {
            //mostrar una alerta de error
            mostrarAlerta('El nombre de la tarea es Obligatorio', 'errores', document.querySelector('.modal-body label'));
            return;
        } 

        agregarTarea(tarea);
        
    }



    //Muestra un mensaje en la interfaz
    function mostrarAlerta(mensaje, tipo, referencia){
        //previene de mostrar mas de una alerta (la misma alerta)
        const alertaPrevia = document.querySelector('.alerta');
        if(alertaPrevia){
            alertaPrevia.remove();
        }
        const alerta = document.createElement('DIV');
        alerta.classList.add('alerta', tipo);
        alerta.textContent = mensaje;
        //inserta la alerta antes del label
        referencia.parentElement.insertBefore(alerta, referencia);
        console.log(alerta);

        //elminar alerta en 5 segundos
        setTimeout(() => {
            alerta.remove();
        }, 5000);
    }



    //consultar el servidor para añadir una nueva tarea al proyecto actual
    async function agregarTarea(tarea){
        //construir la peticion
        const datos = new FormData();
        datos.append('nombre', tarea);
        datos.append('proyectoId', obtenerProyecto());
        

        try{
           const url = 'http://localhost:3000/api/tarea';
           const respuesta = await fetch(url, {
            method: 'POST',
            body: datos
           });

           const resultado = await respuesta.json();
           console.log(resultado);

           mostrarAlerta(resultado.mensaje, resultado.tipo,
           document.querySelector('.modal-body label'));

           if (resultado.tipo === 'exito') {
            // Cerrar el modal después de 3 segundos con jquery
            setTimeout(() => {
                $('#modalAgregarTarea').modal('hide');
                //agregar el objeto de tarea al global de tareas
                const tareaObj = {
                    id: String(resultado.id),
                    nombre:tarea,
                    estado: "0",
                    proyectoId: resultado.proyectoId
                }

                tareas = [...tareas, tareaObj];
                mostrarTareas();
            }, 2000);  
        }
        } catch (error) {
            
        }

    }

    function cambiarEstadoTarea(tarea){
        console.log(tarea);
        const nuevoEstado = tarea.estado === "1" ? "0" : "1";
        tarea.estado = nuevoEstado
        actualizarTarea(tarea);
    }

    async function actualizarTarea(tarea){
        const {estado, id, nombre, proyectoId} = tarea;

        const datos = new FormData();
        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('estado', estado);
        datos.append('proyectoId', obtenerProyecto());

        // for(let valor of datos.values()) {
        //     console.log(valor);
        // }
        try{
            const url = 'http://localhost:3000/api/tarea/actualizar';
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
            const resultado = await respuesta.json();

            if(resultado.respuesta.tipo === 'exito'){
                mostrarAlerta(
                    resultado.respuesta.mensaje, resultado.respuesta.tipo,document.querySelector('.contenedor-nueva-tarea'));

                    tareas = tareas.map(tareasMemoria =>{
                        if(tareasMemoria.id === id){
                            tareasMemoria.estado = estado;
                        }
                        return tareasMemoria;
                    });
                    mostrarTareas();
            }
        } catch(error){
            console.log(error);
        }
    }


    function confirmarEliminarTarea(tarea){

        Swal.fire({
            title: "Eliminar Tarea?",
            showCancelButton: true,
            confirmButtonText: "Si",
            cancelButtonText: 'No'
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
             console.log('elimanando....')
             eliminarTarea(tarea);
            } 
            
        });
    }

    async function eliminarTarea(tarea){

        const {estado, id, nombre} = tarea;

        const datos = new FormData();
        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('estado', estado);
        datos.append('proyectoId', obtenerProyecto());

        try{
            const url = 'http://localhost:3000/api/tarea/eliminar';
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            })
            const resultado = await respuesta.json();
            if(resultado.resultado){
                // mostrarAlerta(
                //     resultado.mensaje,
                //     resultado.tipo,
                //     document.querySelector('.contenedor-nueva-tarea')
                // );

                swal.fire('Eliminado!', resultado.mensaje, 'success');

                tareas = tareas.filter(tareaMemoria => tareaMemoria.id !== tarea.id);
                mostrarTareas();
            }
        } catch (error) {

        }
    }


    function obtenerProyecto(){
        const proyectoParams = new URLSearchParams(window.location.search);
        const proyecto = Object.fromEntries(proyectoParams.entries());
        return proyecto.url;
    }

    function limpiarTareas() {
        const listadoTareas = document.querySelector('#listado-tareas');

        while(listadoTareas.firstChild){
            listadoTareas.removeChild(listadoTareas.firstChild);
        }
    }

})();



