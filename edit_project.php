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

// Prépare la requête pour récupérer les données du projet
try {
    $stmt = $db->prepare("SELECT * FROM projets WHERE id = :id AND user_id = :user_id");
    $stmt->bindParam(':id', $project_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $_SESSION['users_id'], PDO::PARAM_INT);
    $stmt->execute();
    $projet = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$projet) {
        die("Projet non trouvé.");
    }
} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre']);
    $description = trim($_POST['description']);
    $lien = trim($_POST['lien']);

    // Valide les nouvelles données
    if (strlen($titre) > 100 || strlen($description) > 500) {
        die('Le titre ou la description dépasse la longueur maximale.');
    }

    // Prépare et exécute la mise à jour
    try {
        $sql = "UPDATE projets SET titre = :titre, description = :description, lien = :lien WHERE id = :id AND user_id = :user_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':lien', $lien, PDO::PARAM_STR);
        $stmt->bindParam(':id', $project_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $_SESSION['users_id'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Projet modifié avec succès!";
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Erreur: " . $stmt->errorInfo()[2];
        }
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
}

$db = null;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le Projet</title>
</head>
<body>
    <header>
    <header>
        <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <a href="deconnexion.php">Se déconnecter</a>
    </header>
    <main>
        <h2>Modifier le Projet</h2>
        <form action="edit_project.php?id=<?php echo htmlspecialchars($projet['id']); ?>" method="POST">
            <div>
                <label for="titre">Titre du projet:</label>
                <input type="text" name="titre" id="titre" value="<?php echo htmlspecialchars($projet['titre']); ?>" maxlength="100" required>
            </div>
            <div>
                <label for="description">Description:</label>
                <textarea name="description" id="description" maxlength="500" required><?php echo htmlspecialchars($projet['description']); ?></textarea>
            </div>
            <div>
                <label for="lien">Lien vers le projet:</label>
                <input type="url" name="lien" id="lien" value="<?php echo htmlspecialchars($projet['lien']); ?>" required>
            </div>
            <button type="submit">Modifier le projet</button>
        </form>
    </main>
</body>
</html>
