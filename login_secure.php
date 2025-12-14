<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = mysqli_connect("localhost", "phpuser", "php123", "testdb");
if (!$conn) {
    die("Database connection failed");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Secure Login</title>
</head>
<body>

<h2>Secure Login Page</h2>

<form method="POST">
    Username: <input type="text" name="username"><br><br>
    Password: <input type="text" name="password"><br><br>
    <input type="submit" value="Login">
</form>

<?php
if (isset($_POST['username'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // ✅ Secure query (prepared statement)
    $stmt = mysqli_prepare(
        $conn,
        "SELECT * FROM users WHERE username=? AND password=?"
    );
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<p style='color:green'>Login Successful</p>";
    } else {
        echo "<p style='color:red'>Invalid Credentials</p>";
    }
}
?>

</body>
</html>

