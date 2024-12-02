<?php 
class Usuarios extends ControladorBase {

    public function cadastrar() {

        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        if(isset($formulario)){

            $validacao_sucesso = true;

            // Aplica a função a todos os itens do $_POST e gera um array chamado $formulario com todos os elementos    
            $formulario = array_map('cleanUp', $_POST);

            $dados = [
            'nome' => $formulario['nome'] ?? '',
            'email' => $formulario['email'] ?? '',
            'senha' => $formulario['senha'] ?? '',
            'confirma_senha' => $formulario['repete_senha'] ?? '',
            ];    

            $partes_nome = explode(' ', $formulario['nome']);
            $senhaCrypt = password_hash($formulario['senha'], PASSWORD_BCRYPT);
        
            /* Validações do nome (TESTADO) */ 
            //Se vazio
            if (empty($formulario['nome'])): 
                $dados['erro_nome_vazio'] = 'Nome obrigatório'; 
                $validacao_sucesso = false;
            //Se não atende o critério de somente letras
            elseif (Check::checkNome($formulario['nome'])): 
                $dados['erro_nome_caracteres'] = "Digite apenas apenas letras alfabéticas";
                $validacao_sucesso = false; 
            //Se tiver apenas uma palavra
            elseif (count($partes_nome) < 2): 
                $dados['erro_nome_curto'] = 'Insira seu nome completo';
                $validacao_sucesso = false;            
           
            endif;

            /* Validações do Email (TESTADO) */
            //Se vazio
            if (empty($formulario['email'])) :
                $dados['erro_email_vazio'] = 'Email obrigatório';
                $validacao_sucesso = false;
            //Se não atende aos critérios de email
             elseif (Check::checkEmail($formulario['email'])) :
                $dados['erro_email_invalido'] = 'Formato de e-mail inválido';
                $validacao_sucesso = false;
           
            endif;
           
            /* Validações da Senha (TESTADO) */
            //Se vazio
            if (empty($formulario['senha'])): 
                $dados['erro_senha_vazia'] = 'Senha obrigatória'; 
                $validacao_sucesso = false;
            //Se tem menos de 6 caracteres
            elseif (strlen($formulario['senha']) < 6): 
                $dados['erro_senha_curta'] = 'A senha deve ter pelo menos 6 caracteres.';
                $validacao_sucesso = false;                            
            endif;

            /* Validações da Repetição de Senha (TESTADO) */
            //Se vazio
            if (empty($formulario['repete_senha'])): 
                $dados['erro_repete_senha'] = 'Necessário confirmar a senha'; 
                $validacao_sucesso = false;
            //Se tem menos de 6 caracteres
            elseif (strlen($formulario['repete_senha']) < 6): 
                $dados['erro_repete_senha_curto'] = 'A confirmação de senha deve ter pelo menos 6 caracteres.';
                $validacao_sucesso = false; 
            elseif (($formulario['senha']) !== $formulario['repete_senha']): 
                $dados['erro_repete_senha_nao_confere'] = 'As senhas não conferem'; 
                $validacao_sucesso = false;
       
            endif;

            //Se todas as validações deram certo, Então vamos consultar o banco através da Model para verificar se o usuário existe:
            if ($validacao_sucesso) {
                    
                //Instanciar o Model
                $model = $this->carregarModel('UsuariosModel'); // Carregando o model

                // Chama a função VerificarSeUSuarioExiste e salva o retorno dela na variavel usuarioExiste
                $usuarioExiste = $model->verificarSeUsuarioExiste($formulario['email']);
                         
                //Se retornar um email do banco, então a variavel usuarioExiste possui a string do email e é TRUE                
                if($usuarioExiste){
                   
                    $dados['erro_usuario_cadastrado'] = 'E-mail já cadastrado. <br>' .  "<a class='text-warning' href=\"" . URL_PROJETO . "/usuarios/login\">Clique aqui</a> para acessar a plataforma";                                                    
                } else {                    
                    //Não é necessário instanciar o model novamente, mas apenas chamar a função inserirUsuarioNoBanco
                    $token = rand(100000, 999999);
                    $inseridoComSucesso = $model->inserirUsuarioNoBanco($formulario['nome'], $formulario['email'], $senhaCrypt, $token);

                    if ($inseridoComSucesso) {
                      
                        if (Email::enviarEmaildeCadastro($formulario['email'], $formulario['nome'], $token)) {
                         
                            $dados['sucesso_email_cadastrado'] = 'Parabéns! Seu email foi cadastrado com sucesso! Um token foi enviado para a sua caixa de entrada. Vefique seu e-mail para confirmar seu cadastro.';
                        } else {
                        
                            $dados['erro_email_nao_enviado'] = 'Seu usuário foi cadastrado, mas houve um erro no envio do e-mail de confirmação. Por favor, entre em contato com o suporte da Bin em atendimento@binwebconnect.com.br';
                        }                       
                    }                                                           
                }
            }                                                                                                                      
        } else {               
            // Inicializa os dados com strings vazias se o formulário não for preenchido corretamente
            $dados = [
                'nome' => '',
                'email' => '',
                'senha' => '',
                'confirma_senha' => '',
                
            ];                                                      
        }    
        $this->carregarView('usuarios/cadastrar', $dados);
    }
   
