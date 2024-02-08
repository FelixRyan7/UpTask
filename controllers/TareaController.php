<?php

namespace Controllers;

use Model\Tarea;
use Model\Proyecto;


class TareaController {
    public static function index(){
        //Coger el url= de la url y guardarla en la variable
        $proyectoId = $_GET['url'];
        // si no lo hay se manda a ldashboard
        if(!$proyectoId) header('Location: /dashboard');
        //comparamos las urls de la base de datos y vemos si coincide con el de la variable
        $proyecto = Proyecto::where('url', $proyectoId);
        session_start();
        
        if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) header ('Location: /404');

        $tareas = Tarea::belongsTo('proyectoId', $proyecto->id);

        echo json_encode(['tareas' => $tareas]);

    }

    public static function crear(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            session_start();
 
            $proyectoId = $_POST['proyectoId'];

            $proyecto = Proyecto::where('url', $proyectoId);
            
            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'errores',
                    'mensaje' => 'hubo un error al agregar la tarea'

                ];
                echo json_encode($respuesta);
                return;
            } 
                // Todo bien, instanciar y crear la tarea

                $tarea = new Tarea($_POST);
                $tarea->proyectoId = $proyecto->id;
                $resultado = $tarea->guardar();
                $respuesta = [
                    'tipo' => 'exito',
                    'id' => $resultado['id'],
                    'mensaje' => 'Tarea creada correctamente',
                    'proyectoId' => $proyecto->id
                ];
                echo json_encode($respuesta);
            
        }
    }

    public static function actualizar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //validar que el proyecto exista
            $proyecto = Proyecto::where('url', $_POST['proyectoId']);

            session_start();

            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                $respuesta = [
                    'tipo' => 'errores',
                    'mensaje' => 'hubo un error al actualizar la tarea'

                ];
                echo json_encode($respuesta);
                return;
            } 
            
            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;

            $resultado = $tarea->guardar();
            if($tarea->estado === "0"){
                $tarea->estado = 'Pendiente';
            } else{
                $tarea->estado = 'Completada';
            }
            if($resultado) {
                $respuesta = [
                    'tipo' => 'exito',
                    'id' => $tarea->id,
                    'proyectoId' => $proyecto->id,
                    'mensaje' => 'Tarea " ' . $tarea->nombre . ' " cambia a ' . $tarea->estado
                ];
                echo json_encode(['respuesta' => $respuesta]);
            }
            
        }
    }

    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){

             //validar que el proyecto exista
             $proyecto = Proyecto::where('url', $_POST['proyectoId']);

             session_start();
 
             if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                 $respuesta = [
                     'tipo' => 'errores',
                     'mensaje' => 'hubo un error al actualizar la tarea'
 
                 ];
                 echo json_encode($respuesta);
                 return;
             }  

             $tarea = new Tarea($_POST);
             $resultado = $tarea->eliminar();

             $resultado = [
                'resultado' => $resultado,
                'mensaje' => 'Tarea ' . $tarea->nombre . ' Eliminada Correctamente',
                'tipo' => 'exito'
             ];
             
            echo json_encode($resultado);
        }
    }

}