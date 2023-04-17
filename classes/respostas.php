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
        $filterRespostas = [];
        foreach ($arrayCompleto as $itens):
            $found_keyP = in_array($itens['IDRESPOSTA'], $respostasArray);
            if (!$found_keyP) {
                $novoArray = [
                    'idPergunta' => $itens['IDPERGUNTA'],
                    'idResposta' => $itens['IDRESPOSTA'],
                    'resposta' => $itens['RESPOSTAS'],
                    'tohave' => isset($itens['TOHAVE']) ? $itens['TOHAVE'] : null,
                    'flag' => isset($itens['FLAG']) ? $itens['FLAG'] : null,
                    'questionario' => $itens['IDQUESTIONARIO'],
                    'visao' => $itens['IDVISAO'],
                ];
                array_push($respostasArray, $novoArray);
                sort($respostasArray);
            }
            $filterRespostas = $this->arrayUniqueMultidimensional($respostasArray);
        endforeach;
        $filterRespostas = array_map(function ($item) {
            if (empty($item['idPergunta'])) {
                $item['idPergunta'] = 0;
            }
            if (empty($item['idResposta'])) {
                $item['idResposta'] = 0;
            }
            if (empty($item['resposta'])) {
                $item['resposta'] = 0;
            }
            if (empty($item['tohave'])) {
                $item['tohave'] = 0;
            }

            if (empty($item['questionario'])) {
                $item['questionario'] = 0;
            }
            if (empty($item['visao'])) {
                $item['visao'] = 0;
            }
            return $item;
        }, $filterRespostas);
        return $filterRespostas;
    }

    public function arrayUniqueMultidimensional($input)
    {
        $serialized = array_map('serialize', $input);
        $unique = array_unique($serialized);
        return array_intersect_key($input, $unique);
    }

    public function countResposta($array, $presidente, $departamento)
    {
        $values_string = implode(',', $array);
        $values_dp = implode(',', $departamento);
        $sql = "SELECT
                perguntas.id as id_pergunta,
                respostas.id as id_resposta,
                COUNT(RF.id_resposta) as total
	            FROM resposta_funcionario RF";
        if ($presidente == 1 || $values_dp[0] != 0) {
            $sql .= " INNER JOIN funcionario F ON F.id = RF.id_funcionario ";
        }
        if ($presidente == 1) {
            $sql .= "AND F.id_gestor_direto = 144 ";
        }
        if ($values_dp[0] != 0) {
            $sql .= " AND F.id_departamento IN ($values_dp)";
        }
        $sql .= " RIGHT JOIN relacao_pergunta_resposta RPR ON RF.id_resposta = RPR.id_resposta and RF.id_pergunta = RPR.id_pergunta
                LEFT JOIN perguntas perguntas ON perguntas.id = RPR.id_pergunta
                LEFT JOIN respostas respostas ON respostas.id = RPR.id_resposta
	            WHERE RPR.ativo = 1 AND perguntas.id IN ($values_string)
	            GROUP BY
                perguntas.id,
                respostas.id
            	ORDER BY
                perguntas.id,
                respostas.id";
        try {
            //var_dump($sql);
            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function countRespostaQ($array, $presidente, $departamento)
    {
        $values_string = implode(',', $array);
        $values_dp = implode(',', $departamento);

        $sql = "SELECT
		         id_tipo_visao AS id_visao,
		         respostas.id AS id_resposta,
	             COUNT (RF.id_resposta) AS total
                 FROM resposta_funcionario RF        
                 INNER JOIN funcionario F ON F.id = RF.id_funcionario ";
        $sql .= " RIGHT JOIN relacao_pergunta_resposta RPR ON RF.id_resposta = RPR.id_resposta and RF.id_pergunta = RPR.id_pergunta
                 LEFT JOIN perguntas perguntas ON perguntas.id = RPR.id_pergunta
                 LEFT JOIN respostas respostas ON respostas.id = RPR.id_resposta
	             WHERE RPR.ativo = 1 AND RF.id_questionario = $values_string ";
        if ($presidente == 1) {
            $sql .= "AND F.id_gestor_direto = 144 ";
        }
        if ($values_dp[0] != '0') {
            $sql .= " AND F.id_departamento IN ($values_dp) ";
        }
        $sql .= " GROUP BY
                 id_tipo_visao,
	             respostas.id
            	 ORDER BY
               	 id_tipo_visao,
	             respostas.id";
        try {

            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function countRespostaQTotal($array)
    {
        //$values_string = implode(',', $array);
        $sql = "SELECT
	x.id_visao,
	x.id_departamento,
	x.id_resposta,
	SUM (total) total
FROM
	(
		SELECT
			id_tipo_visao AS id_visao,
			id_departamento AS id_departamento,
			respostas.id AS id_resposta,
			COUNT (RF.id_resposta) AS total
		FROM
			resposta_funcionario RF
		INNER JOIN funcionario F ON F.id = RF.id_funcionario
		RIGHT JOIN relacao_pergunta_resposta RPR ON RF.id_resposta = RPR.id_resposta
		AND RF.id_pergunta = RPR.id_pergunta
		LEFT JOIN perguntas perguntas ON perguntas.id = RPR.id_pergunta
		LEFT JOIN respostas respostas ON respostas.id = RPR.id_resposta
		WHERE
			RPR.ativo = 1
		AND RF.id_questionario = 1
		GROUP BY
			id_tipo_visao,
			id_departamento,
			respostas.id
		UNION
			SELECT
				relacao_pergunta_resposta.id_visao,
				departamento.id,
				respostas.id,
				0 total
			FROM
				departamento
			INNER JOIN respostas ON 1 = 1
			INNER JOIN relacao_pergunta_resposta ON relacao_pergunta_resposta.id_resposta = respostas.id
			INNER JOIN perguntas ON perguntas.id = relacao_pergunta_resposta.id_pergunta
			WHERE
				relacao_pergunta_resposta.ativo = 1
			AND relacao_pergunta_resposta.id_questionario = 1
			GROUP BY
				relacao_pergunta_resposta.id_visao,
				departamento.id,
				respostas.id
	) AS x
      GROUP BY
	    x.id_visao,
	    x.id_departamento,
	    x.id_resposta
       ORDER BY
        x.id_visao,
        x.id_departamento,
        x.id_resposta";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function countRespostaD($array, $modo, $presidente, $departamento)
    {
        if ($modo == "dimensoes") {
            $string = "modelo_dimensao";
        } elseif ($modo == "praticas") {
            $string = "modelo_praticas";
        }
        $values_dp = implode(',', $departamento);

        $values_string = implode(',', $array);
        $sql = " SELECT x.id_visao, x.id_resposta, x.$string, SUM(total) total
        FROM (
            SELECT perguntas.id id_pergunta,
        respostas.id id_resposta,
        perguntas.$string,
        relacao_pergunta_resposta.id_visao,
        COUNT(resposta_funcionario.id_resposta) total
        FROM respostas
        INNER JOIN relacao_pergunta_resposta ON relacao_pergunta_resposta.id_resposta = respostas.id
        INNER JOIN perguntas ON perguntas.id = relacao_pergunta_resposta.id_pergunta
        LEFT JOIN resposta_funcionario on resposta_funcionario.id_resposta = respostas.id AND resposta_funcionario.id_pergunta = perguntas.id AND resposta_funcionario.id_tipo_visao = relacao_pergunta_resposta.id_visao ";
        if ($presidente == 1 || $values_dp[0] != 0) {
            $sql .= " INNER JOIN funcionario ON funcionario.id = resposta_funcionario.id_funcionario ";
        }
        if ($presidente == 1) {
            $sql .= " AND funcionario.id_gestor_direto = 144 ";
        }
        if ($values_dp[0] != 0) {
            $sql .= " AND funcionario.id_departamento IN ($values_dp) ";
        }
        $sql .= " WHERE perguntas.$string IN ($values_string)
        GROUP BY respostas.id, perguntas.id, perguntas.$string, relacao_pergunta_resposta.id_visao
        UNION
			SELECT
				perguntas.id,
		
		respostas.id id_resposta,
		perguntas.$string,
relacao_pergunta_resposta.id_visao,
		0 total
			FROM
				departamento
			INNER JOIN respostas ON 1 = 1
			INNER JOIN relacao_pergunta_resposta ON relacao_pergunta_resposta.id_resposta = respostas.id
			INNER JOIN perguntas ON perguntas.id = relacao_pergunta_resposta.id_pergunta
			WHERE
				perguntas.$string IN ($values_string)
			GROUP BY
				departamento.id,
				respostas.id,
				perguntas.id,
				perguntas.$string,
				relacao_pergunta_resposta.id_visao
        ) as x
        GROUP BY x.id_visao, x.id_resposta, x.$string
        ORDER BY x.id_visao, x.$string, x.id_resposta";
        try {
            //print_r($sql);
            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_OBJ);
            //var_dump($result);

            return $result;


        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function countRespostaDDP($array, $modo, $presidente)
    {
        if ($modo == "dimensoes") {
            $string = "modelo_dimensao";
        } elseif ($modo == "praticas") {
            $string = "modelo_praticas";
        }

        $values_string = implode(',', $array);
        $sql = "SELECT x.$string, x.id_resposta, x.id_visao,x.id_departamento , SUM(total) total
        FROM (  SELECT 
				funcionario.id_departamento,
				perguntas.id id_pergunta,
        respostas.id id_resposta,
        perguntas.$string,
        relacao_pergunta_resposta.id_visao,
        COUNT(resposta_funcionario.id_resposta) total
        FROM respostas
        INNER JOIN relacao_pergunta_resposta ON relacao_pergunta_resposta.id_resposta = respostas.id
        INNER JOIN perguntas ON perguntas.id = relacao_pergunta_resposta.id_pergunta
        INNER JOIN resposta_funcionario on resposta_funcionario.id_resposta = respostas.id 
				AND resposta_funcionario.id_pergunta = perguntas.id 
				AND resposta_funcionario.id_tipo_visao = relacao_pergunta_resposta.id_visao 
        LEFT JOIN funcionario ON funcionario.id = resposta_funcionario.id_funcionario										
         WHERE perguntas.$string IN ($values_string)
        GROUP BY respostas.id, perguntas.id, perguntas.$string, relacao_pergunta_resposta.id_visao,funcionario.id_departamento
        UNION
        SELECT
            departamento.id,
            perguntas.id id_pergunta,
            respostas.id id_resposta,
            perguntas.$string,
            relacao_pergunta_resposta.id_visao,
        0
	
        FROM
        departamento
        INNER JOIN respostas on 1 = 1
        INNER JOIN relacao_pergunta_resposta ON relacao_pergunta_resposta.id_resposta = respostas.id
        INNER JOIN perguntas ON perguntas.id = relacao_pergunta_resposta.id_pergunta
        
        WHERE
            perguntas.$string IN ($values_string)
        GROUP BY
        departamento.id,
            respostas.id,
            perguntas.id,
            perguntas.$string,
            relacao_pergunta_resposta.id_visao
        ) as x
        GROUP BY x.$string, x.id_departamento ,x.id_visao, x.id_resposta  
        ORDER BY x.$string, x.id_departamento ,x.id_visao, x.id_resposta";
        try {
            //print_r($sql);
            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            $result = $sql->fetchAll(PDO::FETCH_OBJ);
            //var_dump($result);

            return $result;


        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function getTotalPerguntaRespondida($id, $presidente, $departamento)
    {
        $values_dp = implode(',', $departamento);

        $sql = "SELECT count(0) total_respostas FROM resposta_funcionario";
        if ($presidente == 1 || $departamento != 0) {
            $sql .= " INNER JOIN funcionario  ON funcionario.id = resposta_funcionario.id_funcionario ";
        }
        $sql .= " WHERE id_pergunta = :id_pergunta ";
        if ($presidente == 1) {
            $sql .= " AND funcionario.id_gestor_direto = 144 ";
        }
        if ($values_dp[0] != 0) {
            $sql .= " AND funcionario.id_departamento IN ($values_dp) ";
        }
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

    public function countRespostaOP($id, $id_departamento, $presidente)
    {
        //var_dump($id_departamento);
        // $id_departamento = ($id_departamento) ? $id_departamento : "";
        // if ($id_departamento != false) {
        //     $id_departamento;
        // } else {
        //     $id_departamento ="";
        // }
        $values_dp = implode(',', $id_departamento);
        $sql = "SELECT x.id_pergunta,
        x.id_resposta, SUM(total) total from (SELECT
        perguntas.id id_pergunta,respostas.id id_resposta,
        COUNT (resposta_funcionario.id_resposta) total FROM respostas
        INNER JOIN relacao_pergunta_resposta ON relacao_pergunta_resposta.id_resposta = respostas.id
        INNER JOIN perguntas ON perguntas.id = relacao_pergunta_resposta.id_pergunta
        LEFT JOIN resposta_funcionario ON resposta_funcionario.id_resposta = respostas.id
        AND resposta_funcionario.id_pergunta = perguntas.id
        LEFT JOIN  funcionario ON funcionario.id = resposta_funcionario.id_funcionario
        WHERE  perguntas.id = $id";
        if ($values_dp[0] != 0) {
            $sql .= " AND funcionario.id_departamento IN ($values_dp) ";
        }
        if ($presidente == 1) {
            $sql .= " AND funcionario.id_gestor_direto = 144 ";
        }
        $sql .= " GROUP BY
        perguntas.id,
        respostas.id
        UNION ALL
        SELECT
        perguntas.id id_pergunta,respostas.id id_resposta, 0 FROM respostas
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

    public function getEditResposta($avaliacao, $pergunta)
    {
        $sql = "SELECT DISTINCT
                RPR.id_avaliacao,
                P.pergunta,
                RPR.id_pergunta,
                R.id,
                R.resposta
                FROM
                relacao_pergunta_resposta RPR
                LEFT JOIN perguntas P ON P.id = RPR.id_pergunta
                AND P.ativo = 1
                INNER JOIN respostas R ON R.id = RPR.id_resposta
                WHERE
                RPR.ativo = 1
                AND RPR.id_avaliacao = :id_avaliacao
                AND P.id = :id_pergunta
                ORDER BY
                R.id";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_avaliacao", $avaliacao);
            $sql->bindValue(":id_pergunta", $pergunta);
            $sql->execute();
            return $sql->fetchAll();
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function getRespostaQ()
    {
        $sql = "SELECT * FROM
                respostas
                WHERE
                id IN (17, 18, 19, 20, 21)
                AND ativo = 1";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            return $sql->fetchAll();
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function getRespostaQ2()
    {
        $sql = "SELECT * FROM
                respostas
                WHERE
                id NOT IN (17, 18, 19, 20, 21)
                AND ativo = 1";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            return $sql->fetchAll();
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }


}