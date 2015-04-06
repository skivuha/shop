<?php defined('BOOKS') or die('Access denied');?>
    
            <div id="bookDetails"> 
                <h1><?= $product['book_name']?></h1>
                <div class="productDetails">        
                    <img src="<?=ADMIN_IMG.$product['img']?>">
                </div>
                <div id="detailsText">     
                    <h2>Product Details</h2>
                    <p class="detailsfirst"><b>Author: </b>
                    <?=$product['authors_name']?></p>
                    <p><b>Genre: </b>
                    <?=$product['genre_name']?></p>
                    <p><b>Paperback</b>: 192 pages</p>
                    <p><b>Language:</b> English</p><br>
                </div>
                <div class="reviews"></div>
                <div class="reviewsContent"> 
<?=$product['content']?>
            </div>
            </div>