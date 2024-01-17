<header class=" bg-white py-4 px-4 flex items-center justify-between">
        
        <div class="flex items-center">
            <img src="https://rails-assets-us.bookshop.org/ds/images/logo.041f4577edde0efff6b67907832d4c3dfd52407b.svg" alt="Logo" class="w-36 mr-2">
        </div>

   <form method="GET" action="index.php" class="flex text-center bg-gray-200  border border-pink-500 rounded-full">
        <input type="text" name="query" placeholder="Search books, author, ISBNs" size="45"class="rounded-full py-1 px-2" 
          style="background-color: transparent; border: none;">
        <button type="submit" class="bg-transparent text-black py-1 px-2 rounded-full">
        <i class="bi bi-search"></i>
        </button>
      </form>

        <div class="flex items-center">
            <a href="index.php" class="text-black text-lg mr-4">Home</a> 
            <a href="index.php " class="text-black text-lg mr-4">sign in</a>
             <?php if(isset($_SESSION['account'])): 
              $email = $_SESSION['account'];
              $getuser = mysqli_query($connect,"select * from accounts where email = '$email'");

              $getuser = mysqli_fetch_array($getuser);
              
              ?> 
               <a href="index.php" class="text-black text-lg mr-4"><?=$getuser['name'];?></a> 
            
            <a href="cart.php" class="text-black text-lg mr-4">Cart</a>
            <a href="logout.php" class="text-black text-lg mr-4">logout</a>     
            <?php else:?>
              <a href="login.php" class="text-black text-lg mr-4">login</a>  
              <a href="register.php" class="text-black text-lg mr-4">create an account</a> 
              <a href="" class="text-md font-bold">
                <i class="bi bi-cart-fill"></i>
            </a>
            <?php endif;?> 
</div>
</header>
