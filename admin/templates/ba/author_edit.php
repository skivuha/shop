<?php defined('BOOKS') or die('Access denied');?>
<h2 class="editGanre">Edit author</h2>
<?php 
if(isset($_SESSION['data_edit']['res'])){
    echo $_SESSION['data_edit']['res'];
    unset($_SESSION['data_edit']['res']);
}
?>
<form action="" method="post">
    Author: <input type="text" name="name" value="<?=htmlspecialchars($get_author_id[authors_name])?>">    
    <p><input type="submit" name="submit" value="Save"></p>
</form>