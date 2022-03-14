<?php
use Ls\Wp\Log as Log;
use Spipu\Html2Pdf\Html2Pdf;

class LS_Mailer {

    public static function getTemplate($templatePath, $data){
        ob_start();
        get_template_part(
            $templatePath, 
            null,
            ['data' => $data]
        );
        $template = ob_get_contents();
        ob_end_clean();
        return $template;
    }

    public static function sendMail($emailTo, $subject, $template, $checkType, $data){
        $checkType = 'ok';
        if(!empty($checkType) && $emailTo == 'zankoav@gmail.com'){

            $checkHTML = self::generateCheck($checkType, $data);

            $html2pdf = new Html2Pdf('P', 'A4', 'ru', true, 'UTF-8', 0);
            // $html2pdf->setDefaultFont('Arial');
            try {
                    Log::info('1', '+');
                    $html2pdf->writeHTML($checkHTML);
                    $html2pdf->output(WP_CONTENT_DIR.'/uploads/document.pdf', 'F');
                    Log::info('2', '+');
            
            } catch (Spipu\Html2Pdf\Exception\Html2PdfException $e) {
                $html2pdf->clean();
                Log::info('0', $e->getMessage());
            }
        }
        $attachments = array(WP_CONTENT_DIR . '/uploads/document.pdf');
        $headers = 'From: Краснагорка <info@krasnagorka.by>' . "\r\n";
        $result = wp_mail([$emailTo], $subject, $template, $headers, $attachments);
        unlink(WP_CONTENT_DIR . '/uploads/document.pdf');
        return $result;
    }

    private static function generateCheck($checkType, $data){
        $result = "<page style='font-family:freeserif'>
        <table>
        <tbody>
        <tr>
        <td colspan='2' class='title'>ПОДТВЕРЖДЕНИЕ БРОНИРОВАНИЯ</td>
        </tr>
        </tbody>
        </table>
        </page>
        ";
        return $result;
    }
}

add_filter('wp_mail_content_type', function(){
    return 'text/html';
});