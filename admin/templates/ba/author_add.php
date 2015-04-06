<?php defined('BOOKS') or die('Access denied');?>
<h2 class="editGanre">Add author</h2>
<?php 
if(isset($_SESSION['data_add']['res'])){
    echo $_SESSION['data_add']['res'];
    unset($_SESSION['data_add']['res']);
}
?>
<form action="" method="post">
    Author: <input type="text" name="name">    
    <p><input type="submit" name="submit" value="Save"></p>
</form>