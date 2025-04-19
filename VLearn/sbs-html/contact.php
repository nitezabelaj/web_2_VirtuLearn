<?php 
const SITE_TIME = "SkatingBoardSchool"; //AnitaC
$success = false;
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

    // RegEx për validim e stringjeve - AnitaC
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
        $success = true;
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
                     <li class="d_none"><a href="Javascript:void(0)"><i class="fa fa-user" aria-hidden="true"></i></a></li>
                     <li class="d_none"> <a href="Javascript:void(0)"><i class="fa fa-search" style="cursor: pointer;" aria-hidden="true"></i></a> </li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
      <!-- end header inner -->
      <!-- contact -->
      <div class="contact">
      <a href="?lang=en">🇬🇧 English</a> | <a href="?lang=al">🇦🇱 Shqip</a>
         <div class="container">
            <div class="row ">
               <div class="col-md-12 text_align_center">
                  <?php
                  $greeting= new UserGreeting();
                  ?>
                  </div>
               </div> <!-- mos i prekni qeto veq nese muj i bini nfije me bo per tana phpt qe i kem shkru nelt-->
               <div class="col-md-6">
               <form id="request" class="main_form" method="post">
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
                           </li> <!-- anitac-->
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
      <script src="js/jquery.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <!-- sidebar -->
      <script src="js/custom.js"></script>
      <script>
         AOS.init();
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