
<?php 
require_once "Pessoa.php";
$pessoa = new Pessoa("cadastro", "localhost", "root", "");

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="estilo.css">
    <title>Cadastro de Pessoas</title>
</head>
<body>

<?php

//não consegui usar a função add addslashes;
if (isset($_POST['nome'])) 
//clicou no botão cadastrar ou editar
{
    if (isset($_GET['id_up']) && !empty($_GET['id_up']))
    {

        //------------------------Atualizar-----------------------------

    $id_update = addslashes($_GET['id_up']);
    $nome = addslashes($_POST['nome']);
    $telefone = addslashes($_POST['telefone']);
    $email = addslashes($_POST['email']);
    

    if(!empty($nome) && !empty($telefone) && !empty($email)) {
        
        $pessoa->atualizarDados($id_update, $nome, $telefone, $email);
        header("Location: index.php");

    } 
    else 
    {
        ?>
            <div class="aviso">
                <img src="aviso2.png" alt="aviso">
                <h4>Preencha todos os campos</h4> 
            </div>
        <?php
           
        
    } 
    }

    //-------------------------Cadastrar--------------------------------
    else 
    {
    $nome = addslashes($_POST['nome']);
    $telefone = addslashes($_POST['telefone']);
    $email = addslashes($_POST['email']);

    if(!empty($nome) && !empty($telefone) && !empty($email)) {
        
        if(!$pessoa->salvar($nome, $telefone, $email))
        {
            ?>
                <div class="aviso">
                    <img src="aviso2.png">
                    <h4>Email já esta cadastrado</h4> 
                </div>
            <?php
        }
    } 
    else 
    {
        ?>
            <div class="aviso">
                <img src="aviso2.png">
                <h4>Preencha todos os campos</h4> 
            </div>
        <?php
    } 
    }

}

?>
<?php 
 if(isset($_GET['id_up']))
 {
     $id_update = ($_GET['id_up']);
     $res = $pessoa->buscarDadosPessoa($id_update);
 }
?>


    <section id="esquerda"> 
        <form  method="POST">
            <h2>CADASTRAR PESSOA</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome"
            value="<?php if(isset($res)){echo $res['nome'];} ?>"
            >
            <label for="telefone">Telefone</label>
            <input type="text" name="telefone" id="telefone"
            value="<?php if(isset($res)){echo $res['telefone'];} ?>"
            >
            <label for="email">Email</label>
            <input type="email" name="email" id="email"
            value="<?php if(isset($res)){echo $res['email'];} ?>"
            >
            <input type="submit" value="<?php if(isset($res)){echo 'Atualizar';} else {echo 'Cadastrar';} ?>">
        </form>

    </section>

    <section id="direita">
    <table>
            <tr id="titulo">
                <td>NOME</td>
                <td>TELEFONE</td>
                <td colspan="2">EMAIL</td>
            </tr>
    <?php
        $dados = $pessoa->buscarTodos();
        
        if(count($dados) > 0)
        {
            for ($i=0; $i < count($dados); $i++) { 
                echo "<tr>";
                foreach ($dados[$i] as $key => $value) {
                    if ($key != "id")
                    {
                        echo "<td>" . $value . "</td>";
                    }
                }
                ?>
                <td>
                <a href="index.php?id_up=<?php echo $dados[$i]['id'];?>">Editar</a>
                <a href="index.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
                </td>
                <?php
                echo "</tr>";
             
            }
           
        } else 
        {
               
        ?>
        </table>
        <div class="aviso">
            <h4>Não há pessoas cadastradas</h4> 
        </div>
    <?php
}
?>

    </section>
</body>
</html>

<?php 
    if(isset($_GET['id']))
    {
        $id_pessoa = addslashes($_GET['id']);
        $pessoa->excluirPessoa($id_pessoa);
        header("location: index.php");
    }

   


?>