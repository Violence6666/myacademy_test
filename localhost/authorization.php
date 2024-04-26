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
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Myacademy</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/auth.css">
  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
</head>
<?php include 'header.php'; ?>

<body>
<?php include 'modal.php'; ?>
  <div class="auth-container">
    <div class="auth-modal-box">
      <div class="auth-switch-buttons">
        <div>
          <label class="tab ">Регистрация</label>
          <label class="tab active">Авторизация</label>
        </div>
      </div>
      <div>
        <form class="signup-tab tab-form " action="source/signup.php" method="POST">
          <div class="form-container">
            <div>
              <div>
                <input type="text" name="rsurname" placeholder="Фамилия" required>
              </div>
              <div>
                <input type="text" name="rname" placeholder="Имя" required>
              </div>
              <div>
                <input type="text" name="rpatr" placeholder="Отчество" required>
              </div>
              <div>
                <input type="email" name="remail" placeholder="E-mail" required>
              </div>
              <div>
                <input type="text" name="rlogin" placeholder="Логин" minlength="2" maxlength="32" required>
              </div>
              <div>
                <input type="password" name="rpassword" placeholder="Пароль" minlength="2" maxlength="32" required>
              </div>

              <div >
                <button class="button-box" type="submit" name="send2">Создать аккаунт</button>
              </div>
            </div>

            <div>
              
            </div>
          </div>

        </form>

        <form class="signin-tab tab-form active" action="source/signin.php" method="POST" id='myForm'>
          <div class="form-container">
            <div>
              <div>
                <input type="text" name="login" id='login' placeholder="Логин" minlength="2" maxlength="32" required>
                <span id="loginError"></span>
              </div>
              <div>
                <input type="password" id='password' name="password" placeholder="Пароль" minlength="2" maxlength="32" required>
                <?php if (isset($_SESSION['validation']['result'])) {
                    echo $_SESSION['validation']['result'];
                } ?>
                <span id="passwordError"></span>
              </div>

              <div >
                <button class="button-box" type="submit" name="send">Войти</button>
              </div>
            </div>

            <div>
             
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>


  <script src="js/script.js"></script>
  <script src="js/auth.js"></script>
<script src=" ">
    
</script>

</body>

</html>