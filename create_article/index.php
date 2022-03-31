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
    // sanitize : vient supprimer/le blinder mais ça ne s'afficher pas

    if(sizeof($validations) === 0){
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