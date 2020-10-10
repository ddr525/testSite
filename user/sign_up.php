<?php
    require "../libs/db_rb.php";
    $data=$_POST;

    $sign_users = R::findAll('users');

    if( isset($data['do__sign_up'])){
        $errors=array();
        
        foreach($sign_users as $us){
            if(trim($us->login) == trim($data['login'])){
                $errors[]='Этот логин занят другим пользователем!';
            }
            if(trim($us->email) == trim($data['email'])){
                $errors[]='Этот email уже зарегистрирован!';
            }
        }
        if(trim($data['login']) == ''){
            $errors[]='Введите логин!';
        }
        if(trim($data['email']) == ''){
            $errors[]='Введите Email!';
        }
        if($data['password'] == ''){
            $errors[]='Введите пароль!';
        }
        if($data['password_2'] != $data['password']){
            $errors[]='Повторный пароль введен неверно!';
        }
        if( empty($errors) ) {
            $user = R::dispense('users');
            $user->login = $data['login'];
            $user->email = $data['email'];
            $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
            $user->admin = 0;
            R::store($user);
            $_SESSION['logged_user'] = $user;
            header('Location: /');
        }
        else{
            $message = array_shift($errors);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../media/css/users.css">
</head>
<body>
    <div class="form">
    <form action="sign_up" method="POST">
        <p><strong>Введите ваш логин</strong>:</p>
        <input type="text" name="login" value="<?php echo @$data['login'];?>">
        <p><strong>Введите ваш email</strong>:</p>
        <input type="email" name="email" value="<?php echo @$data['email'];?>">
        <p><strong>Введите ваш пароль</strong>:</p>
        <input type="password" name="password">
        <p><strong>Повторите пароль</strong>:</p>
        <input type="password" name="password_2">
        <p>
            <button type="submit" name="do__sign_up">Зарегистрироваться</button>
        </p>
        <p>У вас уже есть аккаунт?- <a href="login">Войти</a></p>
        <p style="text-align: center; color: red;"><strong><?php echo $message;?></strong></p>
    </form>
    <hr>
    <p><a href="/">Вернутся на главную</a></p>
    </div>
</body>
</html>