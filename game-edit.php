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
    <link rel="stylesheet" href="css/styles.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <title>Edit Game</title>
</head>
<body>
    
    <div id="app">
        <?php
            include_once "topo.php";
        ?>
        <h1>Edição de Jogo</h1>
        <table class='detalhes'>
            <?php
                if (is_admin() || is_editor()) {
                    if (!isset($_POST['nome'])) {
                        $c = $_GET['cod'] ?? 0;
                        $q = "SELECT j.cod, j.nome, j.nota, j.descricao, j.capa, p.produtora, g.genero 
                        from jogos j join produtoras p on p.cod = j.produtora join generos g 
                        on g.cod = j.genero where j.cod = ?";

                        $stmt = $banco->prepare($q);
                        $stmt->bind_param("i", $c);
                        $stmt->execute();

                        $busca2 = $stmt->get_result();
                        $reg2 = $busca2->fetch_object();
                        include_once "game-edit-form.php";

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
                            echo msg_error("Os dados não podem ficar vazios, apenas a imagem!");
                        }
                        if (@getimagesize($_FILES["capa"]["tmp_name"]) === false) {
                            echo msg_aviso("A imagem antiga será mantida");
                            $capa_off = true;
                                
                        } else if ($imageFileType != 'png' && $imageFileType != 'jpeg' && $imageFileType != 'jpg') {
                            echo msg_aviso("Só são aceitas imagens PNG, JPG ou JPEG");
                            $capa_off = true;

                        } else if (move_uploaded_file($_FILES["capa"]["tmp_name"], $target_file)) {
                            echo msg_sucesso("Imagem atualizada com sucesso!");
                            $capa_off = false;
                        }
                        
                        $c = $_GET['cod'];
                        if ($capa_off) {
                            $stmt = $banco->prepare("SELECT capa from jogos where cod = ?");
                            $stmt->bind_param("i", $c);
                            $stmt->execute();
                            $b = $stmt->get_result();
                            $reg2 = $b->fetch_object(); 
                            $nome_capa = $reg2->capa;
                        }
                        
                        $q = "UPDATE jogos set
                        nome = ? , genero = (SELECT cod from generos where genero = ?),  produtora = (SELECT cod from produtoras where produtora = ?), 
                        nota = ?, descricao = ?, capa = ? WHERE cod = ?";
                        $stmt= $banco->prepare($q);
                        $stmt->bind_param("sssdssi", $nome, $genero, $produtora , $nota, $descricao, $nome_capa, $c);
                        $ok = $stmt->execute();
                        $busca = $stmt->get_result();

                        if (!$ok) {
                            echo $banco->error;
                            echo msg_error("Erro na busca!");
                        } else {
                            echo msg_sucesso("Jogo Atualizado com sucesso!");
                        }
                    }
                } else {
                    msg_aviso("Área restrita!");
                }              
            ?>
        </table>
        <?php echo voltar(); ?>
    </div>
    <?php include_once "rodape.php";?>
</body>
</html>