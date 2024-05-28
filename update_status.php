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
        <h2>Изменить статус заявки</h2>
        <form action="" method="post">
            <table>
                <tr>
                    <td><label for="problem_id">Номер заявки</label></td>
                    <td><input type="text" name="problem_id" id="problem_id"></td>
                </tr>
                <tr>
                    <td>Сменить статус заявки</td>
                    <td><select name="problem_status" id="problem_status">
                        <option value="новая заявка">новая заявка</option>
                        <option value="в процессе ремонта">в процессе ремонта</option>
                        <option value="ожидание запчастей">ожидание запчастей</option>
                        <option value="завершена">завершена</option>
                    </select></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button>Исправить</button></td>
                </tr>
            </table>
        </form>
        <?php
        require_once("db.php");
        if (!empty($_POST['problem_id']) && !empty($_POST['problem_status'])) {
            $problem_id = $_POST['problem_id'];
            $problem_status = $_POST['problem_status'];
            $_SESSION['status'] = $_POST['problem_status'];
            $result = mysqli_query($link, "UPDATE problems SET problem_status = '$problem_status' WHERE problem_id = '$problem_id'");
            if ($problem_status == 'завершена') {
                $result_1 = mysqli_query($link, "UPDATE problems SET problem_date_end = NOW(), 
                problem_time_diff = TIMEDIFF(problem_date_end, problem_date_start) WHERE problem_id = '$problem_id'");
            } else {
                $result_2 = mysqli_query($link, "UPDATE problems SET problem_date_end = NULL, 
                problem_time_diff = '00:00:00' WHERE problem_id = '$problem_id'");
            }
            if ($result == 'true') {
                $_SESSION['change_status'] = "Статус заказа " . $problem_id . " изменен на: " . $_SESSION['status'];
                header("Location: admin.php");
            } else {
                echo "<p class='error'>Ошибка при изменении!</p>";
            }
        }
        ?>
    </main>
</body>
</html>