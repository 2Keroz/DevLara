<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

include "./show_projects.php";
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./assets/css/dashboard.css">
    <title>Dashboard - Ajouter un Projet</title>
</head>

<body>
    <header>
        <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <a href="deconnexion.php">Se déconnecter</a>
    </header>
    <main>
        <div class="add_project">
            <h2>Ajouter un nouveau projet</h2>
            <form action="add_project.php" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="image">Image du projet (JPEG, PNG, GIF):</label>
                </div>
                <div>
                    <input type="file" name="image" id="image" accept="image/jpeg, image/png, image/gif" required>
                </div>
                <div>
                    <label for="titre">Titre du projet:</label>
                </div>
                <div>
                    <input type="text" name="titre" id="titre" maxlength="100" required>
                </div>
                <div>
                    <label for="description">Description:</label>
                </div>
                <div>
                    <textarea name="description" id="description" maxlength="500" required></textarea>
                </div>
                <div>
                    <label for="lien">Lien vers le projet:</label>
                </div>
                <div>
                    <input type="url" name="lien" id="lien" required>
                </div>
                <button type="submit">Ajouter le projet</button>
            </form>
        </div>
        <div class="projects">
            <h2>Mes Projets</h2>
            <div class="my_project">
                <?php if (isset($message)): ?>
                    <p><?php echo htmlspecialchars($message); ?></p>
                <?php else: ?>
                    <?php foreach ($projets as $projet): ?>
                        <div class="project">
                            <img src="<?php echo htmlspecialchars($projet['image']); ?>" alt="<?php echo htmlspecialchars($projet['titre']); ?>" class="project-image">
                            <h3><?php echo htmlspecialchars($projet['titre']); ?></h3>
                            <p><?php echo htmlspecialchars($projet['description']); ?></p>
                            <div class="buttons">
                                <button><a href="<?php echo htmlspecialchars($projet['lien']); ?>" target="_blank">Voir le projet</a></button>
                                <button><a href="edit_project.php?id=<?php echo htmlspecialchars($projet['id']); ?>">Modifier</a></button>
                                <button><a href="delete_project.php?id=<?php echo htmlspecialchars($projet['id']); ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet?');">Supprimer</a></button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <footer>
        <!-- Contenu du pied de page -->
    </footer>
</body>

</html>