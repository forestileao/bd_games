<!DOCTYPE html>
<?php
    require_once "./includes/banco.php";
    require_once "./includes/login.php";
    require_once "./includes/functions.php";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/styles.css?v=<?php echo time();?>">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
</head>
<body>
    <div id='app'>
    <?php
        if (!is_logado()) {
            echo msg_error("Efetue o  <a href='user-login.php'>login</a> para editar seus dados");
        } else {
            if (!isset($_POST['usuario'])) {
                include "user-edit-form.php";
            } else {
                $usuario = $_POST['usuario'] ?? null;
                $nome = $_POST['nome'] ?? null;
                $tipo = $_POST['tipo'] ?? null;
                $senha1 = $_POST['senha1'] ?? null;
                $senha2 = $_POST['senha2'] ?? null;

                $q = "UPDATE usuarios set usuario = '$usuario', nome='$nome'";

                if (empty($senha1) || is_null($senha1)) {
                    echo msg_aviso("Senha antiga mantida");
                } else if ($senha1 === $senha2) {
                    $senha = gera_hash($senha1);
                    $q .= ", senha='$senha'";
                } else {
                    msg_aviso("Senhas nao conferem. A senha anterior será mantida.");
                }
                $q .= " WHERE usuario = '" . $_SESSION['user'] . "'";
                
                if ($banco->query($q)) {
                    echo msg_sucesso("Usuário alterado com sucesso!");
                    logout();
                    echo msg_aviso("Por segurança, efetua o <a href='user-login.php'>login</a> novamente.");
                } else {
                    echo msg_error("Não foi possível alterar os dados!");
                }
            }
        }

    echo voltar();
    ?>

    </div>
</body>
</html>