<?php
    require "_dbconnect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Result</title>
    <link rel="stylesheet" href="style/navbar.css">
    <link rel="stylesheet" href="style/signupAndloginButton.css">
    <link rel="stylesheet" href="style/threadlist.css">
    <link rel="stylesheet" href="style/footer.css">
    <style>
    #search_result {
        position: relative;
        left: 50%;
        transform: translateX(-50%);
        margin-top: 10px;
        width: 80%;
    }

    .result {
        border: 1px solid black;
    }

    .question {
        width: 100%;
    }

    footer {
        margin-top: 200px;
    }
    </style>
</head>

<body>
    <?php
        require "_header.php";
    ?>

    <div id="search_result">
        <h2>
            Search Results for
            <?php
                echo "<em>'";
                echo $_GET['search'];
                echo "'</em>";
                ?>
        </h2>
                <?php
                    $SearchQuery = $_GET['search'];
                    $getQuestions = "SELECT * FROM `idiscuss`.`threads` where match (thread_title,thread_descrapation) against ('$SearchQuery') ";
                    $gettingQuestions = mysqli_query($conn,$getQuestions);
                    // $NumberofResult = mysqli_num_rows($gettingQuestions);
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
                            <img src="images/user.png" alt="User">
                            <div class="user-data">
                                <h3>'.$question_title.'</h3>
                                <span>'.$UserName.'</span>
                                <span>Date : '.$question_date.'</span>
                            </div>
                        </div>
                        <div class="problem">
                            <p>'.$question_descripation.'</p>
                            <a href="thread.php/?id = '.$row['thread_id'].'">Answer</a>
                        </div>
                    </div>';
                }
                if ($noResult) {
                    echo '<div class = "question" >
                        <h2 style ="margin-bottom : 10px;">Sorry! No Results Found</h2>
                        <b>Suggesitions : </b>
                        <ul style = "list-style-position : inside";>
                            <li>Make Sure that all words are splled correctly.</li>
                            <li>Try Diffrent Keywords</li>
                            <li>Try More Genreal Keywords</li>
                        </ul>
                    </div>';
                }
                ?>
        
    </div>
    <?php
        require "_footer.php";
    ?>
</body>

</html>