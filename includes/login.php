<?php
    session_start();
    
    if (!isset($_SESSION['user'])) {
        $_SESSION['user'] = "";
        $_SESSION['nome'] = "";
        $_SESSION['tipo'] = "";
    }
    

    function cripto($senha) {
        $c = '';
        for($pos = 0; $pos < strlen($senha); $pos++) {
            $letra = ord($senha[$pos]) + 1;
            $c .= chr($letra);
        }
        return $c;
    }

    function gera_hash($senha) {
        $txt = cripto($senha);
        $hash = password_hash($txt, PASSWORD_DEFAULT);
        return $hash;

    }

    function testar_hash($senha, $hash) {
        $txt = cripto($senha);
        $ok = password_verify($txt, $hash);
        return $ok;
    }
    
    function logout() {
        unset($_SESSION['user']);
        unset($_SESSION['nome']);
        unset($_SESSION['tipo']);
    }

    function is_logado() {
        if (empty($_SESSION['user'])) {
            return false;
        } else {
            return true;
        }
    }

    function is_admin() {
        $t = $_SESSION['tipo'] ?? null;
        if(is_null($t) || $t != 'admin') {
            return false;
        } else {
            return true;
        }
    }

    function is_editor() {
        $t = $_SESSION['tipo'] ?? null;
        if(is_null($t) || $t != 'editor') {
            return false;
        } else {
            return true;
        }
    }
