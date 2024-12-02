<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Tela de Cadastro</title>
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
				<form action="<?= URL_PROJETO;?>/usuarios/cadastrar" method="POST">				
					<h3>Seja bem-vindo!</h3>
					<h4>Cadastre-se aqui para usar o sistema</h4>
					<!-- Mensagens de Erro de Nome -->
					<?php if (isset($erro_nome_vazio)): ?>   <div class='msg-erro-servidor'><?= $erro_nome_vazio; ?></div> <?php endif; ?>
					<?php if (isset($erro_nome_caracteres)): ?>   <div class='msg-erro-servidor'><?= $erro_nome_caracteres; ?></div> <?php endif; ?>
					<?php if (isset($erro_nome_curto)): ?>   <div class='msg-erro-servidor'><?= $erro_nome_curto; ?></div> <?php endif; ?>													
					<!-- Mensagens de Erro de Email -->
					<?php if (isset($erro_email_vazio)): ?>   <div class='msg-erro-servidor'><?= $erro_email_vazio; ?></div> <?php endif; ?>
					<?php if (isset($erro_email_invalido)): ?>   <div class='msg-erro-servidor'><?= $erro_email_invalido; ?></div> <?php endif; ?>
					<!-- Mensagens de Erro de Senha -->
					<?php if (isset($erro_senha_vazia)): ?>   <div class='msg-erro-servidor'><?= $erro_senha_vazia; ?></div> <?php endif; ?>
					<?php if (isset($erro_senha_curta)): ?>   <div class='msg-erro-servidor'><?= $erro_senha_curta; ?></div> <?php endif; ?>		
					<!-- Mensagens de Erro de Repete Senha -->
					<?php if (isset($erro_repete_senha)): ?>   <div class='msg-erro-servidor'><?= $erro_repete_senha; ?></div> <?php endif; ?>
					<?php if (isset($erro_repete_senha_curto)): ?>   <div class='msg-erro-servidor'><?= $erro_repete_senha_curto; ?></div> <?php endif; ?>
					<?php if (isset($erro_repete_senha_nao_confere)): ?>   <div class='msg-erro-servidor'><?= $erro_repete_senha_nao_confere; ?></div> <?php endif; ?>
					<!-- Mensagens Gerais -->				
					<?php if (isset($erro_usuario_cadastrado)): ?>   <div class='msg-erro-servidor'><?= $erro_usuario_cadastrado; ?></div> <?php endif; ?>
					<?php if (isset($sucesso_email_cadastrado)): ?>   <div class='msg-sucesso-servidor'><?= $sucesso_email_cadastrado; ?></div> <?php endif; ?>
					<?php if (isset($sucesso_email_cadastrado)): ?>    <div class='msg-blue-servidor'>    <a href="<?=URL_PROJETO;?>/usuarios/confirmacao">Clique aqui para confirmar seu cadastro </a> </div> <?php endif; ?>
					<?php if (isset($erro_email_nao_enviado)): ?>   <div class='msg-erro-servidor'><?= $erro_email_nao_enviado; ?></div> <?php endif; ?>										
					
					<!-- Input Nome -->
					<div class="form-holder">						
						<input type="text" id="nome" name="nome" class="form-control" placeholder="Nome Completo" value="<?= $nome ?? ''; ?>"  >
						<div class="msg-erro" id="erro-nome"> </div>												
					</div>					
					<!-- Input Email -->
					<div class="form-holder">					
						<input type="text" id="email" name="email" class="form-control" placeholder="Email" value="<?= $email; ?>" >
						<div class="msg-erro" id="erro-email"> </div>						
					</div>
					<!-- Input Senha -->
					<div class="form-holder">				
						<input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" value="<?= $senha; ?>" >
						<div class="msg-erro" id="erro-senha"> </div>						
					</div>
					<!-- Input Repete Senha -->
					<div class="form-holder">				
						<input type="password" id="repete_senha" name="repete_senha" class="form-control" placeholder="Confirme a Senha" value="<?= $confirma_senha; ?>" >
						<div class="msg-erro" id="erro_repete_senha"> </div>						
					</div>																								
					<button id="submit" type="submit"> <span>Cadastrar-se</span> </button>					
					<hr>
					<p class="link">Já possui cadastro?<a href="<?= URL_PROJETO;?>/usuarios/login"> Entrar</a></p>
				</form>
				<img src="<?= URL_PROJETO;?>/public/img/image-2.png" alt="" class="image-2">
			</div>			
		</div>	
		<!-- JQuery -->	
		<script src="js/jquery-3.3.1.min.js"></script>
		<!-- Validações de Input Javascript -->
		<script src="<?= URL_PROJETO;?>/public/js/cadastrar.js"></script> 
						
		<script>
			$(document).ready(function() {
				<?php if(isset($sucesso_email_cadastrado)) { ?>
					swal({
						title: "Uhu! E-mail cadastrado com sucesso! 🥳 ",
						text: "<?= $sucesso_email_cadastrado;?>",
						icon: "success",
						button: "Fechar",
					});
				<?php };?>
				<?php if(isset($erro_email_nao_cadastrado)) { ?>
					swal({
						title: "Ops. Algo deu errado! 😔 ",
						text: "<?= $erro_email_nao_cadastrado;?>",
						icon: "warning",
						button: "Fechar",
					});
				<?php };?>
		});
		</script>
		<!-- Bootstrap Javascript -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>		
	</body>
</html>