<?php
  include "../includes/config.php";
  require "../libs/db_rb.php";
  include "../functions/articles__add_image.php";
    $data=$_POST;
    print_r($name);
    if( isset($data['do_post'])){
        $errors=array();

        $article_title = R::findOne('articles', 'title = ?', array($data['title']));

        if(trim($data['title']) == ''){
            $errors[]='Поле заголовка обязателен для заполнения!';
        }

        if(trim($data['text']) == ''){
            $errors[]='Поле содержимое новости обязателен для заполнения';            
        }

        if($article_title){
            $errors[]='Новость с таким заголовком уже существует';
        }
        if($_FILES && $_FILES['img']['error'] == UPLOAD_ERR_OK){
          $name = mt_rand(0,11111) . $_FILES['img']['name'];
          move_uploaded_file($_FILES['img']['tmp_name'], '../static/images/'. $name);
          
        }
        if( empty($errors) ){
            $article = R::dispense('articles');
            $article->title = $data['title'];
            $article->image = $name;
            $article->text = $data['text'];
            $article->pubdate = date('d.m.Y');
            $article->views = 0;
            R::store($article);
            header("Location: /");
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
  <title><?php echo $config['title']?></title>
  <link rel="stylesheet" href="../media/css/style.css">
  <link rel="stylesheet" href="../media/css/admin-form.css">
</head>
<body>
  <div id="wrapper">
    <?php if($_SESSION['logged_user']->admin == 1) { ?>
    <?php include "../includes/header.php"; ?>
    <div id="content">
      <div class="container">
        <div class="form">
          <form action="add_news" method="post" enctype="multipart/form-data">
              <p><strong>Введите заголовок новости</strong>:</p>
              <input name="title" type="text" value="<?php echo $data['title']; ?>">
              <p><strong>Изображение под новость (необязательно)</strong>:</p>
              <input type="file" name="img">
              <p><strong>Введите содержимое новости</strong>:</p>
              <textarea name="text" cols="30" rows="10"><?php echo $data['text'];?></textarea>
              <p>
                  <button type="submit" name="do_post">Загрузить новость</button>
              </p>
          </form>
          <?php echo $message; ?>
        </div>
      </div>
    </div>
    <?php include "../includes/footer.php";
    }
    else if($_SESSION['logged_user']->admin == 0) {
      ?>
			<script> document.location.href="/404.html"; </script>
      <?php } ?>
  </div>

</body>
</html>