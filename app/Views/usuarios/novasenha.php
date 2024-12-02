<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Nova Senha</title>
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

				<form action="<?= URL_PROJETO;?>/usuarios/novasenha" method="POST">

					<h3>Nova senha.</h3>

					<p id="titleheader">Informa uma nova senha com no mínimo 6 caracteres.</p>

					<!-- Mensagens de Erro de Email -->
					<?php if (isset($erro_email_vazio)): ?>   <div class='msg-erro-servidor'><?= $erro_email_vazio; ?></div> <?php endif; ?>
					<?php if (isset($erro_email_invalido)): ?>   <div class='msg-erro-servidor'><?= $erro_email_invalido; ?></div> <?php endif; ?>


					<!-- Mensagens de Erro de Código -->
					<?php if (isset($erro_codigo_vazio)): ?>   <div class='msg-erro-servidor'><?= $erro_codigo_vazio; ?></div> <?php endif; ?>

					<!-- Mensagens de Erro de Senha -->
					<?php if (isset($erro_senha_vazio)): ?>   <div class='msg-erro-servidor'><?= $erro_senha_vazio; ?></div> <?php endif; ?>
					<?php if (isset($erro_senha_caracteres)): ?>   <div class='msg-erro-servidor'><?= $erro_senha_caracteres; ?></div> <?php endif; ?>
					
					
					
					<!-- Mensagmes Gerais -->
					<?php if (isset($erro_usuario_nao_cadastrado)): ?>   <div class='msg-erro-servidor'><?= $erro_usuario_nao_cadastrado; ?></div> <?php endif; ?>
					<?php if (isset($erro_codigo_invalido)): ?>   <div class='msg-erro-servidor'><?= $erro_codigo_invalido; ?></div> <?php endif; ?>
					<?php if (isset($senha_alterada_sucesso)): ?>   <div class='msg-sucesso-servidor'><?= $senha_alterada_sucesso; ?></div> <?php endif; ?>
					<?php if (isset($senha_alterada_falha)): ?>   <div class='msg-erro-servidor'><?= $senha_alterada_falha; ?></div> <?php endif; ?>
					<?php if (isset($usuario_bloqueado_definitivivamente)): ?>   <div class='msg-erro-servidor'><?= $usuario_bloqueado_definitivivamente; ?></div> <?php endif; ?>
					<?php if (isset($erro_token_nao_gerado)): ?>   <div class='msg-erro-servidor'><?= $erro_token_nao_gerado; ?></div> <?php endif; ?>


				

					
					<?php if(isset($codigo_gerado_e_email_enviado)){ ?> <p class="mt-2"></p><a href="<?= URL_PROJETO; ?>/usuarios/novasenha">Clique aqui</a> para gerar uma nova senha </p> <?php }?>

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
					
					<!-- Input Senha -->
					<div class="form-holder">						
						<input type="password" id="senha" name="senha" class="form-control" placeholder="Nova Senha" value="<?= $senha; ?>" >
						<div class="msg-erro" id="erro-senha"></div>
					</div>											
					
					
					<button id="submit"  type="submit"> <span>Redefinir senha</span> </button>					
					<hr>

					<p class="link">Conseguiu alterar sua senha? <br><a href="<?= URL_PROJETO;?>/usuarios/login"> Voltar para Login</a></p>

					
				</form>

				<img src="<?= URL_PROJETO;?>/public/img/image-2.png" alt="" class="image-2">
			</div>
			
		</div>

		<script src="<?= URL_PROJETO;?>/public/js/novasenha.js"></script>
		
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

				<?php if(isset($codigo_gerado_e_email_enviado)) { ?>
					swal({
						title: "E-mail enviado com sucesso!",
						text: "<?= $codigo_gerado_e_email_enviado;?>",
						icon: "success",
						button: "Fechar",
					});
				<?php };?>

				<?php if(isset($senha_alterada_sucesso)) { ?>
					swal({
						title: "Perfeito!",
						text: "<?= $senha_alterada_sucesso;?>",
						icon: "success",
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
			
			
		});
		</script>


	</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>