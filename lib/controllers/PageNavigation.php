<?php
class PageNavigation
{
    function count_rows()
    {
        $query = "SELECT COUNT(book_id) as count_rows FROM books WHERE visible='1'";
        $res = mysql_query($query) or die(mysql_error());
        $count_rows = array();
        while ($row = mysql_fetch_assoc($res)) {
            if ($row['count_rows']) {
                $count_rows = $row['count_rows'];
            }
        }

        return $count_rows;
    }
}
?>