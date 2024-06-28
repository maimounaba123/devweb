<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  
  <title>Acceuil</title>
  <link rel="stylesheet" type="text/css" href="./listesdesclients.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
  <nav id="navigation">
    <a href="../acceuil/acceuil.html" class="logo"><img src="Vector.png" style="width: 20%; height: 25%;">  Service<b>Car</b>Link</a>
    <ul class="links">
      <li><a href="./listesdes_rv.php">Liste des rendez-vous</a></li>
      <li><a href="./listesdesclients.php">Liste des clients</a> </li>

      <li class="dropdown"><a href="./profil.php" class="trigger-drop">Profil<i class="arrow"></i></a>
        <ul class="drop">
          <li><a href="./profil.php">Informations personnelles</a></li>
          <li><button onclick="deconnexion()">Déconnexion</button></li>
        </ul>
      </li>
    </ul>
  </nav>

  <div class="title-container">
    <h3>Liste des clients</h3>
  </div>

  <div class="search-container">
    <input type="text" id="searchInput" onkeyup="searchClients()" placeholder="Rechercher...">
    <i class="fas fa-search"></i>
  </div>
  <table id="clientsTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Connexion à la base de données
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "garage"; // Remplacez par le nom de votre base de données

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérifier la connexion
        if ($conn->connect_error) {
            die("La connexion a échoué: " . $conn->connect_error);
        }

        // Requête pour récupérer les clients
        $sql = "SELECT idclient, nom, email FROM clients";
        $result = $conn->query($sql);

        // Vérifier si des résultats sont retournés
        if ($result && $result->num_rows > 0) {
            // Affichage des données dans un tableau HTML
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . (isset($row['idclient']) ? htmlspecialchars($row['idclient']) : '') . '</td>';
                echo '<td>' . (isset($row['nom']) ? htmlspecialchars($row['nom']) : '') . '</td>';
                echo '<td>' . (isset($row['email']) ? htmlspecialchars($row['email']) : '') . '</td>';
                echo '<td>
                        <div class="action-buttons">
                            <a href="./modifierclient.html" class="edit-btn">Modifier</a>
                            <button class="delete-btn">Supprimer</button>
                            <a href="./detailsclient.html?clientId=' . (isset($row['idclient']) ? htmlspecialchars($row['idclient']) : '') . '" class="details-btn">Détails</a>
                        </div>
                      </td>';
                echo '</tr>';
            }
        } else {
            echo "<tr><td colspan='4'>Aucun client trouvé.</td></tr>";
        }

        // Fermer la connexion
        $conn->close();
        ?>
    </tbody>
</table>




  <script>
    function searchClients() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("searchInput");
      filter = input.value.toLowerCase();
      table = document.getElementById("clientsTable");
      tr = table.getElementsByTagName("tr");

      for (i = 1; i < tr.length; i++) { // Skip the header row
        tr[i].style.display = "none"; // Hide all rows by default
        td = tr[i].getElementsByTagName("td");
        for (var j = 0; j < td.length; j++) { // Loop through all table columns
          if (td[j]) {
            txtValue = td[j].textContent || td[j].innerText;
            if (txtValue.toLowerCase().indexOf(filter) > -1) {
              tr[i].style.display = ""; // Show the row if any column matches the search
              break; // Break out of the loop if a match is found
            }
          }
        }
      }
    }

   
  </script>
</body>
</html>
