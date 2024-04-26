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

if (isset($_GET['id_course']) && isset($_GET['id_lesson'])) {
    $courseId = $_GET['id_course'];
    $lessonId = $_GET['id_lesson'];

    // данные о курсе
    $courseQuery = "SELECT course_title FROM courses WHERE id_course = $courseId";
    $courseResult = $connect->query($courseQuery);

    if ($courseResult->rowCount() > 0) {
        $courseData = $courseResult->fetch(pdo::FETCH_ASSOC);
        $courseTitle = $courseData['course_title'];
    } else {
        echo 'Курс не найден';
        exit();
    }

    // данные об уроке
    $lessonQuery = "SELECT lesson_title FROM lessons WHERE id_lesson = $lessonId";
    $lessonResult = $connect->query($lessonQuery);

    if ($lessonResult->rowCount() > 0) {
        $lessonData = $lessonResult->fetch(pdo::FETCH_ASSOC);
        $lessonTitle = $lessonData['lesson_title'];
    } else {
        echo 'Урок не найден';
        exit();
    }
} else {
    echo 'Неверный запрос';
    exit();
}

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
} else {
    echo 'нет доступа';
}
 
$moduleQuery = "SELECT * FROM module WHERE parent_course = $courseId";
$moduleResult = $connect->query($moduleQuery);

// echo 'автор: ' . $courseData['author'] . '<br>';

if (isset($_GET['go_back'])) {
    header("Location: $previous_page");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Myacademy</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/lesson.css">

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
</head>
<?php include 'header.php'; ?>

<body>
    <div class="heading">
        <p>
            <?php echo $lessonTitle; ?>
        </p>
    </div>
    <div class="lesson-main">
        <div class="sidebar">
            <div style="width: 100%;display: flex; align-items: center; margin-right: 1vw; margin-left: 1vw;">
            <a href="course-info.php?course_id=<?php echo $courseId; ?>"><span id="left" class=" "><img src="img/arrow-left.svg" style="height: 1.5rem;"></span></a>
                <h4>
                    <?php echo $courseTitle; ?>
                </h4>
            </div>
            <div style="width: 100%;">
                <?php
                $moduleQuery = "SELECT * FROM module WHERE parent_course = $courseId";
                $moduleResult = $connect->query($moduleQuery);

                if ($moduleResult->rowCount() > 0) {
                    while ($moduleData = $moduleResult->fetch(pdo::FETCH_ASSOC)) {
                        echo '<div class="module">';
                        echo '<div class="module-link"><p class="module-t">' .
                            $moduleData['module_title'] .
                            '</p></div>';
                        $moduleId = $moduleData['id_module'];
                        $lessonQuery = "SELECT * FROM lessons WHERE parent_module = $moduleId";
                        $lessonResult = $connect->query($lessonQuery);

                        if ($lessonResult === false) {
                            echo 'ошибка: ' . $e->getMessage();
                        } else {
                            while ($lessonData = $lessonResult->fetch(pdo::FETCH_ASSOC)) {
                                echo '<div class="lesson-link"><img src="img/document-text.svg"><a href="lesson.php?id_course=' . $courseId . '&id_lesson=' . $lessonData['id_lesson'] . '">
                            <p class="lesson-t">' . $lessonData['lesson_title'] . '</p></a></div>';
                            }
                        }
                        echo '</div>';
                    }
                } else {
                    echo '<p>Вы не добавили ни одного модуля<p>';
                }
                ?>
            </div>
        </div>
        <div class="content-section">
            <div class="content-container">
                <div class="content">
                    <?php
                    $lessonContentQuery = "SELECT lesson_content FROM lessons WHERE id_lesson = $lessonId";
                    $lessonContentResult = $connect->query($lessonContentQuery);
                
                    if ($lessonContentResult->rowCount() > 0) {
                        $lessonContentData = $lessonContentResult->fetch(pdo::FETCH_ASSOC);
                        $lessonContent = $lessonContentData['lesson_content'];
                        if (!empty($lessonContent)) {
                            echo $lessonContent;
                        } else {
                            echo '<br><p>Здесь пока пусто.<p>';
                        }
                    } else {
                        echo 'Данные не найдены';
                    }
                    ?>

                </div>
                <div>
                    <?php if ($userRole == '2') {
                        if (isset($Author)) {
                            if ($Author) {
                                echo '<a href="lesson-editor.php?id_course=' .
                                    $courseId .
                                    '&id_lesson=' .
                                    $lessonId .
                                    '" class="button-box">Редактировать</a>';
                            }
                        }
                    } ?>
                </div>
            </div>
        </div>
    </div>


    <?php include 'footer.php'; ?>
</body>

</html>