    public function confirmacao() {
        // Definindo os dados que você quer passar para a View

        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        
        if(isset($formulario)){    
           
            $validacao_sucesso = true;

            // Aplica a função a todos os itens do $_POST e gera um array chamado $formulario com todos os elementos    
            $formulario = array_map('cleanUp', $_POST);

            $dados = [        
            'email' => $formulario['email'] ?? '',             
            'codigo' => $formulario['codigo'] ?? '',             
            ];    
                        
            /* Validações do Email */
            //Se vazio
            if (empty($formulario['email'])) :
                $dados['erro_email_vazio'] = 'Campo email obrigatório';
                $validacao_sucesso = false;
            //Se não atende aos critérios de email
             elseif (Check::checkEmail($formulario['email'])) :
                $dados['erro_email_invalido'] = 'Insira um formato de e-mail válido';
                $validacao_sucesso = false;           
            endif;

            /* Validações do Codigo */
            //Se vazio
            if (empty($formulario['codigo'])): 
                $dados['erro_codigo_vazio'] = 'Campo código obrigatório'; 
                $validacao_sucesso = false;                      
            endif;
           
            //Se todas as validações deram certo, Então vamos consultar o banco através da Model para verificar se o usuário existe:
            if ($validacao_sucesso) {
                    
                //Instanciar o Model
                $model = $this->carregarModel('UsuariosModel'); // Carregando o model

                // Chama a função VerificarSeUSuarioExiste e salva o retorno dela na variavel usuarioExiste
                $usuarioExiste = $model->verificarSeUsuarioExiste($formulario['email']);             
            
                //Se retornar um email do banco, então a variavel é usuarioExiste possui a string do emial e é TRUE                
                if($usuarioExiste){      
               
                    //Se o usuário existe, verificar se o codigo informado confere com o codigo inserido no banco:
                    $codigoConfirmacao = $model->verificarToken($formulario['email'], $formulario['codigo']);
                                          
                                   
                    if($codigoConfirmacao == $formulario['codigo']){
                        
                                         
                        $usuarioDesbloqueado = $model->desbloquearUsuario($formulario['email']);                        
                        $codigoConfirmacaoResetado = $model->resetarToken($formulario['email']);

                        if($usuarioDesbloqueado && $codigoConfirmacaoResetado){
                            $dados['sucesso_usuario_confirmado'] = 'Seu usuário foi confirmado com sucesso! Agora você pode acessar a nossa plataforma e começar cadastrar sua citações favoritas!';
                        } else {
                            $dados['erro_usuario_nao_confirmado'] = 'Houve um erro ao confirmar seu cadastro. Por favor, entre em contato com o atendimento da Bin em atendimento@binwebconnect.com.br';
                        }

                    } else {   
                        
                    
                        // Defina a mensagem de código inválido
                        $dados['erro_codigo_invalido'] = 'Código informado inválido.';                        
                        // Verifica a quantidade de tentativas erradas
                        $tentativas = $model->verificarContador($formulario['email']);

                        // Incrementar tentativas apenas após verificar o número de tentativas
                        $tentativaAtual = $tentativas + 1;

                        // Se o número de tentativas erradas for igual a 2 (ou seja, na próxima tentativa ele atingirá 3)
                        if ($tentativas >= 2) {
                            // Bloquear o usuário porque ele já digitou o código errado 3 vezes
                            $model->incrementarContador($formulario['email']);
                            $bloqDefinitivo = $model->bloquearDefinitivamente($formulario['email']);
                            $dados['quantidade_errada'] = 'Você digitou o código errado ' . $tentativaAtual . 'x';
                            $dados['usuario_bloqueado_definitivamente'] = 'Seu usuário foi bloqueado definitivamente após 3 tentativas. Favor, entrar em contato com o suporte da Bin: atendimento@binwebconnect.com.br';
                        } else {
                            // Incrementar tentativas erradas
                            $model->incrementarContador($formulario['email']);
                            $dados['quantidade_errada'] = 'Você digitou o código errado ' . $tentativaAtual . 'x';
                        } 

                                                                                                                                                                                                                                                                     
                    }                                                                                                                                 
                } else {                                                     
                    $dados['erro_email_nao_cadastrado'] = 'Usuário não cadastrado no sistema';                                                                         
                }
            }
                                                                                                                      
        } else {        
       
            // Inicializa os dados com strings vazias se o formulário não for preenchido corretamente
            $dados = [           
                'email' => '',
                'codigo' => '',
                        
            ];
                                                      
        }
                
        // Chamar uma View já fazendo junção de back com front
        $this->carregarView('usuarios/confirmacao', $dados);
    }
    
