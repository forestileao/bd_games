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
    <link rel="stylesheet" href="./css/styles.css?v=<?php echo time();?>">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <title>Title of the page</title>
</head>
<body>
    <?php
        if (is_admin()) {
            require "game-crud-script.php";
        }
        
        $ordem = $_GET['o'] ?? "nome";
        $chave = $_GET['c'] ?? "";
    ?>
    <div id="app">
        <?php include_once "topo.php";?>
        <h1>Escolha seu jogo</h1>
        
        <form id="busca" method="get" action="index.php">
            Ordenar: 
            <a href="index.php?o=n&c=<?php echo "$chave"; ?>">Nome</a> | 
            <a href="index.php?o=p&c=<?php echo "$chave"; ?>">Produtora</a> | 
            <a href="index.php?o=n1&c=<?php echo "$chave"; ?>">Nota Alta</a> | 
            <a href="index.php?o=n2&c=<?php echo "$chave"; ?>">Nota Baixa</a> | 
            <a href="index.php?">Mostrar todos</a> |
            Buscar: <input type="text" name="c" size="10" maxlength="40" />
            <input type="submit" value="ok">
        </form>
        <table class="list">
            <?php
                $q = "SELECT j.cod, j.nome, g.genero, p.produtora, j.capa from jogos j join generos g on j.genero = g.cod
                join produtoras p on j.produtora = p.cod ";

                if (!empty($chave)) {
                    $q .= "WHERE j.nome like CONCAT('%',?,'%') OR p.produtora like CONCAT('%',?,'%') OR g.genero like CONCAT('%',?,'%') ";
                }

                switch ($ordem) {
                    case "p":
                        $q .= "ORDER BY p.produtora";
                        break;

                    case "n1":
                        $q .= "ORDER BY j.nota DESC";
                        break;

                    case "n2":
                        $q .= "ORDER BY j.nota";
                        break;
                    
                    default:
                        $q .= "ORDER BY j.nome";
                        break;
                    
                }

                // This part of the code will avoid SQL injection
                $stmt = $banco->prepare($q);
                if (!empty($chave))
                    $stmt->bind_param("sss", $chave, $chave, $chave);
                $stmt->execute();
                $busca = $stmt->get_result();
                
                if (!$busca) {
                    echo "<tr><td>Unfortunately, the occured an error during the search</td></tr>";
                } else if ($busca->num_rows == 0){
                    echo "<tr><td>No register found</td></tr>";
                } else {
                    while($reg = $busca->fetch_object()) {
                        $t = thumb($reg->capa);
                        echo "<tr><td><img class='mini' src='$t' />";
                        echo "<td><a href='./detalhes.php?cod=$reg->cod'>$reg->nome</a>";
                        echo " [$reg->genero]";
                        echo "<br/>$reg->produtora";
                        if (is_admin()) {
                            
                            echo "<td>
                            <button onclick='editGame("; echo $reg->cod . ")'><i class='material-icons'>edit</i></button>
                            <button onclick='deleteGame("; echo $reg->cod . ")'><i class='material-icons'>delete</i></button>";
                        } else if (is_editor()) {
                            echo "<td><i class='material-icons'>edit</i>";
                        }
                    } 
                }
                    
                
            ?>
        </table>
    </div>
    <?php $banco->close();?>
    <?php include_once "rodape.php";?>
</body>
</html>
