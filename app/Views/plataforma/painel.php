<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Bem-vindo ao sistema

    <?php 
    if(!isset($_SESSION['session_token'])){
        echo "não tme sessao";
    } else {
        
    }
    ?>

    <p><a href="<?php echo URL_PROJETO;?>/plataforma/sair">Sair</a></p>
</body>
</html>