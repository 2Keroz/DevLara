<?php
session_start();
include './assets/db/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $mail = $_POST['mail'];

    try {
        // Vérifiez si l'email est déjà utilisé
        $stmt = $db->prepare("SELECT * FROM users WHERE mail = :mail");
        $stmt->bindParam(':mail', $mail);
        $stmt->execute();
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            $_SESSION['error_message'] = 'L\'adresse e-mail est déjà utilisée.';
            header("Location: index.php");
            exit();
        }

        // Vérifiez si le nom d'utilisateur est déjà utilisé
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $existingUsername = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUsername) {
            $_SESSION['error_message'] = 'Le nom d\'utilisateur est déjà pris.';
            header("Location: index.php");
            exit();
        }

        // Insérez le nouvel utilisateur
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (username, mail, password) VALUES (:username, :mail, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->execute();

        $_SESSION['success_message'] = 'Le compte a bien été créé.';
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error_message'] = 'Erreur : ' . $e->getMessage();
        header("Location: index.php");
        exit();
    }
}
?>
