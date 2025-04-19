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
class ContentItem {
   protected $title;
   protected $description;

   public function __construct($title, $description) {
       $this->title = $title;
       $this->description = $description;
   }

   public function render() {
       echo "<div class='col-md-4 margi_bottom'>";
       echo "<div class='class_box text_align_center'>";
       echo "<i><img src='images/class1.png' alt='#'/></i>";
       echo "<h3>{$this->title}</h3>";
       echo "<p>{$this->description}</p>";
       echo "</div>";
       echo "<a class='read_more' href='Javascript:void(0)'>Read More</a>";
       echo "</div>";
   }
}
//klasat per trashigimi nga OOP
   class SkatingArticle extends ContentItem {
   private $difficulty;

   public function __construct($title, $description, $difficulty) {
       parent::__construct($title, $description);
       $this->difficulty = $difficulty;
   }

   public function render() {
       echo "<div class='col-md-4 margi_bottom'>";
       echo "<div class='class_box text_align_center'>";
       echo "<i><img src='images/class1.png' alt='#'/></i>";
       echo "<h3>{$this->title}</h3>";
       echo "<p>{$this->description}</p>";
       echo "<p><strong>Hard:</strong> {$this->difficulty}</p>";
       echo "</div>";
       echo "<a class='read_more' href='Javascript:void(0)'>Read More</a>";
       echo "</div>";
   }
} 

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["instructorId"])) {
   $instructorId = $_POST["instructorId"];
   if (isValidNumber($instructorId)) {
       echo "<p style='color:green; text-align:center;'>Instruktori me ID: $instructorId është regjistruar me sukses.</p>";
   } else {
       echo "<p style='color:red; text-align:center;'>ID e instruktori nuk është valide.</p>";
   }
}

// Form validation for newsletter
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["newsletterPhone"])) {
   $name = $_POST["newsletterName"];
   $phone = $_POST["newsletterPhone"];
   $errors = [];

   if (!preg_match("/^[a-zA-Z\s]{2,50}$/", $name)) {
       $errors[] = "Emri nuk është valid. Përdorni vetëm shkronja (minimumi 2).";
   }

   if (!preg_match("/^\+?[0-9\s\-\(\)]{8,20}$/", $phone)) {
       $errors[] = "Numri i telefonit nuk është valid.";
   }

   if (empty($errors)) {
       echo "<p style='color:green; text-align:center;'>Faleminderit për abonimin!</p>";
   } else {
       foreach ($errors as $error) {
           echo "<p style='color:red; text-align:center;'>$error</p>";
       }
   }
}
?>

<?php
global $emriFaqes;
$emriFaqes = "VirtuuLearn";
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
      <!-- end header inner -->
      <!-- our class -->
      <div class="class">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage text_align_center">
                     <h2>Our Skating Class</h2>
                     <p>There are many variations of passages of Lorem</p>
                  </div>
               </div>
            </div>
            <div class="row">
         <?php 
           $articles = [
         new SkatingArticle("Skateboarding for beginners", "Guide for beginners.", "Beginners"),
         new SkatingArticle("Professional tricks", "Learn advanced tricks.", "Advanced"),
         new SkatingArticle("Skating for kids ", "A class designed for younger children.", "Easy")
       ];

      foreach ($articles as $article) {
         $article->render();
       }
        ?>
       </div>

               <div class="col-md-4 margi_bottom">
                  <div class="class_box blue text_align_center">
                     <i><img src="images/class2.png" alt="#"/></i>
                     <h3>Skateboard</h3>
                     <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alterationThere are many variations </p>
                  </div>
                  <a class="read_more" href="Javascript:void(0)">Read More</a>
               </div>
               <div class="col-md-4 margi_bottom">
                  <div class="class_box text_align_center">
                     <i><img src="images/class3.png" alt="#"/></i>
                     <h3>Skateboard</h3>
                     <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alterationThere are many variations </p>
                  </div>
                  <a class="read_more" href="Javascript:void(0)">Read More</a>
               </div>
               <?php
                  //Vagjet numerike dhe multidimensional
                  $nivelet=["Beginner","Intermediate","Advance"];
                  $students=[
                     ["Emri"=>"Arta","Niveli"=>"Intermediate"],
                     ["Emri"=>"Alba","Niveli"=>"Advance"],
                     ["Emri"=>"Alma","Niveli"=>"Beginner"]
                  ];
                  echo "<div class='col-md-12'><h3>Nivelet e arritura në kurs:</h3><ul>";
                  foreach($nivelet as $nivel){
                     echo "<li>Niveli: $nivel</li>";
                 }
                    echo "</ul></div>";

                   echo "<div class='col-md-12'><h3>Niveli që kanë arritur disa nga studentët tanë:</h3><ul>";
                   foreach($students as $student){
                     echo "<li>{$student['Emri']}-Niveli: {$student['Niveli']}</li>";
                   }
                      echo "</ul></div>";
                   

                  ?>
            </div>
         </div>
      </div>
      <!-- end our class -->
      <!--  footer -->
      <footer>
         <div class="footer">
            <div class="container">
               <div class="row">
                  <div class="col-md-4 ">
                     <div class="infoma">
                        <h3>Contact Us</h3>
                        <ul class="conta">
                           <li><i class="fa fa-map-marker" aria-hidden="true"></i>Locations 
                           </li>
                           <li><i class="fa fa-phone" aria-hidden="true"></i>Call +01 1234567890</li>
                           <li> <i class="fa fa-envelope" aria-hidden="true"></i><a href="Javascript:void(0)"> demo@gmail.com</a></li>
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
                                       <input class="newsl" placeholder="Enter your name" type="text" name="newsletterName">
                                    </div>
                                    <div class="col-md-4">
                                       <input class="newsl" placeholder="Enter your number" type="text" name="newsletterPhone">
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
                                 <li><a href="index.html">Home</a></li>
                                 <li><a href="about.html">About</a></li>
                                 <li><a href="skating.html">Skating</a></li>
                                 <li><a href="shop.html">Shop</a></li>
                                 <li><a href="contact.html">Contact Us</a></li>
                              </ul>
                           </div>
                        </div>
                        <div class="col-md-3">
                           <div class="infoma text_align_left">
                              <ul class="social_icon">
                                 <li><a href="Javascript:void(0)"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                 <li><a href="Javascript:void(0)"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                 <li><a href="Javascript:void(0)"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                                 <li><a href="Javascript:void(0)"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
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
   </body>
</html>