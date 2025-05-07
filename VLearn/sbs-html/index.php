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


// Lista për asort (renditje sipas grupmoshës)//asort
$studentetAsort = [
    "Ardi Kola" => "4-8",
    "Elira Mehmeti" => "9-14",
    "Luan Dervishi" => "9-14",
    "Ina Muca" => "15-18",
    "Blerina Hoti" => "15-18"
];

asort($studentetAsort);

$greeting = "";
$hour = date("H");

if ($hour >= 5 && $hour < 12) {
    $greeting = "Mirëmëngjes!";
} elseif ($hour >= 12 && $hour < 18) {
    $greeting = "Mirëdita!";
} else {
    $greeting = "Mirëmbrëma!";
}

$dayMessage = "";
$day = date("l"); // Monday, Tuesday...

switch ($day) {
    case "Monday":
        $dayMessage = "Java sapo ka filluar! Jepi me energji!";
        break;
    case "Friday":
        $dayMessage = "Është e premte! Mbylle javën me sukses.";
        break;
    case "Sunday":
        $dayMessage = "Pushim i merituar!";
        break;
    default:
        $dayMessage = "Suksese sot!";
}

$ageGroup1 = [4, 8];
$group1 = implode("-", $ageGroup1);

$ageGroup2 = [9, 14];
$group2 = implode("-", $ageGroup2);

$ageGroup3 = [15, 18];
$group3 = implode("-", $ageGroup3);

class Studenti {
   private $emri, $mbiemri, $mosha, $grupmosha;

   public function __construct($emri, $mbiemri, $mosha, $grupmosha) {
       $this->emri = $emri;
       $this->mbiemri = $mbiemri;
       $this->mosha = $mosha;
       $this->grupmosha = $grupmosha;
   }

   public function getGrupi() {
       return $this->grupmosha;
   }

   public function getInfo() {
       return "{$this->emri} {$this->mbiemri}, {$this->mosha} vjeç - Grupmosha {$this->grupmosha} vjeç";
   }
}

$studentet = [
   new Studenti("Ardi", "Kola", 6, "4-8" ),
   new Studenti("Elira", "Mehmeti", 10, "9-14"),
   new Studenti("Luan", "Dervishi", 13, "9-14"),
   new Studenti("Ina", "Muca", 17, "15-18"),
   new Studenti("Blerina", "Hoti", 16, "15-18")
];

function shfaqStudentetPerGrup($grupmosha) {
   global $studentet;
   $studentetGrupi = array_filter($studentet, fn($s) => $s->getGrupi() === $grupmosha);

   echo "<div class='studentet-info' id='info-$grupmosha' style='display:none; margin-top:10px;'>";
   echo "<ul>";
   foreach ($studentetGrupi as $s) {
       echo "<li>" . $s->getInfo() . "</li>";
   }
   echo "</ul></div>";
}

?>

<?php 
//Definimi i konstantave dhe variablave
const SITE_TIME = "SkatingBoardSchool";
$menu_items = [
   "index.php" => "Home",
   "about.php" => "About",
   "skating.php" => "Skating",
   "shop.php" => "Shop",
   "contact.php" => "Contact Us"
];

