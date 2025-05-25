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
                <!-- PJESA E IMPLMENTIMIT TE AJAX LEXIMIT DHE UPDATE NGA DB -->
               <tbody id="users-table-body">
    <tr><td colspan="4" id="loading-message">Duke u ngarkuar të dhënat...</td></tr>
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
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addUserModalLabel">Shto Përdorues të Ri</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="addUserForm">
                <div class="mb-3">
                    <label for="username" class="form-label">Emri i përdoruesit</label>
                    <input type="text" class="form-control" id="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Fjalëkalimi</label>
                    <input type="password" class="form-control" id="password" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Roli</label>
                    <select class="form-control" id="role">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mbyll</button>
            <button type="button" class="btn btn-primary" onclick="submitNewUser()">Shto</button>
            
        </div>
    </div>
  </div>
</div>

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
            <li class="list-group-item"><a href="contact_messages.php">Shiko Mesazhet e Kontaktit</a></li>
            <li class="list-group-item"><a href="logout.php">Dil</a></li>
        </ul>
    </section>
</main>
</div>
<!-- Bootstrap JS bundle -->
 
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/ajax_operations.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    fetch('get_users.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('users-table-body');
            if (data.length === 0) {
                tableBody.innerHTML = "<tr><td colspan='4'>Nuk u gjet asnjë përdorues.</td></tr>";
                return;
            }

            let rows = "";
            data.forEach(user => {
                rows += `<tr>
                    <td>${user.id}</td>
                    <td>${user.username}</td>
                    <td>
    <select class="role-select" onchange="updateUserRole(${user.id}, this.value)">
        <option value="user" ${user.role === 'user' ? 'selected' : ''}>User</option>
        <option value="admin" ${user.role === 'admin' ? 'selected' : ''}>Admin</option>
    </select>
</td>
                    <td>
                        <button class="btn btn-sm btn-warning">Edito</button>
                        <button class="btn btn-sm btn-danger">Fshij</button>
                    </td>
                </tr>`;
            });
            tableBody.innerHTML = rows;
        })
        .catch(err => {
            document.getElementById('users-table-body').innerHTML = "<tr><td colspan='4'>Gabim gjatë ngarkimit të të dhënave.</td></tr>";
            console.error("Gabim:", err);
        });
});
//per butonat rifresko dhe shto te ri
function loadUsersData() {
    fetch('get_users.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('users-table-body');
            if (data.length === 0) {
                tableBody.innerHTML = "<tr><td colspan='4'>Nuk u gjet asnjë përdorues.</td></tr>";
                return;
            }

            let rows = "";
            data.forEach(user => {
                rows += `<tr>
                    <td>${user.id}</td>
                    <td>${user.username}</td>
                    <td>
                        <select class="role-select" onchange="updateUserRole(${user.id}, this.value)">
                            <option value="user" ${user.role === 'user' ? 'selected' : ''}>User</option>
                            <option value="admin" ${user.role === 'admin' ? 'selected' : ''}>Admin</option>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-warning">Edito</button>
                        <button class="btn btn-sm btn-danger">Fshij</button>
                    </td>
                </tr>`;
            });
            tableBody.innerHTML = rows;
        })
        .catch(err => {
            document.getElementById('users-table-body').innerHTML = "<tr><td colspan='4'>Gabim gjatë rifreskimit.</td></tr>";
            console.error("Gabim:", err);
        });
}
function submitNewUser() {
    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value.trim();
    const role = document.getElementById("role").value;

    if (!username || !password) {
        alert("Ju lutem plotësoni të gjitha fushat.");
        return;
    }

    fetch('add_user.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ username, password, role })
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert("Përdoruesi u shtua me sukses.");
            loadUsersData(); // rifresko tabelën
            const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
            modal.hide();
        } else {
            alert("Gabim: " + result.message);
        }
    })
    .catch(error => {
        console.error("Gabim:", error);
        alert("Ndodhi një gabim gjatë shtimit të përdoruesit.");
    });
}

<script src="js/ajax_operations.js">

</script>
</body>
</html>
