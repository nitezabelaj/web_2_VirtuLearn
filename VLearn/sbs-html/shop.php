<?php 
const SITE_TIME = "SkatingBoardSchool";
$menu_items = [
   "index.php" => "Home",
   "about.php" => "About",
   "skating.php" => "Skating",
   "shop.php" => "Shop",
   "contact.php" => "Contact Us"
];

function generateMenu($items) {
   $current = basename($_SERVER['PHP_SELF']);
   foreach ($items as $link => $label) {
       $isActive = ($current === basename($link)) ? " active" : "";
       echo "<li class='nav-item$isActive'><a class='nav-link' href='$link'>$label</a></li>";
   }
}

?>


<?php
// Përcaktimi i produkteve
$produktet = [
    "Helmet" => 35,
    "Rrotat" => 45,
    "Skateboard Pro" => 120
];





// Llogaritja e totalit permes operatorit +
$totali = array_sum($produktet);
?>
   <?php
   // Përcaktimi i produkteve me të dhëna të plota
   $produktet = array(
    array("id" => 1, "emri" => "Skateboard Pro", "cmimi" => 120),
    array("id" => 2, "emri" => "Helmet", "cmimi" => 35),
     array("id" => 3, "emri" => "Rrotat", "cmimi" => 45)
    );

  // Marrim vlerën e sortimit nga dropdown
  $sortimi = isset($_GET['sort']) ? $_GET['sort'] : '';

   if ($sortimi === 'low_high') {
    usort($produktet, function($a, $b) {
        return $a['cmimi'] - $b['cmimi'];
    });
   } elseif ($sortimi === 'high_low') {
    usort($produktet, function($a, $b) {
        return $b['cmimi'] - $a['cmimi'];
    });
    }
   ?>
<?php
global $emriFaqes;
$emriFaqes = "VirtuLearn";
?>

