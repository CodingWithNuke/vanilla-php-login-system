<?php
include('./config/db.php');

$errors = [];

// Check if user is already logged in, if so redirect to dashboard
if (isset($_SESSION['_id']) && $_SESSION['_id']) {
  header('Location: http://' . $_SERVER['SERVER_NAME'] . '/dashboard.php');
}

// Check if request is a post request to register
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = $_POST['password'];

  // Check for username rules
  if (empty($username)) {
    array_push($errors, 'Username is required.');
  } else if (strlen($username) < 4) {
    array_push($errors, 'Username must be between 4 and 50 characters.');
  }

  // Check for password rules
  if (empty($password)) {
    array_push($errors, 'Password is required.');
  } else if (strlen($password) < 6) {
    array_push($errors, 'Password must be more than 6 characters.');
  }

  // Now we can hash the password
  $password = hash('sha256', $password);

  // No errors, registration starts...
  if (!count($errors)) {
    $sql = "SELECT _id FROM users WHERE username = :username";
    if ($stmt = $db->prepare($sql)) {
      $stmt->bindParam(':username', $username);

      if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
          array_push($errors, 'This username is already in use.');
        }
      }

      unset($stmt);
    }
  }

  // No errors, registration continues...
  if (!count($errors)) {
    $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
    if ($stmt = $db->prepare($sql)) {
      $stmt->bindParam(':username', $username);
      $stmt->bindParam(':password', $password);

      if ($stmt->execute()) {
        header('Location: http://' . $_SERVER['SERVER_NAME'] . '/login.php');
      } else {
        array_push($errors, 'Something went wrong. Please try again later.');
      }

      unset($stmt);
    }
  }
}

?>

<?php
$title = 'Login';
include('./includes/header.php')
?>
<div class="card">
  <div class="card-body">
    <h5 class="card-title">Register an Account</h5>

    <?php if (count($errors)) : ?>
      <div class="alert alert-danger mt-3" role="alert">
        <?php foreach ($errors as $error) : ?>
          <?php echo $error; ?> <br />
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input class="form-control" name="username" id="username" maxlength="50" minlength="4" type="text" value="<?php if (isset($_POST['username'])) echo $_POST['username'] ?>" />
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input class="form-control" name="password" id="password" type="password" minlength="6" />
      </div>
      <button class="btn btn-primary" type="submit">Register</button>
    </form>
  </div>
</div>
<?php
include('./includes/footer.php')
?>