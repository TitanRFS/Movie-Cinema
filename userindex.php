<?php
session_start();
$_SESSION['theatre_n']=null;
$_SESSION['timer']=null;
?>


<html>
<head>
    <title>User Dashboard</title>
    <link href="css/animate.css" type='text/css' rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/swiper.min.css">
    <link rel="stylesheet" type="text/css" href="css/userdashboardstyles.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>


<style>
    .navbar li a:hover {
        background-color: black;
        color: white;

    }

    .navbar ul
    {
        height:50px;
        list-style-type: none;
        overflow: hidden;
        background-color: #ffffff;
    }

    .navbar li a {
        float: left;
        display: block;
        color:white;
        text-align: center;
        padding: 12px 16px;
        text-decoration: none;
        font-size: 22px;
    }

    .navbar li a.active {
        background-color:black;
        color: white;
    }


    .navbar .search-container {
        float: right;
    }

    .navbar input[type=text] {
        padding: 6px;
        margin-top: 2px;
        font-size: 17px;
        border: none;
    }

    .navbar .search-container button {
        float: right;
        padding: 7.5px 10px;
        margin-top: 2px;
        margin-right: 16px;
        background: #ddd;
        font-size: 17px;
        border: none;
        cursor: pointer;
    }

    .navbar .search-container button:hover {
        background: #ccc;
    }


</style>
<body class="animated fadeIn">
<div class='navbar'>
    <ul>
        <li>
            <div class="toggle-btn" onclick="sidebarToggleButton()">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </li>

        <li><img src="images/logo.png" style="padding-left:50px;padding-right:20px;padding-top:8px;float:left;height:35px;width:250px" /></li>

        <li ><a class="active" href="userindex.php">Home</a></li>

        <?php if(isset($_SESSION['name']))
        {?>
            <li style="padding-left:50px;padding-right:20px;padding-top:6px;"><button class='sign' onclick="document.location.href='userlogout.php'">Logout</button></li>
        <?php }else{?>
            <li style="padding-left:50px;padding-right:20px;padding-top:6px;"><button class='sign'  onclick="document.location.href='index.php'">Login In</button></li>
        <?php }?>



        <div class="search-container">
            <form method="post">
                <input type="text" placeholder="Search Movie" name="search">
                <button type="submit" name="search1" ><i class="fa fa-search"></i></button>
            </form>
        </div>

    </ul>
</div>

<?php
//??? ??????? ? ????????? ???????
//?? ??? ?????? ?? ????? ??? ??????? ??? ???? ?????????, ???? ??????????? ?????? ??????
//?? ?????? ?? ????? ??? ??????? ??? ???? ?????????, ???? ??????????? ? ?????? ??? ???????

if(isset($_POST['search1'])) {
    $movie=$_POST['search'];
    include('databaseconnect.php');
    $querysearch1 = "Call searchmovie('$movie'); ";
    $resultq=mysqli_query($conn,$querysearch1);
    $rows=mysqli_num_rows($resultq);
    if($rows==0) {
        $_SESSION['noid']=$movie;
        header('location:moviedetails.php');
    }
    $row = mysqli_fetch_array($resultq);
    $_SESSION['mid']=$row['Movie_id'];
    header('location:moviedetails.php');
}

?>
<div id="sidebar">
    <ul>

        <li><center><img src="images/profile.png" width="150px" height="150px" /></center></li>
        <?php if(isset($_SESSION['name']) && isset($_SESSION['email']))
        {
            ?>
            <li>Name : <?php echo $_SESSION['name'];?></li>
            <li>Email : <?php echo $_SESSION['email'];?></li>
            <li>Movie Booked : <br>

                <?php
                $user=$_SESSION['name'];
                include 'databaseconnect.php';
                $qry5 = "select * from bookings where username='$user' ";
                $resultq=mysqli_query($conn,$qry5);
                while($bomov=mysqli_fetch_array($resultq)){
                    echo nl2br("\n"."Movie-".$bomov['movie']."\nDate-".$bomov['date']."\n");
                }
                ?>
            </li>

        <?php }else{?>
            <li><h4>??? ????? ????????????. ?????????? ??? ?? ???????? ?????????.</h4></li>
        <?php }?>

    </ul>
</div>



<?php
include('databaseconnect.php');
//??? ??????? ? ???????? ??? ??????? ???? ?????? ??????
//??????????? ?? ????? ??? ???????, ? ????? ??? ???????, ? ?????????? ??????????? ??? ? ?????? ??? ???????
//??????, ??????? ??? ??? ?????? ??? ??????? ?? ?????? ??? ?????? ??? ???????
// ??? ??? ?????? ??? ??????? ?? ?????? ??? ?????? ??? ???????? ??????????
$querysearch1 = "SELECT * from movies";

$resultq = mysqli_query($conn,$querysearch1);


$row_count=mysqli_num_rows($resultq);
?>

<div class="swiper-container">
    <div class="swiper-wrapper">
        <?php
        for($i=0;$i<$row_count;$i++)
        {
            $row1 = mysqli_fetch_array($resultq);
            ?>
            <div class="swiper-slide">
                <div class="imgBx">
                    <img src="<?php echo $row1['poster'];?>" width="300px" height="300px">
                </div>
                <div class="details">
                    <h3><?php echo $row1['Movie_Name'];?><br><span><?php echo $row1['type'];?></span></h3>
                </div>
            </div>


            <?php
        }
        ?>




    </div>
    <div class="swiper-pagination"></div>
</div>


<br>

<div style="background-color: #ffffff;">
    <br><br>
    <h2 class="headings" style="margin-left:30px;color:#dashstyle.css;font-size:30px;text-decoration:underline;text-decoration-color:#000000;">NEW RELEASES</h2>
</div>
<h2 style="position:absolute;left:30px;top:650px">DRAMA/ACTION <i class="right"></i></h2>


<div class="movie-list">

    <table height="500px" width="100%">



        <tr style="padding-top:20px;padding-bottom:10px;">
            <?php

            include('databaseconnect.php');
            $query6 = "select * from movies where type like '%action%'";
            $run = mysqli_query($conn,$query6);
            $rows=mysqli_num_rows($run);
            while($row = mysqli_fetch_array($run))
            {
                if($row['Release_date'])
                {
                    ?><td width="25%">
                    <center>
                        <div class="movie-detailscss">

                            <a href="moviedetails.php?id=<?php echo $row['Movie_id'];?>">
                                <img height="300px" width="300px" style="transition:0.75s;border-radius:20px;" src="<?php echo $row['poster']?>">
                            </a>
                        </div>

                    </center>
                    </td>


                <?php }

            }?>

        </tr>
        </tr>

    </table>

</div>



<div class="book" style="background-color:#ffffff" ><center><form action="ticket-booking.php" method="post"> <input type="submit" name="submit" value="Book Now"> </form></center>
</div>


<?php
//E?? ????????? ??? ?????? ???? ??????? ?? ?????? ??? ?????? ??? ???????? ??????????
if(isset($_POST["submit"])) {
    header('location:ticket-booking.php');
}
?>


<script type="text/javascript" src="js/swiper.min.js">
</script>

<?php  //??? ????? ?? image slider ??? ????????????? ?? javascript?>

<script>
    var swiper = new Swiper('.swiper-container', {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',
        coverflowEffect: {
            rotate: 1,
            stretch: 0,
            depth: 200,
            modifier: 4,
            slideShadows : true,
        },
        autoplay: {
            delay: 4100,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
        },
    });
</script>



<script>
    function sidebarToggleButton()
    {
        document.getElementById("sidebar").classList.toggle("active");

    }

</script>


</body>
</html>
