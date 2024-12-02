<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Reativacao</title>
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

				<form action="<?= URL_PROJETO;?>/usuarios/reativacao" method="POST">

					<h3>Reativação de Conta.</h3>

					<p id="titleheader">Informe seu e-mail e código de recuperação recebidos no seu e-mail </p>
					
					
					<!-- Mensagens de Erro de Email -->
					<?php if (isset($erro_email_vazio)): ?>   <div class='msg-erro-servidor'><?= $erro_email_vazio; ?></div> <?php endif; ?>
					<?php if (isset($erro_email_invalido)): ?>   <div class='msg-erro-servidor'><?= $erro_email_invalido; ?></div> <?php endif; ?>


					<!-- Mensagens de Erro de Código -->
					<?php if (isset($erro_codigo_vazio)): ?>   <div class='msg-erro-servidor'><?= $erro_codigo_vazio; ?></div> <?php endif; ?>

				
					
					<!-- Mensagmes Gerais -->
					<?php if (isset($erro_usuario_nao_cadastrado)): ?>   <div class='msg-erro-servidor'><?= $erro_usuario_nao_cadastrado; ?></div> <?php endif; ?>
					<?php if (isset($usuario_reativado)): ?>   <div class='msg-sucesso-servidor'><?= $usuario_reativado; ?></div> <?php endif; ?>
					<?php if (isset($erro_desbloqueio)): ?>   <div class='msg-erro-servidor'><?= $erro_desbloqueio; ?></div> <?php endif; ?>
					<?php if (isset($erro_codigo_errado)): ?>   <div class='msg-erro-servidor'><?= $erro_codigo_errado; ?></div> <?php endif; ?>
					<?php if (isset($usuario_bloqueado_definitivamente)): ?>   <div class='msg-erro-servidor'><?= $usuario_bloqueado_definitivamente; ?></div> <?php endif; ?>
					<?php if (isset($usuario_bloqueado)): ?>   <div class='msg-erro-servidor'><?= $usuario_bloqueado; ?></div> <?php endif; ?>
					<?php if (isset($usuario_nao_bloqueado)): ?>   <div class='msg-erro-servidor'><?= $usuario_nao_bloqueado; ?></div> <?php endif; ?>
					
					
					


															
					<!-- Input Email -->
					<div class="form-holder">					
						<input type="text" id="email" name="email" class="form-control" placeholder="Email" value="<?= $email; ?>">
						<div class="msg-erro" id="erro-email"></div>
					</div>
										
					<!-- Input Código de Recuperação -->
					<div class="form-holder">						
						<input type="text" id="codigo" name="codigo" class="form-control" placeholder="Código de Recuperação" value="<?= $codigo; ?>" >
						<div class="msg-erro" id="erro-codigo"></div>
					</div>	
														
					<button id="submit"  type="submit"> <span>Reativar conta</span> </button>					
					

					<p class="link">Conseguiu reativar sua conta? <br><a href="<?= URL_PROJETO;?>/usuarios/recuperacao">Recuperar senha</a></p>
					<hr>
					<p class="link">Desejar voltar para a página de login? <br><a href="<?= URL_PROJETO;?>/usuarios/login">Entrar na conta</a></p>
					

					
				</form>

				<img src="<?= URL_PROJETO;?>/public/img/image-2.png" alt="" class="image-2">
			</div>
			
		</div>

		<script src="<?= URL_PROJETO;?>/public/js/reativacao.js"></script>
		
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/main.js"></script>

		<script>
			$(document).ready(function() {

				<?php if(isset($usuario_nao_existe)) { ?>
					swal({
						title: "E-mail não cadastrado no sistema",
						text: "Só é possível recuperar uma senha caso você seja um usuário do sistema.",
						icon: "warning",
						button: "Fechar",
					});
				<?php };?>

			


				<?php if(isset($codigo_invalido)) { ?>
					swal({
						title: "Código inválido!",
						text: "O código informado não confere com o código recebido no seu e-mail.",
						icon: "warning",
						button: "Fechar",
					});
				<?php };?>
				
				<?php if(isset($usuario_bloqueado_definitivo)) { ?>
					swal({
						title: "Usuário bloqeuado definitivamente!",
						text: "<?= $usuario_bloqueado_definitivo;?>",
						icon: "warning",
						button: "Fechar",
					});
				<?php };?>
			
				<?php if(isset($usuario_reativado)) { ?>
					swal({
						title: "Usuário reativado com sucesso!",
						text: "Sua senha foi resetada. Volte para a tela de recuperação de senha para gerar uma nova senha.",
						icon: "success",
						button: "Fechar",
					});
				<?php };?>
			
			
		});
		</script>


	</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>