<?php
require('../../fpdf/fpdf.php');
$imagesObject = json_decode(file_get_contents('php://input'));

// Criar um novo objeto FPDF
$pdf = new FPDF('L','mm',"A4");

// Percorrer as imagens do objeto e adicioná-las ao PDF
foreach ($imagesObject as $key => $imagem) {    
  // Decodificar a imagem em base64 para um arquivo de imagem
  // remover os cabeçalhos do tipo MIME da string em base64
  $data = str_replace('data:image/png;base64,', '', $imagem);
  
  $imgData = base64_decode($data);  
  if ($imgData === false) {
    throw new Exception('Erro ao decodificar a imagem em base64');
  }

  // Escrever o arquivo de imagem
  $fileName = '../img-r/imagem-'.uniqid().'.png';
  //echo $fileName; var_dump($imagem);
  $pdfData = file_put_contents($fileName, $imgData);  
  //echo $pdfData;
  if ($pdfData === false) {
    throw new Exception('Erro ao escrever o arquivo de imagem');
  }  
  // Adicionar a imagem ao PDF
  $pdf->AddPage();
  $pdf->Image($fileName); 
  
}

$nomeArquivo = '../img-r/imagem-'.uniqid().'.pdf';

// Gerar o PDF e enviar para o navegador
$pdf->Output('F', $nomeArquivo, true); 

echo $nomeArquivo;
?>