    public function desbloqueio() {
        // Definindo os dados que você quer passar para a View

        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        
        if(isset($formulario)){    

           
            $validacao_sucesso = true;

            // Aplica a função a todos os itens do $_POST e gera um array chamado $formulario com todos os elementos    
            $formulario = array_map('cleanUp', $_POST);

            $dados = [        
            'email' => $formulario['email'] ?? '',             
            ];    
                        
            /* Validações do Email */
            //Se vazio
            if (empty($formulario['email'])) :
                $dados['erro_email_vazio'] = 'Campo email obrigatório';
                $validacao_sucesso = false;
            //Se não atende aos critérios de email
             elseif (Check::checkEmail($formulario['email'])) :
                $dados['erro_email_invalido'] = 'Por favor, insira um formato de e-mail válido';
                $validacao_sucesso = false;           
            endif;
           
            //Se todas as validações deram certo, Então vamos consultar o banco através da Model para verificar se o usuário existe:
            if ($validacao_sucesso) {
                    
                //Instanciar o Model
                $model = $this->carregarModel('UsuariosModel'); // Carregando o model

                // Chama a função VerificarSeUSuarioExiste e salva o retorno dela na variavel usuarioExiste
                $usuarioExiste = $model->verificarSeUsuarioExiste($formulario['email']);
                         
                //Se retornar um email do banco, então a variavel é usuarioExiste possui a string do emial e é TRUE                
                if($usuarioExiste){

                                                  
                    //Se o usuário existe, verificar se o codigo informado confere com o codigo inserido no banco:
                    $status = $model->consultarStatusUsuario($formulario['email']);

                    if($status == 'bloqueado'){
                                           
                        //Inserir um códido de recuperação no banco e enviar esse código por e-mail com um link para inserir esse código
                        $token = rand(100000, 999999);
                        
                        $codigoGerado = $model->salvarToken($formulario['email'], $token);

                        if($codigoGerado){

                            if (Email::enviarEmaildeDesbloqueio($formulario['email'], $token)) {
                                
                                $dados['codigo_gerado_e_email_enviado'] = 'O código foi enviado para o seu e-email. Favor, confira sua caixa de entrada.' . '<br>' .  "<a class='text-warning' href=\"" . URL_PROJETO . "/usuarios/reativacao\">Clique aqui</a> para reativar seu cadastro";
                                
                            } else {

                                $dados['codigo_gerado_e_email_nao_enviado'] = 'Código gerado, mas e-mail não enviado.' . '<br>' . 'Favor, entre em contato com o suporte em atendimento@binwebconnect.com.br';
                            }

                        } else {
                            $dados['erro_codigo_gerado'] = 'Ocorreu um erro ao gerar o código. <br> Favor, entre em contato com o suporte. <br> atendimento@binwebconnect.com.br';
                        }

                    } else {
                        $dados['erro_usuario_nao_bloqueado'] = 'Erro 456';
                    }
                                                       
                    
                                                           
                                                    
                } else {                                     
                    //Não é necessário instanciar o model novamente, mas apenas chamar a função inserirUsuarioNoBanco
                    $dados['erro_email_nao_cadastrado'] = 'Não é possível recuperar uma conta de um email não cadastrado no sistema. ' . '<br>' .  "<a class='text-warning' href=\"" . URL_PROJETO . "/usuarios/cadastrar\">Clique aqui</a> para cadastrar-se";
                                                                         
                }
            }                                                                                                                      

        } else {        
       
            // Inicializa os dados com strings vazias se o formulário não for preenchido corretamente
            $dados = [           
                'email' => '',
                        
            ];

            
                               
           
        }
        
        

        // Chamar uma View já fazendo junção de back com front
        $this->carregarView('usuarios/desbloqueio', $dados);
    }
  
