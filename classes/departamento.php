<?php
class Departamento
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getDepartamento()
    {
        $sql = "SELECT * FROM departamento ORDER BY nome";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            $result = $sql->fetchAll();
            if ($result != false) {
                return $result;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            echo "Falha ao logar : {$e->getMessage()}";
        }
    }

    public function getGestor($idUsuario)
    {
        $sql = "SELECT * FROM gestores 
        WHERE id_funcionario = :id_funcionario";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id_funcionario', $idUsuario);
            $sql->execute();
            $result = $sql->fetch();
            if ($result != false) {
                return $result;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            echo "Falha ao logar : {$e->getMessage()}";
        }
    }

    public function gravarDepartamento($nome)
    {
        $sql = "INSERT INTO departamento (nome) VALUES (:nome)";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':nome', mb_strtoupper($nome));
            $sql->execute();           
            
        } catch (PDOException $e) {
            echo "Falha ao logar : {$e->getMessage()}";
        }
    }

    public function dpGerencia($idUsuario,$idDepartamento)
    {
        $sql = "INSERT INTO departamento (id_funcionario,id_departamento) VALUES (:id_funcionario,:id_departamento)";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id_funcionario', $idUsuario);
            $sql->bindValue(':id_departamento', $idDepartamento);
            $sql->execute();           
            
        } catch (PDOException $e) {
            echo "Falha ao logar : {$e->getMessage()}";
        }
    }

}