<?php

class Perguntas extends Respostas
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

  
    public function getPerguntas($idUsuario, $tipoQuestionario)
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
        INNER JOIN resposta_funcionario RF ON RF.id_pergunta = RPR.id_pergunta AND RF.id_tipo_visao = RPR.id_visao
        INNER JOIN perguntas P ON P.id = RPR.id_pergunta
        INNER JOIN respostas R ON R.id = RPR.id_resposta
        WHERE RPR.id_questionario = :id_questionario AND RPR.ativo = 1 AND RF.id_funcionario = :id_funcionario";

        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id_funcionario', $idUsuario);
            $sql->bindValue(':id_questionario', $tipoQuestionario);
            $sql->execute();
            $result = $sql->fetchAll();
            //var_dump($result);

            return $result;


        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }

    }

    public function getTotalPerguntas($tipoQuestionario)
    {

        $sql = "SELECT COUNT(DISTINCT id_pergunta) as total FROM relacao_pergunta_resposta WHERE id_questionario = :id_questionario";
        try {
            $sql = $this->pdo->prepare($sql);
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
        INNER JOIN perguntas P ON P.id = RPR.id_pergunta
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

    public function getVerificaRespondido($idFuncionario, $idQuestionario)
    {
        $sql = "SELECT COUNT(DISTINCT id_pergunta) AS TOTAL 
        FROM resposta_funcionario WHERE id_funcionario = :id_funcionario and id_questionario = :id_questionario AND flag_finalizado = 0 AND ativo = 1";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_funcionario", $idFuncionario);
            $sql->bindValue(":id_questionario", $idQuestionario);
            $sql->execute();
            return $sql->fetch();
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }


    public function setPergunta($arrayCompleto)
    {
        $perguntasArray = [];
        //var_dump($arrayCompleto);
        foreach ($arrayCompleto as $itens):

            $found_keyP = in_array($itens['IDPERGUNTA'], $perguntasArray);
            if (!$found_keyP) {
                $novoArray = [
                    'idPergunta' => $itens['IDPERGUNTA'],
                    'pergunta' => $itens['PERGUNTAS'],

                ];
                array_push($perguntasArray, $novoArray);
                //sort($perguntasArray);
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
}