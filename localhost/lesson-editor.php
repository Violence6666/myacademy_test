<?php
session_start();
require_once 'dbconnect.php';

if ($_SESSION['user']) {
    $userId = $_SESSION['user']['id_user'];

    $query = "SELECT * FROM users WHERE id_user = $userId";
    $result = $connect->query($query);

    if ($result->rowCount() > 0) {
        $userData = $result->fetch(pdo::FETCH_ASSOC);
        $_SESSION['user'] = $userData;
    }
}

$userRole = $_SESSION['user']['role'];
$_SESSION['previous_page'] = $_SERVER['REQUEST_URI'];

if (isset($_GET['id_course']) && isset($_GET['id_lesson'])) {
    $courseId = $_GET['id_course'];
    $lessonId = $_GET['id_lesson'];

    // получаем данные о курсе
    $courseQuery = "SELECT course_title FROM courses WHERE id_course = $courseId";
    $courseResult = $connect->query($courseQuery);
 
    if ($courseResult->rowCount() > 0) {
        $courseData = $courseResult->fetch(pdo::FETCH_ASSOC);
        $courseTitle = $courseData['course_title'];
    } else {
        echo 'Курс не найден';
        exit();
    }

    // получаем данные об уроке
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
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Myacademy</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/lesson.css">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
</head>
<?php include 'header.php'; ?>
<style>

</style>
<body>
    <div class="heading">
        <p>
            <?php echo $lessonTitle; ?>
        </p>
    </div>
    <div class="lesson-main">
        <div class="sidebar">
            <div style="width: 100%;">
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
                            echo 'Error in lesson query: ' . $e->getMessage();
                        } else {
                            while ($lessonData = $lessonResult->fetch(pdo::FETCH_ASSOC)) {
                                echo '<div class="lesson-link"><img src="img/document-text.svg"><a href="lesson.php?id_course=' .
                                    $courseId .
                                    '&id_lesson=' .
                                    $lessonData['id_lesson'] .
                                    '">
                            <p class="lesson-t">' .
                                    $lessonData['lesson_title'] .
                                    '</p></a></div>';
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
                    <h2>
                        Редактирование урока
                    </h2>
                    <textarea id="editor"></textarea>

                </div>
                <?php if ($userRole == '2') {
                    if ($Author) {
                        echo '<div><a onclick="saveLessonContent()" class="button-box">Сохранить</a></div>';
                    }
                } ?>
            </div>
        </div>
    </div>


    <?php include 'footer.php'; ?>
    <script src="https://cdn.tiny.cloud/1/5cp5uqjftxu87q1xsxzp1x5vh9249d6hh4whd8poo2kqu23g/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage advtemplate ai mentions tableofcontents footnotes mergetags autocorrect typography inlinecss markdown',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        });

        function saveLessonContent() {
        var lessonContent = tinymce.get('editor').getContent();

        $.ajax({
            type: "POST",
            url: "source/save_lesson_content.php",
            data: {
                id_course: <?php echo $courseId; ?>,
                id_lesson: <?php echo $lessonId; ?>,
                lesson_content: lessonContent
            },
            success: function (response) {
                alert('Сохранено успешно');
                window.location.href = "lesson.php?id_course=<?php echo $courseId; ?>&id_lesson=<?php echo $lessonId; ?>";
            },
            error: function (error) {
                alert('Ошибка при сохранении');
            }
        });
    }
    </script>

    
</body>

</html>