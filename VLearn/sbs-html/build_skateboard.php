 <?php
//T.G
//AnitaC - P2 / Sessions
session_start();
ob_start(); 

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

if (!isset($_SESSION['user_id'])) {
    die("Ju lutem, identifikohuni për të vazhduar.");
}

$user_id = $_SESSION['user_id'];

$mysqli = new mysqli("localhost", "root", "", "virtu_learn");
if ($mysqli->connect_error) {
    die("Lidhja me bazën e të dhënave dështoi: " . $mysqli->connect_error);
}

if (isset($_GET['clear']) && $_GET['clear'] === 'true') {
    $stmt = $mysqli->prepare("DELETE FROM user_builds WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    unset($_SESSION['build']);

    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deck = $_POST['deck'] ?? '';
    $wheels = $_POST['wheels'] ?? '';
    $trucks = $_POST['trucks'] ?? '';
    $color = $_POST['color'] ?? '';

    if ($deck && $wheels && $trucks && $color) {
        $query = "
            INSERT INTO user_builds (user_id, deck, wheels, trucks, color, updated_at)
            VALUES (?, ?, ?, ?, ?, NOW())
            ON DUPLICATE KEY UPDATE
                deck = VALUES(deck),
                wheels = VALUES(wheels),
                trucks = VALUES(trucks),
                color = VALUES(color),
                updated_at = NOW()
        ";

        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("issss", $user_id, $deck, $wheels, $trucks, $color);
        $stmt->execute();
        $stmt->close();

        $_SESSION['build'] = [
            'deck' => $deck,
            'wheels' => $wheels,
            'trucks' => $trucks,
            'color' => $color
        ];

        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
    } else {
        echo "<p style='color:red;'>Ju lutem plotësoni të gjitha fushat!</p>";
    }
}
//Error_hadler me te gjithaspecifikat
function error_handler($errno, $errstr, $errfile, $errline) {
    echo "<div style='background:#fee;border:1px solid #c00;padding:10px;margin:10px 0;color:#900;'>";
    echo "<strong>Gabim u kap!</strong><br>";
    echo "Lloji: $errno <br>";
    echo "Mesazhi: $errstr <br>";
    echo "Skedari: $errfile <br>";
    echo "Rreshti: $errline <br>";
    echo "</div>";
}
set_error_handler("error_handler");

if (!isset($_SESSION['build'])) {
    $stmt = $mysqli->prepare("SELECT deck, wheels, trucks, color FROM user_builds WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $_SESSION['build'] = $row;
    }
    $stmt->close();
}

$mysqli->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🛹 Build Your Skateboard</title>
    <style>
           * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('https://images.ctfassets.net/3s5io6mnxfqz/153UQSRpQG8kVMiqA5UE0W/35a404178dfd824a990ce5e54d0b60e2/AdobeStock_279385959.jpeg?w=1920') no-repeat center center fixed;
            background-size: cover;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

      
        nav {
            background: rgba(0, 0, 0, 0.8);
            padding: 10px 20px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0,0,0,0.7);
            display: flex;
            justify-content: center;
            font-weight: 600;
            font-size: 16px;
        }

        nav ul.nav {
            list-style: none;
            display: flex;
            gap: 25px;
        }
        nav ul.nav li.nav-item a.nav-link {
            color: #eee;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        nav ul.nav li.nav-item.active a.nav-link,
        nav ul.nav li.nav-item a.nav-link:hover {
            background-color: #ff4c00;
            color: white;
            box-shadow: 0 0 8px #ff4c00;
        }

   
        .container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            max-width: 450px;
            margin: 120px auto 50px auto; 
            padding: 30px 40px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
            text-align: center;
        }

        .container h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #222;
            letter-spacing: 1px;
            text-shadow: 1px 1px 2px rgba(255, 76, 0, 0.7);
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            text-align: left;
        }

        label {
            font-weight: 600;
            color: #444;
            margin-bottom: 5px;
            display: block;
        }

        select, input[type="color"] {
            padding: 8px 10px;
            border: 2px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
            width: 100%;
        }

        select:focus, input[type="color"]:focus {
            border-color: #ff4c00;
            outline: none;
            box-shadow: 0 0 6px #ff4c00;
        }

        button[type="submit"] {
            background-color: #ff4c00;
            color: white;
            font-weight: 700;
            border: none;
            padding: 12px;
            font-size: 1.1rem;
            border-radius: 12px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
            box-shadow: 0 4px 12px rgba(255, 76, 0, 0.6);
        }

        button[type="submit"]:hover {
            background-color: #e04300;
            box-shadow: 0 6px 18px rgba(224, 67, 0, 0.8);
        }

        .session-box {
            margin-top: 30px;
            background-color: #fff5f0;
            border: 2px solid #ff4c00;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(255, 76, 0, 0.3);
            text-align: left;
        }

        .session-box h2 {
            color: #ff4c00;
            margin-bottom: 15px;
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        .session-box ul {
            list-style: none;
            padding-left: 0;
        }

        .session-box ul li {
            font-size: 1.05rem;
            margin-bottom: 8px;
        }

        .session-box ul li strong {
            color: #cc3b00;
        }

        .session-box ul li span {
            display: inline-block;
            width: 25px;
            height: 25px;
            vertical-align: middle;
            border-radius: 5px;
            border: 1px solid #cc3b00;
            margin-left: 8px;
        }

        .clear {
            display: inline-block;
            margin-top: 15px;
            text-decoration: none;
            color: #cc3b00;
            font-weight: 600;
            border: 1.5px solid #cc3b00;
            padding: 6px 12px;
            border-radius: 10px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .clear:hover {
            background-color: #cc3b00;
            color: white;
            box-shadow: 0 0 10px #cc3b00;
        }

        .sidebar {
            position: fixed;
            top: 60px;
            left: 15px;
            width: 250px;
            max-height: 70vh;
            overflow-y: auto;
            background: rgba(255,255,255,0.9);
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
            font-size: 14px;
            color: #333;
            z-index: 900;
            font-weight: 500;
            margin:20px;

        }

 
        @media (max-width: 600px) {
            nav ul.nav {
                flex-direction: column;
                gap: 10px;
            }
            .container {
                margin: 140px 15px 40px 15px;
                padding: 25px;
                max-width: 90%;
            }
            .sidebar {
                width: 90%;
                left: 5%;
                top: auto;
                bottom: 20px;
                max-height: 150px;
                font-size: 12px;
                padding: 10px;
            }
        }
    </style>
    <head>
    <title>Autentikimi</title>
</head>
<body>



</body>
</html>

</head>
<body>
    <nav>
        <ul class="nav">
            <?php generateMenu($menu_items); ?>
        </ul>
    </nav>

    <div class="sidebar">
        <?php
        //Definimi dhe përdorimi i COOKIES me të gjitha specifikat (krijim, fshirja,
           //ruajtja në varg).

        $cookieConsent = $_COOKIE['cookie_consent'] ?? null;

        if ($cookieConsent !== 'accepted') {
            echo '
            <div id="cookie-consent-banner" style="background:#f5f5f5; padding:10px; border-radius:8px; font-size:14px; color:#333;">
                Our site uses cookies. Do you accept our <strong>Cookies Privacy</strong>?
                <button id="accept-cookies" style="margin-left:10px; padding:5px 10px;">Accept</button>
                <button id="decline-cookies" style="margin-left:5px; padding:5px 10px;">Decline</button>
            </div>
            <script>
                document.getElementById("accept-cookies").addEventListener("click", function() {
                    document.cookie = "cookie_consent=accepted; path=/; max-age=" + 60*60*24*365;
                    location.reload();
                });
                document.getElementById("decline-cookies").addEventListener("click", function() {
                    document.cookie = "cookie_consent=declined; path=/; max-age=" + 60*60*24*365;
                    document.getElementById("cookie-consent-banner").style.display = "none";
                });
            </script>';
        } else if ($cookieConsent === 'accepted') {
            if (isset($_GET['clear_cookie']) && $_GET['clear_cookie'] === 'true') {
                setcookie('last_visits', '', time() - 3600, "/");
                echo "Cookie 'last_visits' has been cleared.<br>";
            }

            if (isset($_COOKIE['last_visits'])) {
                $visits = json_decode($_COOKIE['last_visits'], true);
                
                $lastThree = array_slice($visits, -3, 3, true);

                echo "Your last 3 visits: <ul>";
                foreach ($lastThree as $visit) {
                    echo "<li>" . htmlspecialchars($visit) . "</li>";
                }
                echo "</ul>";
            } else {
                echo "This is your first visit to this page. Welcome!<br>";
                $visits = [];
            }

            $visits[] = date('Y-m-d H:i:s');
            setcookie('last_visits', json_encode($visits), time() + (86400 * 30), "/");
        } else {
            echo "You declined cookies. Some features might be limited.";
        }
        ?>
    </div>

    <div class="container">
        <h1>🛹 Build Your Skateboard</h1>

        <form method="POST">
            <label for="deck">Deck:</label>
            <select name="deck" id="deck">
                <option value="Element">Element</option>
                <option value="Santa Cruz">Santa Cruz</option>
                <option value="Zero">Zero</option>
            </select>

            <label for="wheels">Wheels:</label>
            <select name="wheels" id="wheels">
                <option value="Spitfire">Spitfire</option>
                <option value="Bones">Bones</option>
                <option value="Ricta">Ricta</option>
            </select>

            <label for="trucks">Trucks:</label>
            <select name="trucks" id="trucks">
                <option value="Independent">Independent</option>
                <option value="Thunder">Thunder</option>
                <option value="Venture">Venture</option>
            </select>

            <label for="color">Color:</label>
            <input type="color" name="color" id="color" value="#ff0000">

            <button type="submit">💾 Save Configuration</button>
        </form>
      

        <?php 
           //Manipulimi me PHP Sesione (psh ruajtje të ndryshme të vlerave, pastaj ndryshim i tyre dhe manipulime të tilla).
        if (isset($_SESSION['build'])): ?>
           
            <div class="session-box">
                <h2>🔧 Your Current Build</h2>
                <ul>
                    <li><strong>Deck:</strong> <?= htmlspecialchars($_SESSION['build']['deck']) ?></li>
                    <li><strong>Wheels:</strong> <?= htmlspecialchars($_SESSION['build']['wheels']) ?></li>
                    <li><strong>Trucks:</strong> <?= htmlspecialchars($_SESSION['build']['trucks']) ?></li>
                    <li><strong>Color:</strong> <span style="display:inline-block;width:20px;height:20px;background:<?= htmlspecialchars($_SESSION['build']['color']) ?>;"></span></li>
                </ul>
                <a href="?clear=true" class="clear"> Clear Build</a>
            </div>
        <?php endif; ?>
    </div>
    <?php
echo '<style>
  .box-container {
    background-color:light blue;
    display: inline-block;
    margin: 30px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    border-radius: 8px;
   
    font-family: Arial, sans-serif;
    font-size: 16px;
    line-height: 1.5;
    color: #333;
    max-width: 600px;
    white-space: normal;
  }
  .box-container * {
    font-family: inherit;
    font-size: inherit;
    line-height: inherit;
    color: inherit;
  }
  #content-box {
    display: none;
  }
  button {
    margin-top: 15px;
    padding: 16px 40px;
    font-size: 20px;
    cursor: pointer;
    border: 10px;
    background-color: #007BFF;
    color: white;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0, 123, 255, 0.5);
    transition: background-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
    font-weight: 700;
    max-width: 100%;
    display: inline-block;
    text-align: center;
  }
  button:hover {
    background-color: #0056b3;
    box-shadow: 0 8px 25px rgba(0, 86, 179, 0.7);
    transform: translateY(-4px);
  }
  button:active {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 86, 179, 0.6);
  }
