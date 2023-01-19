<?php
class Questionario
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function gravarQuestionario($idUsuario,$idPergunta,$idResposta,$id_questionario,$idVisao)
    {
        
        $sql = "INSERT INTO resposta_funcionario (id_funcionario, id_pergunta, id_resposta, flag_finalizado, id_questionario, id_tipo_visao)
        VALUES (:id_funcionario, :id_pergunta, :id_resposta, :flag_finalizado, :id_questionario, :id_tipo_visao)";
        
        try{
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id_funcionario',$idUsuario);
            $sql->bindValue(':id_pergunta',$idPergunta);
            $sql->bindValue(':id_resposta',$idResposta);
            $sql->bindValue(':flag_finalizado',0);
            $sql->bindValue(':id_questionario',$id_questionario);
            $sql->bindValue(':id_tipo_visao',$idVisao);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                return true;
            }
        } catch (PDOException $e) {
                echo "{$e->getMessage()}";
        }
    }

    public function finalizaQuestionario($idUsuario,$idPergunta,$idRespostaVE,$id_questionario,$idVisao)
    {

        $sql = "UPDATE resposta_funcionario
        SET finalizacao_questionario = GETDATE()
        WHERE id_funcionario = :id_funcionario AND id_pergunta = :id_pergunta AND id_resposta = :id_resposta AND id_tipo_visao = :id_tipo_visao AND id_questionario = :id_questionario";
        
        try{
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id_funcionario',$idUsuario);
            $sql->bindValue(':id_pergunta',$idPergunta);
            $sql->bindValue(':id_resposta',$idRespostaVE);
            $sql->bindValue(':id_questionario',$id_questionario);
            $sql->bindValue(':id_tipo_visao',$idVisao);
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
        try{
            $sql = "SELECT * FROM resposta_funcionario WHERE id_funcionario = :id_funcionario AND flag_finalizado = 0 AND ativo = 1";
            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':id_funcionario', $idUsuario);
            $sql->execute();
            $result = $sql->fetchAll();
            
            if ($result != false) {
              return $result;
            }
        } catch(PDOException $e){
            echo "{$e->getMessage()}";
        }
        

    }
}
