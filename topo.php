<?php
    echo "<header>";
    if (empty($_SESSION['user'])) {
        echo "<a href='user-login.php'>Entrar</a>";
    } else {
        echo "Olá, <strong>" . $_SESSION['nome'] . "</strong>! (" . $_SESSION['tipo'] . ")";
        echo " | <a href='user-edit.php'>Meus dados</a>";
        if (is_admin()) {
            echo " | <a href='user-new.php'>Novo usuário</a>";
            echo " | <a href='game-new.php'>Novo jogo</a>";
        }
        echo " | <a href='user-logout.php'>Sair</a>";
         
    }

    echo "</header>";