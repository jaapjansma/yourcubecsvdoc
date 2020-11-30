<?php

require 'vendor/autoload.php';

$request = Symfony\Component\HttpFoundation\Request::createFromGlobals();

if ($request->getMethod() == 'POST') {
    // Example data structure below
    // We need to replace this with data coming from a CSV file.
    $data[0]['first_name'] = 'John';
    $data[0]['last_name'] = 'Johnson';
    $data[1]['first_name'] = 'Pete';
    $data[1]['last_name'] = 'Peterson';

    $pdfSmarty = new Smarty();
    $pdfSmarty->setTemplateDir(getcwd().'/templates/');
    $pdfSmarty->setCompileDir(getcwd().'/templates_c/');
    // Assign the data to the template.
    // We should also update the template so the data is shown
    $pdfSmarty->assign('name', 'Tim');
    $pdfSmarty->assign('data', $data);

    $pdfContents = $pdfSmarty->fetch('pdf.tpl');

    $domPdf = new Dompdf\Dompdf();
    $domPdf->loadHtml($pdfContents);
    $domPdf->setPaper('A4', 'portrait');
    $domPdf->render();
    $domPdf->stream("mypdf.pdf", [
        "Attachment" => true
    ]);
} else {
    $smarty = new Smarty();
    $smarty->setTemplateDir(getcwd().'/templates/');
    $smarty->setCompileDir(getcwd().'/templates_c/');

    $smarty->assign('name', 'Tim');

    $smarty->display('index.tpl');
}

?>
