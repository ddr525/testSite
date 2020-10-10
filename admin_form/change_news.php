<?php
    include "../includes/config.php";
    require "../libs/db_rb.php";
    include "../functions/articles__add_image.php";

    $data=$_POST;
    $article = R::findOne('articles', 'id = ' . (int) $_SESSION['id']);
    
    if( isset($data['do_post'])){
        $errors=array();
        if(trim($data['title']) == '')
            $errors[]='Поле заголовка обязателен для заполнения!';
        
        if(trim($data['text']) == ''){
            $errors[]='Поле содержимое новости обязателен для заполнения';            
        }

        if($_FILES && $_FILES['img']['error'] == UPLOAD_ERR_OK){
          $name = mt_rand(0,11111) . $_FILES['img']['name'];
          move_uploaded_file($_FILES['img']['tmp_name'], '../static/images/'. $name);
          
        }
        if( empty($errors) ){
          R::exec("UPDATE `articles` SET `title` = :title, `image` = :img, `text` = :txt, WHERE `id` = :id", array(
            ':title' = $data['title'], ':img' = $name, ':txt' = $data['text'], ':id' => $_SESSION['id']
          ));
            // mysqli_query($connection, "UPDATE `articles` SET `title` = '" . $data['title'] . "', `image` = '" . $name . "', `text` = '" . $data['text'] . "' WHERE `id` = " . (int) $_SESSION['id']);
            header("location: /");
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
  <meta name="viewport" content="width=device-width">
  <title><?php echo $config['title']?></title>
  <link rel="stylesheet" href="../media/css/style.css">
</head>
<body>
  <div id="wrapper">
    <?php if($_SESSION['logged_user']->admin == 1) : ?>
    <?php include "../includes/header.php"; ?>
    <div id="content">
      <div class="container">
        <form action="change_news.php" method="post" enctype="multipart/form-data">
            <p><strong>Введите заголовок новости</strong>:</p>
            <input name="title" type="text" value="<?php echo $article->title; ?>">
            <p><strong>Изображение под новость (необязательно)</strong>:
            <?php if($article->image == '') {echo "К этой новости не добавляли изображение"; }
            else{ echo "Изображение к новости было"; ?>
            </p>
            <img src="<?php echo "../static/images/".$article->image; ?>" style="width: 200px;">
            <?php } ?>
            
            <p><input type="file" name="img"></p>
            <p><strong>Введите содержимое новости</strong>:</p>
            <textarea name="text" cols="30" rows="10"><?php echo $article->text;?></textarea>
            <p>
                <button type="submit" name="do_post">Изменить новость</button>
            </p>
        </form>
        <?php echo $message; ?>
      </div>
    </div>
    <?php include "../includes/footer.php";?>
    
    <?elseif($_SESSION['logged_user']->admin == 0) :?>
      <!-- <?php http_response_code(404);
      include('../libs/404.html');
      die();?> -->
    <?php endif; ?>
  </div>

</body>
</html>