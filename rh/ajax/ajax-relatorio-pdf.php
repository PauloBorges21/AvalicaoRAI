<?php
require('../../fpdf/fpdf.php');
$imagesObject = json_decode(file_get_contents('php://input'));

// Criar um novo objeto FPDF
$pdf = new FPDF('L','mm',"A4");

// Definir um contador
$i = 0;
foreach ($imagesObject as $key => $imagem) {
// Percorrer as imagens do objeto e adicioná-las ao PDF
//quantidades de imagens gráficos


  // Decodificar a imagem em base64 para um arquivo de imagem
  // remover os cabeçalhos do tipo MIME da string em base64
  $data = str_replace('data:image/png;base64,', '', $imagem);
  $imgData = base64_decode($data);
  if ($imgData === false) {
    throw new Exception('Erro ao decodificar a imagem em base64');
  }
  // Escrever o arquivo de imagem
        switch ($i) {
            case 0:
                $fileName = '../img-r/confianca.imagem-'.uniqid().'.png';
                break;
            case 1:
                $fileName = '../img-r/dimensoes.imagem-'.uniqid().'.png';
                break;
            case 2:
                $fileName = '../img-r/praticas_culturais.imagem-'.uniqid().'.png';
                break;
            case 3:
                $fileName = '../img-r/motivo_de_permanencia.imagem-'.uniqid().'.png';
                break;
            case 4:
                $fileName = '../img-r/feedback.imagem-'.uniqid().'.png';
                break;
            case 5:
                $fileName = '../img-r/oportunidade.imagem-'.uniqid().'.png';
                break;
            case 6:
                $fileName = '../img-r/tempo_de_casa.imagem-'.uniqid().'.png';
                break;
        }
  // Adicionar a imagem ao PDF
    $pdfData = file_put_contents($fileName, $imgData);

    //echo $pdfData;
    if ($pdfData === false) {
        throw new Exception('Erro ao escrever o arquivo de imagem');
    }
    $pdf->AddPage();
    $pdf->Image($fileName);
    $i++;
}
$nomeArquivo = '../img-r/imagem-'.uniqid().'.pdf';
// Gerar o PDF e enviar para o navegador
$pdf->Output('F', $nomeArquivo, true);
echo $nomeArquivo;
?>