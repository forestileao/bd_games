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
        if (!is_admin()) {
            echo msg_error("Área Restrita!");            
        } else {
            if (!isset($_POST['usuario'])) {
                require 'user-new-form.php';
            } else {
                $usuario = $_POST['usuario'] ?? null;
                $nome = $_POST['nome'] ?? null;
                $senha1 = $_POST['senha1'] ?? null;
                $senha2 = $_POST['senha2'] ?? null;
                $tipo = $_POST['tipo'] ?? null;

                if ($senha1 === $senha2) {
                    if (empty($usuario) || empty($nome) || empty($senha1) || empty($senha2) || empty($tipo)) {
                        echo msg_error("Todos os dados são obrigatórios!");
                    } else {
                        $senha = gera_hash($senha1);
                        $q = "INSERT INTO usuarios (usuario, nome, senha, tipo) VALUES ('$usuario', '$nome', '$senha', '$tipo')";
                        if($banco->query($q)) {
                            echo msg_sucesso("Usuário $usuario cadastrado com sucesso!");
                        } else {
                            echo msg_error("Não foi possível cadastrar o usuário $usuario, talvez o login já esteja sendo usado.");
                        }
                    }
                } else {
                    echo msg_error("As senhas não conferem!");
                }

            }
        }
        echo voltar();
        ?>
    </div>
</body>
</html>