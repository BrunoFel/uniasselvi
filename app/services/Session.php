<?php

class Session {

    // Método para iniciar a sessão
    public static function iniciar() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Método para criar uma sessão no banco e definir dados na sessão PHP
    public static function criarSessao($email, $session_token) {
       
        $conexao = DataBase::getConexao();

        // Atualiza o token no banco de dados
        $sql = 'UPDATE usuarios SET session_token = :tk WHERE email = :e';
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(":e", $email);
        $stmt->bindValue(":tk", $session_token);
        $stmt->execute();

        // Inicia a sessão no servidor e armazena informações
        self::iniciar();
        $_SESSION['email_usuario'] = $email;
        $_SESSION['session_token'] = $session_token;

        return true;
    }

    // Método para verificar se o usuário está logado
    public static function usuarioLogado() {
        self::iniciar();
        // Verifica se a variável de sessão 'email_s' está definida
        return isset($_SESSION['email_usuario']) && self::verificarToken();
    }

    // Método para verificar se o token da sessão é válido
    private static function verificarToken() {
        $conexao = DataBase::getConexao();
        $email = $_SESSION['email_usuario'] ?? null;
        $session_token = $_SESSION['session_token'] ?? null;

        if ($email && $session_token) {
            $sql = 'SELECT session_token FROM usuarios WHERE email = :e';
            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(":e", $email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Compara o token da sessão com o do banco de dados
            return $result && $result['session_token'] === $session_token;
        }
        return false;
    }

    // Método para obter o email do usuário logado
    public static function getUsuarioLogado() {
        self::iniciar();
        // Retorna o email do usuário se ele estiver logado
        return $_SESSION['email_usuario'] ?? null;
    }

    // Método para destruir a sessão (logout)
    public static function destruirSessao() {
        self::iniciar();
        
        // Obtém o email do usuário logado para remover o session_token do banco
        $email = $_SESSION['email_usuario'] ?? null;

        // Se o email estiver disponível, remove o session_token do banco
        if ($email) {
            $conexao = DataBase::getConexao();
            $sql = 'UPDATE usuarios SET session_token = NULL WHERE email = :e';
            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(":e", $email);
            $stmt->execute();
        }

        // Remove todas as variáveis de sessão e destrói a sessão no servidor
        session_unset(); // Remove todas as variáveis de sessão
        session_destroy(); // Destrói a sessão no servidor

        // Opcionalmente, limpa as variáveis de sessão no array global
        $_SESSION = [];
    }
}