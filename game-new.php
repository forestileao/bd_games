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
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>New Game</title>
    <link rel="stylesheet" href="./css/styles.css?v=<?php echo time();?>">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
</head>
<body>
    <div id='app'>
        <?php
            if (is_admin() && is_logado()) {
                if (!isset($_POST['nome'])) { 
                    require "game-new-form.php";
                } else {
                    $nome = $_POST['nome'] ?? null;
                    $genero = $_POST['genero'] ?? null;
                    $produtora = $_POST['produtora'] ?? null;
                    $nota = $_POST['nota'] ?? null;
                    $descricao = $_POST['descricao'] ?? null;

                    $target_file = "images/" . basename($_FILES['capa']["name"]);
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    $nome_capa = basename($_FILES['capa']["name"]);
                    
                    if (empty($nome) || empty($genero) || empty($produtora) || empty($nota) || empty($descricao)) {
                        echo msg_error("Todos os dados são obrigatórios!");

                    } else if (@getimagesize($_FILES["capa"]["tmp_name"]) === false) {
                        echo msg_error("Não foi possível carregar a imagem!");
                        
                            
                    } else if ($imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'jpg') {
                        echo msg_error("Só são aceitas imagens PNG, JPG ou JPEG");

                    } else if (move_uploaded_file($_FILES["capa"]["tmp_name"], $target_file)) {
                        $q = "INSERT into jogos (nome, genero, produtora, nota, descricao, capa) values
                        (? , (SELECT cod from generos where genero = ?), (SELECT cod from produtoras where produtora = ?), 
                        ?, ?, ?)";
                        $stmt= $banco->prepare($q);
                        $stmt->bind_param("sssdss", $nome, $genero, $produtora , $nota, $descricao, $nome_capa);
                        $stmt->execute();

                        $busca = $stmt->get_result();

                        if (strlen($banco->error != 0)) {
                            echo $banco->error;
                            echo msg_error("Erro na busca!");
                        } else {
                            echo msg_sucesso("Jogo cadastrado com sucesso!");
                        }
                    }
                }

            } else {
                echo msg_aviso("Área Restrita!");
            }
            echo voltar();
        ?>
    </div>
</body>
</html>