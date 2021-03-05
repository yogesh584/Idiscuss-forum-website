<?php
    require '_dbconnect.php';
    
    $thread_id = $_GET['id_'];
    if (session_id() == '') {
        session_start();   
    }
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
    }
    $getUserData = "SELECT* FROM `idiscuss`.`users` WHERE `username` = '$username'";
    $gettingUserData = mysqli_query($conn,$getUserData);
    $row = mysqli_fetch_assoc($gettingUserData);
    $userID = $row['sno'];
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
        elseif(isset($_POST['comment'])){
            $comment = $_POST['comment'];
            $comment = str_replace("<","&lt",$comment);
            $comment = str_replace(">","&gt",$comment);
            $addcomment = "INSERT INTO `idiscuss`.`comments` (`comment_id`, `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES (NULL, '$comment', '$thread_id', '$userID', CURRENT_TIMESTAMP)";
            $addingComment = mysqli_query($conn,$addcomment);
        }
        elseif (isset($_POST['reply'])) {
            // Code for reply
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
                        header('location: ../thread.php/?id ='.$_GET['id_'].'');
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
    <title>Threads</title>
    <link rel="stylesheet" href="../style/navbar.css">
    <link rel="stylesheet" href="../style/signupAndloginButton.css">
    <link rel="stylesheet" href="../style/footer.css">
    <link rel="stylesheet" href="../style/threadlist.css">
    <style>
        .questions {
    width: 70%;
    position: relative;
    left: 50%;
    transform: translateX(-50%);
    }
    
    .question{
        width: 100%;
    }

    #loggedout {
        margin-bottom: 25px;
        font-size: 20px;
        margin-top: 10px;
        border: 1px solid black;
        padding: 10px 10px;
        border-radius: 10px;
        width: 100%;
        position: relative;
        left: 50%;
        transform: translateX(-50%);
    }
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
    .questions .question .problem button {
    display: inline-block;
    padding: 6px 20px;
    margin-top: 15px;
    border-radius: 5px;
    border: 2px solid rgb(14, 190, 93);
    background : #fff;
    color: rgb(14, 190, 93);
    text-decoration: none;
    font-weight: bold;
    transition: all 0.5s;
    cursor: pointer;
    outline: none;
}

.questions .question .problem button:hover {
    background: rgb(14, 190, 93);
    color: #111;
}
    .reply{
        margin-left: 50px;
        transition: all 0.5s;
        display: none;
    }
    .replytext{
        width: 95%;
        height: 60px;
        margin-top: 20px;
        border-radius: 5px;
        padding: 10px 20px;
    }
    .reply button,
    .reply input {
    display: inline-block;
    padding: 6px 20px;
    cursor: pointer;
    outline: none;
    margin-top: 15px;
    border-radius: 5px;
    border: 2px solid rgb(14, 190, 93);
    color: rgb(14, 190, 93);
    text-decoration: none;
    font-weight: bold;
    transition: all 0.5s;
    margin-right: 5px;  
    background: #fff;
}
.reply button {
    margin-top: 5px;
}
.reply button:hover,
.reply input:hover {
    background: rgb(14, 190, 93);
    color: #111;
}
    </style>
</head>

<body>
    <?php
        require '_dbconnect.php';
        require '_header.php';
        $thread_id = $_GET['id_'];
        $getQuestionInfo = "SELECT * FROM `idiscuss`.`threads` WHERE thread_id = $thread_id";
        $gettingQuestionInfo = mysqli_query($conn,$getQuestionInfo);
        $noResult = true;
        while ($row = mysqli_fetch_assoc($gettingQuestionInfo)) {
            $noResult = false;
            $threadTitle = $row['thread_title'];
            $threadDescripation = $row['thread_descrapation'];
            $threadUserId = $row['thread_user_id'];
            $getUserName = "SELECT * FROM `idiscuss`.`users` WHERE `sno` = $threadUserId";
            $gettingUserName = mysqli_query($conn,$getUserName);
            $data = mysqli_fetch_assoc($gettingUserName);
            $username = $data['username'];
        }
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
                <?php
                    echo $threadTitle;
                ?>
            </h2>
            <p>
                <?php
                    echo $threadDescripation;
                ?>
            </p>
            <h3>Posted By :
                <?php
                    echo $username;
                ?>
            </h3>
            <p>Thread Rules :</p>
            <ul>
                <li>No Advertising / Spam / Self_promotion Allowed</li>
                <li>Do not post Copyright Related content</li>
                <li>Remain Respect of other members</li>
            </ul>
        </div>
        <div id="logout">
            <div id="side"></div>
            <ul>
                <li><a href="">My Profile</a></li>
                <li><a href="">Settings</a></li>
                <li><a href="">Help</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="questions">


            <?php
            if (isset($_SESSION['loggedin'])) {
                echo '<div id="askingQuestion" style = "width : 100%";>
                <h2>Post a Comment</h2>
                <form action="" method="post" id="askingQuestionform">
                    <label for="problem">Type your Comment</label>
                    <textarea name="comment" id="comment" cols="30" rows="10" placeholder="Your Comment" required></textarea>
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
            <h2>Discussions</h2>
            <?php
                $id = $_GET['id_'];
                $getCommants = "SELECT * FROM `idiscuss`.`comments` WHERE thread_id = $id";
                $gettingCommants = mysqli_query($conn,$getCommants);
                $noResult = true;
                while ($row = mysqli_fetch_assoc($gettingCommants)) {
                    $noResult = false;
                    $comment_descripation = $row['comment_content'];
                    $comment_id = $row['comment_id'];
                    $comment_date = $row['comment_time'];
                    $userID = $row['comment_by'];
                    $getUserName = "SELECT * FROM `idiscuss`.`users` WHERE `sno` = $userID";
                    $gettingUserName = mysqli_query($conn,$getUserName);
                    $data = mysqli_fetch_assoc($gettingUserName);
                    $UserName = $data['username'];
                    echo '<div class="question">
                        <div class="user-information">
                            <img src="../images/user.png" alt="User">
                            <div class="user-data">
                                <span>Name : <b>'.$UserName.'</b></span>
                                <span> | Date and Time : <b>'.$comment_date.'</b></span>
                            </div>
                        </div>
                        <div class="problem" style = "margin-top : -10px;">
                            <p>'.$comment_descripation.'</p>
                            <button class = "reply-btn">Reply</button>
                        </div>
                        <div class="reply">
                            <form action="" method="post">
                                <textarea name="reply" class="replytext" cols="30" rows="10"></textarea>
                                <input type ="submit" class = "reply-btn2" value="Reply">
                            </form>
                            <button class = "close-btn2">Close</button>
                        </div>
                    </div>';
                }
            ?>
            <?php
                if ($noResult) {
                    echo "<div class='question' style ='margin-bottom : 25px;font-size: 20px;'>Be The Frist Person to ask The Answer of this topic</div>";
                }
            ?>
        </div>
        <?php
            require '_footer.php';
        ?>
    </div>
</body>
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
<script>

    let replybtn = document.getElementsByClassName("reply-btn");
    for(let key of replybtn){
        key.addEventListener("click",(e) =>{
            e.preventDefault();
            key.parentNode.nextSibling.nextSibling.style.display = "block";
            key.style.display = "none";
        });
    };
    let replyCloseBtn = document.getElementsByClassName("close-btn2");
    for(let key of replyCloseBtn){
        key.addEventListener("click",(e)=>{
            e.preventDefault();
            key.parentNode.previousSibling.previousSibling.childNodes[3].style.display = "inline-block";
            key.parentNode.style.display = "none";
        });
    };
</script>
</html>