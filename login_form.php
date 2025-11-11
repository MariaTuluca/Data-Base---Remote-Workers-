<?php
include('server.php');
ini_set('display_errors', 1); 
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $parola = $_POST['parola'] ?? '';

    if (empty($email) || empty($parola)) {
        echo "<script>alert('Completează email și parola.');</script>";
    } else {
        $sql = "SELECT Parola FROM Utilizatori WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($parola, $user['Parola'])) {
                echo "<h2 style='color:green;'>Autentificare reușită!</h2>";
                // header("Location: pagina_principala.php");
                // exit();
            } else {
                echo "<h2 style='color:red;'>Parolă incorectă!</h2>";
            }
        } else {
            echo "<h2 style='color:red;'>Email inexistent!</h2>";
        }

        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Autentificare</title>
    <link rel="stylesheet" href="paginaBD.css">
</head>
<body>
    <form action="login_form.php" method="post">
        <h2>Autentificare</h2>
        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Parolă:</label>
        <input type="password" name="parola" required>

        <button type="submit">Conectează-te</button>
    </form>
</body>
</html>
