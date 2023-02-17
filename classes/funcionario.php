<?php

class Funcionario
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getFuncionario($email, $cpf)
    {
        $sql = "SELECT * FROM funcionario WHERE email = :email AND cpf = :cpf AND ativo = 1";
        try {
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
            } else {
                return false;
            }

        } catch (PDOException $e) {
            echo "Falha ao logar : {$e->getMessage()}";
        }
    }

    // public function getAll($id)
    // {
    //     $sql = "SELECT
    // f.id,
    // f.cpf,
    // f.email,
    // f.nome AS Funcionario,
    // d.nome AS Departamento,
    // d.id as id_departamento,
    // g.id_funcionario AS GestorID,
    // f2.nome AS Gestor 
    // FROM
    // funcionario f
    // INNER JOIN departamento d ON d.id = f.id_departamento
    // INNER JOIN gestores g ON g.id_departamento = f.id_departamento
    // INNER JOIN funcionario f2 ON g.id_funcionario = f2.id
    // WHERE
    // f.id = :id AND f.ativo = 1";
    //     $sql = $this->pdo->prepare($sql);
    //     $sql->bindValue(":id", $id);
    //     $sql->execute();
    //     $result = $sql->fetch();
    //     if ($result != false) {
    //         return $result;
    //     } else {
    //         return false;
    //     }
    // }

    public function getAll($id)
    {
        $sql = "SELECT f.id,f.nome as NOME_FUNC,f.id_gestor_direto,f.email,f.cpf,f.flag_gestor,d.id as id_departamento,d.nome as NOME_DEPARTAMENTO
        ,(SELECT nome FROM funcionario f2 where f2.id = f.id_gestor_direto) NOME_GERENTE
            FROM funcionario f
            INNER JOIN departamento d ON f.id_departamento = d.id
         where f.id =:id and f.ativo = 1";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(":id", $id);
        $sql->execute();
        $result = $sql->fetch();
        if ($result != false) {
            return $result;
        } else {
            return false;
        }
    }

    public function getFunc()
    {
        try {
            $sql = "SELECT
            f.id AS id,
                  f.nome,
                  d.nome AS Departamento,
                  g.id_funcionario AS GestorID,
                  f2.nome AS Gestor 
                  FROM
                  funcionario f
                  INNER JOIN departamento d ON d.id = f.id_departamento
                  INNER JOIN gestores g ON g.id_departamento = f.id_departamento
                  INNER JOIN funcionario f2 ON g.id_funcionario = f2.id
                  WHERE f.ativo = 1";
            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_OBJ);
            if ($result != false) {
                return $result;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Falha ao logar : {$e->getMessage()}";
        }
    }

    public function getFuncDP($idDp)
    {
        try {
            $sql = "SELECT
           f.id AS id,
	       f.nome,
            d.nome AS Departamento,
            g.id_funcionario AS GestorID,
            f2.nome AS Gestor 
            FROM
            funcionario f
            INNER JOIN departamento d ON d.id = f.id_departamento
            INNER JOIN gestores g ON g.id_departamento = f.id_departamento
            INNER JOIN funcionario f2 ON g.id_funcionario = f2.id
            WHERE
            d.id = :id AND f.ativo = 1";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id", $idDp);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_OBJ);
            if ($result != false) {
                return $result;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Falha ao logar : {$e->getMessage()}";
        }
    }

    public function gravarUsuario($nome, $departamento, $cpf, $email, $flag_gestor, $id_gestor_direto)
    {
        $sql = "INSERT INTO funcionario (nome, id_departamento,
        cpf, email, flag_gestor, id_gestor_direto)
        VALUES (:nome, :id_departamento,
        :cpf, :email, :flag_gestor, :id_gestor_direto)";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":id_departamento", $departamento);
            $sql->bindValue(":cpf", $cpf);
            $sql->bindValue(":email", $email);
            $sql->bindValue(":flag_gestor", $flag_gestor);
            $sql->bindValue(":id_gestor_direto", $id_gestor_direto);
            $sql->execute();
            if ($sql->rowCount() > 0) {

                $lastId = $this->pdo->lastInsertId();
                return $usuario = [
                    "usuario" => $lastId,
                    "departamento" => $departamento,
                ];
            }
        } catch (PDOException $e) {
            echo "Falha ao logar : {$e->getMessage()}";
        }
    }


    public function uploadUsuario($id, $nome, $email, $cpf, $departamento, $flag_gestor, $id_gestor_direto)
    {
        $sql = "UPDATE funcionario SET nome = :nome, id_departamento = :id_departamento , cpf = :cpf, email =:email , flag_gestor = :flag_gestor , id_gestor_direto = :id_gestor_direto 
        WHERE id = :id";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id", $id);
            $sql->bindValue(":nome", $nome);
            $sql->bindValue(":email", $email);
            $sql->bindValue(":cpf", $cpf);
            $sql->bindValue(":id_departamento", $departamento);
            $sql->bindValue(":flag_gestor", $flag_gestor);
            $sql->bindValue(":id_gestor_direto", $id_gestor_direto);

            $sql->execute();
            if ($sql->rowCount() > 0) {
                return true;
            }

        } catch (PDOException $e) {
            echo "Falha ao logar : {$e->getMessage()}";
        }
    }


    public function gravarUsuarioGerencia($idUsuario, $idDepartamento)
    {
        $sql = "INSERT INTO gestores (id_funcionario,id_departamento,ativo) VALUES (:id_funcionario,:id_departamento,:ativo)";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_funcionario", $idUsuario);
            $sql->bindValue(":id_departamento", $idDepartamento);
            $sql->bindValue(":ativo", 1);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return true;
            }
        } catch (PDOException $e) {
            echo "Falha ao logar : {$e->getMessage()}";
        }

    }

    public function validarCampoUnico($cpf)
    {
        $sql = "SELECT COUNT(*) as total
        FROM funcionario  WHERE cpf = :cpf";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":cpf", $cpf);
            $sql->execute();
            $result = $sql->fetch(PDO::FETCH_OBJ);
            return $result->total;
        } catch (PDOException $e) {
            echo "Falha ao logar : {$e->getMessage()}";
        }
    }

    public function getAllF()
    {
        $sql = "SELECT * FROM  funcionario WHERE ativo = 1 ORDER BY nome";
        $sql = $this->pdo->prepare($sql);
        $sql->execute();
        $result = $sql->fetchAll();
        if ($result != false) {
            return $result;
        } else {
            return false;
        }
    }

    public function getAllFG()
    {
        $sql = "SELECT *FROM funcionario WHERE flag_gestor = 1 AND ativo = 1 ORDER BY nome";
        $sql = $this->pdo->prepare($sql);
        $sql->execute();
        $result = $sql->fetchAll();
        if ($result != false) {
            return $result;
        } else {
            return false;
        }
    }

    public function getUsersEdit($departamento)
    {
        $departamento = (isset($departamento)) ? $departamento : "";
        $sql = "SELECT f.id,f.nome as NOME_FUNC,f.id_gestor_direto,f.email,f.cpf,f.flag_gestor,d.id as id_departamento,d.nome as NOME_DEPARTAMENTO
        ,(SELECT nome FROM funcionario f2 where f2.id = f.id_gestor_direto) NOME_GERENTE
            FROM funcionario f
            INNER JOIN departamento d ON f.id_departamento = d.id WHERE ativo =1";
        if ($departamento != "") {
            $sql .= " AND id_departamento = :id_departamento";
        }
        $sql = $this->pdo->prepare($sql);
        if ($departamento != "") {
            $sql->bindValue(":department", $departamento);
        }
        $sql->execute();
        $result = $sql->fetchAll();
        if ($result != false) {
            return $result;
        } else {
            return false;
        }
    }

    public function getGestores()
    {
        $sql = "SELECT * FROM funcionario where flag_gestor = 1 AND ativo = 1 ORDER BY nome";
        $sql = $this->pdo->prepare($sql);
        $sql->execute();
        $result = $sql->fetchAll();
        if ($result != false) {
            return $result;
        } else {
            return false;
        }
    }
}