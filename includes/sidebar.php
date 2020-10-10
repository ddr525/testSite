<?php $article_sidebar = R::findAll('articles', 'ORDER BY views DESC LIMIT 10');
?>
<div class="sidebar">
    <div class="block">
      <div class="header__content sidebar">
      <h3>Популярные новости</h3>
      </div>
      <div class="block__content">
        <div class="articles articles__vertical">

        <?php foreach($article_sidebar as $art){ ?>
          <article class="article">
            <div class="article__info">
              <a href="/article.php?id=<?php echo $art->id; ?>"><?php echo $art->title; ?></a>
              <div class="article__info__meta">
                <?php echo '<span class="pubdate">'.$art->pubdate .'</span>'; ?>
                <?php echo '<span class="views">'.$art->views .'</span>'; ?>
              </div>
            </div>
          </article>
          <?php } ?>
        </div>
      </div>
    </div>
  <!-- </div> -->
</div>