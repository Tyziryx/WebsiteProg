<button class="burger" id="toggleSidebar" aria-label="Menu">&#9776;</button>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        Menu
        <button class="close" id="closeSidebar" aria-label="Fermer">&times;</button>
    </div>
    <nav>
        <ul>
            <li><a href="manage_home">Modifier Home</a></li>
            <li><a href="manage_geodex">Modifier Géodex</a></li>
            <li><a href="manage_users">Modifier Users</a></li>
            <li><a href="manage_faq">Modifier FAQ Users</a></li>
            <li><a href="faq">FAQ</a></li>
            <li><a href="models/logout.php">Déconnexion</a></li>
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