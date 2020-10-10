<?php
include "libs/db_rb.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <title>Новости - Жастар Пікірі</title>
  <link rel="stylesheet" href="media/css/style.css">
</head>
<body>
  <div id="wrapper">
    
    <?php include "includes/header.php"; ?>
    <div id="content">
      <div class="main">
        <div class="block">
          <div class="header__content">
            <h3>Последние новости</h3>
          </div>
          <div class="block__content">
            <div class="articles articles__horizontal">
              <?php
              $per_page = 6;
              $page = 1;
              if(isset($_GET['page'])){
                  $page = (int) $_GET['page'];
              }

              $total_count = R::count('articles', 'id');

              $total_pages = ceil($total_count / $per_page);
              if($page <= 1 || $page > $total_pages){
                $page = 1;
              }

              $offset = ($per_page * $page) - $per_page;

              $articles_exist = true;
              $article = R::findAll('articles', "LIMIT 6");
              if( R::count('articles') <= 0 ){
                echo "Нет статей";
                $articles_exist = false;
              }

              foreach($article as $art)
              {
                ?> 
                <article class="article">
                  <a href="/article.php?id=<?php echo $art->id; ?>"> </a>
                  <?php if($art->img != '') : ?>
                    <div class="article__image" style="background-image: url(<?php echo 'static/images/' . $art['image']; ?>);"></div> 
                  
                  <?php else : ?>
                  <div class="article__image" style="background-image: url(<?php echo 'static/images/newspaper.png' ?>);"> 
                  </div>
                
                  
                  <?php endif; ?>
                    <div class="article__info">
                      
                    <a href="/article.php?id=<?php echo $art->id; ?>"><?php echo $art->title; ?>
                    </a>
                    
                      <div class="article__info__preview"><p><?php echo mb_substr(strip_tags($art->text), 0, 100, 'utf-8') . ' ...' ?></p></div>
                      
                      <div class="article__info__meta">
                        <?php echo '<span class="pubdate">'.$art->pubdate .'</span>'; ?>
                        <?php echo '<span class="views">'.$art->views .'</span>'; ?>
                      </div>
                    
                    
                  
                    </div>
                </article>
                <?php
              } ?>
              
            </div>
            <?php
              if( $articles_exist == true ){
                echo '<div class="paginator">';
                if($page > 1){
                  echo '<a style="border: 1px solid #2C6C93FF" href="/index?page='.($page-1).'">Назад</a>';
                }

                for( $i=1; $i<=$total_pages; $i++){
                  $number_page = "<a class='number_page' style='border: 1px solid #2C6C93FF' href=index?page=".$i.">".$i."</a>";

                  if($page == $i){
                    echo "<a class='number_page' style='background-color: #2C6C93FF; pointer-events: none;' href=index?page=".$i.">".$i."</a>";
                  } else {
                    echo $number_page;
                  }
                }

                if( $page < $total_pages ) {
                  echo '<a style="border: 1px solid #2C6C93FF" href="/index?page='.($page+1).'">Вперед</a>';
                }
                echo "</div>";

              } 
            ?>
        </div>
      </div>
    </div>
    <?php 
    include "includes/sidebar.php";
    ?>
    </div>
    
    </div>
    <?php include "includes/footer.php";
    ?>

  </div>
  <script src="js/jquery-3.5.1.min.js"></script>
  <script src="js/menu_fixed.js"></script>
</body>
</html>