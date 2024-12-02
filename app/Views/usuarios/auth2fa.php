<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Autenticação 2 Fatores</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- JQuery -->
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

		<!-- LINEARICONS -->
		<link rel="stylesheet" href="<?= URL_PROJETO;?>/public/fonts/linearicons/style.css">

		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
		
		<!-- STYLE CSS -->
		<link rel="stylesheet" href="<?= URL_PROJETO;?>/public/css/usuarios.css">

		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	</head>

	<body>

		<div class="wrapper">
			<div class="inner">
				<img src="<?= URL_PROJETO;?>/public/img/login-img.png" alt="" class="image-1">

				<form action="<?= URL_PROJETO;?>/usuarios/auth2fa" method="POST">

					<h3>Autenticação <br> de 2 Fatores</h3>
								
					

					<p id="titleheader">Informe o token para acessar sua conta </p>															

					<!-- Mensagens de Erro de Token -->
					<?php if (isset($erro_token_vazio)): ?>   <div class='msg-erro-servidor'><?= $erro_token_vazio; ?></div> <?php endif; ?>
					<?php if (isset($erro_token_invalido)): ?>   <div class='msg-erro-servidor'><?= $erro_token_invalido ?></div> <?php endif; ?>
									
					<!-- Mensagmes Gerais -->
					<?php if (isset($quantidade_errada)): ?>   <div class='msg-erro-servidor'><?= $quantidade_errada ?></div> <?php endif; ?>
					<?php if (isset($usuario_bloqueado)): ?>   <div class='msg-erro-servidor'><?= $usuario_bloqueado ?></div> <?php endif; ?>
					
					
					
					
															
														
					<!-- Input Token-->
					<div class="form-holder">						
						<input type="number" id="codigo" name="codigo" class="form-control" placeholder="Informe o token" value="<?= $codigo; ?>" >
						<div class="msg-erro" id="erro-codigo"></div>
					</div>	
														
					<button id="submit"  type="submit"> <span>Autenticar acesso</span> </button>					
					
					
					<hr>
					<p class="link">Desejar voltar para a página de login? <br><a href="<?= URL_PROJETO;?>/usuarios/login">Entrar na conta</a></p>
					

					
				</form>

				<img src="<?= URL_PROJETO;?>/public/img/image-2.png" alt="" class="image-2">
			</div>
			
		</div>

		<script src="<?= URL_PROJETO;?>/public/js/auth2fa.js"></script>
		
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/main.js"></script>




	</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>