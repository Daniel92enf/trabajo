<?php
    require_once "TareasDB.php";

    class TareasAPI {

        public function API(){
            header('Content-Type: application/JSON');
            $method = $_SERVER['REQUEST_METHOD'];
            switch ($method) {
                case 'GET':            
                    $this->procesaListar();// son funciones creadas en la parte de abajo de este archivo
                    break;
                case 'POST':
                    $this->procesaGuardar();// son funciones creadas en la parte de abajo de este archivo
                    break;
                case 'PUT':
                    $this->procesaActualizar();// son funciones creadas en la parte de abajo de este archivo
                    break;
                case 'DELETE':
                    $this->procesaEliminar();// son funciones creadas en la parte de abajo de este archivo
                    break;
                default:
                    echo 'MÉTODO NO SOPORTADO';
                break;
            }
        }

        function response($code=200, $status="", $message="") {
            http_response_code($code);
            if( !empty($status) && !empty($message) ){
                $response = array("status" => $status,"message"=>$message);
                echo json_encode($response, JSON_PRETTY_PRINT);
            }
        }

        function procesaListar(){
        
            if($_GET['action']=='tareas'){ //se verifica la acción y se verifica que actúe sobre la tabla tareas
                $tareasDB = new TareasDB();// aquí se instancia un objeto de la clase tareasdb

                if(isset($_GET['id'])){ // se solicita un registro por id
                    $response = $tareasDB->dameUnoPorId($_GET['id']);
                    echo json_encode($response, JSON_PRETTY_PRINT);// aquí se muestra la información en formato json un registro por id
                } else {
                    $response = $tareasDB->dameLista(); // de lo contrario, manda la lista completa
                    echo json_encode($response, JSON_PRETTY_PRINT); // muestra la lista en formato json
                }
            } else if ($_GET['login']=='tareas'){
                
                $tareasDB = new TareasDB();// aquí se instancia un objeto de la clase tareasdb
                
                if(isset($_GET['id'])){ // se solicita un registro por id
                    $response = $tareasDB->dameUnoPorId($_GET['id']);
                    echo json_encode($response, JSON_PRETTY_PRINT);// aquí se muestra la información en formato json un registro por id
                } else {
                    $response = $tareasDB->dameLista(); // de lo contrario, manda la lista completa
                    echo json_encode($response, JSON_PRETTY_PRINT); // muestra la lista en formato json
                }
            } else {
                $this->response(400);
            }
        }

        function procesaGuardar(){
            if($_GET['action']=='tareas'){ // se comprueba que trabaja en la tabla tareas
                //Decodifica un string de JSON
                $obj = json_decode( file_get_contents('php://input') );
                $objArr = (array)$obj;
                if (empty($objArr)){
                    $this->response(422,"error","Nothing to add. Check json");
                } else if(isset($obj->titulo)){
                    $tareasDB = new TareasDB();
                    $tareasDB->guarda( $obj->titulo, $obj->descripcion, $obj->prioridad );
                    $this->response(200,"success","new record added");
                } else {
                    $this->response(422,"error","The property is not defined");
                }
            } else if($_GET['action']=='usuarios'){ // se comprueba que trabaja en la tabla tareas
                $obj = json_decode( file_get_contents('php://input') );
                $objArr = (array)$obj;
                if (empty($objArr)){
                    $this->response(422,"error","Mandame el usuario ome gonorrea ome");
                } else if(isset($obj->user)&& isset($obj->password)){
                    //return $this->response(422,"error",$obj->user);
                    $tareasDB = new TareasDB();
                    $response = $tareasDB->dameUnoPorUsuario($obj->user);
                    if ($response && isset($response['user'])) {
                        if($response['password'] == $obj->password){
                            echo json_encode($response, JSON_PRETTY_PRINT);
                        }else{
                            $this->response(401, "error", "Contraseña incorrecta");    
                        }
                    
                    } else {
                        $this->response(404, "error", "Usuario no encontrado");
                    }                   
                } else {
                    $this->response(422,"error","Debe ingresar usuario y contraseña");
                }
            } else {
                $this->response(400);
            }
        }

        function procesaActualizar() {
            if( isset($_GET['action']) && isset($_GET['id']) ){
                if($_GET['action']=='tareas'){
                    $obj = json_decode( file_get_contents('php://input') );
                    $objArr = (array)$obj;
                    if (empty($objArr)){
                        $this->response(422,"error","Nothing to add. Check json");
                    } else if(isset($obj->titulo)){
                        $tareasDB = new TareasDB();
                        $tareasDB->actualiza($_GET['id'], $obj->titulo,
                        $obj->descripcion, $obj->prioridad );
                        $this->response(200,"success","Record updated");
                    } else {
                        $this->response(422,"error","The property is not defined");
                    }
                    exit;
                }
            }
            $this->response(400);
        }

        function procesaEliminar(){
            if( isset($_GET['action']) && isset($_GET['id']) ){
                if($_GET['action']=='tareas'){
                    $tareasDB = new TareasDB();
                    $tareasDB->elimina($_GET['id']);
                    $this->response(204);
                    exit;
                }
            }
            $this->response(400);
        }

    }
?>