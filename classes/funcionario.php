<?php 

class Funcionario
{
private $pdo;

public function __construct($pdo)
{
    $this->pdo = $pdo;
}

public function getFuncionario($email,$cpf)
{
    $sql = "SELECT * FROM funcionario WHERE email = :email AND cpf = :cpf AND ativo = 1";
    try{
        $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":email", $email);
            $sql->bindValue(":cpf", $cpf);
            $sql->execute();
            $result = $sql->fetch();
            //var_dump($result);
            if ($result != false) {
                $_SESSION['funcionarioRai'] = $result['id'];
                return $_SESSION['funcionarioRai'] = $result['id'];
                // exit();
                //echo "<script>alert='$_SESSION['clienteCoop']';</script>";
                //echo $_SESSION['clienteCoop'];
            }else{
                return false;
            }

    } catch(PDOException $e) {
        echo "Falha ao logar : {$e->getMessage()}";
    }
}

public function getAll($id)
{
    $sql = "SELECT
	f.nome AS Funcionario,
	d.nome AS Departamento,
	g.id_funcionario AS GestorID,
	f2.nome AS Gestor 
    FROM
    funcionario f
    INNER JOIN departamento d ON d.id = f.id_departamento
    INNER JOIN gestores g ON g.id_departamento = f.id_departamento
    INNER JOIN funcionario f2 ON g.id_funcionario = f2.id
    WHERE
	f.id = :id AND f.ativo = 1";
    $sql = $this->pdo->prepare($sql);
    $sql->bindValue(":id", $id);
    $sql->execute();
    $result = $sql->fetch();
    if ($result != false) {
        return $result;
    } else{
        return false;
    }
}
}