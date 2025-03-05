<h1>Géodex</h1>
<div class="grid-container">
    <?php
    for ($i = 1; $i <= 25; $i++) {
        $imageIndex = (($i - 1) % 3) + 1; // Permet d'alterner entre image1, image2, image3
        echo "<a href='geodex.php?id=$i'><img src='../images/image$imageIndex.png' alt='Image $i'></a>";
    }
    ?>
</div>
