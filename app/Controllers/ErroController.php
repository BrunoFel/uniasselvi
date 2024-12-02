<?php 
    //Controlador usado caso o primeiro valor na URL não possua um controlador existe
    class Erro extends ControladorBase {
        public function index() {
            // Aqui você pode passar dados para a view se necessário
            $this->carregarView('erros/erro404'); // Certifique-se de que a view 'erro404.php' exista
        }
    }
