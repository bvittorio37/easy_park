<?php
nameSpace App\Service;

Use Dompdf\Dompdf;
Use Dompdf\Options;

class PdfService
{
    private $domPdf;

    public function __construct()
    {
        $this->domPdf =  new Dompdf();
        $pdfOptions =new Options();
        $pdfOptions->set('defaultFont', 'Courier');
        $this->domPdf->setOptions($pdfOptions);
    }

    public function showPdfFile($html){
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $this->domPdf->stream("Detailphp", [
            'Attachement'=> false
        ]);
        
    }
    public function genrateBinaryPdf($html){
        $this->domPdf->loadHtml($html);
        $this->ompdf->render();
        $this->ompdf->output();
    }

} 



?>
