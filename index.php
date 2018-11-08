<?php

// Base path
$base = dirname(FILE);

// Check web folder
$webPath = $base . '/web/';

if (!is_dir($webPath)) {
    exit('The web directory not found. Attention: Move back  the WEB directory and just remove the install directory. (Do Not remove the WEB directory)');
}

// Check htaccess file
$htPath = $base . '/.htaccess';

if (!is_file($htPath)) {
    exit('The .htaccess file does not exist, Move it back from AutoVM.zip file.');   
}