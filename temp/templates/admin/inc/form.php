<?php defined('BOOKS') or die('Access denied');?> 
<div id="formbuy">          <!--form for mail-->
                    <form action="formmail.php" method="POST" name="formmail">
                        <p>Quantity
                            <input type="number" autocomplete="off" max="999" min="1" maxlength="3" value="1" name="quantity" class="quantity">
                                <span> pcs.</span></p>
                        <p><label>First name: <input type="text" name="firstname" maxlength="10"></label></p>
                        <p><label>Last name: <input type="text" name="lastname" maxlength="20"></label></p>
                        <p><label for="adress">Adress </label></p>
                            <textarea name="text" cols="33" rows="2" id="adress"></textarea></p>
                    <div><p><input type="submit" name="submit" value="Send" id="submitMail" ></p></div> <!--div subbmit button-->
                    </form>
                </div>