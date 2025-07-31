<?php
$conn = mysqli_connect("localhost", "root", "", "login");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// LOGIN
if (isset($_POST["login"])) {
    $username = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    $loginSuccess = false;

    while ($row = $result->fetch_assoc()) {
        if ($row["username"] == $username && $row["password"] == $password) {
            $loginSuccess = true;
            break;
        }
    }

    if ($loginSuccess) {
        echo "Login Success";
        echo "<script>window.location.href='dashboard.html';</script>";
    } else {
        echo "<script>window.location.href='loginfail.html';</script>";
    }
}

// REGISTRATION
if (isset($_POST["username"]) && isset($_POST["password"]) && !isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    $alreadyExists = false;

    while ($row = $result->fetch_assoc()) {
        if ($row["username"] == $username) {
            $alreadyExists = true;
            break;
        }
    }

    if ($alreadyExists) {
        echo "<script>alert('User already exists. Please log in.'); window.location.href='index.html';</script>";
    } else {
        $insert = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($insert) === TRUE) {
            echo "Registration Success";
            echo "<script>window.location.href='dashboard.html';</script>";
        } else {
            echo "<script>window.location.href='registerfail.html';</script>";
        }
    }
}

$conn->close();
?>
