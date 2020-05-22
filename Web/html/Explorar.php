<?
session_start();
if ($_SESSION['autentificado'] == "0") {
    header("Location:index.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Mexicash</title>
</head>
<body>
    <div class="menuContainer" ></div>
</body>
    <script>
        $(document).ready(function () {
            $('.menuContainer').load('menu.php');
        });
    </script>
</html>