
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
    <?php include_once "header.php";
    
    //calling orders and order items here
    $user_id = $getuser['user_id'];
    $order =mysqli_query($connect,"select * from orders where user_id='$user_id'and is_ordered='0'");
    $myOrder = mysqli_fetch_array($order);

    $count_myOrder = mysqli_num_rows($order);

  ?>
   <div class="container mx-auto p-4 flex flex-col md:flex-row md:items-center">
    <div class="flex-grow"> 
    <?php
  if($count_myOrder > 0):
    $myOrderid = $myOrder['order_id'];
    //getting order items
    $myOrderitems = mysqli_query($connect, "select * from order_items JOIN books ON order_items.book_id =books.id where order_id='$myOrderid' and is_orderd='0'");
    $count_order_items = mysqli_num_rows($myOrderitems);

     if($count_order_items):
  ?>

    <h1 class="text-3xl font-semibold mb-4">My Cart (<?= $count_order_items;?>)</h1>
    <div class="grid-cols gap-4">
      <?php
         $total_amount =$total_discounted_amount = 0;  
      while($order_item = mysqli_fetch_array($myOrderitems)): 
      $price = $order_item['quantity'] * $order_item['price'];
      $discount_price = $order_item['quantity'] * $order_item['discount_price'];
      ?>
        <div class="bg-gray-100 p-4 mb-2 rounded-lg flex items-center justify-between">
          <div class="flex items-center">
            <img src="images/<?=$order_item['cover_image'];?>" alt="Product Image" class="w-20">
            <div class="ml-4">
              <h2 class="truncate font-semibold"><?= $order_item['title'];?></h2>
              <h5> ₹<?= $order_item['discount_price'];?> <del><?= $order_item['price'];?></del></h5>
              <div class="mt-2 flex items-center">
                <a href="cart.php?book_id=<?= $order_item['id'];?>&dfc=true" class="bg-red-700 text-white px-4 py-2 rounded">-</a>
                <span class="text-black text-lg ml-2 mr-2"> <?=$order_item['quantity'];?></span>
                <a href="cart.php?book_id=<?= $order_item['id'];?>&atc=true" class="bg-green-700 text-white px-4 py-2 rounded">+</a>
              </div>
            </div>
          </div>
          <a href="#" class="bg-black text-white px-4 py-2 rounded mt-10"><i class="bi bi-trash-fill"></i> Delete</a>
        </div>
      <?php 
         $total_amount += $price;
         $total_discounted_amount += $discount_price;

    endwhile;?>
    </div>
  </div>

  <!-- Price Break Section on the right -->
  <div class="md:ml-4">
    <h1 class="text-3xl font-semibold mb-2">Price Break</h1>
    <ul class="list-none">
      <li class="flex justify-between items-center bg-white text-black p-2 rounded gap-5">
        <span class="font-semibold">Total Amount</span>
        <span class="font-semibold"><?= $total_amount;?></span>
      </li>
      <li class="flex justify-between items-center bg-green-400 text-black p-2 rounded gap-5">
        <span class="font-semibold">Total Discount</span>
        <span class="font-semibold"><?= $amount_before_tax = $total_amount - $total_discounted_amount;?></span>
      </li>
      <li class="flex justify-between items-center bg-white text-black p-2 rounded gap-5">
        <span class="font-semibold">Total TAX(GST)</span>
        <span class="font-semibold"><?= $tax =  $total_discounted_amount * 0.18;?></span>
      </li>
      <?php
      if(!$myOrder['coupon_id']):
        ?>
      <li class="flex justify-between items-center bg-yellow-300 text-black p-2 rounded gap-5">
        <span class="font-semibold">Coupon Discount</span>
        <span class="font-semibold">0/-</span>
      </li>
      <?php endif;?>
      <li class="flex justify-between items-center bg-red-600 text-white p-2 rounded gap-5">
        <span class="font-semibold">Payable amount</span>
        <span class="font-semibold"><?= $total_payable_amount = $total_discounted_amount + $tax;


        ?>
      
      
      </span>
      </li> 
    </ul>
    <div class="flex justify-between items-center gap-5 mt-6">
      <a href="#" class="bg-blue-500 text-white px-4 py-2 rounded">Go back</a>
      <a href="#" class="bg-black text-white px-4 py-2 rounded">Checkout</a>
    </div>
    <?php
    if(!$myOrder['coupon_id']):
      ?>
    <div class="mt-3">
      <from action="" method="POST" class="flex justify-between items-center  bg-gray-200 border border-black mt-5">
        <input type="text" placeholder="Enter Coupon Code"name="code" class="rounded py-1 px-2">
        <button type="submit" class="bg-transparent text-black py-1 px-2" value="Apply" name="apply">
        <i class="bi bi-search"></i>
        </button>
      </from>
      </div>
    <?php endif; ?>
   

    <?php endif; else: ?>
      <div class="grid-cols gap-4">
      <div class="bg-gray-100 p-4 mb-2 rounded-lg flex items-center justify-between">
    <h1 class="text-2xl">Sorry, your cart is empty...</h1>
    <a href="index.php" class="bg-black text-white px-4 py-2 rounded">Shop now</a>
     </div>
    </div>
   <?php endif;?>


    </div>
