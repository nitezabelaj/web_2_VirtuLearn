<?php
require_once 'includes/error_handler.php';

session_start();
if (!isset($_SESSION['visit_count_shop'])) {
    $_SESSION['visit_count_shop'] = 1;
} else {
    $_SESSION['visit_count_shop']++;
}

//AnitaC - P2 / Sessions
const SITE_TIME = "SkatingBoardSchool";


$menu_items = [
   "index.php" => "Home",
   "about.php" => "About",
   "skating.php" => "Skating",
   "shop.php" => "Shop",
   "contact.php" => "Contact Us",
   
   "login.php" => "Login",
   "register.php" => "Register",
   "build_skateboard.php"=>"Build your Skateboard"
];

if (isset($_SESSION['user_id'])) {
   if ($_SESSION['role'] === 'admin') {
       $menu_items['admin_dashboard.php'] = "Admin Panel";
   } else {
       $menu_items['dashboard.php'] = "Dashboard";
   }
   $menu_items['logout.php'] = "Logout";
}


function generateMenu($items) {
   $current = basename($_SERVER['PHP_SELF']);
   foreach ($items as $link => $label) {
       $isActive = ($current === basename($link)) ? " active" : "";
       echo "<li class='nav-item$isActive'><a class='nav-link' href='$link'>$label</a></li>";
   }
}
?>


<?php 

$address = "123 Main Street, Tirana";
$phone = "+355 4 123 4567";
$email = "info@skatingschool.com";
$mapQuery = urlencode($address);
   

if (isset($_GET['search'])) {
    $query = trim($_GET['search']);
    header("Location: search.php?q=" . urlencode($query));
    exit();
}


?>


<?php

$produktet = [
    "Helmet" => 35,
    "Rrotat" => 45,
    "Skateboard Pro" => 120
];


// Llogaritja e totalit permes operatorit +
$totali = array_sum($produktet);
?>
   <?php
   
   $produktet = array(
    array("id" => 1, "emri" => "Skateboard Pro", "cmimi" => 120),
    array("id" => 2, "emri" => "Helmet", "cmimi" => 35),
     array("id" => 3, "emri" => "Rrotat", "cmimi" => 45)
    );

 
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

    class SiteSearch {
      private $pages;
  
  
      public function __construct() {
          $this->pages = [
              "Home" => ["url" => "index.php", "content" => "Welcome to the best skating experience for everyone."],
              "About" => ["url" => "about.php", "content" => "Learn more about our mission, team, and journey."],
              "Skating" => ["url" => "skating.php", "content" => "Our skating school offers classes for all levels."],
              "Shop" => ["url" => "shop.php", "content" => "Buy skateboards, helmets, and gear here."],
              "Contact" => ["url" => "contact.php", "content" => "Reach out to us for any inquiries."]
          ];
      }
  
      public function search($query) {
          $results = [];
          $query = strtolower(trim($query));

          foreach ($this->pages as $title => $data) {
              if (strpos(strtolower($title), $query) !== false || strpos(strtolower($data['content']), $query) !== false) {
                  $results[] = [
                      'title' => $title,
                      'url' => $data['url'],
                      'description' => $data['content']
                  ];
              }
          }
  
          return $results;
      }
  }

  $searchResults = [];

if (isset($_GET['search']) && trim($_GET['search']) !== '') {
    $search = new SiteSearch();

    $searchResults = $search->search($_GET['search']);
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
        
#sort {
    font-weight: bold;
    font-size: 16px;
    padding: 5px 10px;
    border-radius: 5px;
    background-color: #f7f7f7;
    border: 1px solid #ddd;
}

#sort::before {
    content: url('https://upload.wikimedia.org/wikipedia/commons/a/a7/Font_Awesome_5_regular_money-bill-alt.svg');
    margin-right: 8px;
    vertical-align: middle;
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

      <style>
         .map-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 50%;
            top: 50%;
            width: 80%;
            max-width: 600px;
            height: 400px;
            transform: translate(-50%, -50%);
            background-color: white;
            border: 2px solid #333;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
         }

         .map-modal iframe {
            width: 100%;
            height: 100%;
            border: none;
         }

         .map-modal .close-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            background: #f00;
            color: white;
            border: none;
            font-size: 16px;
            padding: 2px 8px;
            cursor: pointer;
         }
       
</style>
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
                  <ul class="email text_align_right" style="position: relative;">
                     <li class="d_none" style="position: relative;">
                        <a href="Javascript:void(0)" onclick="toggleSearch()">
                           <i class="fa fa-search" style="cursor: pointer;" aria-hidden="true"></i>
                        </a>
                        </li>
                        </ul>
                        <form method="GET" id="search-form" style="display: none; position: absolute; top: 30px; right: 0; background: white; padding: 5px; border-radius: 5px; z-index: 100;">
                           <input type="text" name="search" placeholder="Search..." required>
                           <button type="submit" style="border: none; background: none;">
                              <i class="fa fa-arrow-right"></i>
                           </button>
                        </form>
                     
                  
               </div>
            </div>
         </div>
      </div>
      <?php if (!empty($searchResults)): ?>
    <div class="container" style="margin-top: 30px;">
        <h3>Search Results for "<?php echo htmlspecialchars($_GET['search']); ?>"</h3>
        <ul>
            <?php foreach ($searchResults as $result): ?>
                <li>
                    <a href="<?php echo $result['url']; ?>"><strong><?php echo $result['title']; ?></strong></a>: 
                    <?php echo $result['description']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php elseif (isset($_GET['search'])): ?>
    <div class="container" style="margin-top: 30px;">
        <h4>No results found for "<?php echo htmlspecialchars($_GET['search']); ?>"</h4>
    </div>
