<?php defined('BOOKS') or die('Access denied');?>
<h2 class="editGanre">List author</h2>
<?php 
if(isset($_SESSION['answer'])){
    echo $_SESSION['answer'];
    unset($_SESSION['answer']);
}
?>
<a href="?view=author_add" class="addGenre">Add author</a>
<table cellspacing="1" class="tabl">
    <tr>
        <th class="numGenre">N</th>
        <th class="strName">Name</th>
        <th class="str_action">Action</th>
    </tr>
<?php $i=1; ?>
<?php foreach($getauthors as $author): ?>
    <tr class="qwer">
        <td class="nomer"><?=$i?></td>
        <td class="nameGanre"><?=$author['authors_name']?></td>
        <td  class="genreaction"><a href="?view=author_edit&authors_id=<?=$author['authors_id']?>">edit</a>&nbsp; | &nbsp;<a href="?view=author_del&authors_id=<?=$author['authors_id']?>" class="delGenre" onclick="return confirmDelete();">delete</a></td>
    </tr>

<?php $i++; ?>
<?php endforeach; ?>
</table>