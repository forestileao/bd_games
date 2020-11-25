<?php
    $q = "SELECT usuario, nome, senha, tipo FROM usuarios WHERE usuario='" . $_SESSION['user'] . "'";
    $busca = $banco->query($q);
    $reg = $busca->fetch_object();
?>

<h1>Alteração de dados</h1>
<form action="user-edit.php" method="post">
    <table>
        <tr>
            <td>Usuário </td>
            <td><input type="text" maxlength="10" size="10" name="usuario" id='usuario' value='<?php echo $reg->usuario;?>' readonly></td>
        </tr>

        <tr>
            <td>Nome </td> 
            <td><input type="text" maxlength="30" size="30" name="nome" id='nome' value='<?php echo $reg->nome;?>'></td>
        </tr>
        
        <tr>
            <td>Tipo </td> 
            <td><input type="text" size="6" name="tipo" id='tipo' value="<?php echo $reg->tipo;?>" readonly></td>
        </tr>

        <tr>
            <td>Senha </td> 
            <td><input type="text" maxlength="10" size="10" name="senha1" id='senha1'></td>
        </tr>

        <tr>
            <td>Confirme a senha </td> 
            <td><input type="text" maxlength="10" size="10" name="senha2" id='senha2'></td>
        </tr>
        <tr> 
            <td><input type="submit" value="Salvar alterações"></td>
        </tr>
        
    </table>
</form>