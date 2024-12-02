<?php 
class Check {

    public static function checkNome($nome){
        if(!preg_match("/^[a-zA-ZÀ-ÖØ-öø-ÿ' çÇ]*$/", $nome)):
            return true;
        else:
             return false;
        endif;
    }

    public static function checkEmail($email){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)):
            return true;
        else:
            return false;
        endif;
    }

}