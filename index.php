<?php
require 'db.php';
require 'Slim/Slim.php';


$app = new Slim();


$app->get('/', 'Depan');


$app->run();


/* METHOD GET DISINI */
/* ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function Depan() {
  echo "Halaman Depan";
}


?>