    public function login() {
                
        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        
        if(isset($formulario)){    

            $validacao_sucesso = true;

            // Aplica a função a todos os itens do $_POST e gera um array chamado $formulario com todos os elementos    
            $formulario = array_map('cleanUp', $_POST);

            $dados = [        
            'email' => $formulario['email'] ?? '',
            'senha' => $formulario['senha'] ?? '',        
            ];    
                        
            /* Validações do Email */
            //Se vazio
            if (empty($formulario['email'])) :
                $dados['erro_email_vazio'] = 'Campo e-mail obrigatório';
                $validacao_sucesso = false;
            //Se não atende aos critérios de email
             elseif (Check::checkEmail($formulario['email'])) :
                $dados['erro_email_invalido'] = 'Insira um e-mail em formato válido';
                $validacao_sucesso = false;           
            endif;

           
           /* Validações da Senha */
            //Se vazio
            if (empty($formulario['senha'])): 
                $dados['erro_senha_vazia'] = 'Campo senha obrigatório'; 
                $validacao_sucesso = false;
            //Se tem menos de 6 caracteres
            elseif (strlen($formulario['senha']) < 6): 
                $dados['erro_senha_curta'] = 'A senha deve ter pelo menos 6 caracteres.';
                $validacao_sucesso = false;                    
            endif; /* Validações da Senha */
          
       
            //Se todas as validações deram certo, Então vamos consultar o banco através da Model para verificar se o usuário existe:
            if ($validacao_sucesso) {

           
                //Instanciar o Model
                $model = $this->carregarModel('UsuariosModel'); // Carregando o model

                // Chama a função VerificarSeUSuarioExiste e salva o retorno dela na variavel usuarioExiste
                $usuarioExiste = $model->verificarSeUsuarioExiste($formulario['email']);

           
                         
                //Se retornar um email do banco, então a variavel é usuarioExiste possui a string do emial e é TRUE                
                if ($usuarioExiste) {

               

                    // Verificar o status do usuário no banco: (ativo / bloqueado / bloqueado definitivamente)
                    $status = $model->consultarStatusUsuario($formulario['email']);
                
                    if ($status === 'bloqueado definitivamente') {
                        $dados['usuario_bloqueado_definitivamente'] = 'Seu cadastro está:  ' . '<br>' . strtoupper($status) . '<br>' . 'Entre em contato conosco.';
                    } elseif ($status === 'bloqueado') {
                        $dados['usuario_bloqueado'] = 'Seu cadastro está:  ' . '<br>' . strtoupper($status) . '<br>' . "<a class='text-warning' href=\"" . URL_PROJETO . "/usuarios/desbloqueio\">Clique aqui</a> para desbloquear sua conta";
                    } else {

                    
                        // Verificar se a senha está correta
                        $senhaDoBanco = $model->verificaSenha($formulario['email']);
                        
                        // Se as senhas batem
                        if (password_verify($formulario['senha'], $senhaDoBanco)) {
                         
                            
                            // Verificar se há autenticação em dois fatores
                            $doisFatores = $model->verificarDoisFatores($formulario['email']);

                          
                            
                            //2 FATORESA ATIVADA
                            if ($doisFatores) {

                                $token = rand(100000, 999999);
                
                                // Salvar o token gerado no banco
                                $tokenSalvo = $model->salvarToken($formulario['email'], $token);
                
                                if ($tokenSalvo) {

                                    if (Email::enviarEmaildeAuthDoisFatores($formulario['email'], $token)) {

                                        $_SESSION['email_inserido'] = $formulario['email'];
                                                                               
                                        URL::redirecionar('usuarios/auth2fa');
                                        exit;
                                        
                                    } else {
                                        $dados['codigo_gerado_e_email_nao_enviado'] = 'Código gerado, mas e-mail não enviado.' . '<br>' . 'Favor, entre em contato com o suporte em atendimento@binwebconnect.com.br';
                                    }
                                }
                            } else {

                             
                                
                                //2 FATORES DESATAIVADA                                
                                $model->zerarToken($formulario['email']);

                                                             
                                $model->zerarContador($formulario['email']);

                               
                              
                                $session_token = bin2hex(random_bytes(32));  
                                                                                              
                                
                                Session::criarSessao($formulario['email'], $session_token);

                                URL::redirecionar('plataforma/painel');
                                
                                exit;

                      
                            }
                        } else {
                            // Se a senha não está correta
                            if (empty($senhaDoBanco)) {
                                $dados['erro_senha_resetada'] = 'Sua senha foi resetada e você precisa criar uma nova imediatamente. ' . '<br>' . '<a class="text-warning" href="' . URL_PROJETO . '/usuarios/recuperacao">Clique aqui</a> para recuperar sua senha';
                            } else {
                                // Verifica a quantidade de tentativas erradas
                                $tentativas = $model->verificarContador($formulario['email']);
                
                                // Se o número de tentativas erradas for igual a 2 (ou seja, na próxima tentativa ele atingirá 3)
                                if ($tentativas >= 2) {
                                    // Bloquear o usuário porque ele já digitou o código errado 3 vezes
                                    $model->incrementarContador($formulario['email']);
                                    $tentativaAtual = $tentativas + 1; // Atualiza a contagem para a mensagem
                                    $dados['quantidade_errada'] = 'Você digitou a senha errada ' . $tentativaAtual . 'x';
                                    $model->bloquearUsuario($formulario['email']);
                                    $dados['usuario_bloqueado'] = 'Seu cadastro está: BLOQUEADO.' . '<br>' . "<a class='text-warning' href=\"" . URL_PROJETO . "/usuarios/desbloqueio\">Clique aqui</a> para desbloquear sua conta";
                                } else {
                                    // Incrementar tentativas erradas
                                    $model->incrementarContador($formulario['email']);
                                    $tentativaAtual = $tentativas + 1; // Atualiza a contagem para a mensagem
                                    $dados['quantidade_errada'] = 'Você digitou a senha errada ' . $tentativaAtual . 'x';
                                }
                            }
                        }
                    }
                } else {
                    // Não é necessário instanciar o model novamente, mas apenas chamar a função inserirUsuarioNoBanco
                    $dados['erro_email_nao_cadastrado'] = 'Email não cadastrado no sistema. ' . '<br>' . "<a class='text-warning' href=\"" . URL_PROJETO . "/usuarios/cadastrar\">Clique aqui</a> para cadastrar-se";
                }
                
            }

                                                                                                                      

        } else {        
       
            // Inicializa os dados com strings vazias se o formulário não for preenchido corretamente
            $dados = [           
                'email' => '',
                'senha' => '',              
            ];                                                      
        }        

        // Chamar uma View já fazendo junção de back com front
        $this->carregarView('usuarios/login', $dados);
        
    }
 
