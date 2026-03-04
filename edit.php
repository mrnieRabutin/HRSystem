<?php
include "config/db.php";
$id=$_GET['id'];
$data=$conn->query("SELECT * FROM appointments WHERE id=$id")->fetch_assoc();
?>

<form action="update.php" method="post">
<input type="hidden" name="id" value="<?php echo $data['id']; ?>">
Fullname: <input name="fullname" value="<?php echo $data['fullname']; ?>">
<button>Update</button>
</form>