<?php 
//Verification constant
defined('BOOKS') or die('Access denied');

//for output book
function bookmain($start_pos, $perpage){
    $query = "SELECT book_id, book_name, img, price, visible FROM books LIMIT $start_pos, $perpage";
    $res = mysql_query($query) or die(mysql_query(Error));
    $booksmain = array();
    while($row = mysql_fetch_assoc($res)){
        $booksmain[]  = $row;
    }
return $booksmain;
}

//count row in table
function count_rows(){
    $query = "SELECT COUNT(book_id) as count_rows FROM books WHERE visible='1'";
    $res = mysql_query($query) or die(mysql_error());
    $count_rows = array();
    while ($row = mysql_fetch_assoc($res)){
        if($row['count_rows']) {
            $count_rows = $row['count_rows'];
        }
    }
return $count_rows;    
}

// nav with param pages and all number of pages
function pagenav($page, $page_count){
    if($_SERVER['QUERY_STRING']) {  // param URL
        $uri ="";
        foreach($_GET as $key => $value){
            //create url whithout number of page. Number of page must param function
            if($key != 'page') $uri .= "{$key}={$value}&amp;";
        }
    }
        // creating of links
        $back = '';
        $forward = '';
        $startpage = '';
        $endpage = '';
        $page2left = '';
        $page1left = '';
        $page2right = '';
        $page1right = '';
        
        if($page > 1){$back = "<a href='?{$uri}page=" .($page-1). "'>&lt;</a>";
                     }
        if($page < $page_count){$forward = "<a href='?{$uri}page=" .($page+1). "'>&gt;</a>";
                     }
        if($page > 3){$startpage = "<a href='?{$uri}page=1'>&laquo;</a>";
                     }
        if($page < $page_count-2){$endpage = "<a href='?{$uri}page={$page_count}'>&raquo;</a>";
                     }
        if($page - 2 > 0){$page2left = "<a href='?{$uri}page=" .($page-2). "'>" .($page-2). "</a>";
                     }
        if($page - 1 > 0){$page1left = "<a href='?{$uri}page=" .($page-1). "'>" .($page-1). "</a>";
                     }
        if($page + 2 <= $page_count){$page2right = "<a href='?{$uri}page=" .($page+2). "'>" .($page+2). "</a>";
                     }
        if($page + 1 <= $page_count){$page1right = "<a href='?{$uri}page=" .($page+1). "'>" .($page+1). "</a>";
                     }
        //show nav
        echo $startpage.$back.$page2left.$page1left.'<a class="navActive">'.$page.'</a>'.$page1right.$page2right.$forward.$endpage;
 }


//filter fo sql query 
function clear($var){
    $var = mysql_real_escape_string($var);
    return $var;
}
// redirect
function redirect($http = false){
    if($http) $redirect = $http;
    else $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    header("Location:".$redirect);
    exit;
}

/*-------------------------GENRE----------------------------*/
//get all genre

class getAll{
    //genre_name, genre_id, genre
    public $name;
    public $id;
    public $tableName;
    
    function __construct($name, $id, $tableName){
        $this->name = $name;
        $this->id = $id;
        $this->tableName = $tableName;
    }
    function getAllData(){
        $name = $this->name;
        $id = $this->id;
        $tableName = $this->tableName;
        $query = "SELECT $name, $id  FROM $tableName";
        $res = mysql_query($query);
        $getgenre = array();
        while($row = mysql_fetch_assoc($res)){
            $getgenre[]  = $row;
        }
    return $getgenre;
    }
    
//get data from ID
    function getDataId($id){
        $name = $this->name;
        $id = $this->id;
        $tableName = $this->tableName;
        $where = $tableName."_id";
        $query = "SELECT $name FROM $tableName WHERE $where=$id";
        $res = mysql_query($query) or die(mysql_query(Error));
        $get_data_id = array();
        $get_data_id = mysql_fetch_assoc($res);
    return $get_data_id;
    }

//page Data(add)
    function idDataAdd(){
        $name = $this->name;
        $id = $this->id;
        $tableName = $this->tableName;
        $newName = trim($_POST['name']);
        if(empty($newName)){
            $_SESSION['data_add']['res'] = "<div class='error'>The field is empty!</div>";
        return false;}
        else{
            $newName = clear($newName); 
            $query = "INSERT INTO $tableName ($name) VALUES ('$newName')";
            $res = mysql_query($query);
            if(mysql_affected_rows() > 0){
                $_SESSION['answer']="<div class='success'>Your genre has add!</div>";
            return true;}
            else{  
                $_SESSION['data_add']['res'] = "<div class='error'>Sorry, something went wrong!</div>";
            return false;}
    }
}
    //page data(edit)
    function idDataEdit($id){
        $name = $this->name;
        $id = $this->id;
        $tableName = $this->tableName;
        $where = $tableName."_id";
        $newName = trim($_POST['name']);
        if(empty($newName)){
            $_SESSION['data_edit']['res'] = "<div class='error'>The field is empty!</div>";
        return false;
        }else{
            $newName = clear($newName);   
        }
        $query = "UPDATE $tableName SET $name='$newName' WHERE $where=$id";
        $res = mysql_query($query);
        if(mysql_affected_rows() > 0){
            $_SESSION['answer']="<div class='success'>Your genre has updated!</div>";
            return true;}
        else{  
            $_SESSION['data_edit']['res'] = "<div class='error'>You do nothing!</div>";
            return false;}
}
    
