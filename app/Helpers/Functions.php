<?php 
// Função para tratamento dos dados recebidos no $_POST:
function cleanUp($dados){
    $dados = htmlspecialchars(stripslashes(trim($dados)));
    return $dados;
  }

function var_dump_pre($dados){
  echo "<pre>";
  var_dump($dados);
  echo "</pre>";
}

?>