<?php defined('BOOKS') or die('Access denied');?>
<div id="formreg"> 
    <h2>Edit book</h2>
<form action="" method="POST" enctype="multipart/form-data">
<p><label><h4>Book name
<input type="text" name="book_name" value="<?=htmlspecialchars($get_book['book_name'])?>"></h4></label></p>
<p><label><h4>Price <input type="text" name="price" value="<?=$get_book['price']?>"></h4></label></p>
<table id="table_reg">
    <tr>
        <th>
            <Label for='genre_name[]'><p id="btngenre"><h3>Add genre</h3></p></Label>
            <select multiple size="5" name="genre_name[]" class="btngenre">
                <?php foreach($getgenre as $genre): ?>
                <option><?=$genre['genre_name']?></option>
                <?php endforeach; ?>
            </select>
        </th>
        <th>
            <Label for='authors_name[]'><p id="btnauthor"><h3>Add author</h3></p></Label>
            <select multiple size="5" name="authors_name[]" class="btnauthor">
                <?php foreach($getauthors as $authors): ?>
                <option><?=$authors['authors_name']?></option>
                <?php endforeach; ?>
            </select>
        </th>
        <th><div class="authors_reg">
            <p><h3>Delete author</h3></p>
            <?=$authorlist?>
            </div>
        </th>
        <th><div class="genre_reg">
            <p><h3>Delete genre</h3></p>
            <?=$genlist?>
            </div>
        </th>
    </tr>
</table>
<div class="img_reg">
<div  class="img_reg_l"><p><?=$baseimg?></p></div>
<div  class="img_reg_r">
<p><h4>Choose file</h4></p>
<p><input type="file" name="baseimg" class="galochka"></p>
<p><h4>For delete image put checker</h4> <input type="checkbox" name="delbaseimg" value="1" class="galochka"></p></div>
</div>
<div class="reviews"></div>
<p><label for="content"><h4>Description</h4></label></p>
<textarea name="content" cols="94" rows="20" id="content"><?=$get_book['content']?></textarea></p>
<div><p><input type="submit" name="submit" value="Save" id="submitMail" ></p></div> 
<!--div submit bottom-->
<p><h4>Show: </h4></p>
    <p><input type="radio" name="visible" value="1" <?php if($get_book['visible']) echo 'checked=""'; ?>>Yes
    <input type="radio" name="visible" value="0" <?php if(!$get_book['visible']) echo 'checked=""'; ?>>No</p>
</form>
</div>