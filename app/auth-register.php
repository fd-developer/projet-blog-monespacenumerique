<?php
require __DIR__ . '/database/database.php';
require_once './includes/functions.php';
$authDB = require_once __DIR__ . '/database/models/security.php';

const ERROR_REQUIRED = 'Veuillez renseigner ce champ';
const ERROR_TOO_SHORT = 'Ce champ est trop court (mini 6 caract.)';
const ERROR_EMAIL_INVALID = "L'email n'est pas valide";
const ERROR_PASSWORD_MISSMATCH = "Les mots de passe sont différents";

$errors = [
    'firstname' => '',
    'lastname' => '',
    'email' => '',
    'password' => '',
    'confirmpassword' => ''
];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $_input = filter_input_array(INPUT_POST, [
        'firstname' => FILTER_SANITIZE_SPECIAL_CHARS,
        'lastname' => FILTER_SANITIZE_SPECIAL_CHARS,
        'email' => FILTER_SANITIZE_EMAIL
    ]);

    $firstname = $_input['firstname'] ?? '';
    $lastname = $_input['lastname'] ?? '';
    $email = $_input['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmpassword = $_POST['confirmpassword'] ?? '';

    if (!$firstname) {
        $errors['firstname'] = ERROR_REQUIRED;
    } elseif (mb_strlen($firstname) < 6) {
        $errors['firstname'] = ERROR_TOO_SHORT;
    }

    if (!$lastname) {
        $errors['lastname'] = ERROR_REQUIRED;
    } elseif (mb_strlen($lastname) < 6) {
        $errors['lastname'] = ERROR_TOO_SHORT;
    }

    if (!$email) {
        $errors['email'] = ERROR_REQUIRED;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = ERROR_EMAIL_INVALID;
    }

    if (!$password) {
        $errors['password'] = ERROR_REQUIRED;
    } elseif (mb_strlen($password) < 6) {
        $errors['password'] = ERROR_TOO_SHORT;
    }

    if (!$confirmpassword) {
        $errors['confirmpassword'] = ERROR_REQUIRED;
    } elseif ($password !== $confirmpassword) {
        $errors['confirmpassword'] = ERROR_PASSWORD_MISSMATCH;
    }

    if (empty(array_filter($errors, fn($e) => $e !== ''))) {
        $authDB->register([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => $password
        ]);

        fct_header('index.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once './includes/head.php' ?>
    <link rel="stylesheet" href="./public/css/auth-register.css">
    <title>Inscription</title>
</head>

<body>
    <div class="container">
        <?php require_once './includes/header.php' ?>
        <div class="content">
            <div class="block p-20 form-container">
                <h1>Inscription</h1>
                <form action="/auth-register.php" , method="POST">
                    <div class="form-control">
                        <label for="title">Prénom</label>
                        <input type="text" name="firstname" id="firstname" value="<?= $firstname ?? '' ?>">
                        <?php if ($errors['firstname']) : ?>
                            <p class="text-danger"><?= $errors['firstname'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="lastname">Nom</label>
                        <input type="text" name="lastname" id="lastname" value="<?= $lastname ?? '' ?>">
                        <?php if ($errors['lastname']) : ?>
                            <p class="text-danger"><?= $errors['lastname'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?= $email ?? '' ?>">
                        <?php if ($errors['email']) : ?>
                            <p class="text-danger"><?= $errors['email'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="password">Mot de passe</label>
                        <input type="text" name="password" id="password">
                        <?php if ($errors['password']) : ?>
                            <p class="text-danger"><?= $errors['password'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-control">
                        <label for="confirmpassword">Confirmez le mot de passe</label>
                        <input type="text" name="confirmpassword" id="confirmpassword">
                        <?php if ($errors['confirmpassword']) : ?>
                            <p class="text-danger"><?= $errors['confirmpassword'] ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="form-action">
                        <a href="/">Annuler</a>
                        <button class="btn btn-primary" type="submit">Valider</button>
                    </div>
                </form>
            </div>
        </div>
        <?php require_once './includes/footer.php' ?>
</body>

</html>