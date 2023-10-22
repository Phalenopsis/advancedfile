<?php


function searchErrors(array $post, array $fields): array
{
    $errors = [];
    // recherche d'erreurs
    foreach ($fields as $field) {
        if (empty(trim($post[$field]))) {
            $errors[$field] = 'Field ' . ucfirst($field) . ' must be completed.';
        } else {
            if ($field == 'age') {
                if (!is_numeric($post[$field])) {
                    $errors[$field] = 'Field Age must be a number.';
                } elseif ($post[$field] < 18) {
                    $errors[$field] = 'Age must be > 18';
                }
            }
        }
    }
    return $errors;
}

function validateAvatar(array $files, array $errors)
{

    if (empty($files['avatar'])) {
        $errors['avatar'][] = 'Uploading file is required.';
    } else {
        /* // chemin vers un dossier sur le serveur qui va recevoir les fichiers uploadés (attention ce dossier doit être accessible en écriture)
        $uploadDir = 'public/uploads/';
        // le nom de fichier sur le serveur est ici généré à partir du nom de fichier sur le poste du client (mais d'autre stratégies de nommage sont possibles)
        $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);
        // Je récupère l'extension du fichier */
        $extension = pathinfo($files['avatar']['name'], PATHINFO_EXTENSION);
        // Les extensions autorisées
        $authorizedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

        $maxFileSize = 1000000;
        // Je sécurise et effectue mes tests
        /****** Si l'extension est autorisée *************/
        if ((!in_array($extension, $authorizedExtensions))) {
            $errors['avatar'][] = 'Veuillez sélectionner une image de type Jpg ou Jpeg ou Png ou webp !';
        }
        /****** On vérifie si l'image existe et si le poids est autorisé en octets *************/
        if (file_exists($files['avatar']['tmp_name']) && filesize($files['avatar']['tmp_name']) > $maxFileSize) {
            $errors['avatar'][] = "Votre fichier doit faire moins de 1M !";
        }
    }
    return $errors;
}

function uploadAvatar(array $post, array $files): array
{

    // traiter les valeurs classiques
    $firstname = htmlentities(trim($post['firstname']));
    $lastname = htmlentities(trim($post['lastname']));
    $age = intval($post['age']);

    // traiter image
    $extension = pathinfo($files['avatar']['name'], PATHINFO_EXTENSION);
    $uploadDir = __DIR__ . '/uploads' . '/';

    $prefix = html_entity_decode($firstname . $lastname . $age);
    $fileName = uniqid($prefix, true) . '.' . $extension;
    $uploadFile = $uploadDir . $fileName;

    // on déplace le fichier temporaire vers le nouvel emplacement sur le serveur. Ça y est, le fichier est uploadé

    move_uploaded_file($files['avatar']['tmp_name'], $uploadFile);
    return ['firstname' => $firstname, 'lastname' => $lastname, 'age' => $age, 'uploadFile' => $fileName];
}
