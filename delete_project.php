
<?php
session_start();
include './assets/db/config.php';

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

// Vérifie si l'ID du projet est passé en paramètre
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de projet manquant.");
}

$project_id = $_GET['id'];

// Prépare la requête pour supprimer le projet
try {
    $sql = "DELETE FROM projets WHERE id = :id AND user_id = :user_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $project_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $_SESSION['users_id'], PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Projet supprimé avec succès!";
    } else {
        echo "Erreur: " . $stmt->errorInfo()[2];
    }

    // Redirection vers le dashboard
    header("Location: dashboard.php");
    exit();

} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}

?>
