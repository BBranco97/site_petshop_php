<?php
require_once(__DIR__."/model/animal.php");

if (isset($_GET['teldono'])) {
    $teldono = $_GET['teldono'];
    $animais = Animal::listarTelefone($teldono);
} else {
    echo "O número de telefone esta vazio.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <h2>Animais por telefone</h2>
</head>
<body>
    <h2>Animais por telefone</h2>
    <p>Lista de animais cadastrados para o telefone <?php echo $teldono; ?>:</p>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Raça</th>
                <th>Telefone do dono</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($animais as $animal) { ?>
            <tr>
                <td><?php echo $animal['nome']; ?></td>
                <td><?php echo $animal['raca']; ?></td>
                <td><?php echo $animal['teldono']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
    <button><a href="index.php">Voltar</a></button>
</body>
</html>