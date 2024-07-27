<?php

namespace App;

use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;

class MPDFPrint
{
    public static function download(object $pdfObject, string $fileName)
    {
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];

        $options = [
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P',
            'debug' => config('app.debug'),
            'tempDir' => storage_path('app/public/temp'),
            'default_font_size' => 11,
            'defaultCssFile' => public_path('/css/print.css'),
            'margin_top' => 24,
            'margin_right' => 12,
            'margin_footer' => 12,
            'margin_left' => 12,
            'default_font' => 'freeserif',
            // 'fontDir'           => array_merge($fontDirs, [
            //     public_path('fonts'),
            // ]),
            // 'fontdata'          => $fontData + [
            //     'BreeSerif' => [
            //         'R' => 'BreeSerif-Regular.ttf',
            //     ],
            //     'OpenSans' => [
            //         'R' => 'OpenSans-Regular.ttf',
            //         'I' => 'OpenSans-Italic.ttf',
            //     ],
            //     'Roboto' => [
            //         'R' => 'Roboto/Roboto-Regular.ttf',
            //         'I' => 'Roboto/Roboto-Italic.ttf',
            //     ],
            //     'SourceSerifPro' => [
            //         'R' => 'SourceSerifPro-Regular.ttf',
            //         'I' => 'SourceSerifPro-Italic.ttf',
            //     ],
            //     'Ubuntu' => [
            //         'R' => 'Ubuntu-Regular.ttf',
            //         'I' => 'Ubuntu-Italic.ttf',
            //     ],
            // ],
        ];

        $options = array_merge($options, $pdfObject->options());

        // dd($options);

        $pdf = new Mpdf($options);

        if (method_exists($pdfObject, 'headerView')) {
            $pdf->SetHTMLHeader($pdfObject->headerView());
        }

        if (method_exists($pdfObject, 'footerView')) {
            $pdf->SetHTMLFooter($pdfObject->footerView());
        }

        $pdf->WriteHTML($pdfObject->view());
        $pdf->showImageErrors = config('app.debug');

        return $pdf->Output($fileName, 'I');
    }
}
