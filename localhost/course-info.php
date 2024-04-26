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
$previous_page = $_SESSION['previous_page'] ?? 'index.php';

$courseId = $_GET['id_course'];
if (isset($_GET['id_lesson'])) {
    $lessonId = $_GET['id_lesson'];
}

$courseId = $_GET['course_id'] ?? null;
if (!$courseId) {
    echo "Не удалось получить ид курса";
    exit;
}
 
// увеличиваем счетчик просмотров
// $updateViewsQuery = "UPDATE courses SET views_count = views_count + 1 WHERE id_course = $courseId";
// $result = $connect->query($updateViewsQuery);

// if (!$result) {
//     echo "Ошибка при обновлении счетчика просмотров: " . $e->getMessage();
//     exit;
// }

// echo "ид курса - $courseId";

$courseQuery = "SELECT * FROM courses WHERE id_course = $courseId";
$courseResult = $connect->query($courseQuery);

if ($courseResult->rowCount() > 0) {
    $courseData = $courseResult->fetch(pdo::FETCH_ASSOC);
    // является ли текущий пользователь автором курса
    if (isset($_SESSION['user']['id_user'])) {
        if ($courseData['author'] == $_SESSION['user']['id_user']) {
            $Author = true;
        } else {
            $Author = false;
        }
    }
} 
else {
    echo "нет доступа";
}

$moduleQuery = "SELECT * FROM module WHERE parent_course = $courseId";
$moduleResult = $connect->query($moduleQuery);


?>

<!DOCTYPE html>

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
            <h3 class="regtext">
                <?php echo $courseData['course_title']; ?>
            </h3>
        </div>

        <div class="course-brief">
            <p>
                <?php echo $courseData['course_brief']; ?>
            </p>
        </div>

        <!-- <div class="filter-key-words">
            <div class=key-word-list>
                <a href="#" class="button-box">Навык#1</a>
                <a href="#" class="button-box">Навык#2</a>
                <a href="#" class="button-box">Навык#3</a>
                <a href="#" class="button-box">Навык#4</a>
                <a href="#" class="button-box">Навык#5</a>
                <a href="#" class="button-box">Навык#6</a>
            </div>
        </div> -->

        <div>
            <h4>О курсе</h4>
            <p style="width: 70%; text-align: justify;">
                <?php echo nl2br($courseData['course_description']); ?>
            </p>
        </div>

        <div class="content-container">
            <h4>Содержание</h4>
            <div class="modules-container">
                <?php
                if ($moduleResult->rowCount() > 0) {
                    $firstModule = true;
                    while ($moduleData = $moduleResult->fetch(pdo::FETCH_ASSOC)) {
                        echo '<div class="module' . ($firstModule ? '' : ' hidden') . '">';
                        echo '<p class="module-t">' . $moduleData['module_title'] . '</p>';
                        $moduleId = $moduleData['id_module'];
                        $lessonQuery = "SELECT * FROM lessons WHERE parent_module = $moduleId";
                        $lessonResult = $connect->query($lessonQuery);
                        if ($lessonResult === false) {
                            echo "ошибка: " . $e->getMessage();
                        } else {
                            while ($lessonData = $lessonResult->fetch(pdo::FETCH_ASSOC)) {
                                echo '<a href="lesson.php?id_course=' . $courseId . '&id_lesson=' . $lessonData['id_lesson'] . '"><p class="lesson-t">' . $lessonData['lesson_title'] . '</p></a>';
                            }
                        }
                        echo '</div>';
                        $firstModule = false;
                    }
                } else {
                    echo "<p>Вы не добавили ни одного модуля<p>";
                }
                ?>
                <div class="arrow-container">
                    <a id="toggleArrow"><img src="img/arrow.svg" alt="Arrow" height="10px"></a>
                    <a id="toggleArrowReversed" class="hidden"><img src="img/reversedarrow.svg" alt="Reversed Arrow" height="50px"></a>
                </div>
            </div>
        </div>

        <div class="course-book">
            <?php
            if (isset($userRole)) {
                switch ($userRole) {
                    case '1':
                        echo '<a href="#" class="button-box">Пройти курс</a>';
                        break;
                    case '2':
                        echo '<a href="#" class="button-box">Пройти курс</a>';
                        if ($Author) {
                            echo '<a href="course-editor.php?id_course=' . $courseId . '" class="button-box">Редактировать</a>';
                            echo '<a href="source/delete-course.php?id_course=' . $courseId . '" class="button-box">Удалить курс</a>';
                        }
                        break;
                    case '0':
                        echo '<a href="#" class="button-box">Пройти курс</a>';
                        break;
                    default:
                        break;
                }
            }

            ?>
        </div>
        
    </section>
    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
    <script src="js/auth.js"></script>
    <script>
        var arrow = document.getElementById('toggleArrow');
        var reversedArrow = document.getElementById('toggleArrowReversed');
        var modules = document.querySelectorAll('.modules-container .module');

        arrow.addEventListener('click', function () {
            modules.forEach(function (module) {
                module.classList.remove('hidden');
            });

            arrow.classList.toggle('hidden');
            reversedArrow.classList.toggle('hidden');
        });

        reversedArrow.addEventListener('click', function () {
            for (var i = 1; i < modules.length; i++) {
                modules[i].classList.add('hidden');
            }

            arrow.classList.toggle('hidden');
            reversedArrow.classList.toggle('hidden');
        });

    </script>
</body>

</html>