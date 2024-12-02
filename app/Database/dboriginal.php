<?php 
class DataBase{
    
    private $type = "mysql"; 
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "sistema_de_citacao";
    private $port = '3306';
    private $charset = 'utf8mb4';
    
    protected function connect() {
        // Criando o DSN:
        $dsn = "$this->type:host=$this->servername;dbname=$this->database;port=$this->port;charset=$this->charset";

        // Definindo as opções do PDO:
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        // Envolvendo a criação do PDO no bloco try-catch
        try {
            // Instanciando o PDO com o DSN, usuário, senha e opções
            $pdo = new PDO($dsn, $this->username, $this->password, $options);
            //echo "Connected successfully";
            return $pdo;
        } catch (PDOException $e) {
            // Tratamento de erros específicos do PDO
            echo "Connection failed: " . $e->getMessage();
            return null; // Retorna null se houver erro de conexão
        } catch (Exception $e) {
            // Tratamento de erros gerais
            echo "General Error: " . $e->getMessage();
            return null;
        }
    }

    

}
?>
