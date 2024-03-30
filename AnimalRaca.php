<?php
    require_once(__DIR__."/model/animal.php");
    
    if(isset($_GET['raca'])) {
        $racaAnimal = $_GET['raca'];
        $animais = Animal::listarRaca($racaAnimal);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <h2>Listagem de animal por raça</h2>
 
</head>
<body>
    <h2>Animais da raça <?php echo $racaAnimal; ?></h2>
    <?php if(isset($animais) && count($animais) > 0) { ?>
        <table >
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($animais as $animal) { ?>
                    <tr>
                        <td><?php echo $animal['id']; ?></td>
                        <td><?php echo $animal['nome']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>Nenhum animal encontrado<?php echo $racaAnimal; ?></p>
    <?php } ?>
    <br>
    <button><a class='direita' href="index.php">Voltar</a></button>
</body>
</html>