<?php


class Dimensoes extends Respostas
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getDimesoes()
    {
        $sql = "SELECT
                CD.categoria modelo_dimensao_nome,
                CP.categoria modelo_praticas_nome
                FROM
                    perguntas P
                INNER JOIN categoria_dimensao CD ON CD.id = P.modelo_dimensao
                AND CD.ativo = 1
                INNER JOIN categoria_pratica CP ON CP.id = P.modelo_praticas
                AND CD.ativo = 1";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            return $sql->fetchAll();
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function setDimensoes($arrayCompleto)
    {
        $dimensoesArray = [];
        foreach ($arrayCompleto as $item):
            $found_keyD = in_array($item['modelo_dimensao_nome'], $dimensoesArray);
            $found_keyP = in_array($item['modelo_praticas_nome'], $dimensoesArray);
            if (!$found_keyP) {
                $novoArray = [
                    'modelo' => $item['modelo_praticas_nome']
                ];
                array_push($dimensoesArray, $novoArray);
            }
            if(!$found_keyD){
                $novoArray2 = [
                    'modelo' => $item['modelo_dimensao_nome']
                ];
                array_push($dimensoesArray, $novoArray2);
            }
            $filterDimensoes = $this->arrayUniqueMultidimensional($dimensoesArray);
        endforeach;
        sort($filterDimensoes);
        return $filterDimensoes;
    }


}