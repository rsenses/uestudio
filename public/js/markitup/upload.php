<?php

//error_reporting(E_ALL | E_STRICT);
//ini_set('display_errors', E_ALL | E_STRICT);
function reemplazo($url = null)
{
    //Reemplazamos caracteres especiales latinos en Mayúscula por culpa de un bug con strtolower
    $table = [
        'Á' => 'A',
        'Ç' => 'c',
        'É' => 'e',
        'Í' => 'i',
        'Ñ' => 'n',
        'Ó' => 'o',
        'Ú' => 'u',
        'á' => 'a',
        'ç' => 'c',
        'é' => 'e',
        'í' => 'i',
        'ñ' => 'n',
        'ó' => 'o',
        'ú' => 'u',
    ];
    $url = strtr($url, $table);
    //Añadimos los guiones
    $url = strtolower(trim($url));
    $url = preg_replace('/[^a-z0-9.-]/', '-', $url);
    $url = preg_replace('/-+/', '-', $url);

    return $url;
    unset($url, $table);
}
/* The following is a very basic PHP script to handle the upload. One might also
 * resize the image (send back the *new* size!) or save some image info to a
 * database. Remember that you can modify the widget to include any data you'd like
 * submitted along with the uploaded image.
 */
if ($_FILES['inline_upload_file']['type'] == 'image/jpeg' || $_FILES['inline_upload_file']['type'] == 'image/gif' || $_FILES['inline_upload_file']['type'] == 'image/pjpeg' || $_FILES['inline_upload_file']['type'] == 'image/png') {
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/images/';
    $response['type'] = 'image';
} else {
    $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/files/';
    $response['type'] = 'file';
}
$name = reemplazo(basename($_FILES['inline_upload_file']['name']));
$upload_path = $upload_dir . $name;

$response = [];

if (move_uploaded_file($_FILES['inline_upload_file']['tmp_name'], $upload_path)) {
    $info = getimagesize($upload_path);

    $response['status'] = 'success';
    $response['width'] = $info[0];
    $response['height'] = $info[1];
    $response['src'] = substr(realpath($upload_path), strlen(realpath($_SERVER['DOCUMENT_ROOT'])));
} else {
    $response['status'] = 'error';
    $response['msg'] = $_FILES['inline_upload_file']['error'];
}
echo json_encode($response);
