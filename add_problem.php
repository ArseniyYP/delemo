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
        <h2>Подать заявку</h2>
        <form action="" method="post">
            <table>
                <tr>
                    <td><label for="problem_type_item">Вид техники</label></td>
                    <td><input type="text" name="problem_type_item" id="problem_type_item"></td>
                </tr>
                <tr>
                    <td><label for="problem_model_item">Модель</label></td>
                    <td><input type="text" name="problem_model_item" id="problem_model_item"></td>
                </tr>
                <tr>
                    <td><label for="problem_description">Описание проблемы</label></td>
                    <td><textarea name="problem_description" id="problem_description"></textarea></td>
                </tr>
                <tr>
                    <td><label for="problem_client_name">ФИО клиента</label></td>
                    <td><input type="text" name="problem_client_name" id="problem_client_name"></td>
                </tr>
                <tr>
                    <td><label for="problem_phone_number">Номер телефона</label></td>
                    <td><input type="number" name="problem_phone_number" id="problem_phone_number"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button>Отправить</button></td>
                </tr>
            </table>
        </form>
    </main>
    <?php
    require_once("db.php");
    if (!empty($_POST['problem_type_item']) && !empty($_POST['problem_model_item']) && !empty($_POST['problem_description']) && 
    !empty($_POST['problem_client_name']) && !empty($_POST['problem_phone_number'])) {
        $problem_type_item = $_POST['problem_type_item'];
        $problem_model_item = $_POST['problem_model_item'];
        $problem_description = $_POST['problem_description'];
        $problem_client_name = $_POST['problem_client_name'];
        $problem_phone_number = $_POST['problem_phone_number'];
        $problem_user_id = $_SESSION['user_id'];
        $query = mysqli_query($link, "INSERT INTO problems(problem_type_item, problem_model_item, problem_description, problem_client_name, problem_phone_number, problem_user_id)
        VALUES ('$problem_type_item', '$problem_model_item', '$problem_description', '$problem_client_name', '$problem_phone_number', '$problem_user_id')");
        if ($query == 'true') {
            header("Location: all_problems.php");
        } else {
            $error = "<p class='error'>Ошибка при добавлении!</p>";
        }
    }
    if (isset($error)) {
        echo $error;
    }
    ?>
</body>
</html>