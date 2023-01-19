<?php 
class Respostas
{
    
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function setResposta($arrayCompleto)
    {
        $respostasArray = [];
        foreach($arrayCompleto as $itens):

        $found_keyP = in_array($itens['IDRESPOSTA'], $respostasArray);
        if (!$found_keyP) {

            $novoArray = [
                'idPergunta' => $itens['IDPERGUNTA'],   
                'idResposta' => $itens['IDRESPOSTA'],
                'resposta' =>   $itens['RESPOSTAS'],
                'tohave' => $itens['TOHAVE'],
                'flag' =>   $itens['FLAG'],
                'questionario' => $itens['IDQUESTIONARIO'],
                'visao' =>  $itens['IDVISAO'],
                                 
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

}