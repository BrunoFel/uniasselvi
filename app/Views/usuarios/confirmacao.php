<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
		<title>Confirmação de Cadastro</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Jquery -->
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<!-- Main Javascript -->
		<script src="js/main.js"></script>
		<!-- Linearicons -->
		<link rel="stylesheet" href="<?= URL_PROJETO;?>/public/fonts/linearicons/style.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">		
		<!-- CSS Próprio -->
		<link rel="stylesheet" href="<?= URL_PROJETO;?>/public/css/usuarios.css">
		<!-- Sweet Alert -->
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>		
	</head>

	<body>

		<div class="wrapper">
			<div class="inner">
				<img src="<?= URL_PROJETO;?>/public/img/login-img.png" alt="" class="image-1">

				<form action="<?= URL_PROJETO;?>/usuarios/confirmacao" method="POST">

					<h3>Confirmação de Cadastro</h3>

					<p id="titleheader">Informe seu e-mail e código de confirmacao.</p>

					
					<!-- Mensagens de Erro de Email -->
					<?php if (isset($erro_email_vazio)): ?>   <div class='msg-erro-servidor'><?= $erro_email_vazio; ?></div> <?php endif; ?>
					<?php if (isset($erro_email_invalido)): ?>   <div class='msg-erro-servidor'><?= $erro_email_invalido; ?></div> <?php endif; ?>
					<!-- Mensagens de Erro de Código -->
					<?php if (isset($erro_codigo_vazio)): ?>   <div class='msg-erro-servidor'><?= $erro_codigo_vazio; ?></div> <?php endif; ?>					
					<?php if (isset($erro_codigo_invalido)): ?>   <div class='msg-erro-servidor'><?= $erro_codigo_invalido . "<br>" . $quantidade_errada; ?></div> <?php endif; ?>					
					<!-- Mensagens Gerais -->				
					<?php if (isset($sucesso_usuario_confirmado)): ?>   <div class='msg-sucesso-servidor'><?= $sucesso_usuario_confirmado; ?></div> <?php endif; ?>
					<?php if (isset($sucesso_usuario_confirmado)): ?>   <div class='msg-blue-servidor'>  <a href="<?=URL_PROJETO;?>/usuarios/login">Clique aqui para acessar o sistema</a> </div> <?php endif; ?>
					<?php if (isset($erro_usuario_nao_confirmado)): ?>   <div class='msg-erro-servidor'><?= $erro_usuario_nao_confirmado; ?></div> <?php endif; ?>										
					<?php if (isset($erro_email_nao_cadastrado)): ?>   <div class='msg-erro-servidor'><?= $erro_email_nao_cadastrado; ?></div> <?php endif; ?>										
					<?php if (isset($usuario_bloqueado_definitivamente)): ?>   <div class='msg-erro-servidor'><?= $usuario_bloqueado_definitivamente; ?></div> <?php endif; ?>										
					<?php if (isset($erro_email_nao_cadastrado)): ?>    <div class='msg-blue-servidor'>    <a href="<?=URL_PROJETO;?>/usuarios/cadastrar">Clique aqui para cadastrar-se</a> </div> <?php endif; ?>
					<?php if (isset($erro_codigo_confirmacao_nao_solicitado)): ?>    <div class='msg-erro-servidor'>  <?= $erro_codigo_confirmacao_nao_solicitado; ?>   </div> <?php endif; ?>
					
				
				
															
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
					
					
					<hr>
					<p class="link">Conseguiu confirmar sua conta? <br><a href="<?= URL_PROJETO;?>/usuarios/login">Fazer login</a></p>
					

					
				</form>

				<img src="<?= URL_PROJETO;?>/public/img/image-2.png" alt="" class="image-2">
			</div>
			
		</div>

		<script>
			$(document).ready(function() {
				<?php if(isset($sucesso_usuario_confirmado)) { ?>
					swal({
						title: "Uhu! Cadastro confirmado! 🥳",
						text: "<?= $sucesso_usuario_confirmado;?>",
						icon: "success",
						button: "Fechar",
					});
				<?php };?>

			
		});
		</script>

		<script src="<?= URL_PROJETO;?>/public/js/confirmacao.js"></script>
		
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/main.js"></script>




	</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>