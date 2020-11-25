<form action="game-edit.php?cod=<?php echo $c;?>" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <table>
        <tr>
            <td>Nome</td> <td><input value="<?php echo $reg2->nome?>" type="text" name="nome" id="nome" size="30" maxlength="30"></td><td style="text-align: center; width: 100%;" rowspan="6"><img <?php echo "src='" . thumb($reg2->capa) . "'" . " class='full'" ?> alt=""></td>
        </tr>
        <tr>
            <td>Gênero</td> <td><select name="genero" id="genero">
                <?php
                    $q = "SELECT genero from generos";
                    $busca = $banco->query($q);
                    
                    while($reg = $busca->fetch_object()) {
                        echo "<option value='$reg->genero' ";
                        if ($reg->genero == $reg2->genero) {
                            echo "selected";
                        }
                        echo ">$reg->genero </option>";
                    }
                ?>
            </select></td>
        </tr>
        <tr>
            <td>Produtora</td> <td><select name="produtora" id="produtora">
                <?php
                    $q = "SELECT produtora from produtoras";
                    $busca = $banco->query($q);
                    
                    while($reg = $busca->fetch_object()) {
                        echo "<option value='$reg->produtora' ";
                        if ($reg->produtora == $reg2->produtora) {
                            echo "selected";
                        }
                        echo ">$reg->produtora</option>";
                    }
                ?>
            </select></td>
        </tr>
        <tr>
            <td>Nota</td> <td><input value="<?php echo $reg2->nota?>" name="nota" id='nota' type="number" step="0.01" min="0" max="10" size="4"></td>
        </tr>
        <tr>
            <td>Descrição</td> <td><textarea style="resize: none;" id="descricao" name="descricao" rows="4" cols="50"><?php echo $reg2->descricao?></textarea></td>
        </tr>
        <tr>
            <td>Foto de capa</td> <td><input accept="image/*" type="file" name="capa" id='capa'></td>
        </tr>
        <tr>
            <td><br><input type="submit" value="Enviar"></td>
        </tr>
    </table>
    
</form>