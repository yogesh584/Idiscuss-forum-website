<div id='header'>
    <div id='leftSideWalaContent'>
        <h2><a href='index.php'>iDiscuss</a></h2>
        <ul>
            <li><a href='index.php'>Home</a></li>
            <li><a href='ContectUs.php'>Contact Us</a></li>
            <li><a href='AboutUs.php'>About Us</a></li>
        </ul>
    </div>
    <div id='RightSideWalaContent'>
        <form action="search.php" method = "get">
            <input type='text' id='Search' name='search' placeholder='Search'>
            <input type='submit' value='Search' id='search-btn'>
        </form>
        <?php
            if (session_id() == '') {
                session_start();
            }
            if ((isset($_SESSION['loggedin']))) {
                echo "<h2 id = 'username' onclick ='username()''>".$_SESSION['username']."</h2>";
            }
            else {
                echo '<a onclick = "signup()" class = "loginOrSignup">Sign Up</a>
                      <a onclick = "login()" class = "loginOrSignup">Log in</a>';
            }
        ?>    
    </div>
    <img src="images/toggle.png" alt="" id = "toggle">
</div>
<div id="login">
        <h2>Login</h2>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method = "post">
            <label for="username">Enter Username</label>
            <input type="text" placeholder="Username" id="username" name="username">
            <label for="password">Enter Password</label>
            <input type="password" name="password" id="password" placeholder="password">
            <div>
                <input type="submit" id="submit">
                <input type="reset" value="Cancle" onclick="login()" id="cancle">
            </div>
        </form>
    </div>
    <div id="signup">
        <h2>Sign Up</h2>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method = "post">
            <label for="username">Enter Username</label>
            <input type="text" placeholder="Username" id="SignupUsername" name="username">
            <label for="password">Enter Password</label>
            <input type="password" name="password" id="SignupPassword" placeholder="password">
            <label for="cpassword">Confirm Password</label>
            <input type="password" name="cpassword" id="SignupCpassword" placeholder="Confirm password">
            <div>
                <input type="submit" id="SignupSubmit">
                <input type="reset" value="Cancle" onclick="signup()" id="SignupCancle">
            </div>
        </form>
    </div>
<script>
    function username() {
        let logout = document.getElementById("logout");
        logout.classList.toggle("logoutActive");
    }
</script>
