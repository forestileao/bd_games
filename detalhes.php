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
    <title>Detalhes</title>
</head>
<body>
    
    <div id="app">
        <?php
            include_once "topo.php";
            $c = $_GET['cod'] ?? 0;
            $q = "select * from jogos where cod = ?";
            $stmt = $banco->prepare($q);
            $stmt->bind_param("i", $c);
            $stmt->execute();

            $busca = $stmt->get_result();
        ?>
        <h1>Details of the game</h1>
        <table class='detalhes'>
            <?php
                if (!$busca) {
                    echo msg_error("Ocurred an error!");
                } else if ($busca->num_rows == 1){
                    $reg = $busca->fetch_object();
                    $t = thumb($reg->capa);

                    echo "<tr><td rowspan='3'><img src='$t' class='full' />";
                    echo "<td><h2>$reg->nome</h2>";
                    echo "Nota: " . number_format($reg->nota, 1) . "/10.0";
                    if (is_admin()) {
                        require "game-crud-script.php";
                        echo "
                        <button onclick='editGame("; echo $reg->cod . ")'><i class='material-icons'>edit</i></button>
                        <button onclick='deleteGame("; echo $reg->cod . ")'><i class='material-icons'>delete</i></button>";
                    } else if (is_editor()) {
                        echo " <i class='material-icons'>edit</i>";
                    }
                    echo "<tr><td><p>$reg->descricao</p>";
                } else {
                    echo "No register Found";
                }
                
            ?>
        </table>
        <?php echo voltar(); ?>
    </div>
    <?php include_once "rodape.php";?>
</body>
</html>