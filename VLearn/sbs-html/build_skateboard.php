<?php
require_once 'includes/error_handler.php';//T.G
//AnitaC - P2 / Sessions
session_start();

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
















<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>🛹 Build Your Skateboard</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('https://images.ctfassets.net/3s5io6mnxfqz/153UQSRpQG8kVMiqA5UE0W/35a404178dfd824a990ce5e54d0b60e2/AdobeStock_279385959.jpeg?w=1920') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            max-width: 500px;
            width: 90%;
            text-align: center;
        }

        h1 {
            color: #0077cc;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            text-align: left;
            margin-top: 1rem;
            font-weight: bold;
        }

        select, input[type="color"] {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            margin-top: 5px;
        }

        button {
            margin-top: 20px;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            transition: background 0.3s ease;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .session-box {
            background-color: #f4f8fb;
            margin-top: 30px;
            padding: 1.2rem;
            border: 1px solid #bcd;
            border-radius: 12px;
            text-align: left;
        }

        .session-box h2 {
            color: #222;
            margin-bottom: 10px;
        }

        .session-box li {
            margin-bottom: 5px;
        }

        a.clear {
            display: inline-block;
            margin-top: 15px;
            color: #c00;
            text-decoration: none;
            font-weight: bold;
        }

        a.clear:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

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

    <?php if (isset($_SESSION['build'])): ?>
        <div class="session-box">
            <h2>🔧 Your Current Build</h2>
            <ul>
                <li><strong>Deck:</strong> <?= htmlspecialchars($_SESSION['build']['deck']) ?></li>
                <li><strong>Wheels:</strong> <?= htmlspecialchars($_SESSION['build']['wheels']) ?></li>
                <li><strong>Trucks:</strong> <?= htmlspecialchars($_SESSION['build']['trucks']) ?></li>
                <li><strong>Color:</strong> 
                    <span style="background: <?= htmlspecialchars($_SESSION['build']['color']) ?>; 
                        padding: 2px 10px; 
                        border-radius: 5px; 
                        color: #fff;">
                        <?= htmlspecialchars($_SESSION['build']['color']) ?>
                    </span>
                </li>
            </ul>
            <a href="?clear=true" class="clear">🗑️ Clear Build</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>