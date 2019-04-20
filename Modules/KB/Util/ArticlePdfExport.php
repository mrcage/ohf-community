<?php

namespace Modules\KB\Util;

use Illuminate\Support\Facades\Config;

class ArticlePdfExport
{
    public static function createPDF($title, $content)
    {
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
        ]);
        $mpdf->showImageErrors = true;

        // Header
        $mpdf->SetHTMLHeader('
        <div style="text-align: right; font-weight: bold;">
            ' . Config::get('app.name') . ' - ' . __('kb::kb.knowledge_base') . '
        </div>');

        // Footer
        $mpdf->SetHTMLFooter('
        <table width="100%">
            <tr>
                <td width="33%">{DATE j-m-Y}</td>
                <td width="33%" align="center">{PAGENO}/{nbpg}</td>
                <td width="33%" style="text-align: right;">' . $title . '</td>
            </tr>
        </table>');

        // Style
        $style = '
            body { 
                font-family: Helvetica; 
            }
        ';
        $mpdf->WriteHTML($style, \Mpdf\HTMLParserMode::HEADER_CSS);

        // Content
        
        // Make image paths relative
        $content = str_replace('src="/', 'src="./', $content);
        
        $mpdf->WriteHTML($content);
        
        $mpdf->Output($title . '.pdf', \Mpdf\Output\Destination::DOWNLOAD);
    }
}