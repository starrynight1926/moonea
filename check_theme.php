<?php
define('WP_USE_THEMES', false);
require('./wp-load.php');
echo "Active Theme Template: " . get_template() . "\n";
echo "Active Theme Stylesheet: " . get_stylesheet() . "\n";
?>
