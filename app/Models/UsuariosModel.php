<?php 


class UsuariosModel{

    private $conexao;

    public function __construct() {
        // Usa a função de conexão da classe DataBase
        $this->conexao = DataBase::getConexao();
    }

    // ------------------ Cadastrar() ------------------ 

    public function verificarSeUsuarioExiste($e){
        $sql = 'SELECT email FROM usuarios where email = ? LIMIT 1';
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$e]);

        $usuario = $stmt->fetchColumn();
        return $usuario;
    }

    public function inserirUsuarioNoBanco($n, $e, $s, $tk) {
        
        $sql = 'INSERT INTO usuarios (nome, email, status, token, 2fa, plano, data_cadastro, senha) 
        VALUES (:n, :e, "nao confirmado", :tk, "0", "basico", now(), :s)';        
        $stmt = $this->conexao->prepare($sql);  
        $stmt->bindValue(":n", $n);
        $stmt->bindValue(":e", $e);
        $stmt->bindValue(":s", $s);
        $stmt->bindValue(":tk", $tk);  
        $stmt->execute();  
        return true;
    }

    // ------------------ Confirmacao() ------------------ 

    
    public function verificarToken($e, $tk){
        $sql = 'SELECT token FROM usuarios where email = :e and token = :tk LIMIT 1';
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(":e", $e);  
        $stmt->bindValue(":tk", $tk);  
        $stmt->execute();
        $token = $stmt->fetchColumn();
        return $token;
    }

    public function verificarTokenZerado($e){
        $sql = 'SELECT token FROM usuarios where email = :e LIMIT 1';
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(":e", $e);          
        $stmt->execute();
        $token = $stmt->fetchColumn();
        return $token;
    }

    public function desbloquearUsuario($e){
        $sql = 'UPDATE usuarios SET status = "ativo" where email = :e';	
        $stmt = $this->conexao->prepare($sql);          
        $stmt->bindValue(":e", $e);  
        $stmt->execute();
        return true;
    }

    public function resetarToken($e){
        $sql = 'UPDATE usuarios SET token = "" where email = :e';	
        $stmt = $this->conexao->prepare($sql);          
        $stmt->bindValue(":e", $e);  
        $stmt->execute();
        return true;
    }

    public function verificarContador($e){

        $sql = 'SELECT contador FROM usuarios where email = :e LIMIT 1';
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(":e", $e);          
        $stmt->execute();
        $tentativas = $stmt->fetchColumn();
        return $tentativas;
    }

    public function incrementarContador($e){

        $sql = 'UPDATE usuarios SET contador = contador + 1 where email = :e';	
        $stmt = $this->conexao->prepare($sql);          
        $stmt->bindValue(":e", $e);  
        $stmt->execute();
        return true;
    }

    public function bloquearDefinitivamente($e){

        $sql = 'UPDATE usuarios SET status = "bloqueado definitivamente" where email = :e';	
        $stmt = $this->conexao->prepare($sql);          
        $stmt->bindValue(":e", $e);  
        $stmt->execute();
        return true;
    }

    // -------------- Login() --------------      
  
    public function verificaSenha($e){        
        $sql = 'SELECT senha FROM usuarios where email = :e LIMIT 1';
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(":e", $e);  
        $stmt->execute();
        $senha = $stmt->fetchColumn();
        return $senha;
    }
  
    public function bloquearUsuario($e){
        $sql = 'UPDATE usuarios SET status = "bloqueado" where email = :e';	
        $stmt = $this->conexao->prepare($sql);          
        $stmt->bindValue(":e", $e);  
        $stmt->execute();
        return true;
    }

    public function consultarStatusUsuario($e){        
        $sql = 'SELECT status FROM usuarios where email = :e LIMIT 1';
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(":e", $e);  
        $stmt->execute();
        $status = $stmt->fetchColumn();
        return $status;
    }

    public function verificarDoisFatores($e){
        $sql = 'SELECT 2fa FROM usuarios where email = :e LIMIT 1';
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(":e", $e);          
        $stmt->execute();
        $doisFatores = $stmt->fetchColumn();
        return $doisFatores;
    } 
    
    public function zerarContador($e){

        $sql = 'UPDATE usuarios SET contador = "0" where email = :e';	
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(":e", $e);          
        $stmt->execute();
        return true;
    }
    



    // -------------- Desbloqueio() --------------

 
    // -------------- Recuperação() --------------
    
 
    public function salvarToken($e, $tk){
        $sql = 'UPDATE usuarios SET token = :tk where email = :e';	
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(":e", $e);  
        $stmt->bindValue(":tk", $tk);  
        $stmt->execute();
        return true;
    }

    // -------------- Nova Senha() --------------

    public function atualizaSenha($e, $senhaCrypt){

        $sql = 'UPDATE usuarios SET senha = :s where email = :e';	
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(":s", $senhaCrypt);  
        $stmt->bindValue(":e", $e);  
        $stmt->execute();
        return true;
    }

    public function zerarToken($e){

        $sql = 'UPDATE usuarios SET token = 0 where email = :e';	
        $stmt = $this->conexao->prepare($sql);          
        $stmt->bindValue(":e", $e);  
        $stmt->execute();
        return true;
    }    
                
    public function resetarSenha($e){

        $sql = 'UPDATE usuarios SET senha = "" where email = :e';	
        $stmt = $this->conexao->prepare($sql);          
        $stmt->bindValue(":e", $e);  
        $stmt->execute();
        return true;
    }


                            
}