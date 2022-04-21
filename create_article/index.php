<?php

require "./model.php";
require "../helpers/form-helper.php";
require "../helpers/auth-helper.php";


function validateInputs($inputs){
    $errors = [];
    if(empty(trim($inputs['title']))) {
        $errors['title'] = 'Title is required';        
    }
    if(empty(trim($inputs['content']))) {
        $errors['content'] = 'Content is required';        
    }
    return $errors;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validations = validateInputs($_POST);
    $article = [
        'title' => sanitize_input($_POST['title']),
        'content' => sanitize_input($_POST['content'])
    ];
    // sanitize : vient supprimer/le blinder mais ça ne s'affichera pas

    if(sizeof($validations) === 0){
        if (!empty($_FILES['image']['name'])) {
            $target_dir = '../uploads/'; //dans quel dossier on va sauver les images
            $target_file = $target_dir . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
            $article['image'] = $target_file;
        }
        try {
            insertArticle($article);
            //header('location: ../articles');
            redirect('../articles');
        }
        catch (PDOException $exception){
            echo "Connection erro:". $exception->getMessage();
        }
    }
}

require "./view.php";

?>