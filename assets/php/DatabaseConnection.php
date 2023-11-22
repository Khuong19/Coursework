<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
$pdo = new PDO('mysql:host=localhost; dbname=coursework; charset=utf8mb4','root', '');