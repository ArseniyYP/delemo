<?php
session_start();
if (empty($_SESSION['auth'])) {
    header("Location: index.php");
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
        <a href="add_problem.php">Подать заявку</a>
        <a href="all_problems.php">Все заявки</a>
        <a href="logout.php">Выйти</a>
    </nav>
    <main>
        <h2>Все заявки</h2>
        <table class="table">
            <tr>
                <th>Номер заявки</th>
                <th>Дата добавления</th>
                <th>Вид техники</th>
                <th>Модель</th>
                <th>Описание проблемы</th>
                <th>ФИО клиента</th>
                <th>Номер телефона</th>
                <th>Статус</th>
            </tr>
            <?php
            require_once("db.php");
            $query = mysqli_query($link, "SELECT * FROM problems WHERE problem_user_id = '$_SESSION[user_id]'");
            while ($row = mysqli_fetch_assoc($query)) {
                echo "<tr>
                        <td>$row[problem_id]</td>
                        <td>$row[problem_date_start]</td>
                        <td>$row[problem_type_item]</td>
                        <td>$row[problem_model_item]</td>
                        <td>$row[problem_description]</td>
                        <td>$row[problem_client_name]</td>
                        <td>$row[problem_phone_number]</td>
                        <td>$row[problem_status]</td>
                    </tr>";
            }
            ?>
        </table>
    </main>
</body>
</html>