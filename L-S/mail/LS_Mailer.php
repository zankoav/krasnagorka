<?php
use Spipu\Html2Pdf\Html2Pdf;
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
        Log::info('1', '+');
        if(class_exists('Html2Pdf')){
            Log::info('2', '+');
            $html2pdf = new Html2Pdf('P', 'A4', 'ru');
            $html2pdf->setDefaultFont('Arial');
            $html2pdf->writeHTML($template);
            $html2pdf->output(WP_CONTENT_DIR.'/uploads/document.pdf', 'F');
            Log::info('3', '+');
        }
        $attachments = array(WP_CONTENT_DIR . '/uploads/document.pdf');
        $headers = 'From: Краснагорка <info@krasnagorka.by>' . "\r\n";
        return wp_mail([$emailTo],$subject,$template, $headers, $attachments);
    }
}

add_filter('wp_mail_content_type', function(){
    return 'text/html';
});