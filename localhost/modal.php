<div class="auth-modal-container" id="authorization-container">
  <div class="auth-modal-box">
    <div class="auth-switch-buttons">
      <div class="switch-flex">
        <label class="tab active">Регистрация</label>
        <label class="tab">Авторизация</label>
      </div>
      <div class="close-cross">
        <img src="img/cross.svg" id="auth-close-btn">
      </div>
    </div>
    <div>
      <form class="signup-tab tab-form active" action="source/signup.php" method="POST">
        <div class="form-container">
          <div>
            <div class="auth-input-container">
              <input class="input-box" type="text" name="rsurname" placeholder="Фамилия" required>
              <input class="input-box" type="text" name="rname" placeholder="Имя" required>
              <input class="input-box" type="text" name="rpatr" placeholder="Отчество" required>
              <input class="input-box" type="email" name="remail" placeholder="E-mail" required>
              <input class="input-box" type="text" name="rlogin" placeholder="Логин" required>
              <input class="input-box" type="password" name="rpassword" placeholder="Пароль" required>
            </div>
 
            <div class="auth-submit-btn">
              <button class="button-box" type="submit" name="send2">Создать аккаунт</button>
            </div>
          </div>

          <div>
            
          </div>
        </div>

      </form>

      <form class="signin-tab tab-form" action="source/signin.php" method="POST">
        <div class="form-container">
          <div style="display: flex;flex-direction: column;justify-content: space-around;">
            <div>
              <div class="auth-input-container">
                <input class="input-box" type="text" name="login" placeholder="Логин">
                <input class="input-box" type="password" name="password" placeholder="Пароль">
                <?php if (isset($_SESSION['validation']['result'])) {
                  echo $_SESSION['validation']['result'];
                } ?>

              </div>


            </div>

            <div class="auth-submit-btn">
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
