<?php
session_start();
require_once("db.php");
if (!empty($_POST['user_login']) && !empty($_POST['user_password'])) {
    $user_login = $_POST['user_login'];
    $user_password = md5($_POST['user_password']);
    $query = mysqli_query($link, "SELECT * FROM users WHERE user_login = '$user_login' AND user_password = '$user_password'");
    $user = mysqli_fetch_assoc($query);
    if (!empty($user)) {
        $_SESSION['auth'] = true;
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_status'] = $user['user_status'];
        if ($_SESSION['user_status'] == '3') {
            header("Location: all_problems.php");
        } else if ($_SESSION['user_status'] == '1') {
            header("Location: admin.php");
        }
    } else {
        $error = "<p class='error'>Неверный логин и/или пароль!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ООО "Ремонт в быту"</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>ООО "Ремонт в быту"</h1>
    </header>
    <nav></nav>
    <main>
        <h2>Авторизация</h2>
        <form action="" method="post">
            <label for="user_login">Логин</label>
            <input type="text" name="user_login" id="user_login">
            <label for="user_password">Пароль</label>
            <input type="password" name="user_password" id="user_password">
            <button>Войти</button>
        </form>
        <?php
        if (isset($error)) {
            echo $error;
        }
        ?>
    </main>
</body>
</html>