<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>VirtuLearn</title>
      <style>
         special_products {
            margin-top: 30px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        
        .special_products h4 {
            color:blue;
        }
         </style>

      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
   </head>
   <!-- body -->
   <body class="main-layout inner_page">
      <!-- loader  -->
      <div class="loader_bg">
         <div class="loader"><img src="images/loading.gif" alt="#"/></div>
      </div>
      <!-- end loader -->
      <!-- header -->
      <div class="header">
         <div class="container-fluid">
            <div class="row d_flex">
               <div class=" col-md-2 col-sm-3 col logo_section">
                  <div class="full">
                     <div class="center-desk">
                        <div class="logo">
                           <a href="index.php"><img src="images/logo.png" alt="#" /></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-8 col-sm-12">
                  <nav class="navigation navbar navbar-expand-md navbar-dark ">
                     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                     <span class="navbar-toggler-icon"></span>
                     </button>
                     <div class="collapse navbar-collapse" id="navbarsExample04">
                        <ul class="navbar-nav mr-auto">
                            <?php generateMenu($menu_items); ?>
                        </ul>
                     </div>
                  </nav>
               </div>
               <div class="col-md-2">
                  <ul class="email text_align_right">
                     <li class="d_none"><a href="Javascript:void(0)"><i class="fa fa-user" aria-hidden="true"></i></a></li>
                     <li class="d_none"> <a href="Javascript:void(0)"><i class="fa fa-search" style="cursor: pointer;" aria-hidden="true"></i></a> </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
  <?php

?> 
<form method="POST" onsubmit="return validateForm()">
    <label for="emri">Emri:</label>
    <input type="text" id="emri" name="emri"><br><br>

    <label for="email">Email:</label>
    <input type="text" id="email" name="email"><br><br>

    <label for="mesazhi">Mesazhi:</label><br>
    <textarea id="mesazhi" name="mesazhi" rows="4" cols="40"></textarea><br><br>

    <button type="submit">Dërgo</button>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emri = trim($_POST['emri']);
    $email = trim($_POST['email']);
    $mesazhi = trim($_POST['mesazhi']);

    if (empty($emri) || empty($email) || empty($mesazhi)) {
        echo "Ju lutem, plotësoni të gjitha fushat.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email-i nuk është i vlefshëm.";
    } elseif (strlen($mesazhi) < 10) {
        echo "Mesazhi duhet të ketë të paktën 10 karaktere.";
    } else {
        echo "Faleminderit! Të dhënat janë dërguar me sukses.";
        // Këtu mund të vazhdosh me ruajtje ose dërgim email-i
    }
}
?>

      <div class="shop">
    <div class="container-fluid">
        <div class="row d_flex d_grid">
            <div class="col-md-7">
                <div class="shop_img text_align_center" data-aos="fade-right">
                    <figure><img class="img_responsive" src="images/shop.png" alt="#"/></figure>
                </div>
            </div>
            <div class="col-md-5 order_1_mobile">
                <div class="titlepage text_align_left">
                    <h2>Our Skate <br>Shop</h2>
                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration...</p>
                    <!-- Dropdown për sortimin -->
                    <form method="GET" style="margin-bottom: 20px;">
                    <label for="sort">Sort by price:</label>
                   <select name="sort" id="sort" onchange="this.form.submit()">
                   <option value="">Select</option>
                       <option value="low_high" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'low_high') echo 'selected'; ?>>Price: Low to High</option>
                      <option value="high_low" <?php if(isset($_GET['sort']) && $_GET['sort'] == 'high_low') echo 'selected'; ?>>Price: High to Low</option>
                     </select>
                    </form>
                    <!-- Lista e produkteve dhe totali -->
                    <div class="product-list">
                        <h4>Our Products:</h4>
                        <ul class="product-items">
                            <?php 
                            // Llogarit totalin gjatë shfaqjes
                            $totali = 0;
                            foreach ($produktet as $produkt): 
                                $totali += $produkt['cmimi'];
                            ?>
                                <li><?php echo $produkt['emri']; ?> - $<?php echo $produkt['cmimi']; ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="total-price">
                            <strong>Total: $<?php echo $totali; ?></strong>
                        </div>
                    </div>
                    <div class="special_products">
                     <?php
                     //Perdorimi tjeter i konstruktorit-Amela
                     class ProduktetSpeciale {
                        private $produktett=[];
                        public function __construct() {
                           $this->produktett = [
                               "Gloves" => 5,
                               "Jumper" => 5,
                               "Skii" => 5
                           ];
 

                        }
                        public function shfaqProduktet(){
                           echo "<h4>Our special Products:</h4>";
                           echo "<ul class='product-items'>";
                           foreach($this->produktett as $emri=>$cmimi){
                              echo "<li>$emri - $cmimi €</li>";
                          }
                          echo "</ul>";

                      }
                      public function __destruct(){
                        

                      }
                     }
                     $produktetSpeciale=new ProduktetSpeciale();
                     $produktetSpeciale->shfaqProduktet();
              
                        
                        
                     ?>
                            </div>


                    <br>
                    <br>
                    <a class="read_more" href="shop.html">Buy Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
      <!-- end shop -->
      <!--  footer -->
      <footer>
         <div class="footer">
            <div class="container">
               <div class="row">
               <div class="col-md-4 ">
                     <div class="infoma">
                        <h3>Contact Us</h3>
                        <ul class="conta">
                           <li><i class="fa fa-map-marker" aria-hidden="true"></i>123 Main Street, Tirana 
                           </li>
                           <li><i class="fa fa-phone" aria-hidden="true"></i>Call +355 4 123 4567</li>
                           <li> <i class="fa fa-envelope" aria-hidden="true"></i><a href="Javascript:void(0)"> info@skatingschool.com</a></li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-md-8">
                     <div class="row border_left">
                        <div class="col-md-12">
                           <div class="infoma">
                              <h3>Newsletter</h3>
                              <form class="form_subscri">
                                 <div class="row">
                                    <div class="col-md-12">
                                    </div>
                                    <div class="col-md-4">
                                       <input class="newsl" placeholder="Enter your email" type="text" name="Enter your email">
                                    </div>
                                    <div class="col-md-4">
                                       <input class="newsl" placeholder="Enter your email" type="text" name="Enter your email">
                                    </div>
                                    <div class="col-md-4">
                                       <button class="subsci_btn">subscribe</button>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                        <div class="col-md-9">
                           <div class="infoma">
                              <h3>Useful Link</h3>
                              <ul class="fullink">
                                 <li><a href="index.php">Home</a></li>
                                 <li><a href="about.php">About</a></li>
                                 <li><a href="skating.php">Skating</a></li>
                                 <li><a href="shop.php">Shop</a></li>
                                 <li><a href="contact.php">Contact Us</a></li>
                              </ul>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="infoma text_align_left">
                           <ul class="social_icon">
                                 <li><a href="https://www.facebook.com/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                 <li><a href="https://www.twitter.com/" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                 <li><a href="https://www.linkedin.com/" target="_blank"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                                 <li><a href="https://www.instagram.com/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="copyright">
               <div class="container">
                  <div class="row">
                     <div class="col-md-12">
                        <p>© 2020 All Rights Reserved. Design by <a href="https://html.design/"> Free html Templates</a></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <!-- end footer -->
      <!-- Javascript files-->
      <script>
         //Validimi i kontrollimit te dhenave para dergimit ne server
    function validateForm() {
        var emri = document.getElementById("emri").value.trim();
        var email = document.getElementById("email").value.trim();
        var mesazhi = document.getElementById("mesazhi").value.trim();

        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

        if (emri === "") {
            alert("Ju lutem, plotësoni emrin.");
            return false;
        }

        if (!emailRegex.test(email)) {
            alert("Ju lutem, fusni një email të vlefshëm.");
            return false;
        }

        if (mesazhi.length < 10) {
            alert("Mesazhi duhet të ketë të paktën 10 karaktere.");
            return false;
        }

        return true; // Të gjitha fushat janë në rregull
    }
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <!-- sidebar -->
      <script src="js/custom.js"></script>
         AOS.init();
      </script>
   </body>
</html>