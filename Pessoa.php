<?php 
class Pessoa {

    private $pdo;

    //===========================CONEXAO========================================

    public function __Construct($dbname, $host, $user, $senha) 
    {
        try {
            $this->pdo = new PDO("mysql:dbname=" . $dbname . ";host=" . $host, $user, $senha);
        } catch (PDOException $e) {
            echo "Erro no banco de dados: " . $e->getMessagne();
        } catch (Exception $e) {
            echo "Erro qualquer" . $e.getMessage();
            exit();
        }
        
    }

    //=====================METODO BUSCAR TODOS======================================
    public function buscarTodos() 
    {
        $resultado = array();
        $cmd = $this->pdo->query("SELECT * FROM tb_pessoa ORDER BY nome");
        $resultado = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;

        echo $resultado;
    }

    //=====================METODO SALVAR TODOS NO BANCO======================================

    
    public function Salvar($nome, $telefone, $email)
    //antes de cadastrar ver se o email ja está cadastrado
    {
        $comando = $this->pdo->prepare("SELECT id FROM tb_pessoa WHERE email = :e");
        $comando->bindParam(":e", $email);
        $comando->execute();
        
        if ($comando->rowCount() > 0) //email já existe no banco de dados
        {
            return false;
        } else //não foi encontrado o email
        {
            $comando = $this->pdo->prepare("INSERT INTO tb_pessoa (nome, telefone, email) VALUES (:n, :t, :e)");
            $comando->bindValue(":n", $nome);
            $comando->bindValue(":t", $telefone);
            $comando->bindValue(":e", $email);
            $comando->execute();
            return true;
        }
    }

        public function excluirPessoa($id)
        {
            $comando = $this->pdo->prepare("DELETE FROM tb_pessoa WHERE id = :id");
            $comando->bindValue(":id", $id);
            $comando->execute();
        }

    //==========================ATUALIZAR OS DADOS======================================

    //Buscar os dados de uma pessoa 
    public function buscarDadosPessoa($id)
    {   
        $result = array();
        $comando = $this->pdo->prepare("SELECT * FROM tb_pessoa WHERE id = :id");
        $comando->bindValue(":id", $id);
        $comando->execute();
        $result = $comando->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    //Atualizar dados no banco
    public function atualizarDados($id, $nome, $telefone, $email)
    {
        $comando = $this->pdo->prepare("UPDATE tb_pessoa SET nome = :n, telefone = :t, email = :e WHERE id = :id");
        $comando->bindValue(":id", $id);
        $comando->bindValue(":n", $nome);
        $comando->bindValue(":t", $telefone);
        $comando->bindValue(":e", $email);
        $comando->execute();
        return true;
        }

    

}


?>