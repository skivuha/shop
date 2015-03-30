<?php
class Palette
{
    private $data;

    function mainPage($arr)
    {
    $data = '';
        foreach($arr as $books)
        {
            $data.='<div align="center" id="contentIndex">';
            $data.='<div id=contenrInfo>';
            $data.='<p><a href="/Home/details/id/'.$books['book_id'].'" class="nameBook">'.$books['book_name'].'</a></p>';
            $data.='<a href="/Home/details/id/'.$books['book_id'].'" class="nameBook"><img src="/lib/views/user_files/img/'.$books['img'].'"></a>';
            $data.='<p><br><span id="priceBook">'.$books['price'].' $</span></p>';
            $data.='<br><p><a href="/Home/details/id/'.$books['book_id'].'" id="detailsBook">Details</a></p>';
            $data.='</div></div>';
        }
        return $data;
    }

    function authorsPage($arr)
    {
        $data = '';
        $data.= '<div id="authors">';
        $data.='<h2>Authors</h2>';
        $data.='<ul class="authorsCol">';
        foreach($arr as $authors)
        {
            $data.='<li><a href="/Home/index/author/'.$authors['authors_id'].'">'.$authors['authors_name'].'</a></li>';
        }
        $data.='</ul></div>';
        return $data;
    }

    function genresPage($arr)
    {
        $data = '';
        $data.= '<div id="genre"> ';
        $data.='<h2>Genre</h2>';
        $data.='<ul class="genreCol">';
        foreach($arr as $genres)
        {
            $data.='<li><a href="/Home/index/genre/'.$genres['genre_id'].'">'.$genres['genre_name'].'</a></li>';
        }
        $data.='</ul></div>';
        return $data;
    }

    function detailsPage($arr)
    {
        $data = '';
        $data.='<div id="bookDetails">';
        $data.='<h1>'.$arr['book_name'].'</h1>';
        $data.='<div class="productDetails">';
        $data.='<img src="/lib/views/user_files/img/'.$arr['img'].'"></div>';
        $data.='<div id="detailsText">';
        $data.='<h2>Product Details</h2>';
        $data.='<p class="detailsfirst"><b>Author: </b>'.$arr['authors_name'].'</p>';
        $data.='<p><b>Genre: </b>'.$arr['genre_name'].'</p>';
        $data.='<p><b>Paperback</b>: 192 pages</p><p><b>Language:</b> English</p><br></div>';
        $data.='<div id="formbuy">          <!--form for mail to admin-->
                    <form method="POST" name="formmail">
                        <p>Quantity
                            <input type="number" autocomplete="off" max="999" min="1" maxlength="3" value="1" name="quantity" class="quantity">
                                <span> pcs.</span></p>
                        <p><label>First name: <input type="text" name="firstname" maxlength="10"></label></p>
                        <p><label>Last name: <input type="text" name="lastname" maxlength="20"></label></p>
                        <p><label for="adress">Adress </label></p>
                            <textarea name="text" cols="33" rows="2" id="adress"></textarea></p>
                    <div><p><input type="submit" name="sendmail" value="Send" id="submitMail"  maxlength="1000"></p></div>
                    </form>
                </div>';
        $data.=$arr['content'].'</div></div>';
        return $data;
    }

    function genrePage($arr)
    {
        $data = '';
        $data.= '<h2><?=$get_authors[0][authors_name]?></h2>';
        foreach($arr as $books) {
            $data .= '<div align="center" id="contentIndex"><div id=contenrInfo>';
            $data .= '<p><a href="?view=details&book_id=<?=$books['book_id']?>" class="nameBook"><?=$books['book_name']?></p>';
            $data .= '<img src="<?=IMG?><?=$books['img']?>"><p></a><br>';
            $data .= '<span id="priceBook"><?=$books['price']?> $</span></p><br>';
            $data .= '<p><a href="?view=details&book_id=<?=$books['book_id']?>" id="detailsBook">Details</a></p>';
            $data .= '</div></div>';
        }
        $data .= '<div class="reviews"></div>';
        $data .= '<div class="pager"></div>';
        return $data;
    }



    function pageNav($page, $page_count)
    {
        $request = $_SERVER['REQUEST_URI'];
        $splits = explode('/', trim($request, '/'));
        $controller = !empty($splits[0]) ? ucfirst($splits[0]) . 'Cntr' : 'Home';
        $action = !empty($splits[1]) ? $splits[1] . 'Action' : 'index';
        $fc = FrontCntr::getInstance();
        $params = $fc->getParams();
        if(!$splits[0])
        {
            $uri = '';
            $uri.="$controller/$action";
        }
        else
        {
            $uri = '';
            $uri.="$splits[0]/$splits[1]";
            foreach($params as $key => $value)
            {
                if($key != 'page' ) $uri .= "/$key/$value";
            }
        }

        // crating of links
        $back = '';
        $forward = '';
        $startpage = '';
        $endpage = '';
        $page2left = '';
        $page1left = '';
        $page2right = '';
        $page1right = '';

        if($page > 1){$back = "<a href='/$uri/page/" .($page-1). "'>&lt;</a>";
        }
        if($page < $page_count){$forward = "<a href='/$uri/page/" .($page+1). "'>&gt;</a>";
        }
        if($page > 3){$startpage = "<a href='/$uri/page/1'>&laquo;</a>";
        }
        if($page < $page_count-2){$endpage = "<a href='/$uri/page/{$page_count}'>&raquo;</a>";
        }
        if($page - 2 > 0){$page2left = "<a href='/$uri/page/" .($page-2). "'>" .($page-2). "</a>";
        }
        if($page - 1 > 0){$page1left = "<a href='/$uri/page/" .($page-1). "'>" .($page-1). "</a>";
        }
        if($page + 2 <= $page_count){$page2right = "<a href='/$uri/page/" .($page+2). "'>" .($page+2). "</a>";
        }
        if($page + 1 <= $page_count){$page1right = "<a href='/$uri/page/" .($page+1). "'>" .($page+1). "</a>";
        }

        $nav = $startpage.$back.$page2left.$page1left.'<a class="navActive">'.$page.'</a>'.$page1right.$page2right.$forward.$endpage;
        return $nav;
    }

}
?>