</style>';

echo '<div class="box-container">';
echo '<p>Dëshironi të lexoni më shumë rreth skateboard?</p>';
echo '<button id="showContentBtn">Po</button>';
echo '<div id="content-box">';
include 'mesazhi.php';
require 'dokument.php';

function writeToFile($content) {
    $file = fopen('data.txt', 'w');
    if ($file) {
        $content1 = "Sot, skateboard-i është bërë pjesë e garave ndërkombëtare dhe <br>madje edhe e Lojërave Olimpike.<br><br>";
        fwrite($file, $content1);
        fwrite($file, $content);
        fclose($file);
    } else {
        echo "Nuk mund të hapim skedarin për të shkruar.";
    }
}

function readFromFile() {
    if (file_exists('data.txt')) {
        $file_size = filesize('data.txt');
        if ($file_size > 0) {
            $file = fopen('data.txt', 'r');
            if ($file) {
                $content = fread($file, $file_size);
                fclose($file);
                return $content;
            } else {
                return "Nuk mund të hapim skedarin për të lexuar.";
            }
        } else {
            return "Skedari është bosh.";
        }
    } else {
        return "Skedari nuk ekziston.";
    }
}

function checkFileSize() {
    if (file_exists('data.txt')) {
        $size = filesize('data.txt');
        return "Madhësia e skedarit është: $size bytes";
    } else {
        return "Skedari nuk ekziston.";
    }
}

