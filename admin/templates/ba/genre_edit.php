<?php defined('BOOKS') or die('Access denied');?>
<h2 class="editGanre">Edit genre</h2>
<?php 
if(isset($_SESSION['data_edit']['res'])){
    echo $_SESSION['data_edit']['res'];
    unset($_SESSION['data_edit']['res']);
}
?>
<form action="" method="post">
    Genre: <input type="text" name="name" value="<?=htmlspecialchars($get_genre_id[genre_name])?>">    
    <p><input type="submit" name="submit" value="Save"></p>
</form>