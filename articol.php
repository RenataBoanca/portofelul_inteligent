<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Articol</title>
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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

    <main class="blog-article">
    <?php  include 'config.php'; // Include fișierul cu conexiunea la baza de date

        if (isset($_GET['id'])) {
            $article_id = intval($_GET['id']); 
            $query = "SELECT titlu, continut, data_publicarii FROM articole WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $article_id);
            $stmt->execute();
            $stmt->bind_result($titlu, $continut, $data_publicarii);
            $stmt->fetch();
            $stmt->close();
        ?>
        <article>
            <h2><?php echo htmlspecialchars($titlu); ?></h2>
            <p><strong>Publicat pe <?php echo date('d F Y', strtotime($data_publicarii)); ?></strong></p>
            <div><?php echo nl2br(htmlspecialchars_decode($continut)); ?></div>
            <div class="share-buttons">
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" target="_blank">
        <i class="fab fa-facebook"></i> Share
    </a>
    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>&text=<?php echo urlencode($titlu); ?>" target="_blank">
        <i class="fab fa-twitter"></i> Tweet
    </a>
</div>
        </article>

        <aside class="sidebar">
            <div class="related-articles">
                <h3>Articole similare</h3>
                <ul>
                    <?php
                    $related_query = "SELECT id, titlu FROM articole WHERE id != ? ORDER BY RAND() LIMIT 3";
                    $stmt_related = $conn->prepare($related_query);
                    $stmt_related->bind_param("i", $article_id);
                    $stmt_related->execute();
                    $stmt_related->bind_result($related_id, $related_titlu);

                    while ($stmt_related->fetch()) {
                        echo "<li><a href='articol.php?id=$related_id'>" . htmlspecialchars($related_titlu) . "</a></li>";
                    }
                    $stmt_related->close();
                    ?>
                </ul>
            </div>
        </aside>
        <?php
        } else {
            echo "<p>Articolul nu a fost găsit.</p>";
        }
        ?>
    </main>

    <footer>
        <p>&copy; 2025 Portofelul Inteligent | Educație financiară pentru toți</p>
    </footer>

    <script src="js/script.js"></script>
</body>
</html>
