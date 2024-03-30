<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetShop </title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
    <?php
    date_default_timezone_set('America/Sao_Paulo');
    require_once "configs/utils.php";
    require_once "model/funcionario.php";
    require_once "model/animal.php";
    require_once "model/atende.php";

    try{
        if (isMetodo("GET")) {
            if (pValidation($_GET, ["deletarFuncionario"])) {
                $id = $_GET["deletarFuncionario"];
                if (Funcionario::existeId($id)) {
                    $resultado = Funcionario::deletar($id);
                    if ($resultado) {
                        echo "<p>Deletado com sucesso</p>";
                    } 
                } else {
                    echo "<p>Funcionário não cadastrado</p>";
                    die;
                    }
                }
            }
        }catch(PDOException $e){
        if ($e->errorInfo[0] == 1451) {
            echo "<script>alert('Funcionário cadastrado em um atendimento')</script>";
        }else{
            echo "<script>alert('Não foi possivel deletar')</script>". $e->getMessage();;
        }
    }

    if (isMetodo("GET")) {
        if (pValidation($_GET, ["deletarAnimal"])) {
            $id = $_GET["deletarAnimal"];
            if (Animal::existeId($id)) {
                $resultado = Animal::deletar($id);
                if ($resultado) {
                    echo "<p>Deletado com sucesso</p>";
                } 
            } else {
                echo "<p>Animal não cadastrado</p>";
                die;
            }
        }
    }

    if (isMetodo("GET")) {
        if (pValidation($_GET, ["deletarAtende"])) {
            $id = $_GET["deletarAtende"];
            if (Atende::existeId($id)) {
                $resultado = Atende::deletar($id);
                if ($resultado) {
                    echo "<p>Atendimento deletado com sucesso</p>";
                } 
            } else {
                echo "<p>Atendimento não cadastrado</p>";
                die;
            }
        }
    }

    if (isMetodo("POST")) {
        if (pValidation($_POST, ["nome", "email"])) {
            $nome = $_POST["nome"];
            $email = $_POST["email"];
            $datacadastro = date('Y-m-d H:i:s');

            if (!Funcionario::existeEmail($email)) {
                if (Funcionario::cadastrar($nome, $email, $datacadastro)) {
                    echo "<p>Funcionário cadastrado com sucesso</p>";
                } else {
                    echo "<p>Erro ao cadastrar o funcionário</p>";
                }
            } else {
                echo "<p>Já existe um funcionario com o e-mail informado</p>";
            }
        }

        if (pValidation($_POST, ["nome", "raca", "teldono"])) {
            $nome = $_POST["nome"];
            $raca = $_POST["raca"];
            $teldono = $_POST["teldono"];
            $datacadastro = date('Y-m-d H:i:s');

            
            if (!Animal::existeNome($nome) && !Animal::existeTel($teldono)) {
                if (Animal::cadastrar($nome, $raca, $teldono, $datacadastro)) {
                    echo "<p>Animal cadastrado com sucesso</p>";
                } else {
                    echo "<p>Erro ao cadastrar o animal</p>";
                }
            } else {
                echo "<p>ID ja cadastrado no sistema</p>";
            }
        }

        if (pValidation($_POST, ["idfuncionario", "idanimal"])) {
            $idfuncionario = $_POST["idfuncionario"];
            $idanimal = $_POST["idanimal"];
            $data = date('Y-m-d H:i:s');

            
            if (!Atende::existeAtende($idfuncionario, $idanimal) && Funcionario::existeId($idfuncionario) && Animal::existeId($idanimal)) {
                if (Atende::cadastrar($idfuncionario, $idanimal, $data)) {
                    echo "<p>Atendimento cadastrado com sucesso</p>";
                } else {
                    echo "<p>Erro ao cadastrar o atendimento</p>";
                }
            } else {
                echo "<p>ID já cadastrado no sistema</p>";
            }
        }
    }

    if(isset($_POST["idFunc"]) and !empty($_POST["idFunc"])) {
        $idFunc = $_POST["idFunc"];

        require_once(__DIR__."/model/Animal.php");

        $listaAnimais = Animal::listarFuncionario($idFunc);

        if(count($listaAnimais) > 0) {
            echo "<h3>Animais cuidados pelo funcionário selecionado:</h3>";
            echo "<table >";
            echo "<thead>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Nome</th>";
            echo "<th>Raça</th>";
            echo "<th>Telefone do dono</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            foreach($listaAnimais as $animal) {
                echo "<tr>";
                echo "<td>" . $animal["id"] . "</td>";
                echo "<td>" . $animal["nome"] . "</td>";
                echo "<td>" . $animal["raca"] . "</td>";
                echo "<td>" . $animal["teldono"] . "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>Nenhum animal foi encontrado</p>";
        }
    }

    ?>

    <div class="header">
        <h1>PET SHOP</h1>
        <img class='pricipal'src="foto18.jpg"/>
    </div>

    <div class = "container">
        <div >

        <br>
            <h2 class='centro'>Animais</h2>
            <div class='lado'>
                <div class='baixo'>
                    <h2>Cadastre um animal</h2>
                    <form method="POST">
                        <div class='linha'>
                            <p>Nome: </p>
                            <input type="text" name="nome" required>
                        </div>
                        <div class='linha'>
                            <p>Raça: </p>
                            <input type="text" name="raca" required>
                        </div>
                        <div class='linha'>
                            <p>Telefone do dono: </p>
                            <input type="text" name="teldono" required>
                            <button>Cadastrar</button>
                        </div>
                    </form>
                </div>
                <img class='animais'src="111.jpg"/>
            </div>

            <h2>Animais cadastrados</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Raça</th>
                        <th>Telefone do dono</th>
                        <th>Cadastro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $lista = Animal::listar();
                    foreach ($lista as $animal) {
                        echo "<tr>";
                        echo "<td>" . $animal["id"] . "</td>";
                        echo "<td>" . $animal["nome"] . "</td>";
                        echo "<td>" . $animal["raca"] . "</td>";
                        echo "<td>" . $animal["teldono"] . "</td>";
                        echo "<td>" . $animal["datacadastro"] . "</td>";
                        $id = $animal["id"];
                        echo "<td class='borda'>
                            <a href='editarAnimal.php?id=$id'>Editar</a> | 
                            <a href='index.php?deletarAnimal=$id'>Deletar</a>
                        </td>";
                        echo "</tr>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <br><br><br>

            <h2 class='centro'>Funcionários</h2>
            
            <br>
            <div class='lado'>
                <div class='baixo'>
                    <h2>Cadastre um funcionário</h2>
                    <form method="POST">
                        <div class= "linha">
                            <p>Nome: </p>
                            <input type="text" name="nome" required>
                        </div>
                        <div class="linha">
                            <p>E-mail: </p>
                            <input type="email" name="email" required>
                            <button>Cadastrar</button>
                        </div>
                    </form>
                </div>
            
                 <img class='animais'src="curso.png"/>
            
            </div>
            <br>
            
            <h2>Funcionários cadastrados</h2>
            <table class="tabela">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Cadastro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $lista = Funcionario::listar();
                    foreach ($lista as $funcionario) {
                        echo "<tr>";
                        echo "<td>" . $funcionario["id"] . "</td>";
                        echo "<td>" . $funcionario["nome"] . "</td>";
                        echo "<td>" . $funcionario["email"] . "</td>";
                        echo "<td>" . $funcionario["datacadastro"] . "</td>";
                        $id = $funcionario["id"];
                        echo "<td class='borda'>
                            <a href='editarFuncionario.php?id=$id'>Editar</a> | 
                            <a href='index.php?deletarFuncionario=$id'>Deletar</a>
                        </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>

           
            <br><br><br>

            <h2 class='centro'>Atendimentos</h2>
            <br>
            <h2>Cadastre um atendimento</h2>
            <div class='lado'>
                <div class='baixo'>
                    <form method="POST">
                        <div class='linha'>
                            <p>ID do funcionário: </p>
                            <input type="number" name="idfuncionario" required>
                        </div>
                        <div class = 'linha'>
                            <p>ID do animal: </p>
                            <input type="number" name="idanimal" required>
                            <button>Cadastrar</button>
                        </div>
                    </form>
                </div>
                <img class='animais'src="download.jpg"/>
            </div>
            <h2>Atendimentos cadastrados</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID Funcionário</th>
                        <th>ID Animal</th>
                        <th>Cadastrado em</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $lista = Atende::listar();
                    foreach ($lista as $atende) {
                        echo "<tr>";
                        echo "<td>" . $atende["id"] . "</td>";
                        echo "<td style='text-align:center'>" . $atende["idfuncionario"] . "</td>";
                        echo "<td style='text-align:center'>" . $atende["idanimal"] . "</td>";
                        echo "<td>" . $atende["data"] . "</td>";
                        $id = $atende["id"];
                        echo "<td class='borda'>
                            <a href='index.php?deletarAtende=$id'>Deletar</a>
                        </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
                        
            <br><br><br>
            <h2 class='centro'>Listas</h2>
            <div class='lado2'>
                <img class = 'lista' src="lupa.avif"/>
                
                <div class='baixo'>
                    <h2>Buscar funcionário por animal</h2>
                    <form method="GET" action="FuncAnimal.php">
                        <div class='linha'>
                            <select name="nome">
                                <option value="">Selecione um animal</option>
                                <?php
                                require_once(__DIR__."/model/Animal.php");
                                $animais = Animal::listar();
                                foreach($animais as $animal) {
                                    echo "<option value='{$animal['id']}'>{$animal['nome']}</option>";
                                }
                                ?>
                            </select>
                            <input type="submit" value="Buscar">
                        </div>
                    </form>
            
                    <h2>Buscar animal por raça</h2>
                    <form method="GET" action="AnimalRaca.php">
                            <div class='linha'>
                            <select name="raca">
                                <option value="">Selecione uma raça</option>
                                <?php
                                require_once(__DIR__."/model/Animal.php");
                                $animais = Animal::listar();
                                foreach($animais as $animal) {
                                    echo "<option value='{$animal['raca']}'>{$animal['raca']}</option>";
                                }
                                ?>
                            </select>
                            <input type="submit" value="Buscar">
                        </div>
                    </form>

                    <h2>Buscar animal por telefone</h2>
                    <form method="GET" action="AnimalTel.php" class="animaltel">  
                        <div class='linha'>
                            <select name="teldono" required>
                                <option value="">Selecione um telefone</option>
                                <?php
                                require_once(__DIR__."/model/animal.php");
                                $telefones = Animal::listar();

                                foreach($telefones as $teldono) {
                                    echo "<option value='{$teldono['teldono']}'>{$teldono['teldono']}</option>";
                                }
                                ?>
                            </select>
                            <input type="submit" value="Buscar">
                            </form>
                        </div>

                    <h2>Buscar de animal por funcionário</h2>

                    <form method="POST">
                        <div class='linha'>
                            <select name="idFunc" required>
                                <option value="">Selecione um funcionário</option>
                                <?php 
                                    require_once(__DIR__."/model/Funcionario.php");

                                    $listaFuncionarios = Funcionario::listar();

                                    foreach($listaFuncionarios as $funcionario) {
                                        echo "<option value='" . $funcionario["id"] . "'>" . $funcionario["nome"] . " (" . $funcionario["email"] . ")" . "</option>";
                                    }
                                ?>
                            </select>
                            <button>Buscar</button>
                        </div>
                    </form>
                </div>

             </div>
             <br><br><br>
    </div>
  
</body>

</html>