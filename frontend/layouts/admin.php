<?php

View::partial('Head');
View::partial('Navbar');


?>
<body class="bg-base-200 min-h-screen flex flex-col ">
    <?= $content ?>
</body>



<?php
View::partial('Footer');
?>