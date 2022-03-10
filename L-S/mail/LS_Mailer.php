<?php
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

    public static function sendMail($emailTo, $subject, $template){
        $html2pdf = new Html2Pdf();
        $html2pdf->writeHTML($template);
        // $html2pdf->output('attachment');
        $attachments = array(WP_CONTENT_DIR . '/uploads/text.txt');
        return wp_mail([$emailTo],$subject,$template, null, $attachments);
    }
}

add_filter('wp_mail_content_type', function(){
    return 'text/html';
});