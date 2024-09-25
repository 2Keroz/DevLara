<?php
// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

// Inclure le fichier de connexion à la base de données
include './assets/db/config.php';

// Vérifiez que l'ID utilisateur est bien défini
if (!isset($_SESSION['users_id']) || empty($_SESSION['users_id'])) {
    die("Erreur: utilisateur non identifié.");
}

$user_id = $_SESSION['users_id'];

try {
    // Prépare la requête SQL pour récupérer les projets de l'utilisateur
    $stmt = $db->prepare("SELECT * FROM projets WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    // Récupère tous les projets
    $projets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($projets)) {
        $message = "Aucun projet trouvé.";
    }

} catch (PDOException $e) {
    $message = "Erreur: " . $e->getMessage();
}

// Ferme la connexion
$db = null;
?>
