<?php
    require_once(__DIR__."/model/funcionario.php");
    require_once(__DIR__."/model/animal.php");

    if(isset($_GET['nome'])) {
        $nomeAnimal = $_GET['nome'];
        $funcionarios = funcionario::listarAnimal($nomeAnimal);
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <h2>Lista de funcionários por animal</h2>
</head>
<body>
    <h2>Funcionários que atenderam o animal <?php echo $nomeAnimal ; ?></h2>
    <?php if(isset($funcionarios) && count($funcionarios) > 0) { ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($funcionarios as $funcionario) { ?>
                    <tr>
                        <td><?php echo $funcionario['id']; ?></td>
                        <td><?php echo $funcionario['nome']; ?></td>
                        <td><?php echo $funcionario['email']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>Nenhum funcionário encontrado <?php echo $nomeAnimal; ?></p>
    <?php } ?>
    <br>
    <button><a class='direita' href="index.php">Voltar</a></button>
</body>
</html>