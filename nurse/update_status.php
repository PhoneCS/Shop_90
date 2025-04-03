<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $current_status = $_POST['current_status'];

    try {
        $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Toggle employment status
        $new_status = $current_status === 'Unemployed' ? 'Employed' : 'Unemployed';
        $stmt = $pdo->prepare("UPDATE graduates SET employment_status = ? WHERE email = ?");
        $stmt->execute([$new_status, $email]);

        // Redirect back to profile page or wherever you want
        header("Location: index.php"); // ปรับตามที่คุณต้องการ
        exit();

    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }

    $pdo = null;
}
?>
