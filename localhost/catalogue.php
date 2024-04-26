<?php
session_start();
require_once 'dbconnect.php';

if (isset($_SESSION['user'])) {
  $userId = $_SESSION['user']['id_user'];

  $query = "SELECT * FROM users WHERE id_user = $userId";
  $result = $connect->query($query);

  if ($result->rowCount() > 0) {
    $userData = $result->fetch(pdo::FETCH_ASSOC);
    $_SESSION['user'] = $userData;
  }
} 

if (isset($_SESSION['user']['role'])) {
  $userRole = $_SESSION['user']['role'];
}
$_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];

$search = isset($_GET['search']) ? $_GET['search'] : '';
$level = isset($_GET['level']) ? $_GET['level'] : '';

$sql = "SELECT * FROM courses";

if (!empty($search)) {
  $sql .= " WHERE 
            course_title LIKE '%$search%' OR
            course_brief LIKE '%$search%' OR
            course_description LIKE '%$search%'";
} elseif (!empty($level)) {
  $sql .= " WHERE difficulty_lvl = '$level'";
}

// сортировка по времени создания
$sql .= " ORDER BY id_course DESC";

$coursesResult = $connect->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Myacademy</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/auth.css">
  <link rel="stylesheet" href="css/catalogue.css">
  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
</head>

<?php include 'header.php'; ?>

<body>

  <?php include 'modal.php'; ?>

  <section>

    <div class="topic-title">
      <h2 class="regtext">ОБУЧАЮЩИЕ курсы</h2>
    </div>


    <div class="filter-key-words">
      <form method="get" action="" class="search-container">
        <div class="search-box">
          <input class="input-box" type="text" name="search" value="<?= $search ?>" placeholder="Поиск" style="width: 12vw;">
        </div>
      </form>
    </div>


    <div class="slider-container">
      <div class="courses-list">
        <?php
        // вывод курсов
        while ($course = $coursesResult->fetch(pdo::FETCH_ASSOC)) {
          // получение случайного изображения для каждого курса
          $sql = 'SELECT svg_code FROM images ORDER BY RAND() LIMIT 1';
          $result = $connect->query($sql);

          if ($result->rowCount() > 0) {
            $row = $result->fetch(pdo::FETCH_ASSOC);
            $svgCode = $row['svg_code'];

            echo '<a href="course-info.php?course_id=' . $course['id_course'] . '">';
            echo '<div class="course-card" id="course-card">';
            echo '<div class="course-desc"></div>';
            echo '<p class="c-title">' . $course['course_title'] . '</p>';
            echo '<p style="display: flex; justify-content: center; align-items: center; height: 30vh;">' .
              $svgCode .
              '</p>';
            echo '<p class="c-desc">' . $course['course_brief'] . '</p>';
            echo '<p class="c-lvl">' . $course['difficulty_lvl'] . '</p>';
            echo '</div></a>';
          } else {
            echo 'Ошибка: ' . $e->getMessage();
          }
        } ?>
      </div>
    </div>

  </section>
  <?php include 'footer.php'; ?>
  <script src="js/auth.js"></script>
  <script src="js/script.js"></script>

</body>

</html>