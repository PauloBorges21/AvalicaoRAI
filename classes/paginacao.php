<?php
class Paginacao
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;

    }
    public function getPagQuestionario($idQuestionario)
    {
        $pagina = filter_input(INPUT_GET, 'avaliacao-pag');
        
        $pagina = (isset($pagina) ? (int) $pagina : 1); //vamos verificar se existe GET_tarefas na url,Passamos Int para fazer a conta a baixo, caso contrario 1
        $maximo_por_pagina = 100 ;        
        $inicio = (($maximo_por_pagina * $pagina) - 99);
        $maximo_por_pagina = 100 * $pagina;
        $sql = ("SELECT * from(SELECT ROW_NUMBER() OVER(ORDER BY RPR.id_pergunta,RPR.id_visao,RPR.id_resposta ASC) AS Row,
        RPR.id_pergunta as IDPERGUNTA,
        RPR.id_resposta as IDRESPOSTA,
        RPR.id_visao as IDVISAO,
        RPR.id_questionario as IDQUESTIONARIO,
        P.pergunta as PERGUNTAS,
        R.resposta as RESPOSTAS        
        FROM relacao_pergunta_resposta RPR      
        INNER JOIN perguntas P ON P.id = RPR.id_pergunta
        INNER JOIN respostas R ON R.id = RPR.id_resposta
        WHERE RPR.id_questionario = :id_questionario AND RPR.ativo = 1
        ) as x
        WHERE Row BETWEEN :inicio AND :maximo_por_pagina");
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':inicio', $inicio);
        $sql->bindValue(':maximo_por_pagina', $maximo_por_pagina);
        $sql->bindValue(':id_questionario', $idQuestionario);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function ordenarQuestionario()
    {

        $pagina = filter_input(INPUT_GET, 'avaliacao-pag');
        $pagina = (isset($pagina) ? (int) $pagina : 1); //vamos verificar se existe GET_tarefas na url,Passamos Int para fazer a conta a baixo, caso contrario 1
        $maximo_por_pagina = 10;

        
        //2           1 =  2  -     2 = 0    o Resultado zerado é a primeira posição do array
        $sql = "SELECT COUNT(DISTINCT id_pergunta) as total FROM relacao_pergunta_resposta WHERE id_questionario = :id_questionario";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(":id_questionario", 1);
            $sql->execute();
            $result = $sql->fetch();
            if ($result['total'] > 0) {
                $total_registros = $result['total'];                
                $max_link = 3;
                $total_paginas = ceil($total_registros / $maximo_por_pagina);                
                if ($total_registros > $maximo_por_pagina) {
                    if ($pagina != 1) {
                        echo '<a href="?avaliacao-pag=1">Primeira Página</a>';
                    }
                    for ($i = $pagina - $max_link; $i <= $pagina - 1; $i++) {                        
                        if ($i >= 1) {
                            echo '<a href="?avaliacao-pag=' . $i . '">' . $i . '</a>';
                        }
                    }
                    echo '<a class="active">' . $pagina . '</a>';
                    for ($i = $pagina + 1; $i <= $pagina + $max_link; $i++) {
                        if ($i <= $total_paginas) {
                            echo '<a href="?avaliacao-pag=' . $i . '">' . $i . '</a>';
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

}