    //page data(delete)
    function idDataDel($id){
        $name = $this->name;
        $id = $this->id;
        $tableName = $this->tableName;
        $where = $tableName."_id";
        $query = "DELETE FROM $tableName WHERE $where=$id";
        $res = mysql_query($query);
        if(mysql_affected_rows() > 0){
            $_SESSION['answer'] = "<div class='success'>Genre deleted!</div>";
            return true;
        }else{
            $_SESSION['answer'] = "<div class='error'>Sorry, something went wrong!</div>";
            return false;
        }
    } 
}


/*-------------------------BOOK----------------------------*/ 
//details
function get_book($book_id){
    $query = "SELECT DISTINCT book_id, price, book_name, img, content, GROUP_CONCAT(DISTINCT authors_name) as authors_name, GROUP_CONCAT(DISTINCT genre_name) as genre_name FROM books, authors, genre INNER JOIN book_a, book_g WHERE books.book_id = book_a.b_id and authors.authors_id = book_a.a_id and books.book_id = book_g.b_id and genre.genre_id = book_g.g_id and book_id = $book_id GROUP BY book_name";
    $res = mysql_query($query);
    $product = array();
    $product = mysql_fetch_assoc($res);
return $product;
}

//deleting book
function del_book($book_id){
    $query = "DELETE FROM books WHERE book_id = $book_id";
    $res = mysql_query($query);
}

/*-------------------------ADD BOOK----------------------------*/ 
//add book
function addbook() {
    $book_name = trim($_POST['book_name']);
    $price = round(floatval(preg_replace("#,#", ".", $_POST['price'])),2);
    $content = trim($_POST['content']);
    $visible = (int)$_POST['visible'];
    if(empty($book_name)){
        $_SESSION['book_add']['res'] = "<div class='error'>Need name!</div>";
        $_SESSION['book_add']['price'] = $price;
        $_SESSION['book_add']['content'] = $content;
        return false;}
    else{
        $book_name = clear($book_name);
        $content = clear($content);
        $query = "INSERT INTO books (book_name, price, content, visible) VALUES ('$book_name', $price, '$content', '$visible')";
        $res = mysql_query($query);
        if(mysql_affected_rows()>0){
            $id = mysql_insert_id(); // id book
                $types = array("image/gif", "image/png", "image/jpeg", "image/pjpeg", "image/x-png"); // array extensions
                if($_FILES['baseimg']['name']){
                    $baseimgExt = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES['baseimg']['name'])); //extensions image 
                    $baseimgName = "{$id}.{$baseimgExt}"; // new name image
                    $baseingTmpName = $_FILES['baseimg']['tmp_name']; // tmp name image
                    $baseimgType = $_FILES['baseimg']['type']; // type img
                        if(@move_uploaded_file($baseingTmpName, "../user_files/tmp/$baseimgName")){
                            resize("../user_files/tmp/$baseimgName", "../user_files/img/$baseimgName", 210, 316, $baseimgExt);
                            @unlink("../user_files/tmp/$baseimgName");
                            mysql_query("UPDATE books SET img = '$baseimgName' WHERE book_id = $id");
                        }
                }
//Show authors       
    $author_name = $_POST['authors_name'];
        foreach($author_name as $authors_name){
            $res = mysql_query("SELECT authors_id FROM authors WHERE authors_name='$authors_name'");
            $rez = mysql_fetch_assoc($res);
            mysql_query("INSERT INTO book_a (a_id, b_id) VALUES ($rez[authors_id], $id)");
        }
            
//Show genre       
    $genr_name = $_POST['genre_name'];
        foreach($genr_name as $genre_name){
            $res = mysql_query("SELECT genre_id FROM genre WHERE genre_name='$genre_name'");
            $rez = mysql_fetch_assoc($res);
            mysql_query("INSERT INTO book_g (g_id, b_id) VALUES ($rez[genre_id], $id)");
        }        
    $_SESSION['book_add']['res'] .= "<div class='success'>Book added</div>";
    return true;
        }else{
            $_SESSION['book_add']['res'] = "<div class='success'>Sorry, something went wrong!</div>";
            return false;
        }
    }
}

