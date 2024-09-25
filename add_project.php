<?php
session_start();

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

// Vérifie si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les données du formulaire
    $titre = trim($_POST['titre']);
    $description = trim($_POST['description']);
    $lien = trim($_POST['lien']);

    // Valide le titre et la description
    if (strlen($titre) > 100 || strlen($description) > 500) {
        die('Le titre ou la description dépasse la longueur maximale.');
    }

    // Valide et télécharge l'image
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Vérifie si le fichier est une image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        die("Le fichier n'est pas une image.");
    }

    // Vérifie l'extension de l'image
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        die("Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.");
    }

    // Crée le répertoire 'uploads' s'il n'existe pas
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Déplace le fichier uploadé vers le répertoire cible
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        die("Désolé, une erreur s'est produite lors du téléchargement de votre fichier.");
    }

    // Prépare la requête SQL
    $sql = "INSERT INTO projets (user_id, titre, description, lien, image) VALUES (:user_id, :titre, :description, :lien, :image)";
    $stmt = $db->prepare($sql);

    // Lie les paramètres
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':lien', $lien, PDO::PARAM_STR);
    $stmt->bindParam(':image', $target_file, PDO::PARAM_STR);

    // Exécute la requête
    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Erreur: " . $stmt->errorInfo()[2];
    }

    $stmt->closeCursor();
    $db = null;
}
?>