<?php endif; ?>

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
                    <div>
                  <?php

$pdo = new PDO("mysql:host=localhost;dbname=virtu_learn", "root", "");
session_start();

if (!isset($_SESSION['username'])) {
    die("User not logged in.");
}

$stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch();

if (!$user) {
    die("User not found.");
}

$userId = $user['id'];
$username = $_SESSION['username'];

$products = [
    ["name" => "Skateboard", "price" => 49.99, "image" => "https://pngimg.com/d/skateboard_PNG11708.png"],
    ["name" => "Helmet", "price" => 29.99, "image" => "https://triple8.com/cdn/shop/files/IMG_10138_1_1024x1024.jpg?v=1714482700"],
    ["name" => "Wrist Guards", "price" => 19.99, "image" => "https://demon-united.com/cdn/shop/products/DS3878_201_1080x.jpg?v=1615264670"],
    ["name" => "Hoodie", "price" => 39.99, "image" => "https://scene7.zumiez.com/is/image/zumiez/product_main_medium/Empyre-Push-Skate-Black-Hoodie-_388094-alt1-US.jpg"]
];

$message = "";
$lastActionProduct = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['product'])) {
        $product = $_POST['product'];
        $price = $_POST['price'];
        $image = $_POST['image'];
        $lastActionProduct = $product;

        if (isset($_POST['add'])) {
            $stmt = $pdo->prepare("INSERT INTO shopping_cart (user_id, product_name, product_price, product_image_url) VALUES (?, ?, ?, ?)");
            $stmt->execute([$userId, $product, $price, $image]);
            $message = "added";
        } elseif (isset($_POST['delete'])) {
            $stmt = $pdo->prepare("DELETE FROM shopping_cart WHERE user_id = ? AND product_name = ?");
            $stmt->execute([$userId, $product]);
            $message = "deleted";
        }
    } elseif (isset($_POST['confirm_order'])) {
        $fullname = $_POST['fullname'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $paypal = $_POST['paypal'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("INSERT INTO shipping_address (user_id, username, fullname, city, address, paypal_number, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$userId, $username, $fullname, $city, $address, $paypal, $password]);

        echo "<p>Your order has been confirmed and will be delivered to your doorstep within 48 hours.</p>";
    }
}
?>

<style>
    .product { border: 1px solid #ccc; padding: 20px; margin: 20px; width: 250px; display: inline-block; vertical-align: top; }
    img { max-width: 100%; height: auto; }
    form { margin-top: 10px; }
</style>

<h2>Below are our products that you can shop now:</h2>
<p>When you add products to the shopping cart, the admin of this website will be able to see which<br>
    products you have selected.<br>
    If you complete the Shipping Address form — which is valid only within the territory of Kosovo —<br>
    your order will automatically be processed.</p>

<?php
$productCountStmt = $pdo->prepare("SELECT COUNT(*) FROM shopping_cart WHERE user_id = ?");
$productCountStmt->execute([$userId]);
$cartCount = $productCountStmt->fetchColumn();

foreach ($products as $p): ?>
    <div class="product">
        <h3><?= htmlspecialchars($p["name"]) ?></h3>
        <img src="<?= htmlspecialchars($p["image"]) ?>" alt="<?= htmlspecialchars($p["name"]) ?>">
        <p>Price: $<?= number_format($p["price"], 2) ?></p>
         <?php if (!empty($lastActionProduct) && $lastActionProduct === $p["name"]): ?>
            <p class="message <?= $message === 'added' ? 'added' : 'deleted' ?>">
                <?= $message === 'added' ? 'The product has been added to the cart.' : 'The product has been removed from the cart.' ?>
            </p>
        <?php endif; ?>
        <form method="POST">
            <input type="hidden" name="product" value="<?= $p["name"] ?>">
            <input type="hidden" name="price" value="<?= $p["price"] ?>">
            <input type="hidden" name="image" value="<?= $p["image"] ?>">
            <button type="submit" name="add">Add to ShoppingCart</button>
            <button type="submit" name="delete">Delete from ShoppingCart</button>
        </form>
    </div>
<?php endforeach; ?>

<?php if ($cartCount > 0): ?>
    <h3>Shipping Address</h3>
    <form method="POST">
        <label>Full Name: <input type="text" name="fullname" required></label><br>
        <label>City:
            <select name="city" required>
                <option value="Prishtina">Prishtina</option>
                <option value="Peja">Peja</option>
                <option value="Gjakova">Gjakova</option>
                <option value="Ferizaj">Ferizaj</option>
                <option value="Mitrovica">Mitrovica</option>
                <option value="Gjilan">Gjilan</option>
            </select>
        </label><br>
        <label>Address: <input type="text" name="address" required></label><br>
        <label>PayPal Card Number: <input type="text" name="paypal" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <button type="submit" name="confirm_order">Confirm Order</button>
    </form>
<?php endif; ?>




                     
                   </div>
                    


                  <br><br>
                    <a class="read_more" href="shop.html"></a>
                </div>
            </div>
        </div>
    </div>
                             <p style="text-align: center; color:black; margin-top: 100px;">Kjo faqe është vizituar <?php echo $_SESSION['visit_count_shop']; ?> herë gjatë këtij sesioni.</p>

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
                        <li>
                              <i class="fa fa-map-marker" aria-hidden="true"></i>
                              <a href="javascript:void(0);" onclick="openMapModal()">
                                 <?php echo $address; ?>
                              </a>
                           </li>
                           <li>
                              <i class="fa fa-phone" aria-hidden="true"></i>
                              <a href="tel:<?php echo preg_replace('/\s+/', '', $phone); ?>">
                                 Call <?php echo $phone; ?>
                              </a>
                           </li>
                           <li> 
                              <i class="fa fa-envelope" aria-hidden="true"></i>
                              <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <div class="col-md-8">
                     <div class="row border_left">
                        <div class="col-md-12">
                           <div class="infoma">
                              <h3>Newsletter</h3>
                             <form class="form_subscri" method="POST" action="subscribe_newsletter.php">
                                 <div class="row">
                                    <div class="col-md-12">
                                    </div>
                                    <?php if (!empty($newsletterMessages)) echo $newsletterMessages; ?>
                                    <div class="col-md-4">
                                       <input class="newsl" placeholder="Enter your name" type="text" name="newsletterName">
                                    </div>
                                    <div class="col-md-4">
                                       <input class="newsl" placeholder="Enter your email" type="text" name="newsletterEmail">
                                    </div>
                                    <div class="col-md-4">
                                       <button class="subsci_btn" type = "submit">subscribe</button>
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
                          <!--Implementimi i cookies te ndryshimit te ngjyres background ne footer A.Z-->
         <footer id="footer" style="padding: 20px;">
    <form onsubmit="changeFooterColor(event)">
        <label for="color">Choose the color of footer:</label>
        <select id="color">
            <option value="white">White</option>
            <option value="black">Black</option>
            <option value="lightblue">Light Blue</option>
            <option value="lightgray">Light Gray</option>
        </select>
        <button type="submit">Change</button>
    </form>
</footer>
<script src="footerTheme.js"></script>

      </footer>
      <!-- end footer -->
      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <!-- sidebar -->

      <script>
      
         function toggleSearch() {
            const searchForm = document.getElementById('search-form');
            if (searchForm.style.display === 'none' || searchForm.style.display === '') {
               searchForm.style.display = 'block';
            } else {
               searchForm.style.display = 'none';
            }
         }

         document.addEventListener('click', function(e) {
            const form = document.getElementById('search-form');
            const icon = e.target.closest('.fa-search');
            const insideForm = e.target.closest('#search-form');
            if (!insideForm && !icon) {
               form.style.display = 'none';
            }
         });

         function openMapModal() {
            document.getElementById("mapModal").style.display = "block";
         }
         function closeMapModal() {
            document.getElementById("mapModal").style.display = "none";
         }
      </script>

      <script src="js/custom.js"></script>
      <script>
         AOS.init();
         //Funksione per ndryshimin e cookies e implementuar ne footer AniteZabelaj
         function changeFooterColor(event) {
    event.preventDefault(); // që të mos rifreskohet faqja
    const selectedColor = document.getElementById("color").value;
    setCookie("footerColor", selectedColor, 30);
    applyFooterColor();
}

function applyFooterColor() {
    const color = getCookie("footerColor");
    const footer = document.getElementById("footer");
    if (color) {
        footer.style.backgroundColor = color;
    }
}

// funksione ndihmëse për cookie
function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days*24*60*60*1000));
    document.cookie = `${name}=${value};expires=${d.toUTCString()};path=/`;
}

function getCookie(name) {
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i].trim();
        if (c.indexOf(name + "=") === 0) return c.substring(name.length + 1);
    }
    return "";
}

window.onload = applyFooterColor;

      </script>

      <?php
$ip = file_get_contents("https://api.ipify.org");
$curl = curl_init("http://ip-api.com/json/{$ip}");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
curl_close($curl);

if ($response !== false) {
    $data = json_decode($response, true);
    if ($data && $data['status'] === 'success') {
        echo "<div style='text-align:center; color: black; margin-top: 40px; font-size: 0.9em;'>";
        echo "Ju jeni duke vizituar nga <strong>{$data['city']}, {$data['country']}</strong> (IP: {$ip})";
        echo "</div>";
    }
}
?>

   </body>
</html>


