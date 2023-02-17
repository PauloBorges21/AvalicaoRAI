<?php
class Questionario
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function gravarQuestionario($idUsuario, $idPergunta, $idResposta, $id_questionario, $idVisao)
    {

        $sql = "INSERT INTO resposta_funcionario (id_funcionario, id_pergunta, id_resposta, flag_finalizado, id_questionario, id_tipo_visao)
        VALUES (:id_funcionario, :id_pergunta, :id_resposta, :flag_finalizado, :id_questionario, :id_tipo_visao)";

        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id_funcionario', $idUsuario);
            $sql->bindValue(':id_pergunta', $idPergunta);
            $sql->bindValue(':id_resposta', $idResposta);
            $sql->bindValue(':flag_finalizado', 0);
            $sql->bindValue(':id_questionario', $id_questionario);
            $sql->bindValue(':id_tipo_visao', $idVisao);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return true;
            }
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function finalizaQuestionario($idUsuario, $idPergunta, $idRespostaVE, $id_questionario, $idVisao)
    {

        $sql = "UPDATE resposta_funcionario
        SET finalizacao_questionario = GETDATE()
        WHERE id_funcionario = :id_funcionario AND id_pergunta = :id_pergunta AND id_resposta = :id_resposta AND id_tipo_visao = :id_tipo_visao AND id_questionario = :id_questionario";

        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id_funcionario', $idUsuario);
            $sql->bindValue(':id_pergunta', $idPergunta);
            $sql->bindValue(':id_resposta', $idRespostaVE);
            $sql->bindValue(':id_questionario', $id_questionario);
            $sql->bindValue(':id_tipo_visao', $idVisao);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return true;
            }
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function finalizaQuestionario1($idUsuario, $id_questionario)
    {

        $sql = "UPDATE resposta_funcionario
        SET finalizacao_questionario = GETDATE()
        WHERE id_funcionario = :id_funcionario AND id_questionario = :id_questionario";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id_funcionario', $idUsuario);
            $sql->bindValue(':id_questionario', $id_questionario);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return true;
            }
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function getFormularioPendente($idUsuario)
    {
        try {
            $sql = "SELECT * FROM resposta_funcionario WHERE id_funcionario = :id_funcionario AND flag_finalizado = 0 AND ativo = 1";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id_funcionario', $idUsuario);
            $sql->execute();
            $result = $sql->fetchAll();

            if ($result != false) {
                return $result;
            }
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function statusReport()
    {
        try {
            $sql = "SELECT DISTINCT 
            f.id AS id, 
            f.nome, 
            f.id_gestor_direto,
            rf.id_questionario,
            rf.finalizacao_questionario,
            d.nome AS Departamento,
            f.id_departamento AS id_departamento,
            (SELECT DISTINCT f2.nome 
             FROM funcionario f2 
             WHERE f2.id = f.id_gestor_direto AND f2.flag_gestor = 1 AND f2.ativo = 1) AS NOME_GESTOR,
           (SELECT COUNT(DISTINCT f2.id) 
            FROM funcionario f2 
              WHERE f2.id_departamento = f.id_departamento AND f2.ativo = 1) AS total_colaborador,
            (SELECT COUNT(DISTINCT rf2.id_funcionario)
             FROM resposta_funcionario rf2
             WHERE rf2.id_questionario = 2 AND rf2.finalizacao_questionario IS NOT NULL AND rf2.finalizacao_questionario > '1753-01-01' AND rf2.ativo = 1 AND rf2.id_funcionario = f.id) AS total_finalizados
          FROM 
            funcionario f
            INNER JOIN departamento d ON f.id_departamento = d.id AND f.ativo = 1
            LEFT JOIN resposta_funcionario rf ON f.id  = rf.id_funcionario AND rf.ativo = 1 AND id_questionario = 2
          WHERE 
            f.ativo = 1";
            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            $result = $sql->fetchAll();
            if ($result != false) {
                return $result;
            }
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

}