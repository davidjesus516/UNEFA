<?php
$url = 'https://upload.wikimedia.org/wikipedia/commons/6/6b/Bitmap_escudo_UNEFA.png';
$data = @file_get_contents($url);
if ($data !== false) {
    echo "OK - Se pudo acceder a la imagen remota.";
} else {
    echo "FAIL - No se pudo acceder a la imagen remota.";
}
?>