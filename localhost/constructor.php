<?php
session_start();
require_once 'dbconnect.php';

if (!$_SESSION['user']) {
    header('Location: index.php');
    exit;
}

$userRole = $_SESSION['user']['role'];


$query = "SELECT * FROM difficulty_level";
$stmt = $connect->query($query);

$difficultyLevels = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Myacademy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/constructor.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
</head>
<?php include 'header.php'; ?>
<style>
    .input-box {
        box-sizing: border-box;
        min-width: 14vw;
    }

    .auto-expand {
        resize: none;
        overflow: hidden;
    }

    select:hover,
    select:focus {
        border-radius: 30px !important;
    }
</style>


<body>

    <section class="center-sec" id="constructor">

        <div class="topic-title">
            
            <h2 class="regtext">Конструктор курсов</h2>
            
        </div>
        <div>
            <h3>Добавить курс</h3>
            <form action="source/course-create.php" method="POST" enctype="multipart/form-data" id="courseForm">

                <div class="const-cont">
                    <div>
                        <!-- <label for="">Название курса</label> -->
                        <input class="input-box " type="text" name="course_title" placeholder="Название курса" required
                            minlength="5">
                        <div class="error-message" id="courseTitleError"></div>
                    </div>
                    <div>
                        <select class="input-box" name="difficulty_lvl" id="c_level" style="border-radius: 30px;">
                            <?php foreach ($difficultyLevels as $level) { ?>
                                <option>
                                    <?php echo $level['level']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>


                    <div>
                        <!-- <label for="">Краткое описание курса</label> -->
                        <textarea class="input-box auto-expand" style="min-height:4vh;" type="text"
                            name="course_brief" placeholder="Краткое описание курса" required minlength="4"></textarea>
                    </div>

                    <div>
                        <!-- <label for="c_description">Полное описание курса</label> -->
                        <textarea class="input-box auto-expand" style="min-height:8vh;" type="text"
                            name="course_description" id="c_description" placeholder="Полное описание курса" required
                            minlength="4"></textarea>
                    </div>
                </div>
                <h3>Содержание курса</h3>
                <div>
                    <div class="const-cont">
                        <div id="modulesList">
                            
                                <div><input class="input-box " type="text" name="module_1" placeholder="Название модуля"
                                        required minlength="4">
                                </div>

                                <div>
                                        <div style="margin-top: 1vh;">
                                            <input class="input-box ci-1" type="text" name="lesson_1_1"
                                                placeholder="Название урока" required minlength="4">
                                            <button type="button" class="add_lesson button-box" data-module="1"
                                                data-lesson="1">+</button>
                                        </div>
                                
                            </div>
                            
                            </div>
                        <div style="margin-bottom: 1vh;">
                            <button class="button-box add_module" type="button">Добавить модуль</button>
                        </div>
                    </div>
                </div>
                <button class="button-box" type="submit" name="send" value="<?php echo $courseId; ?>">Сохранить</button>
            </form>
        </div>


    </section>
    <?php include 'footer.php'; ?>

    <script src="js/addition.js"></script>
    <script>
        $(document).ready(function () {
            function adjustInputWidth(input) {
                var hiddenSpan = $('<span>').text(input.val()).css({
                    'position': 'absolute'
                });
                $('body').append(hiddenSpan);
                var textWidth = hiddenSpan[0].scrollWidth;
                hiddenSpan.remove();

                var viewportWidth = $(window).width();
                var maxWidthPercentage = 60;
                var padding = 20;
                var maxWidth = (viewportWidth * maxWidthPercentage) / 100 - padding;
                input.width(Math.min(textWidth, maxWidth));
            }


            $('input.input-box').on('input', function () {
                adjustInputWidth($(this));
            });
        });

        $(document).ready(function () {
            $('.auto-expand').on('input', function () {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        });


    </script>
</body>

</html> 