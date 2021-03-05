<?php 
require "_dbconnect.php";
$showError = false;
    $accoutCreated = false;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        if (isset($_POST['cpassword'])) {
            $username = $_POST['username'];
            $username = str_replace("<","&lt",$username);
            $username = str_replace(">","&gt",$username);
            $password = $_POST['password'];
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
        elseif (isset($_POST['title'])) {
            $title = $_POST['title'];
            $title = str_replace(">","&gt",$title);
            $title = str_replace("<","&lt",$title);
            $descripation = $_POST['problem'];
            $descripation = str_replace("<","&lt",$descripation);
            $descripation = str_replace(">","&gt",$descripation);
            
            $threadid = $_GET['id_'];
            session_start();
            $username = $_SESSION['username'];
            $getUserid = "SELECT * FROM `idiscuss`.`users` WHERE `username` = '$username'";
            $gettingUserId = mysqli_query($conn,$getUserid);
            $userid;
            $NumberOfUsers = mysqli_num_rows($gettingUserId);
            if ($NumberOfUsers == 1) {
                while ($row = mysqli_fetch_assoc($gettingUserId)) {
                    $userid = $row['sno'];
                }
            }
            $insertQuestion = "INSERT INTO `idiscuss`.`threads` (`thread_id`, `thread_title`, `thread_descrapation`, `thread_cat_id`, `thread_user_id`, `date_of_adding_question`) VALUES (NULL, '$title', '$descripation', '$threadid', '$userid', CURRENT_TIMESTAMP)";
            $insertingQuestion = mysqli_query($conn,$insertQuestion);
        }
        else {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $selectUser = "SELECT * FROM `idiscuss`.`users` WHERE username = '$username'";
            $selectingUser = mysqli_query($conn,$selectUser);
            $NumberOfUsers = mysqli_num_rows($selectingUser);
            if ($NumberOfUsers == 1) {
                while ($row = mysqli_fetch_assoc($selectingUser)) {
                    if (password_verify($password,$row['password'])) {
                        session_start();
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $username;
                        header('location: ../threadslist.php/?id ='.$_GET['id_'].'');
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
<?php
    require '_dbconnect.php';

    $id = $_GET['id_'];
    $getCategoryDetails = "SELECT * FROM `idiscuss`.`category` WHERE `category_id` = $id";
    $gettingCategoryDetails = mysqli_query($conn,$getCategoryDetails);
    while ($row = mysqli_fetch_assoc($gettingCategoryDetails)) {
        $categoryName = $row['category_Name'];
        $categoryDescripation = $row['category_descripation'];
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Threads</title>
    <link rel="stylesheet" href="../style/navbar.css">
    <link rel="stylesheet" href="../style/signupAndloginButton.css">
    <link rel="stylesheet" href="../style/footer.css">
    <link rel="stylesheet" href="../style/threadlist.css">
    <style>
    #logout {
        position: fixed;
        top: 60px;
        right: 20px;
        background: rgb(11, 118, 180);
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
        width: 150px;
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
        color:  rgb(16, 209, 103);;
    }

    #logout #side {
        position: absolute;
        background:  rgb(11, 118, 180);
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
    #loggedout{
        margin-bottom : 25px;
        font-size: 20px;
        margin-top: 10px;
        border: 1px solid black;
        padding: 10px 10px;
        border-radius: 10px;
        width: 70%;
        position: relative;
        left: 50%;
        transform : translateX(-50%);
    }
    </style>
</head>

<body>
    <?php
        require '_header.php';
    ?>
    
    <div id="container">
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
        <div id="jumbodrone">
            <h2>
                Welcome to
                <?php
                echo $categoryName;
            ?>
                forums
            </h2>
            <p>
                <?php
                echo $categoryDescripation;
                ?>
            </p>
            <p>Thread Rules :</p>
            <ul>
                <li>No Advertising / Spam / Self_promotion Allowed</li>
                <li>Do not post Copyright Related content</li>
                <li>Remain Respect of other members</li>
            </ul>
        </div>
        <?php
            
        ?>
        <div id="logout">
            <div id="side"></div>
            <ul>
                <li><a href="">My Profile</a></li>
                <li><a href="">Settings</a></li>
                <li><a href="">Help</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </div>
        <?php
            if (isset($_SESSION['loggedin'])) {
                echo '<div id="askingQuestion">
                <h2>Start a Discussion</h2>
                <form action="" method="post" id="askingQuestionform">
                    <label for="title">Problem Title</label>
                    <input type="text" placeholder="Title" name="title" id="title" required>
                    <label for="problem">Your Problem</label>
                    <textarea name="problem" id="problem" cols="30" rows="10" placeholder="Problem Descripation" required></textarea>
                    <input type="submit" name="submit" id="questionSubmit">
                </form>
            </div>';
            }
            else {
                echo '<div id = "loggedout">
                <p>Please Log in frist for ask a question</p>
            </div>';
            }
        ?>
        
        
        <div class="questions">
            <h2>Browse Questions</h2>
            <?php
            $getQuestions = "SELECT * FROM `idiscuss`.`threads` WHERE thread_cat_id = $id";
            $gettingQuestions = mysqli_query($conn,$getQuestions);
            $noResult = true;
            while ($row = mysqli_fetch_assoc($gettingQuestions)) {
                $noResult = false;
                $question_title = $row['thread_title'];
                $question_descripation = $row['thread_descrapation'];
                $question_date = $row['date_of_adding_question'];
                $question_id = $row['thread_id'];
                $userID = $row['thread_user_id'];
                $getUserName = "SELECT * FROM `idiscuss`.`users` WHERE `sno` = $userID";
                $gettingUserName = mysqli_query($conn,$getUserName);
                $data = mysqli_fetch_assoc($gettingUserName);
                $UserName = $data['username'];

                echo '<div class="question">
                    <div class="user-information">
                        <img src="../images/user.png" alt="User">
                        <div class="user-data">
                            <h3>'.$question_title.'</h3>
                            <span>'.$UserName.'</span>
                            <span>Date : '.$question_date.'</span>
                        </div>
                    </div>
                    <div class="problem">
                        <p>'.$question_descripation.'</p>
                        <a href="../thread.php/?id = '.$row['thread_id'].'">Answer</a>
                    </div>
                </div>';
            }
            if ($noResult) {
                echo "<div class='question' style ='margin-bottom : 25px;font-size: 20px;'>Be The Frist Person to ask The question about this topic</div>";
            }
        ?>

        </div>
        <?php
        require '_footer.php';
    ?>
    </div>
</body>

</html>
<script src="../js/login.js"></script>
<script>
    let cross = document.getElementById("cross");
    function RemoveAlert() {
        let alert = document.getElementById("alert");
        if (alert != null) {
            alert.style.marginTop = "-150px";
        }
    }
    if(cross != null){
        cross.addEventListener("click", RemoveAlert);
    }
    setTimeout(RemoveAlert, 3000);
</script>
<script>
    function username() {
        let logout = document.getElementById("logout");
        logout.classList.toggle("logoutActive");
    }
</script>