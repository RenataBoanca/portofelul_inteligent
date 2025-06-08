<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portofelul_inteligent";

// Crearea conexiunii
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificarea conexiunii
if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}

// Obținerea articolelor din baza de date
$sql = "SELECT id, titlu, continut FROM articole ORDER BY data_publicarii DESC LIMIT 5";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ro">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blog - Portofelul Inteligent</title>
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <header>
      <h1>Portofelul Inteligent</h1>
      <nav>
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
      <section class="blog-posts" style="font-size: 0.9em">
        <h2>Articole recente</h2>
        <?php while ($row = $result->fetch_assoc()): ?>
          <article>
            <h3><a href="articol.php?id=<?php echo $row['id']; ?>"><?php echo $row['titlu']; ?></a></h3>
            <p><?php echo substr($row['continut'], 0, 127) . '...'; ?></p>
          </article>
        <?php endwhile; ?>
      </section>
    </main>
    
    <footer>
      <p>&copy; 2025 Portofelul Inteligent | Educație financiară pentru toți</p>
    </footer>
    
    <script src="js/script.js"></script>
  </body>
</html>

<?php $conn->close(); ?>
