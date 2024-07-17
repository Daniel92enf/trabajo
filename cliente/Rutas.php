<?php
    class Rutas {
        protected $urlBase = "http://localhost/trabajo";
            public function __construct() {
        }
        public function dameUrlBase() {
            return $this->urlBase;
        }
        public function dameMenuInicio() {
            return '<a href="'.$this->urlBase.'/cliente/index.php">Inicio</a>';
        }
        public function dameMenuNuevo() {
            return "<a href='".$this->urlBase."/cliente/nuevo.php'>Nuevo</a>";
        }

        public function dameMenuModificar($id) {
            return "<a href='".$this->urlBase."/cliente/modificar.php?id=".$id."'>Modificar</a>";
        }

        public function dameMenuEliminar($id) {
            return "<a href='".$this->urlBase."/cliente/eliminar.php?id=".$id."'>Eliminar</a>";
        }
    }
?>