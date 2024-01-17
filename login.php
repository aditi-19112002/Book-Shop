<?php include_once "connect.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
     <?php include "header.php";?>
        

     <div class="container mx-auto">
  <div class="flex item-center mt-4">
    <div class="w-1/3 bg-white text-black shadow-md p-4">
      <div class="font-semibold text-xl">
        <h1>Login here</h1>
      </div>
      <div class="card-body">
        <form action="" method="POST">
          <div class="mb-3">
            <lable for=""class="block text-black">Email:</lable>
            <input type="text" name="email" class="form-control w-full px-3 py-2 border rounded-lg">
         </div>
         <div class="mb-3">
            <lable for=""class="block text-black">Password:</lable>
            <input type="text" name="password"  class="form-control w-full px-3 py-2 border rounded-lg">
         </div>
         <div class="mb-3">
            <input type="submit" name="login" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" value="sign in">
          </div>
</form> 
<?php
  if(isset($_POST['login'])){
    $_email = $_POST['email'];
    $_password = $_POST['password'];

    $query = mysqli_query($connect,"select * from accounts where email ='$_email'AND password = '$_password'");

    $count = mysqli_num_rows($query);
    $checksucessLevel = mysqli_fetch_array($query);


    if($count > 0){

      $_SESSION['account']=$_email;
       
        if($checksucessLevel['IsAdmin'] == 1){
          $_SESSION['admin']=$_email;
          echo"<script>window.open('admin/index.php','_self')</script>";
        }
        else{
        
          echo"<script>window.open('index.php','_self')</script>";
        }
      
    }
    else{
      echo"<script>alert('username and password is invalid try again')</script>";
    }

  }
  ?>

</div>
</div>
</div>
</div>
                
</body>
</html>