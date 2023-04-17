<?php
class Paginacao
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;

    }
    public function getPagQuestionario($idQuestionario,$id_avaliacao)
    {
        $pagina = filter_input(INPUT_GET, 'avaliacao-pag');

        $pagina = (isset($pagina) ? (int) $pagina : 1); //vamos verificar se existe GET_tarefas na url,Passamos Int para fazer a conta a baixo, caso contrario 1
        $maximo_por_pagina = 100;
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
        AND RPR.id_avaliacao = :id_avaliacao
        ) as x WHERE Row BETWEEN :inicio AND :maximo_por_pagina");
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':inicio', $inicio);
        $sql->bindValue(':maximo_por_pagina', $maximo_por_pagina);
        $sql->bindValue(':id_questionario', $idQuestionario);
        $sql->bindValue(':id_avaliacao', $id_avaliacao);
        $sql->execute();
        return $sql->fetchAll();
    }

    public function ordenarQuestionario()
    {

        $pagina = filter_input(INPUT_GET, 'avaliacao-pag');
        //var_dump($pagina);
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

    public function getPagtbUser($departamento,$ativo)
    {
        $pagina = filter_input(INPUT_GET, 'editar-list-users');
        $pagina = (isset($pagina) ? (int) $pagina : 1); //vamos verificar se existe GET_tarefas na url,Passamos Int para fazer a conta a baixo, caso contrario 1
        $maximo_por_pagina = 10;
        $inicio = (($maximo_por_pagina * $pagina) - $maximo_por_pagina);
        $maximo_por_pagina = 10 * $pagina;
        $departamento = (isset($departamento)) ? $departamento : "";
        $sql = "SELECT * from (SELECT ROW_NUMBER() OVER(ORDER BY f.id , f.id_gestor_direto, d.id ASC) AS row_number
                 ,(SELECT nome FROM funcionario f2 where f2.id = f.id_gestor_direto) AS nome_gerente ,
                  f.*,d.nome as departamento
              FROM funcionario f
              INNER JOIN departamento d ON f.id_departamento = d.id WHERE";
         if($ativo) {
             $sql .= " ativo = 1 ";
                 } else {
             $sql .= " ativo = 0 ";
         }
        if ($departamento != "") {
            $sql .= "AND f.id_departamento = $departamento";
        }
            $sql .= ") x WHERE row_number BETWEEN :inicio AND :maximo_por_pagina";
            $sql = $this->pdo->prepare($sql);

        $sql->bindValue(':inicio', $inicio);
        $sql->bindValue(':maximo_por_pagina', $maximo_por_pagina);
        $sql->execute();
        $result = $sql->fetchAll();
        if ($result != false) {
            return $result;
        } else {
            return false;
        }
    }

    public function getPagtbUserName($nome,$ativo)
    {
        $pagina = filter_input(INPUT_GET, 'editar-list-users');
        $pagina = (isset($pagina) ? (int) $pagina : 1); //vamos verificar se existe GET_tarefas na url,Passamos Int para fazer a conta a baixo, caso contrario 1
        $maximo_por_pagina = 10;
        $inicio = (($maximo_por_pagina * $pagina) - $maximo_por_pagina);
        $maximo_por_pagina = 10 * $pagina;
        $nome = (isset($nome)) ? $nome : "";
        $sql = "SELECT * from (SELECT ROW_NUMBER() OVER(ORDER BY f.id , f.id_gestor_direto, d.id ASC) AS row_number
                 ,(SELECT nome FROM funcionario f2 where f2.id = f.id_gestor_direto) AS nome_gerente ,
                  f.*,d.nome as departamento
              FROM funcionario f
              INNER JOIN departamento d ON f.id_departamento = d.id WHERE";
        if($ativo) {
            $sql .= " ativo = 1 ";
        } else {
            $sql .= " ativo = 0 ";
        }
        if ($nome != "") {
            $sql .= " AND f.nome LIKE '%$nome%'";
        }
        $sql .= ") x WHERE row_number BETWEEN :inicio AND :maximo_por_pagina";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':inicio', $inicio);
        $sql->bindValue(':maximo_por_pagina', $maximo_por_pagina);
        $sql->execute();
        $result = $sql->fetchAll();

        if ($result != false) {
            return $result;
        } else {
            return false;
        }
    }

    public function ordenarTbUser($ativo)
    {

        $pagina = filter_input(INPUT_GET, 'editar-list-users');
        //var_dump($pagina);
        $pagina = (isset($pagina) ? (int) $pagina : 1); //vamos verificar se existe GET_tarefas na url,Passamos Int para fazer a conta a baixo, caso contrario 1
        $maximo_por_pagina = 10;
        //2           1 =  2  -     2 = 0    o Resultado zerado é a primeira posição do array
        $sql = "SELECT COUNT(DISTINCT id) as total FROM funcionario WHERE";
        if($ativo) {
        $sql .= " ativo = 1 ";
    } else {
        $sql .= " ativo = 0 ";
    }
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            $result = $sql->fetch();
            if ($result['total'] > 0) {
                $total_registros = $result['total'];
                $max_link = 3;
                $total_paginas = ceil($total_registros / $maximo_por_pagina);
                if ($total_registros > $maximo_por_pagina) {
                    if ($pagina != 1) {
                        echo '<a href="?editar-list-users=1">Primeira Página</a>';
                    }
                    for ($i = $pagina - $max_link; $i <= $pagina - 1; $i++) {
                        if ($i >= 1) {
                            echo '<a href="?editar-list-users=' . $i . '">' . $i . '</a>';
                        }
                    }
                    echo '<a class="active">' . $pagina . '</a>';
                    for ($i = $pagina + 1; $i <= $pagina + $max_link; $i++) {
                        if ($i <= $total_paginas) {
                            echo '<a href="?editar-list-users=' . $i . '">' . $i . '</a>';
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function ordenarTbUser2($total)
    {
        $c1 = 1;
        $pagina = (isset($c1) ? (int) $c1 : 1); //vamos verificar se existe GET_tarefas na url,Passamos Int para fazer a conta a baixo, caso contrario 1
        $maximo_por_pagina = 8;
        //2           1 =  2  -     2 = 0    o Resultado zerado é a primeira posição do array

        if ($c1 > 0) {
            $total_registros = $total;
            $max_link = 3;
            $total_paginas = ceil($total_registros / $maximo_por_pagina);
            if ($total_registros > $maximo_por_pagina) {
                if ($pagina != 1) {
                    echo '<a href="?editar-list-users=1">Primeira Página</a>';
                }
                for ($i = $pagina - $max_link; $i <= $pagina - 1; $i++) {
                    if ($i >= 1) {
                        echo '<a href="?editar-list-users=' . $i . '">' . $i . '</a>';
                    }
                }
                echo '<a class="active">' . $pagina . '</a>';
                for ($i = $pagina + 1; $i <= $pagina + $max_link; $i++) {
                    if ($i <= $total_paginas) {
                        echo '<a href="?editar-list-users=' . $i . '">' . $i . '</a>';
                    }
                }

            }


        }
    }

    public function getListPerguntas($ativo)
    {
        if ($ativo) {
            $ativo = 1;
        } else {
            $ativo = 0;
        }
        $pagina = filter_input(INPUT_GET, 'editar-list-users');
        $pagina = (isset($pagina) ? (int) $pagina : 1); //vamos verificar se existe GET_tarefas na url,Passamos Int para fazer a conta a baixo, caso contrario 1
        $maximo_por_pagina = 10;
        $inicio = (($maximo_por_pagina * $pagina) - $maximo_por_pagina);
        $maximo_por_pagina = 10 * $pagina;
        $sql = "SELECT * from (
                SELECT *, ROW_NUMBER() OVER(ORDER BY  x.id_pergunta ASC) AS row_number from (
                SELECT DISTINCT
                RPR.id_avaliacao,                
                RPR.id_pergunta,
                P.pergunta,                
                CD.id modelo_dimensao, 
                CP.id modelo_praticas,
                CD.categoria modelo_dimensao_nome,
                CP.categoria modelo_praticas_nome
                FROM relacao_pergunta_resposta RPR
                INNER JOIN perguntas P ON P.id = RPR.id_pergunta AND P.ativo = $ativo
                LEFT JOIN categoria_dimensao CD ON CD.id = P.modelo_dimensao
                LEFT JOIN categoria_pratica CP ON CP.id = P.modelo_praticas
                ) AS x 
                ) AS y WHERE row_number BETWEEN :inicio AND :maximo_por_pagina";
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':inicio', $inicio);
            $sql->bindValue(':maximo_por_pagina', $maximo_por_pagina);
            $sql->execute();
            $result = $sql->fetchAll();
            if ($result != false) {
                return $result;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }

    public function ordenarListPerguntas($ativo)
    {

        $pagina = filter_input(INPUT_GET, 'editar-list-users');
        //var_dump($pagina);
        $pagina = (isset($pagina) ? (int) $pagina : 1); //vamos verificar se existe GET_tarefas na url,Passamos Int para fazer a conta a baixo, caso contrario 1
        $maximo_por_pagina = 10;
        //2           1 =  2  -     2 = 0    o Resultado zerado é a primeira posição do array
        $sql = "SELECT COUNT(DISTINCT id) as total FROM perguntas WHERE";
        if($ativo) {
            $sql .= " ativo = 1 ";
        } else {
            $sql .= " ativo = 0 ";
        }
        try {
            $sql = $this->pdo->prepare($sql);
            $sql->execute();
            $result = $sql->fetch();
            if ($result['total'] > 0) {
                $total_registros = $result['total'];
                var_dump($total_registros);
                $max_link = 3;
                $total_paginas = ceil($total_registros / $maximo_por_pagina);
                if ($total_registros > $maximo_por_pagina) {
                    if ($pagina != 1) {
                        echo '<a href="?editar-list-users=1">Primeira Página</a>';
                    }
                    for ($i = $pagina - $max_link; $i <= $pagina - 1; $i++) {
                        if ($i >= 1) {
                            echo '<a href="?editar-list-users=' . $i . '">' . $i . '</a>';
                        }
                    }
                    echo '<a class="active">' . $pagina . '</a>';
                    for ($i = $pagina + 1; $i <= $pagina + $max_link; $i++) {
                        if ($i <= $total_paginas) {
                            echo '<a href="?editar-list-users=' . $i . '">' . $i . '</a>';
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            echo "{$e->getMessage()}";
        }
    }
}