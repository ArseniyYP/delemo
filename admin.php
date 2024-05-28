<?php
session_start();
if (empty($_SESSION['auth'])) {
    header("Location: index.php");
}
if ($_SESSION['user_status'] != '1') {
    header("all_problems.php");
}
require_once("db.php");
$counter = mysqli_query($link, "SELECT COUNT(*) AS count FROM problems WHERE problem_status = 'завершена'");
$result_1 = mysqli_fetch_assoc($counter);
$count = $result_1['count'];

if ($count >= 0) {
    $avg_time = mysqli_query($link, "SELECT ROUND(AVG(TIME_TO_SEC(problem_time_diff))) AS time_in_sec
    FROM problems WHERE problem_status = 'завершена'");
    $result_2 = mysqli_fetch_assoc($avg_time);
    $get_time = $result_2['time_in_sec'];
    $time_format = timeFormat($get_time);
}

function timeFormat($seconds) {
    $hours = $seconds / 3600;
    $minutes = $seconds % 3600 / 60;
    $seconds = $seconds % 60;
    return sprintf("%02d часов %02d минут %02d секунд", $hours, $minutes, $seconds);
}

// $statistic = mysqli_query($link, "SELECT COUNT(CASE WHEN problem_type = 'не включается' THEN 1 END)
// AS count_problem_1, COUNT(CASE WHEN problem_type = 'нехарактерные звуки' THEN 1 END) AS count_problem_2
// FROM problems");
// $result_3 = mysqli_fetch_assoc($statistic);
// $stat_1 = $statistic['count_problem_1'];
// $stat_2 = $statistic['count_problem_2'];
// Это для подсчета неисправностей
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
        <a href="add_problem_admin.php">Подать заявку</a>
        <a href="add_worker.php">Добавить исполнителя</a>
        <a href="update_status.php">Изменить статус заявки</a>
        <a href="edit_description.php">Изменить описание проблемы</a>
        <a href="add_comment.php">Добавить комментарий</a>
        <a href="logout.php">Выйти</a>
    </nav>
    <main>
        <h2 class="admin_panel">Панель администратора</h2>
        <?php
        if (!empty($_SESSION['change_status'])) {
            echo "<p class='notice'>" . $_SESSION['change_status'] . "</p>";
            $_SESSION['change_status'] = null;
        }
        ?>
        <span><b>Количество выполненных заявок: </b><? echo $count; ?></span>
        <span><b>Среднее время выполнения заявок: </b><? echo $time_format; ?></span>
        <!-- <table class="table">
            <tr>
                <td colspan = "2"><b>Статистика по неисправностям: </b></td>
            </tr>
            <tr>
                <td>не включается</td>
                <td><?php // echo $stat_1; ?></td>
            </tr>
            <tr>
                <td>нехарактерные звуки</td>
                <td><?php // echo $stat_2; ?></td>
            </tr>
        </table> -->
        <h2>Поиск заявки</h2>
        <form action="" method="post">
            <label for="id_or_name">Введите ФИО или номер заявки</label>
            <input type="text" name="id_or_name" id="id_or_name">
            <button>Найти</button>
        </form>
        <h2>Все заявки</h2>
        <form action="" method="post">
            <button name="by_fio">По ФИО</button>
            <button name="by_item">По названию техники</button>
        </form>
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
                <th>Комментарий</th>
                <th>Исполнитель</th>
            </tr>
            <?php
            if (!empty($_POST['id_or_name'])) {
                $query = mysqli_query($link, "SELECT * FROM problems LEFT JOIN workers ON
                problems.problem_worker_id = workers.worker_id WHERE problem_client_name LIKE '$_POST[id_or_name]%'
                OR problem_id = '$_POST[id_or_name]'");
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
                            <td>$row[problem_comment]</td>
                            <td>$row[worker_name]</td>
                        </tr>";
                }
            } else if (isset($_POST['by_fio'])) {
                $query = mysqli_query($link, "SELECT * FROM problems LEFT JOIN workers ON
                problems.problem_worker_id = workers.worker_id ORDER BY problem_client_name");
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
                            <td>$row[problem_comment]</td>
                            <td>$row[worker_name]</td>
                        </tr>";
                }
            } else if (isset($_POST['by_item'])) {
                $query = mysqli_query($link, "SELECT * FROM problems LEFT JOIN workers ON
                problems.problem_worker_id = workers.worker_id ORDER BY problem_type_item");
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
                            <td>$row[problem_comment]</td>
                            <td>$row[worker_name]</td>
                        </tr>";
                }
            } else {
                $query = mysqli_query($link, "SELECT * FROM problems LEFT JOIN workers ON
                problems.problem_worker_id = workers.worker_id ORDER BY problem_id");
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
                            <td>$row[problem_comment]</td>
                            <td>$row[worker_name]</td>
                        </tr>";
                }
            }
            ?>
        </table>
    </main>
</body>
</html>