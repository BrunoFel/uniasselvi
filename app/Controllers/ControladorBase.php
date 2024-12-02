<?php 

// O Controlador base é uma parte de código que todos os controladores terão por defaultp para acessar a Model e renderizar a View
class ControladorBase {

    public $dados;

    public function __construct()
    {
        $this->dados = array();
    }


    public function carregarView($nomeView, $dados = array()) {        
        $viewPath = '../app/Views/' . $nomeView . '.php';     
        if (file_exists($viewPath)) {
            extract($dados); // Extrai as variáveis do array para que fiquem acessíveis na view como uma variavel
            require '../app/Views/' . $nomeView . '.php';
        } else {
            die('A view ' . $nomeView . ' não existe'); 
        }
    }

    public function carregarModel($nomeModel) {
        $modelPath = '../app/Models/' . $nomeModel . '.php';

        if (file_exists($modelPath)) {
            require_once $modelPath; // Inclui o arquivo do modelo

            // Verifica se a classe existe e a instancia
            if (class_exists($nomeModel)) {
                return new $nomeModel(); // Retorna uma nova instância do modelo
            } else {
                die('O modelo ' . $nomeModel . ' não contém uma classe definida');
            }
        } else {
            die('O modelo ' . $nomeModel . ' não existe'); 
        }
    }


    
}


 

  


   


   
