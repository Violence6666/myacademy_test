<?php
session_start();
session_regenerate_id(true);
error_log(print_r($_SESSION, true));
require_once __DIR__ . '\..\dbconnect.php';
require_once __DIR__ . '\actions\helper.php';

global $connect;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_course'], $_POST['id_lesson'], $_POST['lesson_content'])) {
        $courseId = $_POST['id_course'];
        $lessonId = $_POST['id_lesson'];
        $lessonContent = $_POST['lesson_content'];

        $updateQuery = "UPDATE lessons SET lesson_content = :lessonContent WHERE id_lesson = :lessonId";
 
        try {
            $stmt = $connect->prepare($updateQuery);
            $stmt->bindParam(':lessonContent', $lessonContent, PDO::PARAM_STR);
            $stmt->bindParam(':lessonId', $lessonId, PDO::PARAM_INT);
            $stmt->execute();
            echo "Данные успешно сохранены в базе данных";
        } catch (PDOException $e) {
            echo "Ошибка при сохранении данных: " . $e->getMessage();
        }
    } else {
        echo "Не удалось получить все необходимые данные";
    }
} else {
    echo "Неверный метод запроса";
}
?>
