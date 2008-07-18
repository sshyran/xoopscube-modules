<?php
require_once 'Sabai/Token.php';

class Sabai_Template_PHP_Helper_Token extends Sabai_Template_PHP_Helper
{
    function create($tokenID, $tokenSalt = SABAI_TOKEN_SALT)
    {
        $token =& Sabai_Token::create($tokenID);
        $token->salt($tokenSalt);
        return $token->getValue();
    }

    function createQuery($tokenID, $tokenParam = SABAI_TOKEN_NAME, $tokenSalt = SABAI_TOKEN_SALT)
    {
        return $tokenParam . '=' . $this->create($tokenID, $tokenSalt);
    }

    function write($tokenID, $tokenSalt = SABAI_TOKEN_SALT)
    {
        echo $this->create($tokenID, $tokenSalt);
    }
}