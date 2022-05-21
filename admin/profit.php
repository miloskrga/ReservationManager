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

    table, tr, td, th{
        border: 1px solid black;
        text-align: center;
    }

    .filter-form{
        display: flex;
    }


</style>
<?php include "navigation.php"; ?>
<div class="dasboard-container">
    <?php include "aside.php"; ?>
    <div class="wrapper-page">
        <div style="margin-bottom: 2rem;" class="filter-objects">
            <div class="filter-form">
                <div class="form-input">
                    <label for="">From Date</label>
                    <input type="date" id="date-from">
                </div>
                <div class="form-input">
                    <label for="">&nbsp;&nbsp;&nbsp;&nbsp;To Date</label>
                    <input type="date" id="date-to">
                </div>
                <div class="form-input">&nbsp;&nbsp;&nbsp;&nbsp;                    
                    <button type="button" onclick="filterProfit();">Submit</button>
                </div>
            </div>
        </div>
        <div id="wrapper-table-filter" style="margin-bottom: 4rem;">
        <?php
        $sub_obects_total_price=0;
        $query_select_subobject = "SELECT subobject.`SubObjectId`,subobject.`SubObjectImage`, subobjecttype.`SubObjectTypeName`,subobject.`SubObjectName`, reservation.`FromDate`,reservation.`ToDate`, `object`.`ObjectLink`, subobject.`SubObjectLink`, subobject.Price  from subobject inner join subobjecttype on subobject.SubObjectTypeId=subobjecttype.SubObjectTypeId inner join reservation on subobject.SubObjectId=reservation.SubObjectId INNER join `object` on subobject.ObjectId=`object`.ObjectId";
        $query_select_subobject_result = mysqli_query($connection, $query_select_subobject);

        if(!$query_select_subobject_result)
        {
            die("Query failed:" .mysqli_connect_error($connection));
        }
        else
        {
            $row_counter = mysqli_num_rows($query_select_subobject_result);

            if($row_counter > 0)
            {          
                ?>      
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>SubobjectImage</th>
                            <th>SubobjectType</th>
                            <th>SubobjectName</th>
                            <th>Number of days</th>
                            <th>Sum price</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    
                    while($row = mysqli_fetch_assoc($query_select_subobject_result))
                    {
                        $date_of_days=0;
                        $image_subobject=$row["SubObjectImage"];
                        $id_sub_object = $row["SubObjectId"];
                        $name_sub_object = $row["SubObjectName"];
                        $price = $row["Price"];
                        $link_subobject=$row["SubObjectLink"];
                        $subobject_type=$row["SubObjectTypeName"];
                        $date_from=$row["FromDate"];
                        $date_to=$row["ToDate"];
                        $link_object=$row["ObjectLink"];
                        $date_in_times = strtotime($date_to) - strtotime($date_from);
                        $date_of_days += round($date_in_times/86400);
                        $total_price= $date_of_days * $price;
                        $sub_obects_total_price += $total_price;

                        ?>
                        <tr style='background-color: #a1e2f3;'>
                            <td style="padding: 0.5rem;"><?php echo $id_sub_object;?></td>
                            <td><img style="display: block; width: 5.5rem; height: 4rem; object-fit: cover; margin-left: auto; margin-right: auto; padding: 0.5rem;" src="../objekti/<?php echo $link_object.$link_subobject.$image_subobject; ?>" alt=""></td>
                            <td style="padding: 0.5rem;"><?php echo $subobject_type; ?></td>
                            <td style="padding: 0.5rem;"><?php echo $name_sub_object; ?></td>
                            <td style="padding: 0.5rem;"><?php echo $date_of_days;?></td>
                            <td style="padding: 0.5rem;"><?php echo $total_price;?>&euro;</td>
                        </tr>
                        <?php
                    }?>
                    </tbody>
                    <tfoot>
                        <tr style="background-color: #605f5f;">
                            <td style="padding: 0.5rem;" colspan="4"></td>
                            <td style="padding: 0.5rem;"><b style="color: #fff;">SUM</b></td>
                            <td style="padding: 0.5rem; color: #fff;"><b><?php echo $sub_obects_total_price?>&euro;</b></td>
                        </tr>
                    </tfoot>
                </table>
            <?php

            }
        }
        ?>    
                            

    </div>
</div>
<?php include "footer.php"; ?>
<script src="../js/functions.js"></script>