<?php
require_once 'includes/error_handler.php';//T.G

session_start(); // Vetëm një herë!
//AnitaC - P2 / Sessions
require_once 'config.php';

if (isset($_SESSION['user_visit'])) {
    $user_data = $_SESSION['user_visit'];
    $user_data['last_page'] = basename($_SERVER['PHP_SELF']);
} else {
    $user_data = [
        'first_visit' => date("Y-m-d H:i:s"),
        'last_page' => basename($_SERVER['PHP_SELF'])
    ];
}
$_SESSION['user_visit'] = $user_data;

if (isset($_GET['delete_session'])) {
    session_unset();
    session_destroy();
    echo "<script>alert('Session u fshi me sukses!'); window.location.href = '" . basename($_SERVER['PHP_SELF']) . "';</script>";
    exit();
}

$cookie_name = "user_visit";
if (isset($_COOKIE[$cookie_name])) {
    $user_data = json_decode($_COOKIE[$cookie_name], true);
    $user_data['last_page'] = basename($_SERVER['PHP_SELF']);
} else {
    $user_data = [
        'first_visit' => date("Y-m-d H:i:s"),
        'last_page' => basename($_SERVER['PHP_SELF'])
    ];
}
setcookie($cookie_name, json_encode($user_data), time() + (86400 * 30), "/", "", true, true);

if (isset($_GET['delete_cookie'])) {
    setcookie($cookie_name, "", time() - 3600, "/", "", true, true);
    echo "<script>alert('Cookie u fshi me sukses!'); window.location.href = '" . basename($_SERVER['PHP_SELF']) . "';</script>";
    exit();
}




const SITE_TIME = "SkatingBoardSchool";


$menu_items = [
   "index.php" => "Home",
   "about.php" => "About",
   "skating.php" => "Skating",
   "shop.php" => "Shop",
   "contact.php" => "Contact Us",
   // Login dhe Register janë gjithmonë aty
   "login.php" => "Login",
   "register.php" => "Register"
];


if (isset($_SESSION['user_id'])) {
   if ($_SESSION['role'] === 'admin') {
       $menu_items['admin_dashboard.php'] = "Admin Panel";
   } else {
       $menu_items['dashboard.php'] = "Dashboard";
   }
   $menu_items['logout.php'] = "Logout";
}


// Funksioni për të gjeneruar menunë dinamike
function generateMenu($items) {
   $current = basename($_SERVER['PHP_SELF']);
   foreach ($items as $link => $label) {
       $isActive = ($current === basename($link)) ? " active" : "";
       echo "<li class='nav-item$isActive'><a class='nav-link' href='$link'>$label</a></li>";
   }
}
?>





<?php
if (isset($_GET['search'])) {
   $query = trim($_GET['search']);
   header("Location: search.php?q=" . urlencode($query));
   exit();
}



?>
<?php
 if(isset($_POST['submit'])) {
     // Marrja e të dhënave
     $name = $_POST['name'];
     $phone = $_POST['phone'];
     $email = $_POST['email'];
     $subject = $_POST['subject'];
     $message = $_POST['message'];
     
     // Shfaqja e të dhënave me var_dump() - AnitaC
     echo "<pre>";
     var_dump($_POST);
     echo "</pre>";
 }
 ?>

<?php
//Pjesa e Ameles ne perdorimin e konstruktorit dhe destruktorit si pjese e oop ne php
class UserGreeting{
   private $name;
   public function __construct($name="FutureSkater"){
      $this->name=$name;
      echo "<p style='color:blue;'> Welcome,{$this->name}!We're excited to see you here.</p>";
   } 
   public function __destruct(){
      echo "<p style='color:blue;'>Goodbye,{$this->name}! Hope to see you skating you soon.</p>";
   }
}

