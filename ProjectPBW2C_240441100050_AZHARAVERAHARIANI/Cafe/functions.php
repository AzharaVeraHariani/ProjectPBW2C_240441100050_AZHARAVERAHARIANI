<?php
function renderMenuCards($menus) {
    foreach ($menus as $menu) {
        echo "<div class='menu-card'>";
        echo "<h3>{$menu['nama']}</h3>";
        echo "<p>Rp " . number_format($menu['harga'], 0, ',', '.') . "</p>";
        echo "</div>";
    }
}
?>
