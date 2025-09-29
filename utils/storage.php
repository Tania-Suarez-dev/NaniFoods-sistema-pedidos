<?php

require_once "uuid.php";
function saveImage($image, $tmp_name, $folder)
{
    global $ROOT_PATH, $APP_NAME;
    $uuid = uuid_v4();
    $image_path = $ROOT_PATH . "/" . $APP_NAME . "/img/$folder";
    echo $image_path;
    if (!is_dir($image_path)) {
        echo "Creando directorio: $image_path";
        mkdir($image_path, 0777, true);
    }
    $nombre_limpio = preg_replace('/[^A-Za-z0-9.\-_]/', '_', $image);
    $carpeta_destino = $image_path . "/" . $uuid . "_" . $nombre_limpio;
    $resultado = move_uploaded_file($tmp_name, $carpeta_destino);
    return $resultado ? "img/$folder/$uuid" . "_" . "$nombre_limpio" : null;
}
////tod0: guardar
//ALTER TABLE productos
//ADD COLUMN activo TINYINT(1) NOT NULL DEFAULT 1,
//ADD COLUMN eliminado TINYINT(1) NOT NULL DEFAULT 0;