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
$('#codigo').blur(function() {
	validarCodigo();
});

// Função para validar o campo de senha
function validarCodigo() {
	var codigo = $('#codigo').val();

	//Se vazio
	if (codigo == "" || codigo ==null) { 
		$('#codigo').addClass('is-invalid');
		$('#erro-codigo').addClass('invalid-feedback');
		$('#erro-codigo').html('Código de recuperação não pode ser vazio');
	//Se tem menos de 6 caracteres
	} else if (codigo.length < 6) { 
		$('#codigo').addClass('is-invalid');
		$('#erro-codigo').addClass('invalid-feedback');
		$('#erro-codigo').html('O código tem que ter pelo menos 6 caracteres');                    
	} else { // Se todos os critérios forem preenchidos
		$('#codigo').removeClass('is-invalid');
		$('#erro-codigo').removeClass('invalid-feedback');
		$('#codigo').addClass('is-valid');                    
		$('#erro-codigo').addClass('valid-feedback');                    
		$('#erro-codigo').html('Perfeito!;-)');        
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
		$('#erro-senha').html('Código de recuperação não pode ser vazio');
	//Se tem menos de 6 caracteres
	} else if (senha.length < 6) { 
		$('#senha').addClass('is-invalid');
		$('#erro-senha').addClass('invalid-feedback');
		$('#erro-senha').html('O código tem que ter pelo menos 6 caracteres');                    
	} else { // Se todos os critérios forem preenchidos
		$('#senha').removeClass('is-invalid');
		$('#erro-senha').removeClass('invalid-feedback');
		$('#senha').addClass('is-valid');                    
		$('#erro-senha').addClass('valid-feedback');                    
		$('#erro-senha').html('Perfeito!;-)');        
	}
}

// Evento de clique no botão de enviar
$('#submit').click(function() {
	validarEmail();
	validarSenha();
	validarCodigo();
	// Verifica se todos os campos estão válidos
	if ($('.is-invalid').length > 0) {
		return false; // Impede o envio do formulário se houver erros
    }
});


