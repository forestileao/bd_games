<script>
    function deleteGame(cod) {
        if (confirm("Você deseja excluir o jogo?")) {
            location.href = `game-delete.php?cod=${cod}`;
        }
    }

    function editGame(cod) {
        location.href = `game-edit.php?cod=${cod}`;
    }
</script>