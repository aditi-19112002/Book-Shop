<?php
 include_once "connect.php";
  
if(!isset($_GET['book_id'])){
    echo "<script>window.open('index.php', _self')</script>";
}
 ?>

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
    <div class="bg-gray-200 w-64 h-[260vh]">
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
<div class="flex-1 bg-gray-400">
    <h2 class="font-bold text-black text-2xl ml-5">New Cookbooks - Fall 2023 <i class="bi bi-arrow-down-circle-fill"></i></h2>
    <div class="flex">
    <div class="w-full">
        
            <?php
        
            $book_id = $_GET['book_id'];
            
         $query = mysqli_query($connect, "Select * from books JOIN categories ON books.category=categories.cat_id WHERE id='$book_id'");
          $data = mysqli_fetch_array($query);
            ?>
            <div class="grid grid-cols-4">
            <div class="w-4/4 ml-2 mt-2 mr-2">
                <div class="bg-white shadow-md rounded-md p-4">
                    <img src="<?= "images/".$data['cover_image'];?>" alt="Image" class="w-52 h-42 object-cover rounded-t-md">
                </div>
            </div>
            <div class="w-4/4">
            <table>
             <thead>
            <tr>
            <th class="p-4 text-black">Title:</th>
            <td class="p-4"><?=$data['title'];?></td>
        </tr>  
        <tr>
            <th class="p-4 text-black">Category:</th>
            <td class="p-4"><?=$data['cat_title'];?></td>
        </tr> 
        <tr>
            <th class="p-4 text-black">No of pages:</th>
            <td class="p-4"><?=$data['no_of_pages'];?></td>
        </tr> 
        <tr>
            <th class="p-4 text-black">Author:</th>
            <td class="p-4"><?=$data['author'];?></td>
        </tr>
        <tr>
            <th class="p-4 text-black">Price:</th>
            <td class="p-4"><?=$data['price'];?></td>
        </tr>
         <tr>
    <th> <a href="" class="bg-green-400 hover:bg-blue-900 text-white py-2 px-4 rounded-md inline-block">Buy now</a></th>
    <th> <a href="cart.php?book_id=<?= $data['id'];?>&atc=true" class="bg-yellow-300  text-black py-2 px-4 rounded-md inline-block">Add to cart</a></th>
                    </tr>            
                    </div>

        </thead>
       </table>
       <br>
       <tr>
            <th class="p-4 text-black">Description:</th>
            <td class="p-4"><?=$data['description'];?></td>
        </tr>
            </div>
        </div>
        <h2 class="text-2xl font-bold ml-4"> Related Books</h2>

        <div class="grid grid-cols-4">
            <?php
                 
                $query = mysqli_query($connect, "Select * from books JOIN categories ON books.category=categories.cat_id where id <>'$book_id'");
        
    
          $count=mysqli_num_rows($query);

          if($count < 1){
            echo "<h1 class=text-4xl> Not avaible that books<h1>";
          }
            while($data = mysqli_fetch_array($query)){
            ?>
            <div class="w-4/4 ml-2 mt-8 mr-2">
                <div class="bg-white shadow-md rounded-md p-4"style="height:250px;object-fit:cover">
                    <img src="<?= "images/".$data['cover_image'];?>" alt="Image" class="w-42 h-32 object-cover rounded-t-md">
                    <div class="p-4">
                        <h5 class="text-xl font-semibold"style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;" title="<?=$data['title'];?>"><?=$data['title'];?></h5>
                        <a href="view book.php?book_id=<?=$data['id'];?>" class="bg-green-400 hover:bg-blue-900 text-white py-2 px-4 rounded-md inline-block mt-2 mr-3">view</a>
                       
                    </div>
                </div>
            </div>
            <?php } ?>
            </div>
</div>

</body>
</html>
