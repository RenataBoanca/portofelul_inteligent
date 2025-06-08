<?php  include 'config.php'; ?>

<!DOCTYPE html>
<html lang="ro">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="img/logo.ico" type="image/x-icon">
    <title>Portofelul Inteligent</title>
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
  <div id="popup-bar" class="popup-bar" style="display:none;">
  Mesajul a fost trimis cu succes!
</div>
    <header>
      <h1>Portofelul Inteligent</h1>
      <nav>
        <!-- Butonul hamburger -->
        <div class="menu-toggle" id="menu-toggle">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </div>
        <ul id="menu" class="menu">
          <li><a href="index.php">Incepe aici</a></li>
          <li><a href="blog.php">Blog Financiar</a></li>
          <li><a href="resources.html">Independenta financiara</a></li>
          <li><a href="about.html">Despre mine</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </nav>
    </header>

    <main>
      <section class="hero">
        <h2>Tu știi câți bani cheltuiești într-o lună?</h2>
        <p>
          Dacă nu ai o evidență clară a cheltuielilor tale, îți poate fi greu să
          îți gestionezi banii eficient. Ceea ce nu măsori, nu poți îmbunătăți!
          Începe prin a analiza raportul dintre veniturile și cheltuielile tale.
        </p>
        <a href="calculator_buget.html" class="btn"
          >Vezi care este ponderea cheltuielilor tale</a
        >
      </section>

      <section class="hero">
        <h2>
          Ai control asupra cheltuielilor, dar nu reușești să economisești?
        </h2>
        <p>
          Gestionarea banilor nu înseamnă doar să îți acoperi cheltuielile, ci
          și să economisești inteligent pentru viitor. Fie că este vorba de un
          fond de urgență, îndeplinirea dorințelor tale pe termen lung sau
          investiții care îți pot crește veniturile, economisirea îți oferă
          siguranță și mai multe oportunități financiare.
        </p>
        <a href="ghid_economisire.html" class="btn"
          >Descoperă ghidurile de economisire</a
        >
      </section>

      <?php  include 'config.php'; // Include fișierul cu conexiunea la baza de date


// Interogarea SQL pentru a prelua datele
$sql = "SELECT id, titlu, continut FROM articole ORDER BY data_publicarii DESC LIMIT 2"; // Afișează ultimele 2 articole

// Execută interogarea
$result = $conn->query($sql);

?>

<section class="latest-posts">
    <h2>Vrei să înveți mai multe despre finanțele personale?</h2>
    <p>
        De la sfaturi despre economisire la strategii de investiții, găsești
        tot ce ai nevoie pentru a-ți îmbunătăți situația financiară.
    </p>
    <?php
    // Verifică dacă există rezultate și le afișează
    if ($result->num_rows > 0) {
        // Parcurge rezultatele și adaugă articolele
        while($row = $result->fetch_assoc()) {
            echo '<article>';
            echo '<h3><a href="articol.php?id=' . $row["id"] . '">' . $row["titlu"] . '</a></h3>';
            echo '<p>' . substr($row["continut"], 0, 150) . '...</p>'; // Afișează doar un fragment din conținut
            echo '</article>';
        }
    } else {
        echo '<p>Nu există articole disponibile în acest moment.</p>';
    }
    ?>
</section>

<?php
// Închide conexiunea
$conn->close();
?>
    </main>

    <footer>
      <p>&copy; 2025 Portofelul Inteligent | Educație financiară pentru toți</p>
    </footer>
    <!-- Adăugarea scriptului JS -->
    <script src="js/script.js"></script>
  </body>
</html>
