<?php 
//Verification constant
define('BOOKS', TRUE);

require_once '../config.php';

require_once 'function/functions.php';

session_start();

//default view
$view = empty($_GET['view']) ? 'main' : $_GET['view'];

switch($view){
    case ('main'):
/*-------------------------NAVIGATION----------------------------*/    
    //parametri navigacii
        $perpage = 6;   // number of book on page
        if(isset($_GET['page'])){
            $page = (int)$_GET['page']; 
            if($page < 1) $page = 1;
        }else{
            $page = 1;
    }
        $count_rows = count_rows(); // number all rows in table book
        $page_count = ceil($count_rows / $perpage); // numbers of pages
        if(!$page_count) $page_count = 1; //give $page_count at least one value
        if($page > $page_count) {$page = $page_count;} // if page more then max
        $start_pos = ($page - 1) * $perpage; // first position in query
        
/*-------------------------MAIN----------------------------*/    
        $booksmain = bookmain($start_pos, $perpage);
    break;

/*-------------------------GENRE----------------------------*/  
// page genre (list genre)
    case ('editgenre'):
        $getGenre = new getAll(genre_name, genre_id, genre);
        $getgenre = $getGenre->getAllData();
    //$getgenre = get_genre();
    break;
// page genre (add genre)   
    case('genre_add'):
    if($_POST){
        $idGenreAdd = new getAll(genre_name, genre_id, genre);
        $id_genge_add = $idGenreAdd->idDataAdd();
        if($id_genge_add) redirect('?view=editgenre');
        else redirect();
    }
    break;
// page genre (edit genre)
    case ('genre_edit'):
        $id = abs((int)$_GET['genre_id']);
        $getGenreID = new getAll(genre_name, $id, genre);
        $get_genre_id = $getGenreID->getDataId($id);
        if($_POST){
            $id_genge_edit = $getGenreID->idDataEdit($id);
            if($id_genge_edit) redirect('?view=editgenre');
            else redirect();
        }
    break;
// page genre (delete genre)
    case('genre_del'):
        $id = abs((int)$_GET['genre_id']);
        $genreDel = new getAll(genre_name, $id, genre);
        $genreDel->idDataDel($id);
        redirect();
    break;
    
/*-------------------------AUTHOR----------------------------*/    
// page author (list author)   
    case ('editauthors'):
    $getAuthor = new getAll(authors_name, authors_id, authors);
    $getauthors = $getAuthor->getAllData();
        //$getauthors = get_authors();
    break;
// page author (add author)    
    case('author_add'):
    if($_POST){
        $idAuthorAdd = new getAll(authors_name, authors_id, authors);
        $id_author_add = $idAuthorAdd->idDataAdd();
        if($id_author_add) redirect('?view=editauthors');
    else redirect();
    }
    break;
// page author (edit author)
    case ('author_edit'):
        $id = abs((int)$_GET['authors_id']);
        $getAuthorID = new getAll(authors_name, $id, authors);
        $get_author_id = $getAuthorID->getDataId($id);
        if($_POST){
            $id_author_edit = $getAuthorID->idDataEdit($id);
            if($id_author_edit) redirect('?view=editauthors');
        else redirect();
        }
    break;
// page author (delete author)    
    case('author_del'):
        $id = abs((int)$_GET['authors_id']);
        $authorDel = new getAll(authors_name, $id, authors);
        $authorDel->idDataDel($id);    

        redirect();
    break;
    
/*-------------------------BOOK----------------------------*/    
// book details    
    case ('details'):
        $book_id = abs((int)$_GET['book_id']);
        if($book_id){
            $product = get_book($book_id);
    }
    break;
//delete book
    case ('delbook'): 
        $book_id = abs((int)$_GET['book_id']);
        del_book($book_id);
        redirect(); 
    break;

//add book    
    case ('addbook'):
    $getGenre = new getAll(genre_name, genre_id, genre);
    $getgenre = $getGenre->getAllData();
    $getAuthors = new getAll(authors_name, authors_id, authors);
    $getauthors = $getAuthors->getAllData();
    if($_POST){
        if(addbook()) redirect('?view=addbook');
    else redirect();
    }
    break;
    
    case ('editbook'):
    $getGenre = new getAll(genre_name, genre_id, genre);
    $getgenre = $getGenre->getAllData();
    $getAuthors = new getAll(authors_name, authors_id, authors);
    $getauthors = $getAuthors->getAllData();

    $book_id = (int)$_GET['book_id'];
    $get_book = get_book_forupdate($book_id);
    $updateimg = addimg($book_id);
    if($get_book['img'] != "no_image.png"){
        $baseimg = '<img src="'.ADMIN_IMG.$get_book['img'].'" class="delimg" width="100px" alt="'.$get_book['img'].'" >';
    }
    
    if($get_book['authors_name']){
        $authorslist = explode(",", $get_book['authors_name']);
        foreach($authorslist as $alist){
            $authorlist .= "<p><input type='checkbox' name='alist[]' value='$alist'>$alist</p>";
        }
    }
     if($get_book['genre_name']){
        $genrelist = explode(",", $get_book['genre_name']);
        foreach($genrelist as $glist){
        $genlist .= "<p><input type='checkbox' name='glist[]' value='$glist'>$glist</p>";
        }
    }
    
    if($_POST['delbaseimg'] == 1){
         $delimg = delimg($book_id);
     }
    
    
    if(!empty($_POST['alist'])){
        $authlist = $_POST['alist'];
        foreach($authlist as $alist){
        $delauth = sel_del_auth($book_id, $alist);
        }
    }
    
    if(!empty($_POST['glist'])){
        $genlist = $_POST['glist'];
        foreach($genlist as $glist){
        $delgen = sel_del_gen($book_id, $glist);
        }
    }
    $edit_book = edit_book($book_id);
    
    if($_POST){
        if(edit_book($book_id)){ 
        redirect('?view=main');
    }else redirect();
    }
    break;
    default:
    $view = 'main';
}

require_once ADMIN_TEMPLATE.'header.php';?>          <!--plugin header-->
<?php require_once ADMIN_TEMPLATE.$view.'.php'?>    <!--plugin content-->
</div>
<?php require_once ADMIN_TEMPLATE.'bottom.php';?>        <!--plugin bottom-->
    </div>
</body>
</html>