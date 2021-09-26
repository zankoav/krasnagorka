<?php

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
        return wp_mail([$emailTo],$subject,$template);
    }
}

add_filter('wp_mail_content_type', function(){
    return 'text/html';
});