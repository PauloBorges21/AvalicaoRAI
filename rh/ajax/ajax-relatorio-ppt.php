<?php
require_once '../../vendor/autoload.php';

use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Slide\SlideLayout;
use PhpOffice\PhpPresentation\Shape\RichText;
use PhpOffice\PhpPresentation\Shape\Drawing;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Border;
use PhpOffice\PhpPresentation\Style\Fill;
use PhpOffice\PhpPresentation\Slide\Background\Color as BackgroundColor;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Paragraph;

spl_autoload_register(function ($class) {
    require '../../classes/' . $class . '.php';
});
$UploadPpt = new Upload();
$excluir = $UploadPpt->excluirImagens();
$data = json_decode(file_get_contents('php://input'), true);

// acessando os objetos enviados na requisição
$imagesObject = $data['imagens'];
$tipo = $data['tipo'];
// criando as imagens e salvando na pasta
$i = 0;

foreach ($imagesObject as $key => $imagem) {
    // Decodificar a imagem em base64 para um arquivo de imagem
    // remover os cabeçalhos do tipo MIME da string em base64
    $data = str_replace('data:image/png;base64,', '', $imagem);
    $imgData = base64_decode($data);
    if ($imgData === false) {
        throw new Exception('Erro ao decodificar a imagem em base64');
    }
    if ($tipo['tipo'] == 1):
        // Escrever o arquivo de imagem
        switch ($i) {
            case 0:
                $fileName = '../img-ppt/0confianca.imagem-' . uniqid() . '.png';
                break;
            case 1:
                $fileName = '../img-ppt/1dimensoes.imagem-' . uniqid() . '.png';
                break;
            case 2:
                $fileName = '../img-ppt/2praticas_culturais.imagem-' . uniqid() . '.png';
                break;
            case 3:
                $fileName = '../img-ppt/3motivo_de_permanencia.imagem-' . uniqid() . '.png';
                break;
            case 4:
                $fileName = '../img-ppt/4feedback.imagem-' . uniqid() . '.png';
                break;
            case 5:
                $fileName = '../img-ppt/5oportunidade.imagem-' . uniqid() . '.png';
                break;
            case 6:
                $fileName = '../img-ppt/6tempo_de_casa.imagem-' . uniqid() . '.png';
                break;
            case 7:
                $fileName = '../img-ppt/7visao_global.imagem-' . uniqid() . '.png';
                break;
        }
    elseif ($tipo['tipo'] == 2):
        switch ($i) {
            case 0:
                $fileName = '../img-ppt/0geral.imagem-' . uniqid() . '.png';
                break;
            case 1:
                $fileName = '../img-ppt/1credibilidade.imagem-' . uniqid() . '.png';
                break;
            case 2:
                $fileName = '../img-ppt/2respeito.imagem-' . uniqid() . '.png';
                break;
            case 3:
                $fileName = '../img-ppt/3imparcialidade.imagem-' . uniqid() . '.png';
                break;
            case 4:
                $fileName = '../img-ppt/4orgulho.imagem-' . uniqid() . '.png';
                break;
            case 5:
                $fileName = '../img-ppt/5camaradagem.imagem-' . uniqid() . '.png';
                break;
        }
    elseif ($tipo['tipo'] == 3):
        switch ($i) {
            case 0:
                $fileName = '../img-ppt/0geral.imagem-' . uniqid() . '.png';
                break;
            case 1:
                $fileName = '../img-ppt/1credibilidade.imagem-' . uniqid() . '.png';
                break;
            case 2:
                $fileName = '../img-ppt/2respeito.imagem-' . uniqid() . '.png';
                break;
            case 3:
                $fileName = '../img-ppt/3imparcialidade.imagem-' . uniqid() . '.png';
                break;
            case 4:
                $fileName = '../img-ppt/4orgulho.imagem-' . uniqid() . '.png';
                break;
            case 5:
                $fileName = '../img-ppt/5camaradagem.imagem-' . uniqid() . '.png';
                break;
            case 6:
                $fileName = '../img-ppt/6camaradagem.imagem-' . uniqid() . '.png';
                break;
            case 7:
                $fileName = '../img-ppt/7camaradagem.imagem-' . uniqid() . '.png';
                break;
            case 8:
                $fileName = '../img-ppt/8camaradagem.imagem-' . uniqid() . '.png';
                break;
        }
    endif;
    $pptData = file_put_contents($fileName, $imgData);
    $i++;
}


