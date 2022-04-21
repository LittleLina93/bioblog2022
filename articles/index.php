<?php

define('ROW_PER_PAGE',3);//constant qui définit le nombre de ligne par page

require "./model.php";

$page= 1;
if(!empty($_GET["page"])) {
    $page = (int)$_GET["page"];
}

$articles_list = getMappedArticles($page);

require "./view.php";


?>