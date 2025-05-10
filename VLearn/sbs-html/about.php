<?php 
const SITE_TIME = "VirtuLearn";
$menu_items = [
   "index.php" => "Home",
   "about.php" => "About",
   "skating.php" => "Skating",
   "shop.php" => "Shop",
   "contact.php" => "Contact Us"
];

if (isset($_GET['search'])) {
   $query = trim($_GET['search']);
   header("Location: search.php?q=" . urlencode($query));
   exit();
}

function generateMenu($items) {
   $current = basename($_SERVER['PHP_SELF']);
   foreach ($items as $link => $label) {
       $isActive = ($current === basename($link)) ? " active" : "";
       echo "<li class='nav-item$isActive'><a class='nav-link' href='$link'>$label</a></li>";
   }
}

class ContactInfo {
   // Vetitë private - mund të qasen vetëm nga brenda klasës
   private $location = "123 Main Street, Tirana";
   private $phone = "+355 4 123 4567";
   private $email = "info@skatingschool.com";
   
   // Metoda protected - mund të qaset nga klasa dhe nënklasat
   protected function formatPhone($phone) {
       return preg_replace('/(\d{3})(\d{3})(\d{4})/', '($1) $2-$3', $phone);
   }
   
   // Metoda publike - mund të qasen nga kudo
   public function getLocation() {
       return $this->location;
   }
   
   public function getPhone($formatted = false) {
       return $formatted ? $this->formatPhone($this->phone) : $this->phone;
   }
   
   public function getEmail() {
       return $this->email;
   }
   
   public function getAllInfo() {
       return [
           'location' => $this->getLocation(),
           'phone' => $this->getPhone(true),
           'email' => $this->getEmail()
       ];
   }
}

?>
<?php
global $emriFaqes;
$emriFaqes = "VirtuLearn";
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    // Regex për validimin e email-it
    if (preg_match("/^[\w\.-]+@[\w\.-]+\.\w{2,6}$/", $email)) {
        echo "<p style='color: green;'>Email-i është valid: $email</p>";
    } else {
        echo "<p style='color: red;'>Email-i is not valid!</p>";
    }
}
?>




<?php
//Regex per validim e dates -pjesa e Amela
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_birthday'])){
   $birthday=$_POST['birthday'];
   //RegEx
   if(preg_match("/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/",$birthday)){
      echo "<p style='color: green;'>Ditelindja eshte e vlefshme :$birthday</p>";

   } else {
      echo "<p style='color: red;'>Ditelindja nuk eshte ne format te vlefshem.</p>";
   }

}

//Newsletter validation
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
      <title>sbs</title>
      <style>
         .highlighted-text {
    color: purple;
    font-weight: bold;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #f3e5f5, #e1bee7);
    padding: 6px 12px;
    border-radius: 10px;
    display: inline-block;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.highlighted-text:hover {
    transform: scale(1.05);
}
.summer-offers {
    background-color: #f8f9fa;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    margin: 40px;
}

.summer-offers h3 {
    color: #ff5722;
    font-size: 1.5em;
    margin-bottom: 20px;
}

.summer-offers p {
    color: #333;
    font-size: 1.2em;
    margin: 10px 0;
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
                      </ul>
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

      <!-- about -->
      <div class="about">
         <div class="container-fluid">
            <div class="row d_flex">
               <div class="col-md-6">
                  <div class="titlepage text_align_left">
                     <h2>About <br>Skating <br> school</h2>
                     <p>There are many variations of passages of Lorem Ipsum available, but the majority have alterationThere are many variatioThere are many variations of passages of Lorem Ipsum available, but the majority have suffered alterationThere are many variationsns
                     </p>
                     <div class="link_btn">
                        <a class="read_more" href="about.html">Read More</a>
                     </div>
                  </div>
               </div>
               <form method="POST" action="">
                <label for="email">Your Email:</label>
                <input type="text" name="email" id="email" required>
                 <input type="submit" name="Send" value="Send">
               </form>
               
               <br><br>
               <form method="POST" action="">
                  <label for="birthday">Your Birthday(format: YYYY-MM-DD):</label>
                  <input type="text" name="birthday" id="birthday"  required>
                  <input type="submit" name="submit_birthday" value="Send">
                  </form>
               <div class="col-md-6">
                  <div class="about_img text_align_center">
                     <figure><img src="images/about.png" alt="#"/></figure>
                  </div>
               </div>
               <?php
           
               //Per ndryshim stringjesh -Pjesa e ameles
               $teksti="Future Skater Team";

               $uppercase=strtoupper($teksti);
               $lowercase=strtolower($teksti);
               $titlecase=ucwords($teksti);
               $substr=substr($teksti,0,6);
               echo "<div style='margin-top: 20px; padding: 15px; background-color: #eef; border-radius: 8px;'>";
               echo "Ky eshte emri i ekipes sone: <span class='highlighted-text'>$teksti</span><br>";
               echo "Ky tekst eshte ne kartvizitat tona:<span class='highlighted-text'> $uppercase</span><br>";
               echo "Ky teskt eshte ne hoodiet tona: <span class='highlighted-text'>$lowercase</span><br>";
               echo "Vizioni yne eshte: <span class='highlighted-text'>$substr</span><br>";

               ?>
         

            </div>
                  <?php
                 // P2,Amela, Vendosja e referencave në mes të anëtarëve të vargut
                  $ofertat = [
    2 => ["persona" => 2, "cmimi" => 50],
    3 => ["persona" => 3, "cmimi" => 75],
    5 => ["persona" => 5, "cmimi" => 100]
                ];

         $oferta2 = &$ofertat[2];
         $oferta3 = &$ofertat[3];
         $oferta5 = &$ofertat[5];


         function ndryshoPersonat(&$oferta, $persona) {
    $oferta["persona"] = $persona;
}

ndryshoPersonat($oferta2, 4);
         //P2,Amela,Përcjellja e vlerës përmes referencës

         $oferta5["cmimi"] = 80;

          echo "<div class='summer-offers' style='margin-top: 30px; padding: 15px; background-color: #f8f9fa; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>";
echo "<h3 style='text-align: center; color: #ff5722;'>Ofertat Verore</h3>";
echo "<p style='text-align: center;'>Për " . $oferta2["persona"] . " persona, çmimi është " . $oferta2["cmimi"] . " Euro.</p>";
echo "<p style='text-align: center;'>Për " . $oferta3["persona"] . " persona, çmimi është " . $oferta3["cmimi"] . " Euro.</p>";
echo "<p style='text-align: center;'>Për " . $oferta5["persona"] . " persona, çmimi është " . $oferta5["cmimi"] . " Euro.</p>";
echo "</div>";
?>
         </div>
      </div>
      <!-- end about -->
      <!--  footer -->
      <footer>
         <div class="footer">
            <div class="container">
               <div class="row">
               <div class="col-md-4">
    <div class="infoma">
        <h3>Contact Us</h3>
        <ul class="conta">
            <?php
            $contact = new ContactInfo();
            $contactInfo = $contact->getAllInfo();
            ?>
            <li><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo $contactInfo['location']; ?></li>
            <li><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $contactInfo['phone']; ?></li>
            <li><i class="fa fa-envelope" aria-hidden="true"></i><a href="mailto:<?php echo $contactInfo['email']; ?>"> <?php echo $contactInfo['email']; ?></a></li>
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

         AOS.init();
      </script>
   </body>
</html> 