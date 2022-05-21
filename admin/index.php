<?php include "head.php"; ?>

<style>

    body{
        margin: 0;
    }

    .header{
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 2rem;
        margin-bottom: 0;
        background-color: #706d6d; 
    }

    .header .header-text p{
        font-size: 2rem;
        margin: 0;
    }

    .header .nav a{
        display: flex;
        align-items: center;
        color: #fff;
    }

    .dasboard-container{
        display: flex;
    }

    .wrapper-page{
        padding: 2rem;
        flex-basis: 80%;
        max-width: 80%;
        width: 100%;
    }

    .wrapper-page .dashboard-item{
        flex-basis: 25%;
        max-width: 25%;
        width: 100%;
        padding: 0 15px;
    }

    .dasboard-items{
        display: flex;
    }

    .dashboard-info{
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: lightblue;
        padding: 0.8rem;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .dashboard-info i{
        font-size: 5.5rem;
    }

    .dashboard-info .dasboard-numbers{
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .dashboard-info .dasboard-numbers span{
        padding: 0.2rem 0;
    }

    .dashboard-info .dasboard-numbers span:nth-child(1){
        font-size: 3rem;
    }

    .wrapper-page .dashboard-item .dasboard-link{
        padding: 0.8rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
        border: 2px solid lightblue;
    }

</style>
<?php include "navigation.php"; ?>
<div class="dasboard-container">
    <?php include "aside.php"; ?>
    <div class="wrapper-page">
        <div class="dasboard-items">
            <div class="dashboard-item">
                <div class="dashboard-info">
                <i class="fas fa-hotel"></i>
                    <div class="dasboard-numbers">
                        <?php 
                        
                        $query_select_objects = "SELECT COUNT(ObjectId) As ObjectId FROM `object`";
                        $query_select_objects_result = mysqli_query($connection, $query_select_objects);

                        if(!$query_select_objects_result)
                        {
                            die("Query failed: " .mysqli_connect_error($connection));
                        }
                        else
                        {
                            $row = mysqli_fetch_assoc($query_select_objects_result);
                            $object_id = $row["ObjectId"];
                            echo "<span>$object_id</span>";
                        }
                        
                        ?>
                        <span>Objects</span>
                    </div>
                </div>
                <div class="dasboard-link">
                    <a href="objects.php">View Details</a>
                    <i class="fas fa-chevron-circle-right"></i>
                </div>
            </div>
            <div class="dashboard-item">
                <div class="dashboard-info">
                <i class="fas fa-house-user"></i>
                    <div class="dasboard-numbers">
                        <?php 
                        
                        $today = date("Y-m-d");
                        $query_select_subobjects = "SELECT COUNT(SubObjectId) As SubObjectId FROM reservation WHERE '$today' BETWEEN FromDate AND ToDate";
                        $query_select_subobjects_result = mysqli_query($connection, $query_select_subobjects);

                        if(!$query_select_subobjects_result)
                        {
                            die("Query failed: " .mysqli_connect_error($connection));
                        }
                        else
                        {
                            $row = mysqli_fetch_assoc($query_select_subobjects_result);
                            $subobject_id = $row["SubObjectId"];
                            echo "<span>$subobject_id</span>";
                        }
                        
                        ?>
                        <span>Active Sub Objects</span>
                    </div>
                </div>
                <div class="dasboard-link">
                    <a href="sub-objects.php">View Details</a>
                    <i class="fas fa-chevron-circle-right"></i>
                </div>
            </div>
            <div class="dashboard-item">
                <div class="dashboard-info">
                <i class="fas fa-user"></i>
                    <div class="dasboard-numbers">
                        <?php 
                        
                        $query_select_users = "SELECT COUNT(UserId) As UserId FROM user where `user`.StatusId!=3";
                        $query_select_users_result = mysqli_query($connection, $query_select_users);

                        if(!$query_select_users_result)
                        {
                            die("Query failed: " .mysqli_connect_error($connection));
                        }
                        else
                        {
                            $row = mysqli_fetch_assoc($query_select_users_result);
                            $user_id = $row["UserId"];
                            echo "<span>$user_id</span>";
                        }
                        
                        ?>
                        <span>Users</span>
                    </div>
                </div>
                <div class="dasboard-link">
                    <a href="users.php">View Details</a>
                    <i class="fas fa-chevron-circle-right"></i>
                </div>
            </div>
            <div class="dashboard-item">
                <div class="dashboard-info">
                <i class="fas fa-comment-dots"></i>
                    <div class="dasboard-numbers">
                     <?php 
                        
                        $query_select_comments = "SELECT COUNT(UserObjectRatingId) As UserObjectRatingId FROM userobjectrating";
                        $query_select_comments_result = mysqli_query($connection, $query_select_comments);

                        if(!$query_select_comments_result)
                        {
                            die("Query failed: " .mysqli_connect_error($connection));
                        }
                        else
                        {
                            $row = mysqli_fetch_assoc($query_select_comments_result);
                            $comment_id = $row["UserObjectRatingId"];
                            echo "<span>$comment_id</span>";
                        }
                        
                        ?>
                        <span>Comments</span>
                    </div>
                </div>
                <div class="dasboard-link">
                    <a href="comments.php">View Details</a>
                    <i class="fas fa-chevron-circle-right"></i>
                </div>
            </div>
        </div>
        <div style="margin-top: 3rem;">
            <div style="padding: 0 15px;">
                
                <script>
                
                    google.charts.load('current', {'packages':['bar']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                          ['Date', 'Count'],
                            
                            <?php 
                            
                            $element_text = ['Objects', 'Active Subobjects', 'Users', 'Comments'];
                            $element_count = [$object_id, $subobject_id, $user_id, $comment_id];
                                        
                            for($i = 0; $i<4; $i++)
                            {
                                echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
                            }
                            
                            
                            ?>                            
                        ]);

                        var options = {
                            chart: {
                            title: '',
                            subtitle: '',
                          }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                
                </script>
                
                <div id="columnchart_material" style="width: auto; height: 500px;"></div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
