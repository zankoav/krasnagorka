
<?php
    define("CID_FIELD_ID", "634173");
    define("TAGS_AVAILIBLE", ["1156623"]);
    define("STATUSES_AVAILIBLE", [
        "19518940" => "ПОДТВЕРДИТЬ БРОНИРОВАНИЕ"
    ]);
    
    function getAvailibleTag($tags){
        $tagName = null;
        foreach($tags as $tag) {
            if (in_array($tag["id"], TAGS_AVAILIBLE)) {
                $tagName = $tag["name"];
                break;
            }
        }
        return $tagName;
    }

    function getCid($fields){
        $cid = null;
        foreach($fields as $field) {
            if ($field["id"] === CID_FIELD_ID) {
                $cid = $field["values"][0]["value"];
               break;
            }
        }
        return $cid;
    }
    
    
    function gaSendData($data) {
    	$getString = 'https://ssl.google-analytics.com/collect';
    	$getString .= '?payload_data&';
    	$getString .= http_build_query($data);
    	$result = wp_remote_get($getString);
    	return $result;
    }

    //Send Pageview Function for Server-Side Google Analytics
    function ga_send_pageview($statusName,$cid, $hostname=null, $page=null, $title=null) {
    	$data = array(
    		'v' => 1,
    		'tid' => 'UA-85853604-1', //@TODO: Change this to your Google Analytics Tracking ID.
    		'cid' => $cid,
    		't' => 'pageview',
    		'cd1'=> $statusName,
    		'dh' => $hostname, //Document Hostname "gearside.com"
    		'dp' => $page, //Page "/something"
    		'dt' => $title //Title
    	);
    	gaSendData($data);
    }

    //Send Event Function for Server-Side Google Analytics
    function ga_send_event($statusName, $cid, $category=null, $action=null, $label=null) {
    	$data = array(
    		'v' => 1,
    		'tid' => 'UA-85853604-1', //@TODO: Change this to your Google Analytics Tracking ID.
    		'cid' => $cid,
    		't' => 'event',
    		'cd1'=> $statusName,
    		'ec' => $category, //Category (Required)
    		'ea' => $action, //Action (Required)
    		'el' => $label //Label
    	);
    	gaSendData($data);
    }
    
    if(!empty($_POST["leads"] and !empty($_POST["leads"]["update"] and !empty($_POST["leads"]["update"][0])))){
        
        $offer = $_POST["leads"]["update"][0];
        
        if($offer["name"] === "Сделка с сайта" ){
            
            $tagName = getAvailibleTag($offer["tags"]);
            $cid = getCid($offer["custom_fields"]);
            $statusName = STATUSES_AVAILIBLE[$offer["status_id"]];
            
            if(!empty($tagName) and !empty($statusName) and !empty($cid)){
                ga_send_event($statusName, $cid, 'amocrm', 'changestate');
                $file = 'people.txt';
                file_put_contents($file, json_encode(array("OK",$tagName, $statusName, $cid), JSON_UNESCAPED_UNICODE));
            }else{
                $file = 'people.txt';
                file_put_contents($file, json_encode(array("ERROR",$tagName, $statusName, $cid), JSON_UNESCAPED_UNICODE));
            }
        }
    }
    
    wp_die();