</div>


<?php

if(isset($_GET['book_id']) && isset($_GET['atc'])){

    //check user login or not
       
    if(!isset($_SESSION['account'])){
        echo "<script>window.open('login.php','_self')</script>";
    }
    //if login

    $book_id = $_GET['book_id'];

    $user_id = $getuser['user_id'];


    //checking order already exist or not
    $check_order = mysqli_query($connect,"select * from orders where user_id='$user_id' and is_ordered='0'");
    $Count_check_order = mysqli_num_rows($check_order);

     if($Count_check_order < 1){
     $create_order = mysqli_query($connect,"insert into orders (user_id) value ('$user_id')");
       $created_order_id = mysqli_insert_id($connect);

        $create_order_item = mysqli_query($connect,"insert into order_items(order_id,book_id)value('$created_order_id','$book_id')");
     }
     else{
      //already exist order work
       $current_order = mysqli_fetch_array($check_order);
        $current_order_id = $current_order['order_id'];
        //checking if order_item already exist or not
        $check_order_item = mysqli_query($connect, "select * from order_items where (order_id='$current_order_id' and book_id='$book_id') and is_orderd='0'");
   if (!$check_order_item) {
    die("Query failed: " . mysqli_error($connect));
   }

       $current_order_item = mysqli_fetch_array($check_order_item);
         $Count_current_order_item = mysqli_num_rows($check_order_item);
        // $current_order_id_by_items_table = $current_order_item['order_id'];

        if($Count_current_order_item > 0){
        $current_order_item_id = $current_order_item['oi_id'];
            $query_for_qty_update = mysqli_query($connect,"update order_items set quantity=quantity+1 where oi_id='$current_order_item_id'");
        }
        else{
          $create_order_item = mysqli_query($connect,"insert into order_items(order_id,book_id)value('$current_order_id','$book_id')");
         }

     }

 
   //referece page
   echo "<script> window.open('cart.php', '_self')</script>";
    
}
?>

<?php
// delete from cart

if(isset($_GET['book_id']) && isset($_GET['dfc'])){


    //check user login or not
       
    if(!isset($_SESSION['account'])){
        echo "<script>window.open('login.php','_self')</script>";
    }
    //if login

    $book_id = $_GET['book_id'];

    $user_id = $getuser['user_id'];


    //checking order already exist or not
    $check_order = mysqli_query($connect,"select * from orders where user_id='$user_id' and is_ordered='0'");
    $Count_check_order = mysqli_num_rows($check_order);


      //already exist order work
       $current_order = mysqli_fetch_array($check_order);
        $current_order_id = $current_order['order_id'];
        //checking if order_item already exist or not
        $check_order_item = mysqli_query($connect, "select * from order_items where (order_id='$current_order_id' and book_id='$book_id') and is_orderd='0'");
   if (!$check_order_item) {
    die("Query failed: " . mysqli_error($connect));
   }

       $current_order_item = mysqli_fetch_array($check_order_item);
         $Count_current_order_item = mysqli_num_rows($check_order_item);
        // $current_order_id_by_items_table = $current_order_item['order_id'];

        if($Count_current_order_item > 0){
        $current_order_item_id = $current_order_item['oi_id'];
        $qty = $current_order_item['quantity'];

        if($qty == 1){
          $delete_query_for_order_item = mysqli_query($connect,"delete from order_items where oi_id='$current_order_item_id'");
        }
        
      else{
            $query_for_qty_update = mysqli_query($connect,"update order_items set quantity=quantity-1 where oi_id='$current_order_item_id'");
        }

      }
      
   //referece page
   echo "<script> window.open('cart.php', '_self')</script>";

   //add coupon login
   if(isset($_POST['apply'])) {
    $code = $_POST['code'];
    $callingCoupon = mysqli_query($connect,"select * from coupon where coupon_code= '$code'");
    $getCoupon = mysqli_fetch_array($callingCoupon);

    $CountCoupon = mysqli_num_rows($callingCoupon);

    if($CountCoupon > 0){
      
      //updating coupon id in order record
      $coupon_id = $getCoupon['coupon_id'];
      $updateOrder = mysqli_query($connect,"update orders SET coupon_id= '$coupon_id'where order_id='$myOrderId'");
      echo "<script> window.open('cart.php', '_self')</script>";

    } else{
        echo"<script>alert('invaild coupon code')</script>";
    }
  }
}

?>