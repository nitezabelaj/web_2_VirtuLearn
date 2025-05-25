/**
 * Funksionet bazë për AJAX requests
 */
class AjaxHandler {
    static async getData(endpoint, params = {}) {
        try {
            const queryString = Object.keys(params)
                .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(params[key])}`)
                .join('&');
            
            const url = `${endpoint}${queryString ? `?${queryString}` : ''}`;
            
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });
            
            return await response.json();
        } catch (error) {
            console.error('Gabim në GET request:', error);
            throw error;
        }
    }

    static async postData(endpoint, data = {}) {
        try {
            // Shto CSRF token në të dhënat
            data.csrf_token = document.querySelector('meta[name="csrf-token"]').content;
            
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify(data)
            });
            
            return await response.json();
        } catch (error) {
            console.error('Gabim në POST request:', error);
            throw error;
        }
    }
}

/**
 * Funksione specifike për aplikacionin
 */
class AppDataHandler {
    static async loadUsers() {
        try {
            showLoading('#users-table-body');
            
            const response = await AjaxHandler.getData('includes/ajax_handlers/fetch_data.php', {
                type: 'users'
            });
            
            if (response.status !== 'success') {
                throw new Error(response.message || 'Gabim në marrjen e të dhënave');
            }
            
            renderUsersTable(response.data);
        } catch (error) {
            showError(error.message);
        }
    }

    static async updateUserRole(userId, newRole) {
        try {
            const response = await AjaxHandler.postData('includes/ajax_handlers/update_data.php', {
                action: 'update_user_role',
                user_id: userId,
                new_role: newRole
            });
            
            if (response.status !== 'success') {
                throw new Error(response.message || 'Gabim në përditësim');
            }
            
            showSuccess(response.message);
            await this.loadUsers(); // Rifresko tabelën
        } catch (error) {
            showError(error.message);
        }
    }
}

/**
 * Funksione ndihmëse për UI
 */
function showLoading(selector) {
    const loadingHTML = `
        <tr>
            <td colspan="4" class="text-center">
                <div class="d-flex align-items-center">
                    <div class="spinner-border text-primary me-2" role="status"></div>
                    <span>Po ngarkohen të dhënat...</span>
                </div>
            </td>
        </tr>
    `;
    document.querySelector(selector).innerHTML = loadingHTML;
}

function renderUsersTable(users) {
    let html = '';
    
    users.forEach(user => {
        html += `
            <tr data-user-id="${user.id}">
                <td>${user.id}</td>
                <td>${user.username}</td>
                <td>
                    <select class="form-select user-role-select" 
                            onchange="AppDataHandler.updateUserRole(${user.id}, this.value)">
                        <option value="user" ${user.role === 'user' ? 'selected' : ''}>Përdorues</option>
                        <option value="admin" ${user.role === 'admin' ? 'selected' : ''}>Administrator</option>
                    </select>
                </td>
                <td>
                    <button class="btn btn-sm btn-danger" 
                            onclick="confirmDeleteUser(${user.id})">
                        <i class="fas fa-trash-alt"></i> Fshi
                    </button>
                </td>
            </tr>
        `;
    });
    
    document.querySelector('#users-table-body').innerHTML = html;
}

function showSuccess(message) {
    // Përdor SweetAlert2 nëse është i disponueshëm
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: message,
            timer: 2000,
            toast: true,
            position: 'top-end'
        });
    } else {
        alert('Sukses: ' + message);
    }
}

function showError(message) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'error',
            title: 'Gabim!',
            text: message
        });
    } else {
        alert('Gabim: ' + message);
    }
}

// Ngarko përdoruesit kur faqja të jetë gati
document.addEventListener('DOMContentLoaded', () => {
    AppDataHandler.loadUsers();
});
// Funksioni për ngarkimin e të dhënave
function loadUsersData() {
    const tableBody = document.getElementById('users-table-body');
    
    // Shfaq loading state
    tableBody.innerHTML = `
        <tr>
            <td colspan="4" class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Duke ngarkuar...</span>
                </div>
                <p>Duke ngarkuar të dhënat...</p>
            </td>
        </tr>
    `;

    $.ajax({
        url: 'includes/ajax_handlers/fetch_data.php?type=users',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.status === 'success') {
                renderUsersTable(response.data);
            } else {
                showError(response.message || 'Gabim në marrjen e të dhënave');
            }
        },
        error: function(xhr, status, error) {
            showError('Gabim në server: ' + error);
        }
    });
}

// Funksioni për renderimin e tabelës
function renderUsersTable(users) {
    let html = '';
    
    if (users.length === 0) {
        html = `
            <tr>
                <td colspan="4" class="text-center">Nuk ka përdorues të regjistruar</td>
            </tr>
        `;
    } else {
        users.forEach(user => {
            html += `
                <tr data-user-id="${user.id}">
                    <td>${user.id}</td>
                    <td>${user.username}</td>
                    <td>
                        <select class="form-control role-select" data-user-id="${user.id}">
                            <option value="user" ${user.role === 'user' ? 'selected' : ''}>Përdorues</option>
                            <option value="admin" ${user.role === 'admin' ? 'selected' : ''}>Administrator</option>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary update-btn" data-user-id="${user.id}">
                            <i class="fas fa-save"></i> Ruaj
                        </button>
                        <button class="btn btn-sm btn-danger delete-btn ml-2" data-user-id="${user.id}">
                            <i class="fas fa-trash-alt"></i> Fshi
                        </button>
                    </td>
                </tr>
            `;
        });
    }
    
    document.getElementById('users-table-body').innerHTML = html;
    
    // Shto event listeners për butonat e rinj
    addEventListeners();
}

// Funksioni për shtimin e event listeners
function addEventListeners() {
    // Përditësimi i rolit
    document.querySelectorAll('.update-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            const newRole = this.closest('tr').querySelector('.role-select').value;
            updateUserRole(userId, newRole);
        });
    });
    
    // Fshirja e përdoruesit
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const userId = this.getAttribute('data-user-id');
            confirmDeleteUser(userId);
        });
    });
}

// Funksioni për përditësimin e rolit
function updateUserRole(userId, newRole) {
    $.ajax({
        url: 'includes/ajax_handlers/update_data.php',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'update_role',
            user_id: userId,
            new_role: newRole,
            csrf_token: document.querySelector('meta[name="csrf-token"]').content
        },
        success: function(response) {
            if(response.status === 'success') {
                showSuccess('Roli u përditësua me sukses!');
                loadUsersData(); // Rifresko tabelën
            } else {
                showError(response.message || 'Gabim në përditësim');
            }
        },
        error: function(xhr, status, error) {
            showError('Gabim në komunikim me serverin');
        }
    });
}

// Funksioni për konfirmimin e fshirjes
function confirmDeleteUser(userId) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Jeni i sigurt?',
            text: "Kjo veprim nuk mund të zhbëhet!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Po, fshije!',
            cancelButtonText: 'Anulo'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteUser(userId);
            }
        });
    } else if (confirm('Jeni i sigurt që dëshironi të fshini këtë përdorues?')) {
        deleteUser(userId);
    }
}

// Funksioni për fshirjen e përdoruesit
function deleteUser(userId) {
    $.ajax({
        url: 'includes/ajax_handlers/update_data.php',
        type: 'POST',
        dataType: 'json',
        data: {
            action: 'delete_user',
            user_id: userId,
            csrf_token: document.querySelector('meta[name="csrf-token"]').content
        },
        success: function(response) {
            if(response.status === 'success') {
                showSuccess('Përdoruesi u fshi me sukses!');
                loadUsersData(); // Rifresko tabelën
            } else {
                showError(response.message || 'Gabim në fshirje');
            }
        },
        error: function(xhr, status, error) {
            showError('Gabim në komunikim me serverin');
        }
    });
}

// Ngarko të dhënat kur faqja të jetë gati
document.addEventListener('DOMContentLoaded', function() {
    loadUsersData();
    function updateUserRole(userId, newRole) {
    fetch('ajax_update_role.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: userId, role: newRole })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Roli u përditësua me sukses.");
        } else {
            alert("Gabim gjatë përditësimit të rolit.");
        }
    })
    .catch(err => {
        console.error("Gabim:", err);
        alert("Gabim gjatë komunikimit me serverin.");
    });
}
});