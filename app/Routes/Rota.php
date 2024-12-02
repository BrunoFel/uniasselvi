<?php 
/* Vamos criar uma classe Rota que irá ser executada na index.php para pegar a URL ($_GET) e esmiuça-la em um array */

class Rota{

    private $controlador = '';
    private $metodo = '';
    private $parametros = [];

    
       
    /* Passo 1: Iniciar o método construtor  */
    public function __construct() {

           
        /* Passo 2: Vamos identificar o que foi digitado na URL e dividir em partes dentro de um array. */
        if(isset($_GET['url']) && !empty($_GET['url'])){
    
            $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
            $url = trim(rtrim($url, '/'));  
            $url = explode("/", $url);
            
        } else {
            $url = [];                                
        }  

    

        // Passo 2: Se a URL acima está vazia, então queremos acessar apenas a página inicial do sistema. */
        if (empty($url)) {
            $this->controlador = 'usuarios';
            $this->metodo = 'login';
            $this->parametros = [];

            // Carrega o controlador
            require_once '../app/Controllers/' . $this->controlador . 'Controller.php';
            $this->controlador = new $this->controlador; // Instancia o controlador
            
            // Chama o método index
            call_user_func_array([$this->controlador, $this->metodo], $this->parametros);
            exit();
           
        } 
        // Passo 3: Se a URL não for vazia, então vamos pegar cada parte dela e decidir qual controlador chamar:
        else {

            // Contar a quantidade de itens no array URL
            $count = count($url);

            // Verifica a quantidade de itens e atribui valores com base no número
            switch ($count) {

                //Se houver apenas um vamor na URL
                case 1:
                    // Apenas o controlador existe
                    if (file_exists("../app/Controllers/{$url[0]}Controller.php")) {                
                        $this->controlador = ucwords($url[0]); 
                        require_once '../app/Controllers/' . $this->controlador . 'Controller.php';

                        $this->controlador = new $this->controlador; 
                        $this->metodo = 'login'; 
                        $this->parametros = []; 
                    } else {
                        require_once '../app/Controllers/ErroController.php'; // Inclui o arquivo correto (ErroController.php)    
                        $this->controlador = 'Erro'; // Mantém o nome da classe como "Erro"
                        $this->controlador = new $this->controlador; // Instancia a classe "Erro"
                        $this->metodo = 'index';
                        $this->parametros = [];
                    }
                break;

                case 2:
                    // Controlador e método
                    if (file_exists("../app/Controllers/{$url[0]}Controller.php")) {

                        //Chama o controlador
                        $this->controlador = ucwords($url[0]);
                        require_once '../app/Controllers/' . $this->controlador . 'Controller.php';
                        $this->controlador = new $this->controlador; // Instancia o controlador

                        //Chamada o método
                        $this->metodo = $url[1]; // Método
                        
                        //Verifica se existe o método
                        if (!method_exists($this->controlador, $this->metodo)) {
                            $this->metodo = 'erro'; 
                           /*  echo "Erro: Controlador encontrado, mas o método(função) informado não existe entro desse controlador ";
                            die(); */
                        }
                        
                    } else {                        
                        require_once '../app/Controllers/ErroController.php'; // Inclui o arquivo correto (ErroController.php)    
                        $this->controlador = 'Erro'; // Mantém o nome da classe como "Erro"
                        $this->controlador = new $this->controlador; // Instancia a classe "Erro"
                        $this->metodo = 'index';
                        $this->parametros = [];
                    }
                break;

                default:
                    // Para 3 ou mais itens (controlador, método e parâmetros)
                    if ($count >= 3) {
                        
                        if (file_exists("../app/Controllers/{$url[0]}Controller.php")) {

                            // Chama o controlador
                            $this->controlador = ucwords($url[0]);
                            require_once '../app/Controllers/' . $this->controlador . 'Controller.php';
                            $this->controlador = new $this->controlador; // Instancia o controlador
                            $this->metodo = $url[1]; // Método

                            // Chamada o método
                            if (!method_exists($this->controlador, $this->metodo)) {
                                 $this->metodo = 'erro'; 
                                /* echo "Erro: Controlador encontrado, mas o método(função) informado não existe entro desse controlador ";
                                die(); */
                            }                            
                            else {
                                 //Existe Controlador e método. Agora vamos separar o parementos:
                                // Cortar o array e começa a contar a partir do elemento de índice 2
                            $this->parametros = array_slice($url, 2);
                            }
                            
                        } else {
                            require_once '../app/Controllers/ErroController.php'; // Inclui o arquivo correto (ErroController.php)    
                            $this->controlador = 'Erro'; // Mantém o nome da classe como "Erro"
                            $this->controlador = new $this->controlador; // Instancia a classe "Erro"
                            $this->metodo = 'index';
                            $this->parametros = [];
                        }
                    }
                break;
            }
           
                                  
            // Chama o método do controlador com os parâmetros
            call_user_func_array([$this->controlador, $this->metodo], $this->parametros); //Ex: $pagina->contato(1);
        }
                                     
    }
}