<?php
    function thumb($arc) {
        $path = "./images/$arc";
        if (is_null($arc) || !file_exists($path))
            return "./images/indisponivel.png";
        else
            return $path;
    }

    function voltar() {
        return "<a href='index.php'><i class='material-icons'>arrow_back</i></a>";
    }

    function msg_sucesso($m) {
        $resp = "<div class='sucesso'><i class='material-icons'>check_circle</i> $m</div>";
        return $resp;
    }

    function msg_aviso($m) {
        $resp = "<div class='aviso'><i class='material-icons'>info</i> $m</div>";
        return $resp;
    }

    function msg_error($m) {
        $resp = "<div class='erro'><i class='material-icons'>error</i> $m</div>";
        return $resp;
    }

?>