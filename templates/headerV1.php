<header>
    <!-- Réccupéré sur codepen.io : https://codepen.io/themrsami/details/ogvedxR -->
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">Géodex</div>
            <button class="mobile-nav-toggle" aria-label="Toggle navigation">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>
            <ul class="nav-links">
                <?php
                // Récupérer la page actuelle
                $current_page = $_GET['page'] ?? 'home';

                // Tableau des pages avec leurs liens
                $pages = [
                    'home' => 'Accueil',
                    'contact' => 'Contact',
                    'faq' => 'FAQ',
                ];

                // Parcourir les pages pour générer les liens
                foreach ($pages as $page => $label) {
                    $active_class = ($current_page == $page) ? 'active' : ''; // Ajouter la classe active si c'est la page actuelle
                    echo "<li class=\"$active_class\"><a href=\"index.php?page=$page\">$label</a></li>";
                }

                // Lien spécifique pour Geodex
                echo '<li><a href="../app/index.php" target="_blank">Geodex</a></li>';
                ?>
            </ul>
        </div>
    </nav>
</header>
