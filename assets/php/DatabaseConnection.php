<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
try {
    $pdo = new PDO('mysql:host=localhost;dbname=coursework;charset=utf8mb4', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Handle connection errors - you might want to log the error or display an error message
    echo 'Connection failed: ' . $e->getMessage();
    die(); // Terminate script execution on connection failure
}