//Funksion per gjenerimin e menuse 
function generateMenu($items) {
   $current = basename($_SERVER['PHP_SELF']);
   foreach ($items as $link => $label) {
       $isActive = ($current === basename($link)) ? " active" : "";
       echo "<li class='nav-item$isActive'><a class='nav-link' href='$link'>$label</a></li>";
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
      <title>sbs</title>
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
         .container h3 {
    font-size: 22px;
    color: #2c3e50;
    margin-bottom: 15px;
    padding-bottom: 8px;
    border-bottom: 2px solid #3498db;
    display: inline-block;
}

.container ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.container ul li {
    padding: 10px 15px;
    margin-bottom: 8px;
    background-color: white;
    border-radius: 5px;
    transition: all 0.3s ease;
    border-left: 4px solid #3498db;
}

.container ul li:hover {
    transform: translateX(5px);
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
}

.container ul li:nth-child(odd) {
    background-color: #f0f8ff;
}

.container ul li strong {
    color: #3498db;
}
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
   <body class="main-layout">
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
                        </form> </ul>
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
      <!-- end header inner -->
      <!-- end header -->
      <!-- top -->
      <div class="full_bg">
         <div class="slider_main">
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-12">
                     <!-- carousel code -->
                     <div id="carouselExampleIndicators" class="carousel slide">
                        <ol class="carousel-indicators">
                           <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                           <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                           <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                           <!-- first slide -->
                           <div class="carousel-item active">
                              <div class="carousel-caption relative">
                                 <div class="row d_flex">
                                    <div  class="col-md-5">
                                       <div class="board">
                                          <i><img src="images/top_icon.png" alt="#"/></i>
                                          <h3>
                                            Welcome<br> To <br> Virtu<br> Learn<br> School
                                          </h3>
                                          <h2><?php echo $greeting . "<br>" . $dayMessage;?> </h2><br>
                                          <div class="link_btn">
                                             <a class="read_more" href="Javascript:void(0)">Read More   <span></span></a>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-7">
                                       <div class="banner_img">
                                          <figure><img class="img_responsive" src="images/banner_img.png"></figure>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- second slide -->
                           <div class="carousel-item">
                              <div class="carousel-caption relative">
                                 <div class="row d_flex">
                                    <div  class="col-md-5">
                                       <div class="board">
                                          <i><img src="images/top_icon.png" alt="#"/></i>
                                          <h3>
                                             Virtu<br> Learn<br> 2025
                                          </h3>
                                          <h2><?php echo $greeting . "<br>" . $dayMessage;?> </h2><br>
                                          <div class="link_btn">
                                             <a class="read_more" href="Javascript:void(0)">Read More   <span></span></a>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-7">
                                       <div class="banner_img">
                                          <figure><img class="img_responsive" src="images/banner_img.png"></figure>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- third slide-->
                           <div class="carousel-item">
                              <div class="carousel-caption relative">
                                 <div class="row d_flex">
                                    <div  class="col-md-5">
                                       <div class="board">
                                          <i><img src="images/top_icon.png" alt="#"/></i>
                                          <h3>
                                             <br>VirtuLearn <br> School
                                          </h3>
                                          <h2><?php echo $greeting . "<br>" . $dayMessage;?> </h2><br>
                                          <div class="link_btn">
                                             <a class="read_more" href="Javascript:void(0)">Read More   <span></span></a>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-7">
                                       <div class="banner_img">
                                          <figure><img class="img_responsive" src="images/banner_img.png"></figure>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="container">
                         <h3>Students based on their group age </h3>
                         <ul>
                           <?php foreach ($studentetAsort as $emri => $grupi): ?>
                          <li><?php echo $emri; ?> - group age <?php echo $grupi; ?> years</li>
                          <?php endforeach; ?>
                          </ul>
                         </div>

                        <!-- controls -->
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                        <span class="sr-only">Next</span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end banner -->
      <!-- our class -->
      <div class="class">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage text_align_center">
                     <h2>Our Skating Class</h2>
                     <p>>Discover the right plan for your age group</p>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4 margi_bottom">
                  <div class="class_box text_align_center">
                     <i><img src="images/class1.png" alt="#"/></i>
                     <h3>Skateboard</h3>
                     <p> <p>This class is perfect for age group <?php echo $group1; ?> years. Beginners will learn the basics of skateboarding.</p>
                     </p>
                  </div>
                  <a class="read_more" href="javascript:void(0);" onclick="toggleDiv('info-4-8')">Read More</a>
                  <?php shfaqStudentetPerGrup("4-8"); ?>
               </div>
               <div class="col-md-4 margi_bottom">
                  <div class="class_box blue text_align_center">
                     <i><img src="images/class2.png" alt="#"/></i>
                     <h3>Skateboard</h3>
                     <p><p>Designed for age group <?php echo $group2; ?> years who want to improve their skateboarding skills balance and control.</p>
                     </p>
                  </div>
                  <a class="read_more" href="javascript:void(0);" onclick="toggleDiv('info-9-14')">Read More</a>
                  <?php shfaqStudentetPerGrup("9-14"); ?>
               </div>
               <div class="col-md-4 margi_bottom">
                  <div class="class_box text_align_center">
                     <i><img src="images/class3.png" alt="#"/></i>
                     <h3>Skateboard</h3>
                     <p><p>Advanced program for age group <?php echo $group3; ?> years focusing on professional tricks and techniques.</p>
                     </p>
                  </div>
                  <a class="read_more" href="javascript:void(0);" onclick="toggleDiv('info-15-18')">Read More</a>
                  <?php shfaqStudentetPerGrup("15-18"); ?>
               </div>
            </div>
         </div>
      </div>
      <!-- end our class -->
      <!-- about -->
      <div class="about">
         <div class="container-fluid">
            <div class="row d_flex">
               <div class="col-md-6">
                  <div class="titlepage text_align_left">
                     <h2>About <br>Skating <br> school</h2>
                     <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alterationThere are many variatioThere are many variations of passages of Lorem Ipsum available, but the majority have suffered alterationThere are many variationsns
                     </p>
                     <div class="link_btn">
                        <a class="read_more" href="about.html">Read More</a>
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="about_img text_align_center">
                     <figure><img src="images/about.png" alt="#"/></figure>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end about -->
      <!-- skating -->
      <div class="skating">
         <div class="container-fluid">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage text_align_center">
                     <h2>Skating  Video</h2>
                     <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered
                     </p>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-4">
                  <div class="skating-box ">
                     <figure><img src="images/sakt1.png" alt="#"/></figure>
                     <div class="link_btn">
                        <a class="read_more" href="Javascript:void(0)">See More</a>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="skating-box">
                     <figure><img src="images/sakt2.png" alt="#"/></figure>
                     <div class="link_btn">
                        <a class="read_more" href="Javascript:void(0)">See More</a>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="skating-box">
                     <figure><img src="images/sakt3.png" alt="#"/></figure>
                     <div class="link_btn">
                        <a class="read_more" href="Javascript:void(0)">See More</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end skating -->
      <!-- shop -->
      <div class="shop">
         <div class="container-fluid">
            <div class="row d_flex d_grid">
               <div class="col-md-7">
                  <div class="shop_img text_align_center" data-aos="fade-right">
                     <figure><img class="img_responsive" src="images/shop.png" alt="#"/></figure>
                  </div>
               </div>
               <div class="col-md-5 order_1_mobile">
                  <div class="titlepage text_align_left ">
                     <h2>Our  Skate <br>Shop</h2>
                     <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alterationThere are many variatioThere are many variations of passages of Lorem Ipsum available, but the majority have suffered alterationThere are many variationsns
                     </p>
                     <a class="read_more" href="shop.html">Buy Now</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end shop -->
      <!-- testimonial -->
      <div class="testimonial">
         <div class="container">
            <div class="row">
               <div class="col-sm-12">
                  <div class="titlepage text_align_center">
                     <h2>Testimonial</h2>
                  </div>
               </div>
            </div>
            <!-- start slider section -->
            <div class="row">
               <div class="col-md-12">
                  <div id="myCarousel" class="carousel slide" data-ride="carousel">
                     <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                     </ol>
                     <div class="carousel-inner">
                        <div class="carousel-item active">
                           <div class="container-fluid">
                              <div class="carousel-caption relative">
                                 <div class="row d_flex">
                                    <div class="col-md-3">
                                       <div class="test_box text_align_center">
                                          <span><img src="images/test1.png" alt="#"/></span>
                                          <h4>Jone Lo</h4>
                                          <img class="img_responsive" src="images/te.png" alt="#"/>
                                          <p>humour, or randomised words which don't look even slightly believable. If you are</p>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="test_box white_bg text_align_center">
                                          <span><img src="images/test2.png" alt="#"/></span>
                                          <h4>Michale</h4>
                                          <img class="img_responsive" src="images/te2.png" alt="#"/>
                                          <p>humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure</p>
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="test_box text_align_center">
                                          <span><img src="images/test3.png" alt="#"/></span>
                                          <h4>Disol</h4>
                                          <img class="img_responsive" src="images/te.png" alt="#"/>
                                          <p>humour, or randomised words which don't look even slightly believable. If you are</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="carousel-item">
                           <div class="container-fluid">
                              <div class="carousel-caption relative">
                                 <div class="row d_flex">
                                    <div class="col-md-3">
                                       <div class="test_box text_align_center">
                                          <span><img src="images/test2.png" alt="#"/></span>
                                          <h4>Michale</h4>
                                          <img class="img_responsive" src="images/te.png" alt="#"/>
                                          <p>humour, or randomised words which don't look even slightly believable. If you are</p>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="test_box white_bg text_align_center">
                                          <span><img src="images/test3.png" alt="#"/></span>
                                          <h4>Disol</h4>
                                          <img class="img_responsive" src="images/te2.png" alt="#"/>
                                          <p> humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure</p>
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="test_box text_align_center">
                                          <span><img src="images/test1.png" alt="#"/></span>
                                          <h4>Jone Lo</h4>
                                          <img class="img_responsive" src="images/te.png" alt="#"/>
                                          <p>humour, or randomised words which don't look even slightly believable. If you are</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="carousel-item">
                           <div class="container-fluid">
                              <div class="carousel-caption relative">
                                 <div class="row d_flex">
                                    <div class="col-md-3">
                                       <div class="test_box text_align_center">
                                          <span><img src="images/test3.png" alt="#"/></span>
                                          <h4>Disol</h4>
                                          <img class="img_responsive" src="images/te.png" alt="#"/>
                                          <p>humour, or randomised words which don't look even slightly believable. If you are</p>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="test_box  white_bg text_align_center">
                                          <span><img src="images/test1.png" alt="#"/></span>
                                          <h4>Jone Lo</h4>
                                          <img class="img_responsive" src="images/te2.png" alt="#"/>
                                          <p> humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure</p>
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                       <div class="test_box text_align_center">
                                          <span><img src="images/test2.png" alt="#"/></span>
                                          <h4>Michale</h4>
                                          <img class="img_responsive" src="images/te.png" alt="#"/>
                                          <p>humour, or randomised words which don't look even slightly believable. If you are</p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                     <i class="fa fa-angle-left" aria-hidden="true"></i>
                     <span class="sr-only">Previous</span>
                     </a>
                     <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                     <i class="fa fa-angle-right" aria-hidden="true"></i>
                     <span class="sr-only">Next</span>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end testimonial -->
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

                     <div id="mapModal" class="map-modal">
                        <button class="close-btn" onclick="closeMapModal()">×</button>
                        <iframe
                           src="https://www.google.com/maps?q=<?php echo $mapQuery; ?>&output=embed"
                           allowfullscreen
                           loading="lazy">
                        </iframe>
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
         AOS.init();
      </script>
      <script>
         function toggleDiv(id) {
            const div = document.getElementById(id);
            div.style.display = (div.style.display === "none" || div.style.display === "") ? "block" : "none";
         }

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
   </body>
</html>