    public function recuperacao() {
        
        // Definindo os dados que você quer passar para a View

        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        
        if(isset($formulario)){    
           
            $validacao_sucesso = true;

            // Aplica a função a todos os itens do $_POST e gera um array chamado $formulario com todos os elementos    
            $formulario = array_map('cleanUp', $_POST);

            $dados = [        
            'email' => $formulario['email'] ?? '',             
            ];    
                        
            /* Validações do Email */
            //Se vazio
            if (empty($formulario['email'])) :
                $dados['erro_email_vazio'] = 'Campo email obrigatório';
                $validacao_sucesso = false;
            //Se não atende aos critérios de email
             elseif (Check::checkEmail($formulario['email'])) :
                $dados['erro_email_invalido'] = 'Insira um formato de e-mail válido';
                $validacao_sucesso = false;           
            endif;
           
            //Se todas as validações deram certo, Então vamos consultar o banco através da Model para verificar se o usuário existe:
            if ($validacao_sucesso) {
                    
                //Instanciar o Model
                $model = $this->carregarModel('UsuariosModel'); // Carregando o model
                // Chama a função VerificarSeUSuarioExiste e salva o retorno dela na variavel usuarioExiste
                $usuarioExiste = $model->verificarSeUsuarioExiste($formulario['email']);
                         
                //Se retornar um email do banco, então a variavel é usuarioExiste possui a string do emial e é TRUE                
                if($usuarioExiste){
                    //Verificar o status do usuário, pois usuários bloqeuados definitivamente não podem recuperar senha
                    $status = $model->consultarStatusUsuario($formulario['email']);
                  
                    if($status === 'bloqueado definitivamente'){
                        $dados['usuario_bloqueado_definitivamente'] = 'Seu cadastro está:  ' . '<br>' . strtoupper($status) . '<br>' . 'Entre em contato conosco. <br> atendimento@binwebconnect.com.br';                        
                    } elseif($status === 'bloqueado') {
                        $dados['usuario_bloqueado'] = 'Seu cadastro está:  ' . '<br>' . strtoupper($status) . '<br>' . "<a class='text-warning' href=\"" . URL_PROJETO . "/usuarios/desbloqueio\">Clique aqui</a> para desbloquear sua conta";
                    } else {                              
                        $token = rand(100000, 999999);
                        //Verfificar o codigo informado confere com o código do banco
                        $tokenSalvo = $model->salvarToken($formulario['email'], $token);

                        if($tokenSalvo){                            
                            if (Email::enviarEmaildeRecuperacaoDeSenha($formulario['email'], $token)) {                            
                                $dados['codigo_gerado_e_email_enviado'] = 'Um token foi enviado para o seu e-email. Confira sua caixa de entrada.' . '<br>' .  "<a class='text-danger' href=\"" . URL_PROJETO . "/usuarios/novasenha\">Clique aqui</a> para gerar a nova senha";                                
                            } else {                                
                                $dados['codigo_gerado_e_email_nao_enviado'] = 'Código gerado, mas e-mail não enviado.' . '<br>' . 'Favor, entre em contato com o suporte em atendimento@binwebconnect.com.br';
                            }
                        }
                    }                                                                                                        
                } else {
                                     
                    //Não é necessário instanciar o model novamente, mas apenas chamar a função inserirUsuarioNoBanco
                    $dados['erro_email_nao_cadastrado'] = 'Email não cadastrado no sistema. ' . '<br>' .  "<a class='text-warning' href=\"" . URL_PROJETO . "/usuarios/cadastrar\">Clique aqui</a> para cadastrar-se";
                                                                         
                }
            }                                                                                                                      

        } else {        
       
            // Inicializa os dados com strings vazias se o formulário não for preenchido corretamente
            $dados = [           
                'email' => '',
                        
            ];
                                                      
        }                

        // Chamar uma View já fazendo junção de back com front
        $this->carregarView('usuarios/recuperacao', $dados);
    }
      
