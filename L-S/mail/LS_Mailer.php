<?php
use Ls\Wp\Log as Log;

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

    public static function sendMail($emailTo, $subject, $template){
        if(class_exists('Spipu\Html2Pdf\Html2Pdf')){
            $html2pdf = new Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'ru', true, 'UTF-8');
            $html2pdf->setDefaultFont('Arial');
            try {
                Log::info('1', '+');
                Logger::log("template:" . $template);
                $html2pdf->writeHTML($template);
                $html2pdf->output(WP_CONTENT_DIR.'/uploads/document.pdf', 'F');
                Log::info('2', '+');
            } catch (Spipu\Html2Pdf\Exception\Html2PdfException $e) {
                $html2pdf->clean();
                Log::info('0', $e->getMessage());
            }
        }
        $attachments = array(WP_CONTENT_DIR . '/uploads/document.pdf');
        $headers = 'From: Краснагорка <info@krasnagorka.by>' . "\r\n";
        return wp_mail([$emailTo],$subject, $template, $headers, $attachments);
    }
}

add_filter('wp_mail_content_type', function(){
    return 'text/html';
});