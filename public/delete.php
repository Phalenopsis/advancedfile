<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $file = htmlentities(trim($_POST['delete']));
        if (file_exists($file)) {
            unlink($file);
        }
    }
}
header('location: /');
