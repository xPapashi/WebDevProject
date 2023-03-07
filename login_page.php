<?php

session_start();

$is_invalid = false;
$error_message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/db.php";

    $sql = sprintf("SELECT * FROM users WHERE email = '%s'", $mysqli->real_escape_string($_POST["email"]));

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    var_dump(password_hash($_POST['password'], PASSWORD_DEFAULT));

    if ($user) {
        if (password_verify($_POST["password"], $user["password"]) &&
            $user["authorisation"] == "1") {
            session_start();

            session_regenerate_id();

            $_SESSION["user_id"] = $user["id"];

            header("Location: index.php");
            exit;
        } else if ($user["authorisation"] == "0") {
            $error_message = "You need to be authorised!";
            $is_invalid = true;
        } else if ($_POST["password"] != $user["password"] || 
                    $_POST['email'] != $user['email']){
            $error_message = "Invalid Login!";
            $is_invalid = true;
        } 
    }
} else if (isset($_SESSION["user_id"])) {
    header("Location: index.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Main Page</title>
    <link rel="stylesheet" href="./style/login_style.css" />
    <script src="./js/app.js" defer></script>
    <script src="https://kit.fontawesome.com/031c7b0341.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="loginContainer">
        <?php if ($is_invalid) : ?>
            <em><?= htmlspecialchars($error_message) ?></em>
        <?php endif; ?>
        <h1><u>Login</u></h1>
        <form method="post">
            <div class="email">
                <div class="label1">
                    <label for="email">
                        <h2>E-mail:</h2>
                    </label>
                </div>
                <div class="emailInput">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" id="email" name="email" placeholder="example@email.com" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" />
                </div>
            </div>
            <br /><br />
            <div class="password">
                <div class="label2">
                    <label for="password">
                        <h2>Password:</h2>
                    </label>
                </div>
                <div class="passwordInput">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" id="password" name="password" placeholder="password123" />
                </div>
            </div>
            <br />
            <input class="submitButton" type="submit" name="submit" id="submit" />
        </form>
    </div>
</body>
</html>