<?php

View::partial('Head');
View::partial('Navbar');
?>

<main class="container mx-auto p-4 space-y-4">
    <h1 class="text-3xl font-bold text-center text-primary">Welcome to IESMIŅŠ_STUDĒ</h1>
    <p class="text-center">This is a simple student management system built with PHP, MySQL, and DaisyUI.</p>
    <p class="text-center">You can use the navigation bar above to access different pages.</p>
</main>

<?php
View::partial('Footer');
?>