<?php
session_start();
require_once 'dbconnect.php';

if (isset($_SESSION['user'])) {
  $userId = $_SESSION['user']['id_user'];

  $query = "SELECT * FROM users WHERE id_user = :userId";
  $stmt = $connect->prepare($query);
  $stmt->bindParam(':userId', $userId);
  $stmt->execute();

  if ($stmt->rowCount() > 0) {
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION['user'] = $userData;
  }
}

if (isset($_SESSION['user']['role'])) {
  $userRole = $_SESSION['user']['role'];
}
$_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];

$coursesQuery = 'SELECT * FROM courses';
$coursesResult = $connect->query($coursesQuery);

?>
 
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>MyAcademy</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/auth.css">
  <link rel="stylesheet" href="css/catalogue.css">
  <link rel="shortcut icon" href="img/logo.svg" type="image/x-icon">
  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
</head>
<?php include 'header.php'; ?>

<body>


  <?php include 'modal.php'; ?>

  

  <div class="NewContainer Banner HomePage__banner Banner__lang-ru size--default" style="--float-opacity:1">
            <div class="NewContainer__inner">
              <div class="Banner__container">
                <div class="Banner__text">
                  <h1 class="Banner__title"></h1>
                    
                    <section id="hero" class="Banner__title d-flex flex-column justify-content-center align-items-center">
                      <div class="hero-container aos-init aos-animate" data-aos="fade-in">
                        <h1>Моя академия</h1>
                        <p class="typed-text" style="--gradientColor:linear-gradient(88.93deg, #2A82EB 18.91%, #288BEE 79.91%)">Для <span class="typed" style="--gradientColor:linear-gradient(88.93deg, #2A82EB 18.91%, #288BEE 79.91%)" data-typed-items="каждого, студентов, специалистов, разработчиков">специалистов</span><span class="typed-cursor typed-cursor--blink" aria-hidden="true">|</span></p>
                      </div>
                    </section>
                  
                  <div class="Banner__description">Расширяем возможности будущих технологов <br>Место где инновации сочетаются с совершенством!.<br></div>
                </div>
                <div class="Banner__buttons">
                  <a class="NewButton NewButton--mode-secondary NewButton--background-page NewButton--scheme-light NewButton--padding-large" href="register.php">
                    <span class="NewButton__inner">
                      <span class="ButtonText ButtonText--l-1 ButtonText--t-default">Начать обучение</span>
                    </span>
                  </a>
                </div>
              </div>
            </div>
          </div>




          <div class="NewRow Wallets withoutPaddings" style="--mobileGridGap:72;--tabletSGridGap:100;--tabletMGridGap:100;--desktopGridGap:120;--desktopLargeGridGap:120;--mobileGridSize:repeat(auto-fill, calc((100% / 12) * 12));--tabletSGridSize:repeat(auto-fill, calc((100% / 12) * 12));--tabletMGridSize:repeat(auto-fill, calc((100% / 12) * 12));--desktopGridSize:repeat(auto-fill, calc((100% / 12) * 12));--desktopLargeGridSize:repeat(auto-fill, calc((100% / 12) * 12))">
              <div class="NewCol withoutPaddings">
                <div class="PageBlockSlotted PageBlockSlotted--m-scheme-light PageBlockSlotted--m-size-default">
                  <div class="NewContainer PageBlockSlotted__inner size--default" style="--outsideColumns:4">
                    <div class="NewContainer__inner">
                      <div class="Wallets__header">
                        <h3 class="Title Title--level-3 Wallets__header__title">
                          <p>Начать просто: вам нужен только <span class="HomePage__Wallets__accent">AcademyID</span></p>
                        </h3>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="Wallets__row"><a class="AppCard Wallets__row__item" href="/ru">
                    <div class="AppCard__baseBackground" style="background:#07ACFF"></div>
                    <div class="AppCard__hoverBackground" style="background:#07ACFF"></div>
                    <div class="AppCard__top">
                      <div class="AppCard__topRow"></div>
                      <div class="AppCard__text">
                        <div class="AppCard__title" style="color:var(--default_white)">
                          <p>MyAcademy открывает доступ к знаниям по компьютерным сетям</p>
                        </div>
                      </div>
                    </div>
                  <img src="img/icons.png" alt="app image" class="AppCard__image fade in" style="margin-bottom: 90px">
                  </a>
                  <a class="AppCard Wallets__row__item Wallets__row__item__reversed Wallets__row__item__bordered" href="/ru">
                    <div class="AppCard__baseBackground" style="background:#FFF"></div>
                    <div class="AppCard__hoverBackground" style="background:#FFF"></div>
                    <div class="AppCard__top">
                      <div class="AppCard__topRow"></div>
                      <div class="AppCard__text">
                        <div class="AppCard__title" style="color:#000">
                          <p><span class="HomePage__Wallets__accent">Знания</span> прямо в телефоне</p>
                        </div>
                      </div>
                    </div><img src="img/icons1.png" alt="app image" class="AppCard__image fade in">
                  </a>
                  <a class="AppCard Wallets__row__item" href="/ru">
                    <div class="AppCard__baseBackground" style="background:#232328"></div>
                    <div class="AppCard__hoverBackground" style="background:#232328"></div>
                    <div class="AppCard__top">
                      <div class="AppCard__topRow"></div>
                      <div class="AppCard__text">
                        <div class="AppCard__title" style="color:var(--default_white)">
                          <p style="text-align: center"><span class="HomePage__Wallets__accent">Увлекательные</span> практические и интерактивные задания</p>
                        </div>
                      </div>
                    </div>
                    <img src="img/icons2.png" alt="app image" class="AppCard__image fade in" style="margin-bottom: 90px">
                  </a>

                </div>
              </div>
            </div>





  <section id="main-courses">

    <!-- <div id="blur"></div> -->

    <div class="topic-title">
      <h2 class="regtext">ОБУЧАЮЩИЕ курсы</h2>
    </div>

    <div class="slider-container">
      <div class="courses-list">
        <?php
        // выводим курсы
        $coursesCount = 0; // переменная для подсчета выводимых курсов
        while ($course = $coursesResult->fetch(pdo::FETCH_ASSOC)) {
          // запрос для получения случайного изображения для каждого курса
          $sql = 'SELECT svg_code FROM images ORDER BY RAND() LIMIT 1';
          $stmt = $connect->query($sql);

          if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(pdo::FETCH_ASSOC);
            $svgCode = $row['svg_code'];

            echo '<a href="course-info.php?id_course=' . $course['id_course'] .'">';
            echo '<div class="course-card" id="course-card">';
            echo '<div class="course-desc"></div>';
            echo "<img src='https://i.yapx.ru/XVXN4.png'> ";
            echo '<p class="c-title">' . $course['course_title'] . '</p>';
            echo '</div></a>';

            $coursesCount++;

            // количество выводимых курсов
            if ($coursesCount >= 3) {
              break;
            }
          } else {
            echo 'Ошибка: ' . $e->getMessage();
          }
        }
        ?>
      </div>
    </div>
    <div style="display: flex; justify-content: center;">
      <div><a href='catalogue.php' class="NewButton NewButton--mode-secondary NewButton--background-page NewButton--scheme-light NewButton--padding-large">Всё разделы</a></div>
    </div>
  </section>
  <?php include 'footer.php'; ?>
  <script src="js/auth.js"></script>
  <script src="js/script.js"></script>
 
</body>

</html>