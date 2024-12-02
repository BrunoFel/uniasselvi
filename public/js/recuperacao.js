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

// Evento de clique no botão de enviar
$('#submit').click(function() {

	validarEmail();

	// Verifica se todos os campos estão válidos
	if ($('.is-invalid').length > 0) {
		return false; // Impede o envio do formulário se houver erros
    }
});
