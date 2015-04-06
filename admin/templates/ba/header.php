<?php defined('BOOKS') or die('Access denied');?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Book's</title>
    <link href="<?=ADMIN_TEMPLATE?>style.css" type="text/css" rel="stylesheet">
    <script type="text/javascript" src="<?=ADMIN_TEMPLATE_JS?>scripts.js"></script>

<body>
	<div id="wrapper">             <!--wrapper-->
		<div id="header">             <!--header-->
			<div id="logo"><a href="?view=main"></a></div>    <!--logo-->
            <div id="buy">                   <!--admin-->
                <a class="adminlogin">welcome admin |</a><a href=".." class="adminexit">exit</a>
            </div>
		</div>
        <ul id="menu" >             <!--menu-->
		  <li class="firstMenu"><a href="?view=main">Main</a></li>
		  <li><a href="?view=addbook">Add new book</a></li>
		  <li><a href="?view=editgenre">Genge</a></li>
		  <li><a href="?view=editauthors">Authors</a></li>
			</ul>
		<div id="content">             <!--content-->
			<div id="cornerL"></div>
			<div id="cornerR"></div>