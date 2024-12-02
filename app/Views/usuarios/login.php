<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Tela de Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- JQuery -->
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

		<!-- Bootstrap CSS -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

		<!-- LINEARICONS -->
		<link rel="stylesheet" href="<?= URL_PROJETO;?>/public/fonts/linearicons/style.css">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
		
		<!-- STYLE CSS -->
		<link rel="stylesheet" href="<?= URL_PROJETO;?>/public/css/usuarios.css">

		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	</head>

	<body>

		<div class="wrapper">
			<div class="inner">
				<img src="<?= URL_PROJETO;?>/public/img/login-img.png" alt="" class="image-1">

				<form action="<?= URL_PROJETO;?>/usuarios/login" method="POST">

					<h3>Seja bem-vindo!</h3>

					

					<p id="titleheader">Por favor, insira seu e-mail e senha para acessar sua conta.</p>
				
					<!-- Mensagens de Erro de Email -->
					<?php if (isset($erro_email_vazio)): ?>   <div class='msg-erro-servidor'><?= $erro_email_vazio; ?></div> <?php endif; ?>
					<?php if (isset($erro_email_invalido)): ?>   <div class='msg-erro-servidor'><?= $erro_email_invalido; ?></div> <?php endif; ?>
					<?php if (isset($erro_email_nao_cadastrado)): ?>   <div class='msg-erro-servidor'><?= $erro_email_nao_cadastrado; ?></div> <?php endif; ?>
					
					<!-- Mensagens de Erro de Senha -->
					<?php if (isset($erro_senha_vazia)): ?>   <div class='msg-erro-servidor'><?= $erro_senha_vazia; ?></div> <?php endif; ?>
					<?php if (isset($erro_senha_curta)): ?>   <div class='msg-erro-servidor'><?= $erro_senha_curta; ?></div> <?php endif; ?>		
					<?php if (isset($erro_senha_nao_confere)): ?>   <div class='msg-erro-servidor'><?= $erro_senha_nao_confere; ?></div> <?php endif; ?>		
					<?php if (isset($quantidade_errada)): ?>   <div class='msg-erro-servidor'><?= $quantidade_errada; ?></div> <?php endif; ?>		
					<?php if (isset($erro_senha_resetada)): ?>   <div class='msg-erro-servidor'><?= $erro_senha_resetada; ?></div> <?php endif; ?>		

					<!-- Mensagens Gerais -->				
					<?php if (isset($usuario_bloqueado)): ?>   <div class='msg-erro-servidor'><?= $usuario_bloqueado; ?></div> <?php endif; ?>		
					<?php if (isset($login_nao_permitido)): ?>   <div class='msg-erro-servidor'><?= $login_nao_permitido; ?></div> <?php endif; ?>		
					<?php if (isset($usuario_bloqueado_definitivamente)): ?>   <div class='msg-erro-servidor'><?= $usuario_bloqueado_definitivamente; ?></div> <?php endif; ?>		
					<?php if (isset($notlogged)): ?>   <div class='msg-erro-servidor'><?= $notlogged; ?></div> <?php endif; ?>		
													
																															
					<!-- Input Email -->											
					<div class="form-holder">					
						<input type="text" id="email" name="email" class="form-control" placeholder="Email" value="<?= $email; ?>">
						<div class="msg-erro" id="erro-email"></div>
					</div>

					<!-- Input Senha -->					 
					<div class="form-holder">						
						<input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" value="<?= $senha; ?>">
						<div class="msg-erro" id="erro-senha"></div>
					</div>
					
					
								
					
					<button id="submit"  type="submit"> <span>Entrar</span> </button>					
					<hr>

					<p class="link">Ainda não possui conta? <a href="<?= URL_PROJETO;?>/usuarios/cadastrar"> <br>Cadastre-se</a></p>
					<p class="link">Precisa confirmar sua conta? <a href="<?= URL_PROJETO;?>/usuarios/confirmacao"><br>Confirmar conta</a></p>
					<p class="link">Precisa desbloquear sua conta? <a href="<?= URL_PROJETO;?>/usuarios/desbloqueio"> <br>Desbloquear conta</a></p>
					<p class="link">Esqueceu sua senha?<a href="<?= URL_PROJETO;?>/usuarios/recuperacao"> <br>Recuperar senha</a></p>
					
				</form>

				<img src="<?= URL_PROJETO;?>/public/img/image-2.png" alt="" class="image-2">
			</div>
			
		</div>

		<script src="<?= URL_PROJETO;?>/public/js/login.js"></script>
		
		<script src="js/jquery-3.3.1.min.js"></script>
		
		<script src="js/main.js"></script>
		
		

	</body>
</html>