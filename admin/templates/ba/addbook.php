<?php defined('BOOKS') or die('Access denied');?>
<div id="formreg"> 
    <h2>Add book</h2>
<?php 
if(isset($_SESSION['book_add']['res'])){
    echo $_SESSION['book_add']['res'];}
?>                          
    <!--zakaz book-->
<form action="" method="POST" enctype="multipart/form-data">
<p><label><h4>Book name
<input type="text" name="book_name"></h4></label></p>
<p><label><h4>Price <input type="text" name="price" value="<?=$_SESSION['book_add']['price']?>"></h4></label></p>
    <table id="table_reg">
        <tr>
            <th>
            <Label for='genre_name[]'><p id="btngenre"><h3>Genre</h3></p></Label>
            <select multiple required size="5" name="genre_name[]" class="btngenre">
            <?php foreach($getgenre as $genre): ?>
            <option><?=$genre['genre_name']?></option>
            <?php endforeach; ?>
            </select>
            </th>
            <th>
            <Label for='authors_name[]'><p id="btnauthor"><h3>Author</h3></p></Label>
            <select multiple required size="5" name="authors_name[]" class="btnauthor">
            <?php foreach($getauthors as $authors): ?>
            <option><?=$authors['authors_name']?></option>
            <?php endforeach; ?>
            </select>
            </th>
        </tr>
    </table>
<p><h4>Image</h4> <input type="file" name="baseimg" class="galochka"></p>
<p><label for="content"><h4>Description</h4></label></p>
    <textarea name="content" cols="94" rows="20" id="content"><?=$_SESSION['book_add']['content']?></textarea></p>
    <div><p><input type="submit" name="submit" value="Save" id="submitMail" ></p></div> 
<!--div submit buttom-->
    <p><h4>Show: </h4></p>
    <p><input type="radio" name="visible" value="1" checked="">Yes
    <input type="radio" name="visible" value="0">No</p>
</form>
<?php unset($_SESSION['book_add']['res']); ?>
</div>