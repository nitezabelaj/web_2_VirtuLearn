<?php
require 'config.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menaxho Përdoruesit</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        select { padding: 4px; }
        button { padding: 6px 10px; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Menaxhimi i Përdoruesve</h2>
    <table id="users-table">
        <thead>
            <tr><th>ID</th><th>Username</th><th>Email</th><th>Roli</th><th>Veprime</th></tr>
        </thead>
        <tbody></tbody>
    </table>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 0;
    }

    h2 {
        text-align: center;
        margin-top: 40px;
        color: #333;
    }

    table {
        border-collapse: collapse;
        width: 90%;
        margin: 30px auto;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    th {
        background-color: #007BFF;
        color: white;
        padding: 12px;
        font-weight: 600;
    }

    td {
        padding: 10px;
        border: 1px solid #ccc;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    select {
        padding: 6px;
        font-size: 0.95rem;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    button {
        padding: 6px 12px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #218838;
    }
</style>


    <script>
    // Merr të dhënat e përdoruesve
    fetch('../getUsers.php')
        .then(res => res.json())
        .then(users => {
            const tbody = document.querySelector('#users-table tbody');
            users.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.id}</td>
                    <td>${user.username}</td>
                    <td>${user.email}</td>
                    <td>
                        <select>
                            <option value="user" ${user.role === 'user' ? 'selected' : ''}>user</option>
                            <option value="admin" ${user.role === 'admin' ? 'selected' : ''}>admin</option>
                        </select>
                    </td>
                    <td>
                        <button onclick="updateRole(${user.id}, this)">Përditëso</button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        });

    // Funksioni për përditësim
    function updateRole(userId, button) {
        const role = button.parentElement.parentElement.querySelector('select').value;

        fetch('../updateUserRole.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({id: userId, role: role})
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Roli u përditësua me sukses.');
            } else {
                alert('Gabim: ' + data.error);
            }
        });
    }
    </script>
</body>
</html>
