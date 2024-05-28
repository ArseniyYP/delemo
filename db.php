<?php
$link = mysqli_connect('localhost', 'root', '', 'delemo');
if (!$link) {
    die ('Ошибка: ' . mysqli_connect_error());
}
?>