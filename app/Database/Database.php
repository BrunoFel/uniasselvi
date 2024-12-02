<?php 
class DataBase{
        
    private static $instancia;

    private function __construct() {}

    public static function getConexao(){

        //Usado para se conectar ao banco de dados apenas uma vez sem precisar se conectar várias vezes ao longo do tempo
        if(!isset(self::$instancia)){

            $dbname = 'uniasselvi';
            $host = 'localhost';
            $user = 'root';
            $senha = '';

       
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Lança exceções em caso de erro
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Define o modo de fetch como associativo
                PDO::ATTR_PERSISTENT => true, // Conexão persistente
                PDO::ATTR_EMULATE_PREPARES => false, // Não emular prepared statements
            ];

        
            try {

                self::$instancia = new PDO('mysql:dbname='.$dbname.';host='.$host, $user, $senha, $options);

                self::$instancia->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
            } catch (PDOException $e) {
                
                echo "Connection failed: " . $e->getMessage();
                return null; 

            } catch (Exception $e) {
                // Tratamento de erros gerais
                echo "General Error: " . $e->getMessage();
                return null;
            }

        }

        return self::$instancia;
        
    }                                      
}
?>
