<header>
  <div class="menu">
    <div class="tabs">
      <a href="index.php">Главная</a>
      <a href="catalogue.php">Обучение</a>
      <?php
      if (isset($userRole)) {
        switch ($userRole) {
          case '1':
            echo '<a href="my-courses.php">Мое обучение</a>';
            break;
          case '2':
            echo '<a href="constructor.php">Конструктор курсов</a>';
            break;
          case '0':
            echo '<a href="adminpanel.php">Панель администратора</a>';
            break;
          default:
            break;
        }
      }
      ?>
    </div>
 
    <div style="display: flex; gap: 1vh;">
      <?php
      if (isset($_SESSION['user'])) {
        
        echo '<div class="auth-button-box" id=" "><a href="profile.php">Профиль</a></div>';
        echo '<div class="auth-button-box" id=" "><a href="source/exit.php">Выйти</a></div>';
      } else {
        echo '<div class="auth-button-box" id=" "><a id="auth-button" href="#">Вход</a></div>';
      }
      ?>
    </div>
  </div>
</header>