<?php

class Perguntas extends Respostas
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getPerguntas($idUsuario, $tipoQuestionario, $idAvaliacao)
    {
        $sql = "SELECT 
        RPR.id_pergunta as IDPERGUNTA,
        RPR.id_resposta as IDRESPOSTA,
        RPR.id_visao as IDVISAO,
        RPR.id_questionario as IDQUESTIONARIO,
        RF.flag_finalizado as FLAG,
        RF.finalizacao_questionario as FINALIZADO,
        P.pergunta as PERGUNTAS,
        R.resposta as RESPOSTAS,
        (Select 1 from resposta_funcionario RF2 where
        RF2.id_resposta = RPR.id_resposta AND
        RF2.id_pergunta = RPR.id_pergunta AND
        RF2.id_tipo_visao = RPR.id_visao AND
        RF2.id_funcionario = RF.id_funcionario
        ) as TOHAVE        
        FROM relacao_pergunta_resposta RPR
        INNER JOIN resposta_funcionario RF ON RF.id_pergunta = RPR.id_pergunta AND RF.id_tipo_visao =                RPR.id_visao
        INNER JOIN perguntas P ON P.id = RPR.id_pergunta
        INNER JOIN respostas R ON R.id = RPR.id_resposta
        WHERE RPR.id_questionario = :id_questionario
        AND RPR.ativo = 1 
        AND RF.id_funcionario = :id_funcionario
        AND RF.id_avaliacao = :id_avaliacao       
        ";

        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id_funcionario', $idUsuario);
            $sql->bindValue(':id_questionario', $tipoQuestionario);
            $sql->bindValue(':id_avaliacao', $idAvaliacao);
            $sql->execute();
            $result = $sql->fetchAll();
            //var_dump($result);

            return $result;


        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }

    }

    public function getTotalPerguntas($tipoQuestionario, $avaliacao)
    {
        $sql = "SELECT
                    COUNT (DISTINCT id_pergunta) AS total
                FROM
                    relacao_pergunta_resposta
                WHERE
                    id_questionario = :id_questionario
                AND id_avaliacao = :id_avaliacao
                AND ativo = 1";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_questionario", $tipoQuestionario);
            $sql->bindValue(":id_avaliacao", $avaliacao);
            $sql->execute();
            $result = $sql->fetch();
            if ($result['total'] > 0) {
                return $result['total'];
            }
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function getTotalFlag($idUsuario, $tipoQuestionario)
    {

        $sql = "SELECT COUNT(DISTINCT id ) as total FROM resposta_funcionario WHERE id_questionario = :id_questionario  AND flag_finalizado = 0 AND ativo = 1 AND id_funcionario = :id_funcionario";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_funcionario", $idUsuario);
            $sql->bindValue(":id_questionario", $tipoQuestionario);
            $sql->execute();
            $result = $sql->fetch();
            if ($result['total'] > 0) {
                return $result['total'];
            }
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function getPerguntaRespostas($idQuestionario)
    {
        $sql = "SELECT
        RPR.id_pergunta as IDPERGUNTA,
        RPR.id_resposta as IDRESPOSTA,
        RPR.id_visao as IDVISAO,
        RPR.id_questionario as IDQUESTIONARIO,
        P.pergunta as PERGUNTAS,
        R.resposta as RESPOSTAS        
        FROM relacao_pergunta_resposta RPR      
        INNER JOIN perguntas P ON  P.id = RPR.id_pergunta
        INNER JOIN respostas R ON R.id = RPR.id_resposta
        WHERE RPR.id_questionario = :id_questionario AND RPR.ativo = 1 ";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_questionario", $idQuestionario);
            $sql->execute();
            return $sql->fetchAll();
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function getVerificaRespondido($idFuncionario, $idQuestionario, $avaliacao)
    {
        $sql = "SELECT
                COUNT (DISTINCT id_pergunta) AS TOTAL
                FROM
                resposta_funcionario
                WHERE
                id_funcionario = :id_funcionario
                AND id_questionario = :id_questionario
                AND id_avaliacao = :id_avaliacao
                AND flag_finalizado = 0
                AND ativo = 1";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_funcionario", $idFuncionario);
            $sql->bindValue(":id_questionario", $idQuestionario);
            $sql->bindValue(":id_avaliacao", $avaliacao);
            $sql->execute();
            return $sql->fetch();
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function setPergunta($arrayCompleto)
    {
        $perguntasArray = [];
        foreach ($arrayCompleto as $itens):
            $found_keyP = in_array($itens['IDPERGUNTA'], $perguntasArray);
            if (!$found_keyP) {
                $novoArray = [
                    'idPergunta' => $itens['IDPERGUNTA'],
                    'pergunta' => $itens['PERGUNTAS'],
                ];
                array_push($perguntasArray, $novoArray);
            }
            $filterPerguntas = $this->arrayUniqueMultidimensional($perguntasArray);
        endforeach;
        return $filterPerguntas;
    }

    function porcentagem($totalPerguntas, $totalRespondido)
    {
        $totalRespondido = intval($totalRespondido);
        $totalPerguntas = intval($totalPerguntas);
        // $porcentagem = (100 * intval($totalRespondido)) / intval($totalPerguntas);
        if ($totalRespondido != 0) {
            return round($totalRespondido / $totalPerguntas * 100);
            //return intval($totalRespondido) /
        } else {
            return 0;
        }
    }

    public function getEditPergunta($avaliacao,$pergunta)
    {   $sql ="SELECT DISTINCT
                RPR.id_avaliacao,
                P.pergunta,
                RPR.id_pergunta,
				RPR.id_questionario,
				TQ.nome,
                CD.id modelo_dimensao,
                CP.id modelo_praticas,
                CD.categoria modelo_dimensao_nome,
                CP.categoria modelo_praticas_nome
            FROM
                relacao_pergunta_resposta RPR
            LEFT JOIN perguntas P ON P.id = RPR.id_pergunta
            AND P.ativo = 1
            LEFT JOIN categoria_dimensao CD ON CD.id = P.modelo_dimensao
            LEFT JOIN categoria_pratica CP ON CP.id = P.modelo_praticas
            INNER JOIN tipo_questionario TQ ON TQ.id = RPR.id_questionario
            WHERE
                RPR.ativo = 1
            AND RPR.id_avaliacao = :id_avaliacao
            AND P.id = :id_pergunta
            ORDER BY
                id_pergunta";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_avaliacao", $avaliacao);
            $sql->bindValue(":id_pergunta", $pergunta);
            $sql->execute();
            return $sql->fetch();
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function deletePerguntaRespostas($idAvaliacao,$idQuestionario,$idPergunta)
    {
        $sql = "DELETE FROM relacao_pergunta_resposta WHERE id_avaliacao = :id_avaliacao AND  id_questionario = :id_questionario AND id_pergunta = :id_pergunta";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_avaliacao", $idAvaliacao);
            $sql->bindValue(":id_questionario", $idQuestionario);
            $sql->bindValue(":id_pergunta", $idPergunta);
            $sql->execute();
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function updatePerguntaRespostas($idPergunta,$pergunta,$modelo_dimensao,$modelo_praticas)
    {

        $sql = "UPDATE perguntas
                SET pergunta = :pergunta, modelo_dimensao = :modelo_dimensao, modelo_praticas = :modelo_praticas
                WHERE id = :id;";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id", $idPergunta);
            $sql->bindValue(":pergunta", $pergunta);
            $sql->bindValue(":modelo_dimensao", $modelo_dimensao);
            $sql->bindValue(":modelo_praticas", $modelo_praticas);
            $sql->execute();
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function insertPerguntaRespostas($idPergunta,$idVisao,$idQuestionario,$idResposta,$idAvaliacao)
    {

        $sql = "INSERT INTO relacao_pergunta_resposta 
                (id_pergunta, id_visao, id_questionario, ativo , id_resposta,id_avaliacao)
                VALUES (:id_pergunta,:id_visao,:id_questionario,1,:id_resposta,:id_avaliacao)";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_pergunta", $idPergunta);
            $sql->bindValue(":id_visao", $idVisao);
            $sql->bindValue(":id_questionario", $idQuestionario);
            $sql->bindValue(":id_resposta", $idResposta);
            $sql->bindValue(":id_avaliacao", $idAvaliacao);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return true;
            }
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

}