<?php
require_once 'DatabaseConnection.php';

//function for showing page
function showPage($page, $data=""){
    include("assets/pages/$page.html.php");
}

