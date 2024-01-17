<?php include_once "connect.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <?php include_once "header.php";?>
<div class="flex">
    <div class="bg-gray-200 w-64 h-[180vh]">
        <div class="w-64">
                <a href="#" class="block px-4 py-2 bg-blue-500 text-white rounded mb-2">Categories</a>
                
                <?php
                    $query = mysqli_query($connect,"select * from categories");
                    while($row = mysqli_fetch_array($query)){
                ?>
                    <a href="index.php?cat_id=<?=$row['cat_id'];?>" class="block px-4 py-2 bg-white text-black rounded mb-2"><?= $row['cat_title'];?></a>
                <?php } ?>
        </div>
</div>
<div class="flex-1 bg-gray-500">
    <h2 class="font-bold text-white ml-5">New Cookbooks - Fall 2023 <i class="bi bi-arrow-down-circle-fill"></i></h2>
    <div class="flex">
    <div class="w-full">
        <div class="grid grid-cols-4">
            <?php
            if (isset($_GET['query'])) {
                
                $searchQuery = $_GET['query'];

            $query = mysqli_query($connect, "Select * from books JOIN categories ON books.category=categories.cat_id WHERE title LIKE'%$searchQuery%'");
            }
            
            else{
                if(isset($_GET['cat_id'])){
                    $cat_id = $_GET['cat_id'];
                    $query = mysqli_query($connect, "Select * from books JOIN categories ON books.category=categories.cat_id where cat_id='$cat_id'");
                }
            
            else{
                $query = mysqli_query($connect, "Select * from books JOIN categories ON books.category=categories.cat_id");
            }
        }
          $count=mysqli_num_rows($query);

          if($count < 1){
            echo "<h1 class=text-4xl> Not avaible that books<h1>";
          }
            while($data = mysqli_fetch_array($query)){
            ?>
            <div class="w-4/4 ml-2 mt-2 mr-2">
            <div class="image-container">
                <div class="bg-white shadow-md rounded-md p-4"style="height: 350px;object-fit:cover">
                    <img src="<?= "images/".$data['cover_image'];?>" alt="Image" class="w-42 h-32 object-cover rounded-t-md">
                    <div class="p-4">
                        <h5 class="text-xl font-semibold"style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" title="<?=$data['title'];?>"><?=$data['title'];?></h5>
                        <h2 class="h5">Rs.<?=$data['discount_price'];?>/- <del><?=$data['price'];?>/-</del></h2>
                        <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md inline-block mt-2 mr-3"><?=$data['cat_title'];?></a>
                        <a href="view_book.php?book_id=<?=$data['id'];?>" class="bg-green-400 hover:bg-blue-900 text-white py-2 px-4 rounded-md inline-block mt-2 mr-3">view</a>
                       
                    </div>
                </div>
            </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

</div>

</body>
</html>


<style>
    .image-container {
      position: relative;
      overflow: hidden;
    }

     @keyframes movement {
      0% {
        transform: translateX(0);
      }

      50% {
        transform: translateX(50px);
      }

      100% {
        transform: translateX(0);
      }
    }

    .image-container img {
      animation: movement 5s infinite;
    }
  </style>






