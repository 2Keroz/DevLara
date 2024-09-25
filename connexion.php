<?php
session_start();
include './assets/db/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    try {
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Stocke l'ID utilisateur dans la session
            $_SESSION['users_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['logged_in'] = true;
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error_message'] = 'Nom d\'utilisateur ou mot de passe incorrect.';
            header("Location: index.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
        header("Location: index.php");
        exit();
    }
}
?>