    public function novasenha(){

        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        
        if(isset($formulario)){    

            $validacao_sucesso = true;

            // Aplica a função a todos os itens do $_POST e gera um array chamado $formulario com todos os elementos    
            $formulario = array_map('cleanUp', $_POST);

            $dados = [        
            'email' => $formulario['email'] ?? '',
            'codigo' => $formulario['codigo'] ?? '',   
            'senha' => $formulario['senha'] ?? '',        
            ];    

        
        
        
            /* Validações do Email */
            //Se vazio
            if (empty($formulario['email'])) :
                $dados['erro_email_vazio'] = 'Campo email obrigatório';
                $validacao_sucesso = false;
            //Se não atende aos critérios de email
             elseif (Check::checkEmail($formulario['email'])) :
                $dados['erro_email_invalido'] = 'Insira um formato de e-mail válido';
                $validacao_sucesso = false;           
            endif;

           
            /* Validações do Codigo */
            //Se vazio
            if (empty($formulario['codigo'])): 
                $dados['erro_codigo_vazio'] = 'Campo código obrigatório'; 
                $validacao_sucesso = false;                      
            endif;

            /* Validações da Senha */
            //Se vazio
            if (empty($formulario['senha'])): 
                $dados['erro_senha_vazio'] = 'Campo senha obrigatório'; 
                $validacao_sucesso = false;
            //Se tem menos de 6 caracteres
            elseif (strlen($formulario['senha']) < 6): 
                $dados['erro_senha_caracteres'] = 'A senha deve ter pelo menos 6 caracteres.';
                $validacao_sucesso = false;                   
            endif;

                                          
       
            //Se todas as validações deram certo, Então vamos consultar o banco através da Model para verificar se o usuário existe:
            if ($validacao_sucesso) {
                    
                //Instanciar o Model
                $model = $this->carregarModel('UsuariosModel'); // Carregando o model

                // Chama a função VerificarSeUSuarioExiste e salva o retorno dela na variavel usuarioExiste
                $usuarioExiste = $model->verificarSeUsuarioExiste($formulario['email']);             
            
                //Se retornar um email do banco, então a variavel é usuarioExiste possui a string do emial e é TRUE
                
                if($usuarioExiste){

                    //Verificar se o usuário solicitou nova senha
                    $tokenSolicitado = $model->verificarTokenZerado($formulario['email']);

                    if(empty($tokenSolicitado)){
                        $dados['erro_token_nao_gerado'] = 'Usuário não solicitou nenhuma recuperação de senha.';                                
                    } else {

                        //Verfificar o codigo informado confere com o código do banco
                        $codigoRecuperacaoDoBanco = $model->verificarToken($formulario['email'], $formulario['codigo']);
                    
                        
                        if($codigoRecuperacaoDoBanco == $formulario['codigo']){
                    

                            //vamos alterar a senha do banco pela senha informada:
                            $senhaCrypt = password_hash($formulario['senha'], PASSWORD_BCRYPT);

                            $senha_alterada_sucesso = $model->atualizaSenha($formulario['email'], $senhaCrypt);

                            if($senha_alterada_sucesso){

                                $model->zerarToken($formulario['email']);

                                $dados['senha_alterada_sucesso'] = 'Sua senha foi alterada com sucesso! ' . '<br>' .  "<a class='text-danger' href=\"" . URL_PROJETO . "/usuarios/login\">Clique aqui</a> para fazer login"; 
                        
                            } else {

                                $dados['senha_alterada_falha'] = 'Problema com sua alteração de senha. Por favor, entre em contato com o suporte. <br> atendimento@binwebconnect.com.br'; 
                            }



                        } else {

                            // Defina a mensagem de código inválido
                            $dados['erro_codigo_invalido'] = 'Código informado inválido.';

                            // Verifica a quantidade de tentativas erradas
                            $tentativas = $model->verificarContador($formulario['email']);

                            // Incrementar tentativas apenas após verificar o número de tentativas
                            $tentativaAtual = $tentativas + 1;
                        

                            // Se o número de tentativas erradas for igual a 2 (ou seja, na próxima tentativa ele atingirá 3)
                            if ($tentativas >= 2) {
                                // Bloquear o usuário porque ele já digitou o código errado 3 vezes
                                $model->incrementarContador($formulario['email']);
                                $bloqDefinitivo = $model->bloquearDefinitivamente($formulario['email']);
                                $dados['usuario_bloqueado_definitivivamente'] = 'Usuário bloqueado ' . strtoupper('definitivamente') . ' pois houve mais de ' . $tentativas . ' tentativas de inserção de código errado. <br> Entre em contato com o suporte da Bin em atendimento@binwebconnect.com.br';
                            } else {
                                // Incrementar tentativas erradas
                                $model->incrementarContador($formulario['email']);
                                $dados['erro_codigo_invalido'] = 'Você digitou o código errado ' . $tentativaAtual . 'x';
                            }
                                            
                        }

                    }
                  
                    

                   
                    

                    
                                                    
                } else {
                                                                             
                    $dados['erro_usuario_nao_cadastrado'] = 'Não é possível gerar uma nova senha para um usuário não cadastrado no sistema.' . '<br>' .  "<a class='text-warning' href=\"" . URL_PROJETO . "/usuarios/cadastrar\">Clique aqui</a> para cadastrar-se";
                                                                         
                }
            }

                                                                                                                      

        } else {        
       
            // Inicializa os dados com strings vazias se o formulário não for preenchido corretamente
            $dados = [    
                'email' => '',   
                'codigo' => '',     
                'senha' => '',
                        
            ];

            
                               
           
        }
        
        


        $this->carregarView('usuarios/novasenha', $dados);
    }
      
