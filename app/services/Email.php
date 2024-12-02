<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';

class Email {

    public static function enviarEmaildeCadastro($destinatario, $nome, $token) {

        $mail = new PHPMailer(true); // Instancia o PHPMailer       

        try {
            // Configurações do servidor
            
            $mail->IsSMTP(); // enable SMTP 
            $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only 
            $mail->SMTPAuth = true; // authentication enabled 
            $mail->SMTPSecure = 'tsl'; // secure transfer enabled REQUIRED for Gmail 
            $mail->Host = 'smtp.titan.email'; // Defina o servidor SMTP
            $mail->Port = 587; // Porta TCP           
            $mail->isHTML(true);        
            $mail->Username = EMAIL_SERVIDOR; // Seu e-mail
            $mail->Password = SENHA_EMAIL_SERVIDOR; // Sua senha
            $mail->CharSet = 'UTF-8';
                                
            // Remetente e destinatário
            $mail->setFrom('atendimento@binwebconnect.com.br', 'Bin Sistemas');
            $mail->addAddress($destinatario, $nome); // Adiciona o destinatário

            // Conteúdo do e-mail
           
            $mail->Subject = 'Confirmação de Cadastro';

            $mail->Body = '
                        <html>
                        <head>
                            <style>
                                body { 
                                    font-family: Arial, sans-serif; 
                                }
                                h1 { 
                                    color: #333; 
                                }
                                p { 
                                    color: #555; 
                                }
                                .codigo { 
                                    font-weight: bold; color: #007BFF; 
                                }
                                .footer { 
                                    color: #999; 
                                 }
                            </style>
                        </head>
                        <body>
                            <h1>Uhu! 🥳 </h1>
                            <h1> Seja bem-vindo(a), ' . $nome . '!</h1>                                                        
                            <p> Seu cadastro foi realizado com sucesso!</p>
                            <p>Agora, tudo o que você precisa fazer é logar na plataforma pela primeira vez e inserir o código abaixo para confirmar sua conta. :-)</p>
                            <p>Seu código de confirmação é: <span class="codigo">' . $token . '</span></p>
                            <p><a href="' . URL_PROJETO . '/usuarios/confirmacao">Clique aqui</a> para confirmar seu cadastro.</p>
                            <p>Qualquer dúvida, entre em contato conosco pelo email <strong>atendimento@binwebconnect.com.br</strong></p>
                            <p>É um prazer enorme ter você conosco! </p>
                            <p>Abraços da Equipe Bin Web Connect! 🐘 </p>
                        </body>
                        </html>';

            // Envia o e-mail
            $mail->send();
            return true; // Retorna verdadeiro se o e-mail for enviado com sucesso
        } catch (Exception $e) {
            // Registro de erro em um arquivo
            file_put_contents('email_error_log.txt', "Erro ao enviar e-mail: {$mail->ErrorInfo}\n", FILE_APPEND);
            return false; // Retorna falso se ocorrer um erro
        }
    }   

    public static function enviarEmaildeDesbloqueio($destinatario, $token) {

        $mail = new PHPMailer(true); // Instancia o PHPMailer       

        try {
            // Configurações do servidor
            
            $mail->IsSMTP(); // enable SMTP 
            $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only 
            $mail->SMTPAuth = true; // authentication enabled 
            $mail->SMTPSecure = 'tsl'; // secure transfer enabled REQUIRED for Gmail 
            $mail->Host = 'smtp.titan.email'; // Defina o servidor SMTP
            $mail->Port = 587; // Porta TCP           
            $mail->isHTML(true);        
            $mail->Username = 'atendimento@binwebconnect.com.br'; // Seu e-mail
            $mail->Password = 'M[bCL!@RA&*n2VF3'; // Sua senha
            $mail->CharSet = 'UTF-8';
                                
            // Remetente e destinatário
            $mail->setFrom('atendimento@binwebconnect.com.br', 'Bin Sistemas');
            $mail->addAddress($destinatario); // Adiciona o destinatário
            $urlRecuperacao = 'http://localhost/3_projetos_deploy/2_bin_web_connect/3_bwc_sis_obj/usuarios/recuperacao/' . urlencode($token);

            // Conteúdo do e-mail
           
            $mail->Subject = 'Desbloqueio de Conta';

            $mail->Body = '
                        <html>
                        <head>
                            <style>
                                body { 
                                    font-family: Arial, sans-serif; 
                                }
                                h1 { 
                                    color: #333; 
                                }
                                p { 
                                    color: #555; 
                                }
                                .codigo { 
                                    font-weight: bold; color: #007BFF; 
                                }
                                .footer { 
                                    color: #999; 
                                 }
                            </style>
                        </head>
                        <body>
                            <h2>😲 Nem tudo está perdido! 😲 Vamos recuperar sua conta? 🔑 </h2>                            
                            <p> Você está recebendo esse e-mail porque digitou usa senha errada 3x.</p>   
                            <p> Seu código de recuperação é <span class="codigo">' . $token . '</span></p>                                                                                                             
                            <p><a href="' . URL_PROJETO . '/usuarios/reativacao">Clique aqui</a> para desbloquear seu usuário.</p>
                            <p>Qualquer dúvida, entre em contato conosco pelo email <strong>atendimento@binwebconnect.com.br</strong></p>
                            <p>É um prazer enorme ter você conosco! </p>
                            <p>Abraços da Equipe Bin Web Connect! 🐘 </p>
                        </body>
                        </html>';

            // Envia o e-mail
            $mail->send();
            return true; // Retorna verdadeiro se o e-mail for enviado com sucesso
        } catch (Exception $e) {
            // Registro de erro em um arquivo
            file_put_contents('email_error_log.txt', "Erro ao enviar e-mail: {$mail->ErrorInfo}\n", FILE_APPEND);
            return false; // Retorna falso se ocorrer um erro
        }
    }

    public static function enviarEmaildeRecuperacaoDeSenha($destinatario, $token) {

        $mail = new PHPMailer(true); // Instancia o PHPMailer       

        try {
            // Configurações do servidor
            
            $mail->IsSMTP(); // enable SMTP 
            $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only 
            $mail->SMTPAuth = true; // authentication enabled 
            $mail->SMTPSecure = 'tsl'; // secure transfer enabled REQUIRED for Gmail 
            $mail->Host = 'smtp.titan.email'; // Defina o servidor SMTP
            $mail->Port = 587; // Porta TCP           
            $mail->isHTML(true);        
            $mail->Username = 'atendimento@binwebconnect.com.br'; // Seu e-mail
            $mail->Password = 'M[bCL!@RA&*n2VF3'; // Sua senha
            $mail->CharSet = 'UTF-8';
                                
            // Remetente e destinatário
            $mail->setFrom('atendimento@binwebconnect.com.br', 'Bin Sistemas');
            $mail->addAddress($destinatario); // Adiciona o destinatário
            $urlRecuperacao = 'http://localhost/3_projetos_deploy/2_bin_web_connect/3_bwc_sis_obj/usuarios/recuperacao/' . urlencode($token);

            // Conteúdo do e-mail
           
            $mail->Subject = 'Recuperação de Senha';

            $mail->Body = '
                        <html>
                        <head>
                            <style>
                                body { 
                                    font-family: Arial, sans-serif; 
                                }
                                h1 { 
                                    color: #333; 
                                }
                                p { 
                                    color: #555; 
                                }
                                .codigo { 
                                    font-weight: bold; color: #007BFF; 
                                }
                                .footer { 
                                    color: #999; 
                                 }
                            </style>
                        </head>
                        <body>
                            <h2>😲 Calma, calma! 😲 A gente te ajuda a recuperar a sua conta! 🔑 </h2>                            
                            <p> Você está recebendo esse e-mail porque solicitou a recuperaçao da sua senha.</p>   
                            <p> Seu código de recuperação é <span class="codigo">' . $token . '</span></p>                                                                                                             
                            <p><a href="' . URL_PROJETO . '/usuarios/novasenha/">Clique aqui</a> para criar uma nova senha.</p>
                            <p>Qualquer dúvida, entre em contato conosco pelo email <strong>atendimento@binwebconnect.com.br</strong></p>
                            <p>É um prazer enorme ter você conosco! </p>
                            <p>Abraços da Equipe Bin Web Connect! 🐘 </p>
                        </body>
                        </html>';

            // Envia o e-mail
            $mail->send();
            return true; // Retorna verdadeiro se o e-mail for enviado com sucesso
        } catch (Exception $e) {
            // Registro de erro em um arquivo
            file_put_contents('email_error_log.txt', "Erro ao enviar e-mail: {$mail->ErrorInfo}\n", FILE_APPEND);
            return false; // Retorna falso se ocorrer um erro
        }
    }

    public static function enviarEmaildeAuthDoisFatores($destinatario, $token) {

        $mail = new PHPMailer(true); // Instancia o PHPMailer       

        try {
            // Configurações do servidor
            
            $mail->IsSMTP(); // enable SMTP 
            $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only 
            $mail->SMTPAuth = true; // authentication enabled 
            $mail->SMTPSecure = 'tsl'; // secure transfer enabled REQUIRED for Gmail 
            $mail->Host = 'smtp.titan.email'; // Defina o servidor SMTP
            $mail->Port = 587; // Porta TCP           
            $mail->isHTML(true);        
            $mail->Username = 'atendimento@binwebconnect.com.br'; // Seu e-mail
            $mail->Password = 'M[bCL!@RA&*n2VF3'; // Sua senha
            $mail->CharSet = 'UTF-8';
                                
            // Remetente e destinatário
            $mail->setFrom('atendimento@binwebconnect.com.br', 'Bin Sistemas');
            $mail->addAddress($destinatario); // Adiciona o destinatário
            $urlRecuperacao = 'http://localhost/3_projetos_deploy/2_bin_web_connect/3_bwc_sis_obj/usuarios/recuperacao/' . urlencode($token);

            // Conteúdo do e-mail
           
            $mail->Subject = 'Token de Acesso';

            $mail->Body = '
                        <html>
                        <head>
                            <style>
                                body { 
                                    font-family: Arial, sans-serif; 
                                }
                                h1 { 
                                    color: #333; 
                                }
                                p { 
                                    color: #555; 
                                }
                                .codigo { 
                                    font-weight: bold; color: #007BFF; 
                                }
                                .footer { 
                                    color: #999; 
                                 }
                            </style>
                        </head>
                        <body>
                            <h2>🔑Seu toke de acesso chegou!🔑 </h2>                            
                            <p> Você está recebendo esse e-mail porque tentou entrar em sua conta, porém sua autenticação de 2 fatores está ativada.</p>   
                            <p> Seu token de acesso é: <span class="codigo">' . $token . '</span></p>                                                                                                             
                            <p><a href="' . URL_PROJETO . '/usuarios/acessotoken/">Clique aqui</a> inserir o token e acessar sua conta.</p>
                            <p>Qualquer dúvida, entre em contato conosco pelo email <strong>atendimento@binwebconnect.com.br</strong></p>
                            <p>É um prazer enorme ter você conosco! </p>
                            <p>Abraços da Equipe Bin Web Connect! 🐘 </p>
                        </body>
                        </html>';

            // Envia o e-mail
            $mail->send();
            return true; // Retorna verdadeiro se o e-mail for enviado com sucesso
        } catch (Exception $e) {
            // Registro de erro em um arquivo
            file_put_contents('email_error_log.txt', "Erro ao enviar e-mail: {$mail->ErrorInfo}\n", FILE_APPEND);
            return false; // Retorna falso se ocorrer um erro
        }
    }
}