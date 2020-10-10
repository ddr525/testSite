<?php
    require "../libs/db_rb.php";
    $data=$_POST;
    if( isset($data['do__login'])){
        $errors=array();
        $user = R::findOne('users', 'login = ?', array($data['login']));
        if($user)
        {
            if( password_verify ($data['password'], $user->password)){
                $_SESSION['logged_user'] = $user;
                header("location: /");
            }else{
                $errors[] = 'Неверно введён пароль!';
            }
        }else{
            $errors[] = 'Пользователя с таким логином не найден!';
        }
        if( !empty($errors) ){
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
    <form action="login" method="POST">
        <p><strong>Введите ваш логин</strong>:</p>
        <input type="text" name="login" value="<?php echo @$data['login'];?>">
        <p><strong>Введите ваш пароль</strong>:</p>
        <input type="password" name="password">
        <p>
            <button type="submit" id="do__login" name="do__login">Войти</button>
        </p>
        <p> Вы тут впервые?- <a href="sign_up">Зарегистрируйтесь</a></p>
        <p style="text-align: center; color: red;"><strong><?php echo $message?></strong></p>
    </form>
    <hr>
    <p><a href="/">Вернутся на главную</a></p>
    </div>

</body>
</html>