?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emri = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $subject = $_POST['subject'];
    $message = trim($_POST['message']);

    $validName = preg_match("/^[A-ZÇËa-zçë' -]{2,50}$/", $emri);
    $validPhone = preg_match("/^\+?[0-9]{8,15}$/", $phone);
    $validEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    $validMessage = strlen($message) >= 10;

    if (
        $validName &&
        $validPhone &&
        $validEmail &&
        !empty($subject) &&
        $validMessage
    ) {
        

        echo "<script>alert('Të dhënat janë ruajtur me sukses në server!');</script>";
    } else {
        echo "<script>alert('Ju lutem kontrolloni formatin e të dhënave që keni futur.');</script>";
    }
}
?>

<?php
//Kodi Anisit
$success = false;
$emri = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emri = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    if (
        !empty($emri) &&
        filter_var($email, FILTER_VALIDATE_EMAIL) &&
        !empty($subject) &&
        strlen($message) > 10
    ) {
        $success = true;
    }
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
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

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
                            <?php generateMenu($menu_items); ?> <!-- anitaC-->
                        </ul>
                     </div>
                  </nav>
               </div>
               <div class="col-md-2">
                  <ul class="email text_align_right">
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
                        </form> </ul>
               </div>
            </div>
         </div>
      </div>
      <!-- end header inner -->
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

      <!-- contact -->
      <div class="contact">
         <div class="container">
            <div class="row ">
               <div class="col-md-12 text_align_center">
                  <?php
                  $greeting= new UserGreeting();
                 
                  ?>
                  </div>
               </div> <!-- mos i prekni qeto veq nese muj i bini nfije me bo per tana phpt qe i kem shkru nelt-->
               <div class="col-md-6">
               <form id="request" class="main_form" method="post" action="send_contact.php"> <!--Anita\C -->
         <div class="row">
             <div class="col-md-6">
                 <input class="contactus" placeholder="Name*" type="text" name="name" required> 
             </div>
             <div class="col-md-6">
                 <input class="contactus" placeholder="Phone Number*" type="text" name="phone" required>                          
             </div>
             <div class="col-md-12">
                 <input class="contactus" placeholder="Email*" type="email" name="email" required>                          
             </div>
             <div class="col-md-12 select-outline">
                 <select class="custom-select" name="subject" required>
                     <option value="" disabled selected>Select Subject*</option>
                     <option value="a">a</option>
                     <option value="b">b</option>
                     <option value="c">c</option>
                 </select>
             </div>
             <div class="col-md-12">
                 <textarea class="textarea" placeholder="Message" name="message"></textarea>
             </div>
             <div class="col-md-12">
                 <button class="send_btn" type="submit" name="submit">Send</button>
             </div>
         </div>
     </form>
 </div>
               <div class="col-md-6">
                  <div class="map_main">
                     <div class="map-responsive">
                        <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&amp;q=Eiffel+Tower+Paris+France" width="600" height="450" frameborder="0" style="border:0; width: 100%;" allowfullscreen=""></iframe>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   
      <!-- contact -->
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
                             <li><i class="fa fa-phone" aria-hidden="true"></i>+355 4 123 4567</li>
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
                                    <?php if (!empty($newsletterMessages)) echo $newsletterMessages; ?>
                                    <div class="col-md-4">
                                       <input class="newsl" placeholder="Enter your name" type="text" name="newsletterName">
                                    </div>
                                    <div class="col-md-4">
                                       <input class="newsl" placeholder="Enter your number" type="text" name="newsletterPhone">
                                    </div>
                                    <div class="col-md-4">
                                       <button class="subsci_btn" type = "submit">subscribe</button>
                                    </div>
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
                        <?php
                 
                  unset($greeting);
                  ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <!-- end footer -->
      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <!-- sidebar -->
      <script src="js/custom.js"></script>
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

</script>

                

      <?php if ($success): ?>
      <script>
       window.addEventListener("DOMContentLoaded", function () {
      alert("Faleminderit <?php echo htmlspecialchars($emri); ?>! Mesazhi juaj u dërgua me sukses.");
      });
      </script>
      <?php endif; ?>
      
   </body>
</html>