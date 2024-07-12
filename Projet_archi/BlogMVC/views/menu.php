<div id="bandeau-menu">
    <ul class="menu">
        <li><a href="index.php">Accueil</a></li>
        <?php if (isset($categories) && is_array($categories)): ?>
            <?php foreach ($categories as $categorie): ?>
                <li><a href="?categorie=<?php echo $categorie['id']; ?>"><?php echo $categorie['libelle']; ?></a></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>
