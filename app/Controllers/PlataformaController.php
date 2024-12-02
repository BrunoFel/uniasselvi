<?php 
class Plataforma extends ControladorBase {

    public function __construct()
    {
        
        if (!Session::usuarioLogado()) {
            URL::redirecionar('usuarios/login');                       
        }

    }

    public function painel() {
               
        $this->carregarView('plataforma/painel');
    }

    public function sair() {

       
        $this->carregarView('plataforma/sair');
    }
   
   


     //Metodo usado caso seja acessado o controaldor usuário, mas não existe o método informando no 2º parâmetro da URL
     public function erro() {
        $this->carregarView('erros/erro404');
    }
}