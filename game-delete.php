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
    <title>Game deleted</title>
    <link rel="stylesheet" href="./css/styles.css?v=<?php echo time();?>">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <style>
        div#app {
            width: 500px;
        }
    </style>
</head>
<body>
    <div id='app'>
        <?php
            if (is_logado() && is_admin()) {
                $cod = $_GET['cod'] ?? null;

                if (isset($cod)) {
                    $q = "DELETE from jogos where cod = ?";
                    $stmt = $banco->prepare($q);
                    $stmt->bind_param("i", $cod);
                    $stmt->execute();
                    $busca = $stmt->get_result();
                    
                    if (strlen($banco->error) == 0) {
                        echo msg_sucesso("Jogo excluido com sucesso!");
                    } else {
                        echo msg_error("Ocorreu um erro ao tentar excluir o jogo!");
                    }
                } else {
                    echo msg_error("Jogo não encontrado!");
                }
            } else {
                echo msg_aviso("Área restrita!");
            }
            echo voltar();
        ?>
    </div>
</body>
</html>