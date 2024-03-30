<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar funcionário</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <h2>Editar funcionário</h2>
    <a href='index.php'>Voltar</a>
    <?php
    require_once "configs/utils.php";
    require_once "model/funcionario.php";

    $funcionario = null;

    if (isMetodo("POST")) {
        if (pValidation($_POST, ["id", "nome", "email"])) {
            $resultado = Funcionario::editar($_POST["id"], $_POST["nome"], $_POST["email"]);
            if ($resultado) {
                echo "<h4>Funcionário editado</h4>";
                die;
            } else {
                echo "<h4>Erro ao editar</h4>";   
                die;
            }
        } else {
            echo "<h4>Problema na edição</h4>";
            die;
        }
    }

    if (isMetodo("GET")) {
        if (pValidation($_GET, ["id"])) {
            $id = $_GET["id"];
            if (Funcionario::existeId($id)) {
                $funcionario = Funcionario::getFuncionarioById($id);
            } else {
                echo "<h4>Funcionário não cadastrado</h4>";
                echo "<a href='index.php'>Voltar</a>";
                die;
            }
        } else {
            echo "<h4>Informe um Funcionário</h4>";
            echo "<a href='index.php'>Voltar</a>";
            die;
        }
    }

    ?>

    <h2>Editando as informações de <?= $funcionario["nome"] ?></h2>

    <form method="POST">
        <div class='linha'>
            <p>Digite o nome</p>
            <input type="text" name="nome" value="<?= $funcionario["nome"] ?>" required>
        </div>
        <div class='linha'>
            <p>Digite o email</p>
            <input type="email" name="email" value="<?= $funcionario["email"] ?>" required>
            <input type="hidden" name="id" value="<?= $funcionario["id"] ?>">
            
            <button>Editar</button>
        </div>
    </form>
</body>

</html>