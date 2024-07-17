<?php
    class TareasDB {
    
        protected $mysqli;
        const LOCALHOST = 'localhost'; // 127.0.0.1
        const USER = 'root';
        const PASSWORD = '';
        const DATABASE = 'agenda';
        /**
        * Constructor de clase Inicializa la variable mysqli
        */
        public function __construct() {
            try{
                $this->mysqli = new mysqli(self::LOCALHOST, self::USER, self::PASSWORD, self::DATABASE);
            } catch (mysqli_sql_exception $e) {
                http_response_code(500);
                exit;
            }
        }
        public function dameUnoPorId($id=0){ //función que retorna un registro por medio de una id
            $stmt = $this->mysqli->prepare("SELECT * FROM tareas WHERE id=? ; "); // se prepara la consulta con prepare por medio de la conexión que tenemos
            $stmt->bind_param('i', $id); // en lugar de la interrogación, coloque el valor de la variable id
            $stmt->execute();
            $result = $stmt->get_result();
            $tarea = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $tarea;
        }
        public function dameLista(){ //esta función retorna una lista
            $result = $this->mysqli->query('SELECT * FROM tareas');
            $tareas = $result->fetch_all(MYSQLI_ASSOC); //aquí se ejecuta la consulta
            $result->close();
            return $tareas;
        }
        public function guarda($titulo, $descripcion, $prioridad){ //esta función guarda un registro
            $stmt = $this->mysqli->prepare("INSERT INTO tareas(titulo, descripcion, prioridad) VALUES(?, ?, ?)");
            $stmt->bind_param('ssi', $titulo, $descripcion, $prioridad);
            $r = $stmt->execute();
            $stmt->close();
            return $r;
        }
        public function elimina($id=0) { //esta función elimina un registro
            $stmt = $this->mysqli->prepare("DELETE FROM tareas WHERE id = ?");
            $stmt->bind_param('i', $id);
            $r = $stmt->execute();
            $stmt->close();
            return $r;
        }
    }
?>