<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "garage";

// Connexion
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Récupérer l'ID de l'administrateur à afficher (par exemple à partir d'un paramètre GET)
if (isset($_GET['id'])) {
    $admin_id = $_GET['id'];

    // Préparer et exécuter la requête SQL pour récupérer les informations de l'administrateur
    $sql = "SELECT * FROM administrateur WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $admin_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier s'il y a des résultats
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Détails de l'administrateur</title>
            <!-- Inclure vos styles CSS ici -->
        </head>
        <body>
            <h1>Détails de l'administrateur</h1>
            <table>
                <tr>
                    <th>ID</th>
                    <td><?php echo htmlspecialchars($admin['id']); ?></td>
                </tr>
                <tr>
                    <th>Nom d'utilisateur</th>
                    <td><?php echo htmlspecialchars($admin['username']); ?></td>
                </tr>
                <tr>
                    <th>Nom</th>
                    <td><?php echo htmlspecialchars($admin['nom']); ?></td>
                </tr>
                <tr>
                    <th>Prénom</th>
                    <td><?php echo htmlspecialchars($admin['prenom']); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($admin['email']); ?></td>
                </tr>
                <tr>
                    <th>Téléphone</th>
                    <td><?php echo htmlspecialchars($admin['telephone']); ?></td>
                </tr>
                <tr>
                    <th>Adresse</th>
                    <td><?php echo htmlspecialchars($admin['adresse']); ?></td>
                </tr>
                <tr>
                    <th>Rôle</th>
                    <td><?php echo htmlspecialchars($admin['role']); ?></td>
                </tr>
            </table>
            <!-- Ajouter d'autres éléments HTML et styles CSS selon vos besoins -->
        </body>
        </html>
        <?php
    } else {
        echo "Aucun administrateur trouvé avec cet ID.";
    }

    // Fermer la connexion et les statements
    $stmt->close();
    $conn->close();
} else {
    echo "ID de l'administrateur non spécifié.";
}
?>
