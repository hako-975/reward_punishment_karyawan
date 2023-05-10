<navbar class="navbar navbar-fixed-top">
  <div class="navbar-container">
    <a class="navbar-title" href="index.php"><img src="img/logo.png"> <span>Reward & Punishment</span></a>
      <div class="navbar-nav">
        <?php if (isset($_SESSION['id_user'])): ?>
          <div class="dropdown">
            <button class="dropdown-button button">Menu</button>
            <ul class="dropdown-menu">
              <li><a class="button" href="reward.php">Reward</a></li>
              <li><a class="button" href="punishment.php">Punishment</a></li>
              <li><a class="button" href="karyawan.php">Karyawan</a></li>
              <li><a class="button" href="profile.php">Profile</a></li>
              <li><a class="button" href="logout.php">Logout</a></li>
            </ul>
          </div>
        <?php else: ?>
          <a class="button" href="login.php">Login</a>
        <?php endif ?>
      </div>
  </div>
</navbar>
