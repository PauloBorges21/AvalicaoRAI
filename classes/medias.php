<?php

class Medias
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function calcPeso($tPerguntas, $porIgual)
    {
        if ($porIgual) {
            $array=[];
            for($i= 0 ; $i < $tPerguntas; $i++  ){
                // $auxiliar = $tPerguntas / $tPerguntas;      //Devolve sempre 1
                array_push($array,round(1,2));
            }
            return $array;
        }

        $diff = 1 / $tPerguntas;
        $array = [1];
        $auxiliar = 1.0;
        for($i= 1 ; $i < $tPerguntas; $i++  ){
            $auxiliar = $auxiliar - $diff;
            array_push($array,round($auxiliar,2));

        }
        // var_dump($array);
        return $array;
    }

    public function porcentagemTotal($array, $totalp, $porIgual)
    {
        $result = [];
        $totalRes = 0;
        $porcentagem = 0;
        $peso = $this->calcPeso($totalp, $porIgual);
        $arraySize = sizeof($peso) -1;

        for ($i = 0 ; $i < count($array); $i++) {
            $totalRes += $array[$i];
            $porcentagem += $array[$i] * $peso[$arraySize];
            $arraySize--;
        }

        if($totalRes != 0) {
            $porcentagemF = $porcentagem / $totalRes * 100;
            return $porcentagemF;
        } else {
            return 0;
        }


    }

    public function porcentagemSingularTotal($array, $totalp, $porIgual,$totalR)
    {
        $result = [];
        $totalRes = 0;
        $porcentagem = 0;
        $peso = $this->calcPeso($totalp, $porIgual);
        $value = (is_object($totalR)) ? $totalR->total_respostas : $totalR;
        for ($i = 0 ; $i < count($array); $i++) {
            $totalRes += $array[$i];
            if ($array[$i] == 0) {
                array_push($result, 0);
            } else {
                $porcentagem += $peso[$i] * $array[$i];
                $porcentagemF = $array[$i] / $value * 100;
                array_push($result, $porcentagemF);
                $porcentagem = 0;
                $porcentagemF = 0;
            }
        }
        return $result;
    }
}