<?php
if(isset($_POST['season-generator'], $_POST['from'], $_POST['to'])){
    echo 'Hello';
}
?>
<div class="wrap">
    <h1 class="wp-heading">Seasons generator</h1>
    <form action="" action="POST">
        <input type="date" name="from" readonly/>
        <input type="date" name="to" readonly/>
        <input type="submit" name="season-generator" value="Create"/>
    </form>
</div>