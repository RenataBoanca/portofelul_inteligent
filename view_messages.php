<?php
// Conectare la baza de date
$servername = "localhost";
$username = "root"; // Modifică dacă ai un alt utilizator
$password = ""; // Dacă ai o parolă, adaug-o aici
$database = "portofelul_inteligent";

// Creare conexiune
$conn = new mysqli($servername, $username, $password, $database);

// Verificare conexiune
if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}

// Preluare mesaje din baza de date
$sql = "SELECT id, nume, email, mesaj, data_trimitere FROM mesaje_contact ORDER BY data_trimitere DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesaje Contact</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Mesaje Primite</h1>
    </header>

    <main>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nume</th>
                <th>Email</th>
                <th>Mesaj</th>
                <th>Data</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . htmlspecialchars($row["nume"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                    echo "<td>" . nl2br(htmlspecialchars($row["mesaj"])) . "</td>";
                    echo "<td>" . $row["data_trimitere"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Nu există mesaje.</td></tr>";
            }
            ?>
        </table>
    </main>

    <footer>
        <p>&copy; 2025 Portofelul Inteligent | Educație financiară pentru toți</p>
    </footer>
</body>
</html>

<?php
// Închidere conexiune
$conn->close();
?>
