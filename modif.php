<?php
// Vérifie si des données ont été soumises
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $departement = $_POST['departement'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $username = $_POST['username'];
    
    // Vérifier si le champ motdepass existe et n'est pas vide
    $motdepass = isset($_POST['motdepass']) ? $_POST['motdepass'] : null;
    $hashed_password = !empty($motdepass) ? password_hash($motdepass, PASSWORD_DEFAULT) : null;

    // Connexion à la base de données
    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $dbname = "garage"; // Remplacez par le nom de votre base de données

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("La connexion a échoué: " . $conn->connect_error);
    }

    // Préparer la requête SQL pour la mise à jour en utilisant l'email comme critère
    $sql = "UPDATE clients SET 
                nom = ?, 
                prenom = ?, 
                adresse = ?, 
                Departement = ?, 
                telephone = ?, 
                motdepass = ?
            WHERE email = ?";

    $stmt = $conn->prepare($sql);

    // Vérifier la préparation de la requête
    if ($stmt === false) {
        die("Erreur de préparation de la requête SQL: " . $conn->error);
    }

    // Liage des paramètres et exécution de la requête
    $stmt->bind_param("sssssss", $nom, $prenom, $adresse, $departement, $telephone, $hashed_password, $email);

    // Exécution de la requête
    if ($stmt->execute()) {
        echo "Client mis à jour avec succès.";
    } else {
        echo "Erreur lors de la mise à jour du client: " . $conn->error;
    }

    // Fermeture du statement et de la connexion
    $stmt->close();
    $conn->close();
}
?>
