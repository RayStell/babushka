<?php session_start(); 

include_once './db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // Получение данных из формы
    $formData = $_POST;
    //Поля, которые ожидаем от forData
    $fields = [
        'name', 
        'surname', 
        'email',
        'phone', 
        'password',
        'password-confirm', 
        'agree'
    ];
    
    $errors = [];
    //Проверка + очистка данных
    foreach ($formData as $key => $value){
        $formData[$key] = htmlspecialchars($value);
    }
    // Проверка на существование ключа + пустота значения
    foreach($fields as $idx => $field){
        //проверка на существование ключа
        if(array_key_exists($field, $formData)){
            // Проверка на пустоту значения
            if($formData[$field]){
                //если дошли сюда, выходим из цикла, чтобы ошибка не записалась
            continue;
        }
        
      }
      // Дописать проверку на пустоту значения
        $errors[$field][] = 'Zapolni polya ishak';
    }
    // Проверка правильнсти вводы пароля
    if ($formData['password'] !== $formData['password-confirm']){
        $errors['password-confirm'][]= 'Paroly ne sovpodaut';
    }
    // Проверка уникальности
    $phone = $formData['phone'];
    $user = $db->query("SELECT id FROM users WHERE phone = '$phone'")->fetchAll();
    if(!empty($user)){
        $errors['phone'][] = 'Takoy polzovatel esti';
    }
    //Todo:Заполнить таблицу users 2 пользователями
    //проверить : выдаёт ли ошибку если передать такой же телефон
    // Валидация данных
    if (empty($errors)){
        $request = $db-> 
        prepare("
            INSERT INTO `users`(`name`, `surname`, `email`, `phone`, `passwords`, `agree`) 
            VALUES (?,?,?,?,?,?)
        ")->execute([
            $formData['name'],
            $formData['surname'],
            $formData['email'],
            $formData['phone'],
            password_hash($formData['password'], PASSWORD_BCRYPT),
            $formData['agree'] ? 1 : 0,
        ]);
        $_SESSION['register-errors'] = $errors;
        header('Location: ../login.php');
    }
    //
    if (!empty($errors)){
        $_SESSION['register-errors'] = $errors;
        header('Location: ../register.php');
    }
} else {
    echo 'Запрос неверный';
}

?>