//resize images
function resize($target, $dest, $wmax, $hmax, $ext){
    list($w_orig, $h_orig) = getimagesize($target);
    $ratio = $w_orig / $h_orig;
        if(($wmax / $hmax) > $ratio){
            $wmax = $hmax * $ratio;}
        else{$hmax = $wmax / $ratio;}
    $img = "";
        switch($ext){
            case("gif"):
                $img = imagecreatefromgif($target);
            break;
            case("png"):
                $img = imagecreatefrompng($target);
            break;
            default:
                $img = imagecreatefromjpeg($target);
        }
    $newImg = imagecreatetruecolor($wmax, $hmax);
    if($ext =="png"){
        imagesavealpha($newImg, true);
        $transPng = imagecolorallocatealpha($newImg,0,0,0,127);
        imagefill($newImg,0,0,$transPng);
    }
    imagecopyresampled($newImg, $img, 0, 0, 0, 0, $wmax, $hmax, $w_orig, $h_orig);
    switch($ext){
        case("gif"):
            imagegif($newImg, $dest);
        break;
        case("png"):
            imagepng($newImg, $dest);
        break;
        default:
            imagejpeg($newImg, $dest);
        break;
    }
    imagedestroy($newImg);
}

/*-------------------------EDIT BOOK----------------------------*/ 
//get data book
function get_book_forupdate($book_id){
       $query = "SELECT DISTINCT book_id, price, book_name, img, content, visible, GROUP_CONCAT(DISTINCT authors_name) as authors_name, GROUP_CONCAT(DISTINCT genre_name) as genre_name FROM books, authors, genre INNER JOIN book_a, book_g WHERE books.book_id = book_a.b_id and authors.authors_id = book_a.a_id and books.book_id = book_g.b_id and genre.genre_id = book_g.g_id and book_id = $book_id GROUP BY book_name";
        $res = mysql_query($query);
        $book = array();
        $book = mysql_fetch_assoc($res);
        return $book;
    }

//add image
    function addimg($book_id){
        $id = $book_id; // id book
        $types = array("image/gif", "image/png", "image/jpeg", "image/pjpeg", "image/x-png"); // array extensions
        if($_FILES['baseimg']['name']){
            $baseimgExt = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES['baseimg']['name'])); //extensions image 
            $baseimgName = "{$id}.{$baseimgExt}"; // new name image
            $baseingTmpName = $_FILES['baseimg']['tmp_name']; // tmp name image
            $baseimgType = $_FILES['baseimg']['type']; // type img
            if(@move_uploaded_file($baseingTmpName, "../user_files/tmp/$baseimgName")){
                resize("../user_files/tmp/$baseimgName", "../user_files/img/$baseimgName", 210, 316, $baseimgExt);
                @unlink("../user_files/tmp/$baseimgName");
                mysql_query("UPDATE books SET img = '$baseimgName' WHERE book_id = $id");
            }
        }
                    
    }


//delete image (edit book)
   function delimg($book_id){
       mysql_query("UPDATE books SET img = 'no_image.png' WHERE book_id = $book_id");
   }

//delete authors (edit book)
    function sel_del_auth($book_id, $alist){
        $res = mysql_query("SELECT authors_id FROM authors WHERE authors_name = '$alist'");
        $alist = array();
        $alist = mysql_fetch_assoc($res);
        mysql_query("DELETE FROM book_a WHERE b_id = $book_id AND a_id = $alist[authors_id]");    
    }
//delete genre (edit book)
    function sel_del_gen($book_id, $glist){
        $res = mysql_query("SELECT genre_id FROM genre WHERE genre_name = '$glist'");
        $glist = array();
        $glist = mysql_fetch_assoc($res);
        mysql_query("DELETE FROM book_g WHERE b_id = $book_id AND g_id = '$glist[genre_id]'");    
    }
//обновление данныйх в книге
function edit_book($book_id) {
    $book_name = trim($_POST['book_name']);
    $price = round(floatval(preg_replace("#,#", ".", $_POST['price'])),2);
    $content = trim($_POST['content']);
    $visible = (int)$_POST['visible'];
       
    if(empty($book_name)){
        $_SESSION['book_edit']['res'] = "<div class='error'>Need name!</div>";
        $_SESSION['book_edit']['price'] = $price;
        $_SESSION['book_edit']['content'] = $content;
        return false;}
    else{
        $book_name = clear($book_name);
        $content = clear($content);
        $query = "UPDATE books SET book_name = '$book_name', price = $price, content = '$content' , visible = '$visible' WHERE book_id = $book_id";
        $res = mysql_query($query);
        
//Add authors (edit book)         
        if(!empty($_POST['authors_name'])){
        $author_name = $_POST['authors_name'];
            foreach($author_name as $authors_name){
        $res = mysql_query("SELECT authors_id FROM authors WHERE authors_name='$authors_name'");
        $rez = mysql_fetch_assoc($res);
        mysql_query("INSERT INTO book_a (a_id, b_id) VALUES ($rez[authors_id], $book_id)");
            }
        }
//Add genre (edit book)       
        if(!empty($_POST['genre_name'])){
        $genr_name = $_POST['genre_name'];
            foreach($genr_name as $genre_name){
        $res = mysql_query("SELECT genre_id FROM genre WHERE genre_name='$genre_name'");
        $rez = mysql_fetch_assoc($res);
        mysql_query("INSERT INTO book_g (g_id, b_id) VALUES ($rez[genre_id], $book_id)");
            }
    }}}