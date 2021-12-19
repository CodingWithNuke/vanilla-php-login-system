<?php
include('./config/db.php');
include('./config/session.php');

$stmt = $db->prepare("SELECT username FROM users WHERE _id = :id");
$stmt->bindParam(':id', $_SESSION['_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_OBJ);
?>

<?php
$title = 'Dashboard';
include('./includes/header.php')
?>
<h1>Welcome back, <?php echo $user->username; ?></h1>
<?php
include('./includes/footer.php')
?>