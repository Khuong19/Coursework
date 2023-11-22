<?php
session_start();
include '../php/DatabaseConnection.php';
$user = $_SESSION['user'];
// Retrieve modules from the database
$stmt = $pdo->prepare("SELECT * FROM modules WHERE user_id = ?");
$stmt->execute([$user['user_id']]);
$modules = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display modules in the dropdown
foreach ($modules as $module) {
    echo '<option value="' . $module['module_id'] . '">' . $module['module_name'] . '</option>';
}
?>
