<?php 
date_default_timezone_set('America/Sao_Paulo');

if ($_SERVER['HTTP_HOST'] === 'localhost') {
    define('URL_PROJETO', 'http://localhost/projetos-deploy\2_bin_web_connect\3_bwc_sis_obj');
} else {
    define('URL_PROJETO', 'https://binwebconnect.com.br/paperuniasselvi'); 
}



define('CONFIG_PATH', dirname(__FILE__));
define('URL_DEVSENVOLVIMENTO', 'http://localhost/projetos-deploy\2_bin_web_connect\3_bwc_sis_obj');
define('APP_NOME', 'Curso de PHP 7 Orientado a objetos');
define('EMAIL_SERVIDOR', 'atendimento@binwebconnect.com.br');
define('SENHA_EMAIL_SERVIDOR', 'M[bCL!@RA&*n2VF3');
const APP_VERSAO = '1.0.0';

