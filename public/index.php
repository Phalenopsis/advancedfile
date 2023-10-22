<?php
require __DIR__ . '/../config/twig.php';
require 'validate.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = ['firstname', 'lastname', 'age'];
    $result = [];
    $errors = validateAvatar($_FILES, searchErrors($_POST, $fields));
    if (empty($errors)) {
        $result = uploadAvatar($_POST, $_FILES);
    }
    echo $twig->render('index.html.twig', ['errors' => $errors, 'result' => $result]);
} else {

    echo $twig->render('index.html.twig');
}
