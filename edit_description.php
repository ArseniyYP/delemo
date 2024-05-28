<?php
session_start();
if (empty($_SESSION['auth'])) {
    header("Location: index.php");
}
if ($_SESSION['user_status'] != '1') {
    header("all_problems.php");
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
    <nav>
        <a href="admin.php">Главная</a>
        <a href="add_problem.php">Подать заявку</a>
        <a href="add_worker.php">Добавить исполнителя</a>
        <a href="update_status.php">Изменить статус заявки</a>
        <a href="edit_description.php">Изменить описание проблемы</a>
        <a href="add_comment.php">Добавить комментарий</a>
        <a href="logout.php">Выйти</a>
    </nav>
    <main>
        <h2 class="admin_panel">Панель администратора</h2>
        <h2>Изменить описание проблемы</h2>
        <form action="" method="post">
            <table>
                <tr>
                    <td><label for="problem_id">Номер заявки</label></td>
                    <td><input type="text" name="problem_id" id="problem_id"></td>
                </tr>
                <tr>
                    <td><label for="problem_description">Изменить описание</label></td>
                    <td><textarea name="problem_description" id="problem_description"></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button>Исправить</button></td>
                </tr>
            </table>
        </form>
        <?php
        require_once("db.php");
        if (!empty($_POST['problem_id']) && !empty($_POST['problem_description'])) {
            $problem_id = $_POST['problem_id'];
            $problem_description = $_POST['problem_description'];
            $result = mysqli_query($link, "UPDATE problems SET problem_description = '$problem_description' WHERE problem_id = '$problem_id'");
            if ($result == 'true') {
                header("Location: admin.php");
            } else {
                echo "<p class='error'>Ошибка при изменении!</p>";
            }
        }
        ?>
    </main>
</body>
</html>