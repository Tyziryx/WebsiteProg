<button class="burger" id="toggleSidebar" aria-label="Menu">&#9776;</button>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        Menu
        <button class="close" id="closeSidebar" aria-label="Fermer">&times;</button>
    </div>
    <nav>
        <ul>
            <li><a href="<?php echo $racine_path . 'dashboard'; ?>">Dashboard</a></li>
            <li><a href="geodex">Geodex</a></li>
            <li><a href="<?php echo $racine_path . 'profil'; ?>">Profil</a></li>
            <li><a href="<?php echo $racine_path . '/models/logout.php'; ?>">Déconnexion</a></li>
        </ul>
    </nav>
</aside>


<script>
    const toggleSidebar = document.getElementById("toggleSidebar");
    const closeSidebar = document.getElementById("closeSidebar");
    const sidebar = document.getElementById("sidebar");

    toggleSidebar.addEventListener("click", () => {
        sidebar.classList.add("active");
    });

    closeSidebar.addEventListener("click", () => {
        sidebar.classList.remove("active");
    });
</script>