    public function reativacao() {
        // Definindo os dados que você quer passar para a View

        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        
        if(isset($formulario)){    
           
            $validacao_sucesso = true;

            // Aplica a função a todos os itens do $_POST e gera um array chamado $formulario com todos os elementos    
            $formulario = array_map('cleanUp', $_POST);

            $dados = [        
            'email' => $formulario['email'] ?? '',             
            'codigo' => $formulario['codigo'] ?? '',             
            ];    
                        
            /* Validações do Email */
            //Se vazio
            if (empty($formulario['email'])) :
                $dados['erro_email_vazio'] = 'Campo email obrigatório';
                $validacao_sucesso = false;
            //Se não atende aos critérios de email
             elseif (Check::checkEmail($formulario['email'])) :
                $dados['erro_email_invalido'] = 'Insira um formato de e-mail válido';
                $validacao_sucesso = false;           
            endif;

            /* Validações do Codigo */
            //Se vazio
            if (empty($formulario['codigo'])): 
                $dados['erro_codigo_vazio'] = 'Código de recuperaçõa obrigatório'; 
                $validacao_sucesso = false;                      
            endif;

         
       
            //Se todas as validações deram certo, Então vamos consultar o banco através da Model para verificar se o usuário existe:
            if ($validacao_sucesso) {

             
                    
                //Instanciar o Model
                $model = $this->carregarModel('UsuariosModel'); // Carregando o model


                // Chama a função VerificarSeUSuarioExiste e salva o retorno dela na variavel usuarioExiste
                $usuarioExiste = $model->verificarSeUsuarioExiste($formulario['email']);

             
            
                //Se retornar um email do banco, então a variavel é usuarioExiste possui a string do emial e é TRUE
                
                if($usuarioExiste){

                 

                    $status = $model->consultarStatusUsuario($formulario['email']);

                                     
                

                    if ($status == 'bloqueado') {                                            
                        //Verfificar o codigo informado confere com o código do banco
                        $codigoReativacao = $model->verificarToken($formulario['email'], $formulario['codigo']);
                        
                        if($codigoReativacao == $formulario['codigo']){
                            
                            $model->zerarContador($formulario['email']);                     
                            $desbloqueado = $model->desbloquearUsuario($formulario['email']);
                            $senhaResetada = $model->resetarSenha($formulario['email']);
                            $tokenResetado = $model->zerarToken($formulario['email']);

                            if($desbloqueado && $senhaResetada && $tokenResetado){
                                $dados['usuario_reativado'] = 'Usuário reativado com sucesso! <br> Sua senha foi resetada. ' . '<br>' .  "<a class='text-danger' href=\"" . URL_PROJETO . "/usuarios/recuperacao\">Clique aqui</a> para gerar uma nova senha";
                            } else {
                                $dados['erro_desbloqueio'] = 'Houveu um erro ao desbloquear seu usuário. Por favor, entre em contato com o atendimento da Bin.';
                            }



                        } else {
                            
                            
                        // Defina a mensagem de código inválido
                            $dados['codigo_invalido'] = 'Código informado inválido.';

                            // Verifica a quantidade de tentativas erradas
                            $tentativas = $model->verificarContador($formulario['email']);

                            // Incrementar tentativas apenas após verificar o número de tentativas
                            $tentativaAtual = $tentativas + 1;
                        

                            // Se o número de tentativas erradas for igual a 2 (ou seja, na próxima tentativa ele atingirá 3)
                            if ($tentativas >= 2) {
                                // Bloquear o usuário porque ele já digitou o código errado 3 vezes
                                $model->incrementarContador($formulario['email']);
                                $bloqDefinitivo = $model->bloquearDefinitivamente($formulario['email']);
                                $dados['usuario_bloqueado_definitivivamente'] = 'Usuário bloqueado ' . strtoupper('definitivamente') . ' pois houve mais de ' . $tentativas . ' tentativas de inserção de código errado. <br> Entre em contato com o suporte da Bin em atendimento@binwebconnect.com.br';
                            } else {
                                // Incrementar tentativas erradas
                                $model->incrementarContador($formulario['email']);
                                $dados['erro_codigo_errado'] = 'Você digitou o código errado ' . $tentativaAtual . 'x';
                            }
                                                                                                                                                                                    
                        }
                      
                    }  else {
                        
                        
                        $dados['usuario_nao_bloqueado'] = 'Seu usuário está <br> ---- "bloqueado definitivamente" ----. <br> Por favor entre em contato com o suporte para resolver a situação cadastral.';
                    }                                                                                              
                                                                        
                } else {
                                     
                    //Não é necessário instanciar o model novamente, mas apenas chamar a função inserirUsuarioNoBanco
                    $dados['erro_usuario_nao_cadastrado'] = 'Não é possível reativar uma conta não cadastrada no sistema. ' . '<br>' .  "<a class='text-warning' href=\"" . URL_PROJETO . "/usuarios/cadastrar\">Clique aqui</a> para cadastrar-se";
                                                                         
                }
            }

                                                                                                                      

        } else {        
       
            // Inicializa os dados com strings vazias se o formulário não for preenchido corretamente
            $dados = [           
                'email' => '',
                'codigo' => '',
                        
            ];

            
                               
           
        }
        
        

        // Chamar uma View já fazendo junção de back com front
        $this->carregarView('usuarios/reativacao', $dados);
    }
                       
