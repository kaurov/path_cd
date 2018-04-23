<?php

declare(strict_types = 1);
include_once './src/Path.php';

$path = new Path('/a/b/c/d');
echo '\n<br />' . $path->cd('../x')->getCurrentPath();
