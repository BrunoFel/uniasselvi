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
		$('#erro-codigo').html('Token de autenticação não pode ser vazio');
	//Se tem menos de 6 caracteres                  
	} else { // Se todos os critérios forem preenchidos
		$('#codigo').removeClass('is-invalid');
		$('#erro-codigo').removeClass('invalid-feedback');
		$('#codigo').addClass('is-valid');                    
		$('#erro-codigo').addClass('valid-feedback');                    
		$('#erro-codigo').html('Perfeito!;-)');        
	}
}


// Evento de clique no botão de enviar
$('#submit').click(function() {
	validarCodigo()

	// Verifica se todos os campos estão válidos
	if ($('.is-invalid').length > 0) {
		return false; // Impede o envio do formulário se houver erros
    }
});
