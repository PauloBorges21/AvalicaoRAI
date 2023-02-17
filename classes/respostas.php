<?php
class Respostas extends Medias
{

    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function setResposta($arrayCompleto)
    {
        $respostasArray = [];
        foreach ($arrayCompleto as $itens):

            $found_keyP = in_array($itens['IDRESPOSTA'], $respostasArray);
            if (!$found_keyP) {

                $novoArray = [
                    'idPergunta' => $itens['IDPERGUNTA'],
                    'idResposta' => $itens['IDRESPOSTA'],
                    'resposta' => $itens['RESPOSTAS'],
                    'tohave' => $itens['TOHAVE'],
                    'flag' => $itens['FLAG'],
                    'questionario' => $itens['IDQUESTIONARIO'],
                    'visao' => $itens['IDVISAO'],

                ];
                array_push($respostasArray, $novoArray);
                sort($respostasArray);
            }
            $filterRespostas = $this->arrayUniqueMultidimensional($respostasArray);
        endforeach;
        return $filterRespostas;
    }

    public function arrayUniqueMultidimensional($input)
    {
        $serialized = array_map('serialize', $input);
        $unique = array_unique($serialized);
        return array_intersect_key($input, $unique);
    }

    public function countResposta($array)
    {
        $values_string = implode(',', $array);
        $sql = "SELECT perguntas.id,COUNT(resposta_funcionario.id_resposta) total FROM respostas
        INNER JOIN relacao_pergunta_resposta ON relacao_pergunta_resposta.id_resposta = respostas.id
        INNER JOIN perguntas ON perguntas.id = relacao_pergunta_resposta.id_pergunta
        LEFT JOIN resposta_funcionario on resposta_funcionario.id_resposta = respostas.id 
        AND resposta_funcionario.id_pergunta = perguntas.id
        WHERE perguntas.id IN ($values_string)
        GROUP BY respostas.id,perguntas.id
        ORDER BY perguntas.id,respostas.id";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function countRespostaD($array, $modo)
    {
        if ($modo == "dimensoes") {
            $string = "modelo_dimensao";
        } elseif ($modo == "praticas") {
            $string = "modelo_praticas";
        }

        $values_string = implode(',', $array);
        $sql = "SELECT x.id_visao, x.id_resposta, x.$string, SUM(total) total
        FROM (
        SELECT perguntas.id id_pergunta,
        respostas.id id_resposta,
        perguntas.$string,
        relacao_pergunta_resposta.id_visao,
        COUNT(resposta_funcionario.id_resposta) total
        FROM respostas
        INNER JOIN relacao_pergunta_resposta ON relacao_pergunta_resposta.id_resposta = respostas.id
        INNER JOIN perguntas ON perguntas.id = relacao_pergunta_resposta.id_pergunta
        LEFT JOIN resposta_funcionario on resposta_funcionario.id_resposta = respostas.id
        AND resposta_funcionario.id_pergunta = perguntas.id AND resposta_funcionario.id_tipo_visao = relacao_pergunta_resposta.id_visao
        WHERE perguntas.$string IN ($values_string)
        GROUP BY respostas.id, perguntas.id, perguntas.$string, relacao_pergunta_resposta.id_visao
        ) as x
        GROUP BY x.id_visao, x.id_resposta, x.$string
        ORDER BY x.id_visao, x.$string, x.id_resposta";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_OBJ);
            //var_dump($result);

            return $result;


        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function getTotalPerguntaRespondida($id)
    {
        $sql = "SELECT count(0) total_respostas FROM resposta_funcionario WHERE id_pergunta = :id_pergunta";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id_pergunta', $id);
            $sql->execute();
            $result = $sql->fetch(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function countRespostaOP($id , $id_departamento)
    {
        //var_dump($id_departamento);
        // $id_departamento = ($id_departamento) ? $id_departamento : "";
        // if ($id_departamento != false) {
        //     $id_departamento;
        // } else {
        //     $id_departamento ="";
        // }
        $sql ="SELECT x.id_pergunta,
        x.id_resposta, SUM(total) total from (SELECT
        perguntas.id id_pergunta,respostas.id id_resposta,
        COUNT (resposta_funcionario.id_resposta) total FROM respostas
        INNER JOIN relacao_pergunta_resposta ON relacao_pergunta_resposta.id_resposta = respostas.id
        INNER JOIN perguntas ON perguntas.id = relacao_pergunta_resposta.id_pergunta
        LEFT JOIN resposta_funcionario ON resposta_funcionario.id_resposta = respostas.id
        AND resposta_funcionario.id_pergunta = perguntas.id
        LEFT JOIN  funcionario ON funcionario.id = resposta_funcionario.id_funcionario
        WHERE  perguntas.id = $id";
          if ($id_departamento != '0') {
            $sql .= " AND (funcionario.id_departamento = $id_departamento)";
        } 
        $sql .="GROUP BY
        perguntas.id,
        respostas.id
        UNION ALL
        SELECT
           perguntas.id id_pergunta,respostas.id id_resposta,0 FROM respostas
        INNER JOIN relacao_pergunta_resposta ON relacao_pergunta_resposta.id_resposta = respostas.id
        INNER JOIN perguntas ON perguntas.id = relacao_pergunta_resposta.id_pergunta
        WHERE
           perguntas.id = $id) AS x
            GROUP BY
        x.id_pergunta,
        x.id_resposta";

        try {
            $sql = $this->pdo->prepare($sql);            
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_OBJ);
            if ($result != false) {
                return $result;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    
}