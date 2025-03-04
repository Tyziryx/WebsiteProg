<header>
    <!-- Réccupéré sur codepen.io : https://codepen.io/themrsami/details/ogvedxR -->
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo">GÉODEX</div>
            <button class="mobile-nav-toggle" aria-label="Toggle navigation">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>
            <ul class="nav-links">
                <li><a href="<?php echo $racine_path.'index.php';?>">Accueil</a></li>
                <li><a href="<?php echo $racine_path.'control/contact.php';?>">Contact</a></li>
                <li><a href="<?php echo $racine_path.'control/faq.php';?>">FAQ</a></li>

                <!--Lien spécifique pour Geodex--> 
                <li><a href="<?php echo $racine_path . 'app/index.php'; ?>" target="_blank">Geodex</a></li>
            </ul>

        </div>
    </nav>
</header>
