<?php

    $from = $_POST['from'];
    $to = $_POST['to'];
    $seasonId = $_POST['season-id'];

    if(isset($_POST['season-generator'], $from, $to, $seasonId)){
        echo 'ok';
    }
?>
<div class="wrap">
    <h1 class="wp-heading">Seasons generator</h1>
    <form action="" method="POST">
        <input type="date" name="from" readonly/>
        <input type="date" name="to" readonly/>
        <input type="hidden" name="season-id" readonly/>
        <input type="submit" name="season-generator" value="Create"/>
    </form>
</div>