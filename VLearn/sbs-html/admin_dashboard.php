<?php
session_start();
require_once 'config.php';

// Funksion sanitizeInput nëse nuk e ke në config.php
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Kontrolli i aksesit
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$adminName = sanitizeInput($_SESSION['username']);

$menu_items = [
    "index.php" => "Home",
    "about.php" => "About",
    "skating.php" => "Skating",
    "shop.php" => "Shop",
    "contact.php" => "Contact Us",
    "build_skateboard.php"=>"Build your Skateboard"
];

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        $menu_items['admin_dashboard.php'] = "Admin Panel";
    } else {
        $menu_items['dashboard.php'] = "Dashboard";
    }
    $menu_items['logout.php'] = "Logout";

    unset($menu_items['login.php'], $menu_items['register.php']);
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
<html lang="sq">
<head>
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <meta charset="UTF-8" />
    <title>Admin Dashboard - SkatingBoardSchool</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">SkatingBoardSchool</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php generateMenu($menu_items); ?>
                </ul>
            </div>
        </div>
    </nav>
<!-- Zëvendësoni tabelën ekzistuese me këtë strukturë -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Menaxhimi i Përdoruesve</h6>
        <div>
            <button class="btn btn-sm btn-primary" onclick="loadUsersData()">
                <i class="fas fa-sync-alt"></i> Rifresko
            </button>
            <button class="btn btn-sm btn-success ms-2" onclick="showAddUserModal()">
                <i class="fas fa-plus"></i> Shto të Ri
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="users-table" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th width="5%">ID</th>
                        <th>Emri i Përdoruesit</th>
                        <th width="15%">Roli</th>
                        <th width="20%">Veprimet</th>
                    </tr>
                </thead>
                <tbody id="users-table-body">
                    <!-- Rreshti i ngarkimit -->
                    <tr>
                        <td colspan="4" class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Duke ngarkuar...</span>
                            </div>
                            <p>Duke ngarkuar të dhënat...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    /* Stilizimi i tabelës së përdoruesve */
#users-table {
    font-size: 0.9rem;
}

#users-table th {
    background-color: #4e73df;
    color: white;
    font-weight: 600;
}

.role-select {
    width: 100%;
    padding: 0.25rem 0.5rem;
    font-size: 0.85rem;
}

.update-btn, .delete-btn {
    font-size: 0.8rem;
    padding: 0.25rem 0.5rem;
}

/* Responsive table */
@media (max-width: 768px) {
    #users-table td:nth-child(1):before { content: "ID: "; font-weight: bold; }
    #users-table td:nth-child(2):before { content: "Emri: "; font-weight: bold; }
    #users-table td:nth-child(3):before { content: "Roli: "; font-weight: bold; }
    #users-table td:nth-child(4):before { content: "Veprimet: "; font-weight: bold; }
    
    #users-table td {
        display: block;
        text-align: right;
        padding-left: 50%;
        position: relative;
    }
    
    #users-table td::before {
        position: absolute;
        left: 0.5rem;
        width: calc(50% - 1rem);
        padding-right: 1rem;
        text-align: left;
    }
}
</style>

<!-- Modal për Shtimin e Përdoruesit (opsional) -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Shto Përdorues të Ri</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Forma do të shtohet këtu -->
            </div>
        </div>
    </div>
</div>
</header>

<main class="container my-5" style="max-width: 600px;">
    <h1 class="mb-4">Paneli i Administratorit</h1>
    <p>Përshëndetje, <strong><?= $adminName ?></strong>! Jeni kyçur si <em>admin</em>.</p>
<br>
<br>
<br>
<br>
    <section>
        <h2>Opsionet e Administrimit</h2>
        <ul class="list-group">
            <li class="list-group-item"><a href="manage_users.php">Menaxho Përdoruesit</a></li>
            <li class="list-group-item"><a href="manage_products.php">Menaxho Produktet</a></li>
            <li class="list-group-item"><a href="manage_preferences.php">Preferencat e Përdoruesve për Skateboard</a></li>
            <li class="list-group-item"><a href="contact_messages.php">Shiko Mesazhet e Kontaktit</a></li>
            <li class="list-group-item"><a href="logout.php">Dil</a></li>
        </ul>
    </section>
</main>
<!-- Bootstrap JS bundle -->
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/ajax_operations.js"></script>
</body>
</html>