writeToFile("Përveç argëtimit, ai ndihmon edhe në zhvillimin fizik dhe <br>mendor të individit.<br><br>");
echo "<br>" . checkFileSize() . "<br>";
mesazhi();
echo "<br>";
dokument();
echo "<pre>" . readFromFile() . "</pre>";
echo '</div>';
echo '</div>';

echo '
<script>
  document.getElementById("showContentBtn").addEventListener("click", function() {
    document.getElementById("content-box").style.display = "block";
    this.style.display = "none";
  });
</script>
';
?>
<div style="
    max-width: 400px; 
    margin: 2em auto; 
    padding: 1.5em 2em; 
    border: 2px solid #4A90E2; 
    border-radius: 12px; 
    box-shadow: 0 4px 10px rgba(74, 144, 226, 0.3);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f9faff;
    text-align: center;
">
<p>Shenoi nje fjali motivuese <br></p>
    <h3 id="display" style="
        font-weight: 600; 
        font-size: 1.2rem; 
        margin-bottom: 1.2em; 
        color: #333;
        min-height: 3em;
        display: flex;
        align-items: center;
        justify-content: center;
        ">
        Duke ngarkuar...
    </h3>

    <input type="text" id="inputValue" placeholder="Shkruaj me te miren" style="
        width: 70%;
        padding: 0.4em 0.6em;
        font-size: 1rem;
        border: 1.8px solid #4A90E2;
        border-radius: 6px 0 0 6px;
        outline: none;
        box-sizing: border-box;
        vertical-align: middle;
    " />
    <button onclick="updateValue()" style="
        padding: 0.45em 1em;
        font-size: 1rem;
        border: 1.8px solid #4A90E2;
        border-left: none;
        border-radius: 0 6px 6px 0;
        background-color: #4A90E2;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s ease;
        vertical-align: middle;
    " 
    onmouseover="this.style.backgroundColor='#357ABD'" 
    onmouseout="this.style.backgroundColor='#4A90E2'">
        Përditëso Fjalinë
    </button>

    <div id="message" style="
        margin-top: 1em; 
        color: #4A90E2; 
        min-height: 1.2em;
        font-weight: 500;
        font-size: 0.95rem;
    "></div>
</div>

<script>
    function readValue() {
        fetch('ajax_handler.php?action=read')
            .then(res => res.json())
            .then(data => {
                if(data.value !== undefined){
                    document.getElementById('display').innerText = data.value;
                    document.getElementById('message').innerText = '';
                } else {
                    document.getElementById('message').innerText = 'Gabim në lexim: ' + data.error;
                }
            })
            .catch(err => {
                document.getElementById('message').innerText = 'Gabim në lidhje: ' + err;
            });
    }

    function updateValue() {
        const newVal = document.getElementById('inputValue').value.trim();
        if(newVal === ''){
            document.getElementById('message').innerText = 'Fusha është bosh, shkruaj diçka!';
            return;
        }

        fetch('ajax_handler.php?action=update', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `value=${encodeURIComponent(newVal)}`
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                document.getElementById('message').innerText = 'Fjalimi u përditësua me sukses!';
                readValue();
                document.getElementById('inputValue').value = '';
            } else {
                document.getElementById('message').innerText = 'Gabim në përditësim: ' + data.error;
            }
        })
        .catch(err => {
            document.getElementById('message').innerText = 'Gabim në lidhje: ' + err;
        });
    }

    readValue();
</script>



</body>
</html>


<?php
ob_end_flush();  
?> 