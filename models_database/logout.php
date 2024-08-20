<?php
session_start();
if (isset($_POST["confirm_log_out"])) {
session_destroy();
header("location: ../Public_View_Pages/index.php");
exit;
}
?>
