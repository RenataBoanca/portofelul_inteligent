<?php
include 'config.php'; // Include fișierul cu conexiunea la baza de date

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Preia datele trimise din formular
    $nume = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $mesaj = htmlspecialchars($_POST['message']);

    // Determină tipul formularului (contact sau solicitare Excel)
    $tip_formular = '';
    if (isset($_POST['request_excel']) && $_POST['request_excel'] == 'true') {
        $tip_formular = 'Solicitare Excel';
    } else {
        $tip_formular = 'Contact';
    }

    // Interogare pentru a salva datele în tabelul 'mesaje'
    $sql = "INSERT INTO mesaje (nume, email, mesaj, tip_formular) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $nume, $email, $mesaj, $tip_formular);

    if ($stmt->execute()) {
        // Redirect cu mesaj
        header("Location: index.php?mesaj=trimis");
        exit();
    } else {
        echo "A apărut o eroare la trimiterea mesajului.";
    }

    $stmt->close();
}
?>
