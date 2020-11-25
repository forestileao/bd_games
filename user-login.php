<!DOCTYPE html>
<?php
    require_once "includes/banco.php";
    require_once "includes/login.php";
    require_once "includes/functions.php";
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/styles.css?v=<?php echo time();?>">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <style>
        div#app {
            font-size: 15pt;
            width: 270px;
        }
        td {
            padding: 10px;
        }
    </style>
</head>
<body>
    <div id='app'>
    <?php
        $u = $_POST['usuario'] ?? null;
        $s = $_POST['senha'] ?? null;

        if (is_null($u) || is_null($s)) {
            require "user-login-form.php";
        } else {
            $q = "SELECT nome, usuario, senha, tipo FROM usuarios WHERE usuario = ? LIMIT 1";
            $stmt = $banco->prepare($q);
            $stmt->bind_param("s", $u);
            $stmt->execute();
            $busca = $stmt->get_result();

            if (!$busca) {
                echo msg_error("Falha ao acessar o banco!");
            } else if ($busca->num_rows > 0){
                $reg = $busca->fetch_object();
                if (testar_hash($s, $reg->senha)) {
                    echo msg_sucesso("Logado com sucesso!");
                    $_SESSION['user'] = $reg->usuario;
                    $_SESSION['nome'] = $reg->nome;
                    $_SESSION['tipo'] = $reg->tipo;
                } else {
                    echo msg_error("Senha inválida!");
                }
                
            } else {
                echo msg_error("Usuário não existe!");
            }
        }
        echo voltar();
    ?>
    </div>
</body>
</html>