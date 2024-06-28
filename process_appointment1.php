<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "garage";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion a échoué: " . $conn->connect_error);
}

// Vérifier et récupérer les données du formulaire
if (
    isset($_POST['matricule']) && isset($_POST['model']) && isset($_POST['brand']) &&
    isset($_POST['vehicleType']) && isset($_POST['vehicleSubtype']) && isset($_POST['motif']) &&
    isset($_POST['date']) && isset($_POST['time']) && isset($_POST['color'])
) {
    $matricule = $_POST['matricule'];
    $model = $_POST['model'];
    $brand = $_POST['brand'];
    $vehicleType = $_POST['vehicleType'];
    $vehicleSubtype = $_POST['vehicleSubtype'];
    $motif = $_POST['motif'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $color = $_POST['color'];

    // Mise à jour de l'enregistrement dans la base de données
    $sql = "UPDATE rv SET 
                model = ?, 
                brand = ?, 
                vehicleType = ?, 
                vehicleSubtype = ?, 
                motif = ?, 
                date = ?, 
                time = ?, 
                color = ? 
            WHERE matricule = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssi", $model, $brand, $vehicleType, $vehicleSubtype, $motif, $date, $time, $color, $matricule);

    if ($stmt->execute()) {
        echo "Rendez-vous mis à jour avec succès.";
    } else {
        echo "Erreur lors de la mise à jour du rendez-vous: " . $conn->error;
    }

    // Fermer la connexion
    $stmt->close();
} else {
    echo "Tous les champs du formulaire doivent être remplis.";
}

$conn->close();
?>
