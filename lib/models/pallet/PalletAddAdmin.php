<?php
class PalletAddAdmin implements iPallet
{
    private $query;
    private $data;
    private $session;
    private $bookarr;
    private $subs;

    public function index()
{

}

    public function __construct()
    {
        $this->query = new QueryToDb();
        $this->data = DataCont::getInstance();
        $this->session = Session::getInstance();
        $this->subs = new Substitution();
    }

    public function addbook()
    {
        $flag = $this->data->getPost();
        if(true === $flag) {
            $list_param = $this->data->getParam();
            $name = $list_param['book_name'];
            $price = $list_param['price'];
            $content = $list_param['content'];
            $visible = $list_param['visible'];


            $this->query->setBookNew($name, $price, $content, $visible);

            $id = $this->query->getLastId();
            $types = array("image/gif", "image/png", "image/jpeg", "image/pjpeg", "image/x-png"); // array extensions

            if ($_FILES['baseimg']['name']) {
                $baseimgExt = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES['baseimg']['name'])); //extensions image
                $baseimgName = "{$id}.{$baseimgExt}"; // new name image
                $baseingTmpName = $_FILES['baseimg']['tmp_name']; // tmp name image
                $baseimgType = $_FILES['baseimg']['type']; // type img

                if (move_uploaded_file($baseingTmpName, "/user_files/tmp/$baseimgName")) {
                    $this->resize("/user_files/tmp/$baseimgName", "/user_files/img/$baseimgName", 210, 316, $baseimgExt);
                    @unlink("/user_files/tmp/$baseimgName");

                    $this->query->setImgNew($baseimgName, $id);
                }
            }
//Show authors
            if (isset($list_param['authors_name'])) {
                $author_name = $list_param['authors_name'];
                foreach ($author_name as $authors_name) {
                    $rez = $this->query->getAuthorsList($authors_name);
                    $id_a = $rez[0]['authors_id'];
                    $this->query->setAuthorToBook($id_a, $id);
                }
            }
//Show genre
            if (isset($list_param['genre_name'])) {
                $genr_name = $list_param['genre_name'];
                foreach ($genr_name as $genre_name) {
                    $rez = $this->query->getGenresList($genre_name);
                    $id_g = $rez[0]['genre_id'];
                    $this->query->setGenreToBook($id_g, $id);
                }
            }
            header('Location: '.PATH.'Admin/index/');
        }
        else
        {
            $this->bookarr['LISTAUTHORS'] = $this->listAuthors();
            $this->bookarr['LISTGANRE'] = $this->listGenre();
            $data = $this->subs->templateRender('templates/admin/addAdmin.html', $this->bookarr);
        }
        return $data;
    }

    private function listAuthors()
    {
        $authors = $this->query->getAuthorsName();
        $data = '';
        foreach($authors as $val)
        {
            $data.='<option>'.$val['authors_name'].'</option>';
        }
        return $data;
    }

    private function listGenre()
    {
        $authors = $this->query->getGenresName();
        $data = '';
        foreach($authors as $val)
        {
            $data.='<option>'.$val['genre_name'].'</option>';
        }
        return $data;
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
}
?>