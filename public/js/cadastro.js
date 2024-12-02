			
// Função para validar o campo de nome
$('#nome').blur(function() {
	validarNome();
});
		
function validarNome() {
	var nome = $('#nome').val();
	var regex = /^[a-zA-ZÀ-ÖØ-öø-ÿ' çÇ]*$/;
	var partes_nome = nome.trim().split(/\s+/);

	//Se vazio
	if (nome == "" || nome == null) {
		$('#nome').addClass('is-invalid');
		$('#erro-nome').addClass('invalid-feedback');
		$('#erro-nome').html('Campo de nome não pode ser vazio');
	//Se não atende o critério de somente letras
	} else if (!regex.test(nome)) {
		$('#nome').addClass('is-invalid');
		$('#erro-nome').addClass('invalid-feedback');
		$('#erro-nome').html('O campo de nome deve conter apenas letras alfabéticas');
	}
	//Se tiver apenas uma palavra
	else if (partes_nome.length < 2) {
		$('#nome').addClass('is-invalid');
		$('#erro-nome').addClass('invalid-feedback');
		$('#erro-nome').html('O campo de nome deve conter pelo menos duas palavras');
	//Se tudo estiver certo
	} else {
		$('#nome').removeClass('is-invalid');
		$('#erro-nome').removeClass('invalid-feedback');
		$('#nome').addClass('is-valid');
		$('#erro-nome').addClass('valid-feedback');
		$('#erro-nome').html('Perfeito! ;-)'); 
	}
}

// Função para validar o campo de e-mail
$('#email').blur(function() {
	validarEmail();
});

// Função para validar o campo de e-mail
function validarEmail() {
	var email = $('#email').val();
	var regexEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

	//Se vazio
	if (email == "" || email == null) { 
		$('#email').addClass('is-invalid');
		$('#erro-email').addClass('invalid-feedback');
		$('#erro-email').html('Campo de e-mail não pode ser vazio');                    
	//Se nao antende aos criterios de email
	} else if (!regexEmail.test(email)){ 
		$('#email').addClass('is-invalid');
		$('#erro-email').addClass('invalid-feedback');
		$('#erro-email').html('Por favor, insira um formato de e-mail válido');                
	} else { 
		$('#email').removeClass('is-invalid');
		$('#erro-email').removeClass('invalid-feedback');
		$('#email').addClass('is-valid');                    
		$('#erro-email').addClass('valid-feedback');                    
		$('#erro-email').html('E-mail válido!');        
	}
}

// Função para validar o campo de Senha
$('#senha').blur(function() {
	validarSenha();
});

// Função para validar o campo de senha
function validarSenha() {
	var senha = $('#senha').val();

	//Se vazio
	if (senha == "" || senha ==null) { 
		$('#senha').addClass('is-invalid');
		$('#erro-senha').addClass('invalid-feedback');
		$('#erro-senha').html('Campo de senha não pode ser vazio');
	//Se tem menos de 6 caracteres
	} else if (senha.length < 6) { 
		$('#senha').addClass('is-invalid');
		$('#erro-senha').addClass('invalid-feedback');
		$('#erro-senha').html('A senha deve ter pelo menos 6 caracteres');                    
	} else { // Se todos os critérios forem preenchidos
		$('#senha').removeClass('is-invalid');
		$('#erro-senha').removeClass('invalid-feedback');
		$('#senha').addClass('is-valid');                    
		$('#erro-senha').addClass('valid-feedback');                    
		$('#erro-senha').html('Perfeito!;-)');        
	}
}

// Função para validar o campo de Repte Senha
$('#repete_senha').blur(function() {
	validarRepeteSenha();
});

// Função para validar o campo de confirmação de senha
function validarRepeteSenha() {
	var senha = $('#senha').val();
	var repete_senha = $('#repete_senha').val();

	//Se vazio
	if (repete_senha == "" || repete_senha == null) {
		$('#repete_senha').addClass('is-invalid');
		$('#erro_repete_senha').addClass('invalid-feedback');
		$('#erro_repete_senha').html('Campo de confirmação de senha não pode ser vazio');
	//Se for menos que 6
	}	else if (repete_senha.length < 6) { 
		$('#repete_senha').addClass('is-invalid');
		$('#erro_repete_senha').addClass('invalid-feedback');
		$('#erro_repete_senha').html('A senha deve ter pelo menos 6 caracteres');   
	//Se não confere com a senha               
	}	else if (senha != repete_senha) { 
		$('#repete_senha').addClass('is-invalid');
		$('#erro_repete_senha').addClass('invalid-feedback');
		$('#erro_repete_senha').html('As senhas não conferem');     
		$('#erro_senha').html('As senhas não conferem');                  
	}	else {
	//Se der certo
		$('#repete_senha').removeClass('is-invalid');
		$('#erro_repete_senha').removeClass('invalid-feedback');
		$('#repete_senha').addClass('is-valid');                    
		$('#erro_repete_senha').addClass('valid-feedback');                    
		$('#erro_repete_senha').html('Perfeito! As senham conferem! ;-)');            
	}
}

// Evento de clique no botão de enviar
$('#submit').click(function() {
	validarNome();
	validarEmail();
	validarSenha();
	validarRepeteSenha();

	// Verifica se todos os campos estão válidos
	if ($('.is-invalid').length > 0) {
		return false; // Impede o envio do formulário se houver erros
    }
});
