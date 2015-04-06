<?php defined('BOOKS') or die('Access denied');?>
<h2 class="editGanre">List genre</h2>
<?php 
if(isset($_SESSION['answer'])){
    echo $_SESSION['answer'];
    unset($_SESSION['answer']);
}
?>
<a href="?view=genre_add" class="addGenre">Add genre</a>
<table cellspacing="1" class="tabl">
    <tr>
        <th class="numGenre">N</th>
        <th class="strName">Name</th>
        <th class="str_action">Action</th>
    </tr>
<?php $i=1; ?>
<?php foreach($getgenre as $genre): ?>
    <tr class="qwer">
        <td class="nomer"><?=$i?></td>
        <td class="nameGanre"><?=$genre['genre_name']?></td>
        <td  class="genreaction"><a href="?view=genre_edit&amp;genre_id=<?=$genre['genre_id']?>">edit</a>&nbsp; | &nbsp;<a href="?view=genre_del&amp;genre_id=<?=$genre['genre_id']?>" class="delGenre" onclick="return confirmDelete();">delete</a></td>
    </tr>

<?php $i++; ?>
<?php endforeach; ?>
</table>