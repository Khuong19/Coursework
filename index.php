<?php

require_once 'assets/php/function.php';

$pagecount = count($_GET);

// Check if no specific page is requested, then show the homepage
if (!$pagecount) {
    showPage('homepage');
} elseif (isset($_GET['posts'])) {
    showPage('header', ['page_title' => 'Home']);
    showPage('navbar');
    showPage('posts');
} elseif (isset($_GET['admin'])) {
    showPage('header', ['page_title' => 'Admin Dashboard']);
    showPage('navbar');
    showPage('admin');
} elseif (isset($_GET['addpost'])) {
    showPage('header', ['page_title' => 'Add Post']);
    showPage('navbar');
    showPage('addpost');
} elseif (isset($_GET['editProfile'])) {
    showPage('header', ['page_title' => 'Edit Profile']);
    showPage('navbar');
    showPage('editProfile');
} elseif (isset($_GET['editmodule'])) {
    showPage('header', ['page_title' => 'Edit Module']);
    showPage('navbar');
    showPage('editmodule');
} elseif (isset($_GET['sendmail'])) {
    showPage('header', ['page_title' => 'Contact Admin']);
    showPage('navbar');
    showPage('sendmail');
} elseif (isset($_GET['login'])) {
    showPage('header', ['page_title' => 'Login']);
    showPage('login');
} elseif (isset($_GET['signup'])) {
    showPage('header', ['page_title' => 'Sign Up']);
    showPage('signup');
}