    public function auth2fa() {

        $formulario = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        
        if(isset($formulario)){    
           
            $validacao_sucesso = true;

            // Aplica a função a todos os itens do $_POST e gera um array chamado $formulario com todos os elementos    
            $formulario = array_map('cleanUp', $_POST);

            $dados = [                              
            'codigo' => $formulario['codigo'] ?? '',             
            ];   
                        
            /* Validações do Codigo */
            //Se vazio
            if (empty($formulario['codigo'])): 
                $dados['erro_token_vazio'] = 'Campo código obrigatório'; 
                $validacao_sucesso = false;                      
            endif;
           
            if ($validacao_sucesso) {             
                            
                //Instanciar o Model
                $model = $this->carregarModel('UsuariosModel'); // Carregando o model
                            
                    //Verificar se o codigo informado confere com o codigo inserido no banco:
                    $tokenBanco = $model->verificarToken($_SESSION['email_inserido'], $formulario['codigo']);
                                    
                    if($tokenBanco == $formulario['codigo']){
                                           
                                                                                            
                        $usuarioDesbloqueado = $model->desbloquearUsuario($_SESSION['email_inserido']);                        
                        $tokenResetado = $model->resetarToken($_SESSION['email_inserido']);
                        $contadorResetado = $model->zerarContador($_SESSION['email_inserido']);

                        if($usuarioDesbloqueado && $tokenResetado && $contadorResetado){

                            

                            $session_token = bin2hex(random_bytes(32));  
                                                                                                
                                
                            Session::criarSessao($_SESSION['email_inserido'], $session_token);

                            unset($_SESSION['email_inserido']);

                            URL::redirecionar('plataforma/painel');
                            
                            exit;


                            
                        } else {
                            die('erro de autenticação de 2 fatores');
                        }

                    } else {   
                                                                
                        // Defina a mensagem de código inválido
                        $dados['erro_token_invalido'] = 'Token informado inválido.';    
                                                                        
                        // Verifica a quantidade de tentativas erradas
                        $tentativas = $model->verificarcontador($_SESSION['email_inserido']);

                        // Incrementar tentativas apenas após verificar o número de tentativas
                        $tentativaAtual = $tentativas + 1;

                        // Se o número de tentativas erradas for igual a 2 (ou seja, na próxima tentativa ele atingirá 3)
                        if ($tentativas >= 2) {
                            // Bloquear o usuário porque ele já digitou o código errado 3 vezes
                            $model->incrementarContador($_SESSION['email_inserido']);
                            $model->bloquearUsuario($_SESSION['email_inserido']);
                            $dados['quantidade_errada'] = 'Você digitou o token errado ' . $tentativaAtual . 'x';
                            $dados['usuario_bloqueado'] = 'Seu usuário foi bloqueado após 3 tentativas.' . "<a class='text-warning' href=\"" . URL_PROJETO . "/usuarios/desbloqueio\">Clique aqui</a> para desbloquear sua conta";;
                        } else {
                            // Incrementar tentativas erradas
                            $model->incrementarContador($_SESSION['email_inserido']);
                            $dados['quantidade_errada'] = 'Você digitou o token errado ' . $tentativaAtual . 'x';
                        } 

                                                                                                                                                                                                                                                                        
                    }                                                                                                                                 
                } 
            
                                                                                                                      
        } else {        
       
            // Inicializa os dados com strings vazias se o formulário não for preenchido corretamente
            $dados = [                     
                'codigo' => '',
                        
            ];
                                                      
        }

        $this->carregarView('usuarios/auth2fa', $dados);
    }

    //Metodo usado caso seja acessado o controaldor usuário, mas não existe o
    public function erro() {
        $this->carregarView('erros/erro404');
    }
}