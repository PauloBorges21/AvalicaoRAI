<?php


class Avaliacao
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAvaliacao()
    {
        $sql = "SELECT TOP 1 * FROM avaliacao WHERE ativo = 1
                ORDER BY ROW_NUMBER() OVER (ORDER BY id DESC);";
        try {
            $sql = $this->pdo->prepare($sql);
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
}