<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Uploads\Upload;

$newImage = new Upload;

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../app/views');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
]);

$title = "Upload form";
$noName = '';
$noFile = '';
$destination = '';
$error = '';

if (isset($_POST['submit'])) {

    if ($_FILES['image']['error'] == 0 && !empty($_POST['name'])) {
        $newImage->upload($_FILES['image'], $_POST['name']);
    } else if ($_FILES['image']['error'] == 4 && !empty($_POST['name'])) {
        $noFile = 'Veuillez choisir un fichier a envoyer';

    } else if ($_FILES['image']['error'] == 0 && empty($_POST['name'])) {
        $noName = 'Veuillez remplir ce champs pour choisir le nom du fichier';

    } else {
        $error = 'Veuillez remplir tous les champs';
    }
} else {
    $_POST['name'] = '';
}

$files = glob('../storage/images/*');


echo $twig->render('index.html', [
    'title' => $title,
    'imgName' => $newImage->newImgName,
    'img' => $newImage->destination,
    'requireFile' => $noFile,
    'requireName' => $noName,
    'required' => $error,
    'standard' => $newImage->error,
    'success' => $newImage->success,
    'galery' => $files
]);


