<div class="direction">
    <h2>iDiscuss - Browse Categories</h2>
    <div class="category">
        <?php
            $categories = "SELECT * FROM `idiscuss`.`category`";
            $Gettedcategories = mysqli_query($conn,$categories);
            $incremant = 1;
            while ($row = mysqli_fetch_assoc($Gettedcategories)) {
                echo "<div class='card'>
                <div class='img'>
                    <img src='images/".$incremant.".jpg' alt='Python'>
                </div>
                <div class='top-text'>
                    <div class='name'>".$row['category_Name']."</div>
                    <p>".$row['category_Small_descripation']."</p>
                </div>
                <div class='bottom-text'>
                    <div class='text'>
                       ".substr($row['category_descripation'],0,600)."
                    </div>
                    <div class='btn'>
                        <a href='threadslist.php/?id = ".$row['category_id']."'>View Threads</a>
                    </div>
                </div>
            </div>";
            $incremant++;
            }
        ?>
    </div>
</div>