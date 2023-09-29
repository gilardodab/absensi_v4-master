<?php
// Include koneksi ke database (pastikan variabel $connection telah diinisialisasi)
require_once'../../sw-library/sw-config.php'; 
include_once'../../sw-library/sw-function.php';
	$salt 			= '$%DSuTyr47542@#&*!=QxR094{a911}+';
	$ip_login 		= $_SERVER['REMOTE_ADDR'];
	$created_login	= date('Y-m-d H:i:s');
	$iB 			= getBrowser();
	$browser 		= $iB['name'].' '.$iB['version'];
// Ambil data dari form register
if (isset($_POST['submit'])) {
    $username = htmlentities($_POST['username']);
    $password = hash('sha256', $salt . $_POST['password']);
    $fullname = $_POST['fullname'];

    // Cek apakah username sudah digunakan
    $check_query = "SELECT * FROM user WHERE username='$username'";
    $check_result = $connection->query($check_query);

    if ($check_result->num_rows > 0) {
        echo "Username sudah digunakan. Silakan pilih username lain.";
    } else {
        // Generate session dan insert data pengguna ke dalam database
        $session = md5(rand(1000, 9999) . rand(19078, 9999) . date('ymdhisss'));

        $insert_query = "INSERT INTO user (username, password, fullname, created_login, session) VALUES ('$username', '$password', '$fullname', '$created_login', '$session')";
        if ($connection->query($insert_query) === TRUE) {
            echo "Registrasi berhasil. Silakan login.";
        } else {
            echo "Error: " . $insert_query . "<br>" . $connection->error;
        }
    }
}
?>

<!-- Form Register -->
<form method="post" action="">
    <label for="username">Username:</label>
    <input type="text" name="username" required><br><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required><br><br>

    <label for="fullname">Full Name:</label>
    <input type="text" name="fullname" required><br><br>

    <input type="submit" name="submit" value="Register">
</form>
