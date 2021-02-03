<?php
    function LS_setDevice(){
        if(wp_is_mobile()){
            $devise='mobile';
        }   else {
            $devise='desctop';
        } 
        return $devise;    
    }