// Criar uma nova apresentação
$objPHPPowerPoint = new PhpPresentation();
// Create slide
$currentSlide = $objPHPPowerPoint->getActiveSlide();

$path = '../img-ppt/';
// Buscar todas as imagens na pasta
$images = glob($path . '*.png', GLOB_BRACE);
$j = 0;
foreach ($images as $image) {
    if ($tipo['tipo'] == 1):
        switch ($j) {
            case 0:
                $titulo = "Índice De Confiança";
                break;
            case 1:
                $titulo = "Dimensões";
                break;
            case 2:
                $titulo = "Práticas Culturais";
                break;
            case 3:
                $titulo = "Motivo De Permanência";
                break;
            case 4:
                $titulo = "FeedBack";
                break;
            case 5:
                $titulo = "Oportunidade";
                break;
            case 6:
                $titulo = "Tempo De Casa";
                break;
            case 7:
                $titulo = "Visão Global";
                break;
        }

    elseif ($tipo['tipo'] == 2):
        switch ($j) {
            case 0:
                $titulo = "Geral";
                break;
            case 1:
                $titulo = "Credibilidade";
                break;
            case 2:
                $titulo = "Respeito";
                break;
            case 3:
                $titulo = "Imparcialidade";
                break;
            case 4:
                $titulo = "Orgulho";
                break;
            case 5:
                $titulo = "Camaradagem";
                break;
        }

    elseif ($tipo['tipo'] == 3):
        switch ($j) {
            case 0:
                $titulo = "Contratar E Receber";
                break;
            case 1:
                $titulo = "Inspirar";
                break;
            case 2:
                $titulo = "Falar";
                break;
            case 3:
                $titulo = "Escutar";
                break;
            case 4:
                $titulo = "Agradecer";
                break;
            case 5:
                $titulo = "Desenvolver";
                break;
            case 6:
                $titulo = "Cuidar";
                break;
            case 7:
                $titulo = "Compartilhar";
                break;
            case 8:
                $titulo = "Celebrar";
                break;
        }
    endif;
    if($j == 0) {
        $slide = $currentSlide;
    }else{
        $slide = $objPHPPowerPoint->createSlide();
    }
    
    createPDF($image, $titulo,$slide);
    $j++;
}

// Salvar a apresentação em um arquivo

$dir = '../ppt/';
// Define o nome do arquivo
$filename = 'relatorio' . uniqid() . '.pptx';
$outputFile = $dir . $filename;

// Define o cabeçalho HTTP para download
header('Content-Security-Policy: default-src \'self\';');
header('Content-Type: application/vnd.openxmlformats-officedocument.presentationml.presentation');
header('Content-Disposition: attachment;filename="' . basename($outputFile) . '"');
header('Cache-Control: max-age=0');
$writer = IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
$writer->save($outputFile);
echo $outputFile;

function createPDF($image, $titulo,$slide)
{

// Cria um shape para o título
    // Adiciona a imagem ao slide
    $drawing = new Drawing();
    $drawing->setName('Imagem');
    $drawing->setDescription('Imagem');
    $drawing->setPath($image);
    $drawing->setHeight(600);
    $drawing->setWidth(800);
    $drawing->setResizeProportional(false);
    $drawing->setOffsetX(0);
    $drawing->setOffsetY(100);
    //$drawing->setCoordinates(0, 0);
    $slide->addShape($drawing);

    // Cria um shape para o título
    $shape = $slide->createRichTextShape();
    $shape->setHeight(100);
    $shape->setWidth(800);
    $shape->setOffsetX(0);
    $shape->setOffsetY(0);
    $paragraph = $shape->createParagraph();
    $textRun = $paragraph->createTextRun($titulo);
    $textRun->getFont()->setBold(true);
    $textRun->getFont()->setSize(36);
    $textRun->getFont()->setColor(new Color('38088f'));
    $shape->getFill()->setFillType(Fill::FILL_SOLID)->setStartColor(new Color('000000'));
    $shape->getBorder()->setLineStyle(Border::LINE_SINGLE)->setLineWidth(1)->setColor(new Color('FFFFFF'));
}