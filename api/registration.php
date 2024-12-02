<?php

include_once './db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Получение данных из формы
    $formData = $_POST;
    // Поля , которые мы ожидаем от formData
    $fields =[
        'name',
        'surname',
        'email',
        'phone',
        'password',
        'agree'
    ]
    $errors = [];
    // Проверка + отчистка данных
    // Проверка на пустоту
    foreach($fields as $key => $value){
        $value = $formData[$fields];

        if (!$value){
            $errors[][$fields] = 'Zapolni polya ishak';
        }

        echo $formData[$value];
    }
    // Проверка правильности ввода пароля
    // Проверка уникальности
    echo json_encode[$errors];
} else {
    echo 'Запрос неверный';
}

?>