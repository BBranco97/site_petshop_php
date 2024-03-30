<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar animal</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <h2>Editar animal</h2>
    <a href='index.php'>Voltar</a>
    <?php
    require_once "configs/utils.php";
    require_once "model/animal.php";

    $animal = null;

    if (isMetodo("POST")) {
        if (pValidation($_POST, ["id", "nome", "raca", "teldono"])) {
            $resultado = Animal::editar($_POST["id"], $_POST["nome"], $_POST["raca"], $_POST["teldono"]);
            if ($resultado) {
                echo "<h4>Editado com sucesso</h4>";
                die;
            } else {
                echo "<h4>Erro ao editar</h4>";
                die;
            }
        } else {
            echo "<h4>Problemas na edição</h4>";
            die;
        }
    }

    if (isMetodo("GET")) {
        if (pValidation($_GET, ["id"])) {
            $id = $_GET["id"];
            if (Animal::existeId($id)) {
                $animal = Animal::getAnimalById($id);
            } else {
                echo "<h4>Animal não cadastrado</h4>";
                die;
            }
        } else {
            echo "<h4>Informe um animal</h4>";
            die;
        }
    }

    ?>

    <h2>Editando as informações de <?= $animal["nome"] ?></h2>

    <form method="POST">
        <div class='linha'>
            <p>Nome: </p>
            <input type="text" name="nome" value="<?= $animal["nome"] ?>" required>
        </div>
        <div class='linha'>
            <p>Raca: </p>
            <input type="text" name="raca" value="<?= $animal["raca"] ?>" required>
        </div>
        <div class='linha'>
            <p>Telefone do dono</p>
            <input type="text" name="teldono" value="<?= $animal["teldono"] ?>" required>
            <input type="hidden" name="id" value="<?= $animal["id"] ?>">
        
            <button>Salvar</button>
        </div>
    </form>
</body>

</html>