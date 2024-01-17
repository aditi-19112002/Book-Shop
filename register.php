
<?php include_once "connect.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
     <?php include "header.php";?>
        

     <div class="container mx-auto">
  <div class="flex item-center mt-4">
    <div class="w-1/3 bg-white text-black shadow-md p-4">
      <div class="font-semibold text-xl">
        <h1>create an account</h1>
      </div>
      <div class="card-body">
        <form action="" method="POST">
          <div class="mb-3">
            <label for="" class="block text-black"> Name:</label>
            <input type="text"name="name" class=" form-control w-full px-3 py-2 border rounded-lg">
          </div>
          <div class="mb-3">
            <lable for=""class="block text-black">Email:</lable>
            <input type="text" name="email" class="form-control w-full px-3 py-2 border rounded-lg">
         </div>
         <div class="mb-3">
            <lable for=""class="block text-black">Password:</lable>
            <input type="text" name="password"  class="form-control w-full px-3 py-2 border rounded-lg">
         </div>
         <div class="mb-3">
            <input type="submit" name="create" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" value="sign up">
          </div>
</form> 
<?php
  if(isset($_POST['create'])){
    $_name = $_POST['name'];
    $_email = $_POST['email'];
    $_password = $_POST['password'];

    $query = mysqli_query($connect,"INSERT INTO accounts(name,email, password)VALUE('$_name','$_email','$_password')");

    if($query){
      echo"<script>window.open('login.php','_self')</script>";
    }
    else{
      echo"<script>alert('failed')</script>";
    }

  }
  ?>

</div>
</div>
</div>
</div>
                
</body>
</html>