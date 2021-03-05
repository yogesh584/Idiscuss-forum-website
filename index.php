<?php
    require "_dbconnect.php";
    $showError = false;
    $accoutCreated = false;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (isset($_POST['cpassword'])) {
            $cpassword = $_POST['cpassword'];
            $checkExesistingUser = "SELECT * FROM `idiscuss`.`users` WHERE username = '$username'";
            $checkingExesistingUser = mysqli_query($conn,$checkExesistingUser);
            $NumbersOfExestingUser = mysqli_num_rows($checkingExesistingUser);
            if ($NumbersOfExestingUser > 0) {
                $showError = "Username is Already taken";
            }
            else{
                if ($password == $cpassword) {
                    $passwordhash = password_hash($password,PASSWORD_DEFAULT);
                    $insertUserData = "INSERT INTO `idiscuss`.`users` (`sno`, `username`, `password`, `Date of Joining`) VALUES (NULL, '$username', '$passwordhash', CURRENT_TIMESTAMP);";
                    $insertingUserData = mysqli_query($conn,$insertUserData);
                    if ($insertUserData) {
                        $accoutCreated = true;
                    }
                }
                else {
                    $showError = "Password Do not Matched";
                }
            }
        }
        else {
            $selectUser = "SELECT * FROM `idiscuss`.`users` WHERE username = '$username'";
            $selectingUser = mysqli_query($conn,$selectUser);
            $NumberOfUsers = mysqli_num_rows($selectingUser);
            if ($NumberOfUsers == 1) {
                while ($row = mysqli_fetch_assoc($selectingUser)) {
                    if (password_verify($password,$row['password'])) {
                        session_start();
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $username;
                        header('location: index.php');
                    }
                    else {
                        $showError = "Username or Password is wrong";
                    }
                }
            }
            else {
                $showError = "Username or Password is wrong";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>i Discuss</title>
    <link rel="stylesheet" href="style/navbar.css">
    <link rel="stylesheet" href="style/footer.css">
    <link rel="stylesheet" href="style/categories.css">
    <link rel="stylesheet" href="style/signupAndloginButton.css">
    <style>
    #logout {
        position: fixed;
        top: 60px;
        right: 20px;
        background: rgb(16, 209, 103);
        height: 250px;
        padding: 20px;
        border-radius: 10px;
        visibility: hidden;
        opacity: 0;
        transition: all 0.5s;
    }

    #logout ul li {
        list-style: none;
        border-bottom: 1px solid rgba(255, 255, 255, 0.527);
        display: block;
        padding: 15px 10px;
        width: 200px;
    }

    #logout ul li a {
        text-decoration: none;
        color: #fff;
        font-weight: bold;
        font-family: Calibri;
        text-transform: uppercase;
        transition: all 0.5s;
    }

    #logout ul li a:hover {
        color: rgb(14, 95, 161);
    }

    #logout #side {
        position: absolute;
        background: rgb(16, 209, 103);
        height: 20px;
        width: 20px;
        transform: rotate(45deg);
        top: -10px;
        right: 50px;
    }

    #logout.logoutActive {
        visibility: visible;
        opacity: 1;
        top: 55px;
    }
    </style>
</head>

<body>
    <?php
        require '_header.php';
    ?>
    <div id="container">
        <?php
            require '_dbconnect.php';
        ?>
        <?php
            if ($accoutCreated == true) {
                echo "<div id='alert'>
                <span>
                    <strong>Success</strong>
                    Your Account Created Now You can Login
                </span>
                <span id='cross'>
                    &times;
                </span>
            </div>";
            }
            if ($showError) {
                echo "<div id='alert' style ='background : red;color: #fff;opacity:0.95;'>
                <span>
                    <strong>Error</strong>
                    ".$showError."
                </span>
                <span id='cross'>
                    &times;
                </span>
            </div>";
            }
        ?>
        <?php
            require '_categories.php';
        ?>
        <?php
            include '_footer.php';
        ?>
        <div id="logout">
            <div id="side"></div>
            <ul>
                <li><a href="">My Profile</a></li>
                <li><a href="">Settings</a></li>
                <li><a href="">Help</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</body>

</html>
<script src="js/login.js"></script>
<script>
let cross = document.getElementById("cross");

function RemoveAlert() {
    let alert = document.getElementById("alert");
    if (alert != null) {
        alert.style.marginTop = "-150px";
    }
}
if (cross != null) {
    cross.addEventListener("click", RemoveAlert);
}
setTimeout(RemoveAlert, 3000);
</script>