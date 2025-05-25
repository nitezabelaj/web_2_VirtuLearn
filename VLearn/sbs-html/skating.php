<?php
require_once 'includes/error_handler.php';

session_start();
if (!isset($_SESSION['visit_count_skating'])) {
    $_SESSION['visit_count_skating'] = 1;
} else {
    $_SESSION['visit_count_skating']++;
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




define("SITE_NAME", "VirtuLearn");


if (isset($_GET['search'])) {
   $query = trim($_GET['search']);
   header("Location: search.php?q=" . urlencode($query));
   exit();
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
//klasat per trashigimi nga OOP az
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
// Krijojmë një variabël globale jashtë funksioneve
$emriFaqes = "VirtuLearn";

function shfaqTitullinFaqes() {
    // Përdorim global për ta pasur qasje në variablën globale
    global $emriFaqes;

    echo "<title>$emriFaqes</title>";
}

// Thirrja e funksionit diku në HTML
?>
<!DOCTYPE html>
<html lang="en">
   <head>
   <?php shfaqTitullinFaqes(); ?>
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
      <!-- our class -->
      <div class="class">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage text_align_center">
                  <h1>Mirë se vini në <?php echo $emriFaqes; ?></h1>
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
                          <p style="text-align: center; color:black; margin-top: 100px;">Kjo faqe është vizituar <?php echo $_SESSION['visit_count_skating']; ?> herë gjatë këtij sesioni.</p>

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
         
          function openMapModal() {
            document.getElementById("mapModal").style.display = "block";
         }
         function closeMapModal() {
            document.getElementById("mapModal").style.display = "none";
         }

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