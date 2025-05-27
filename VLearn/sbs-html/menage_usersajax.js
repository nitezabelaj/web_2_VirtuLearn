$(document).ready(function() {
    // Funksioni për të mbushur tabelën
    function loadUsers() {
        $.getJSON('get_users.php', function(users) {
            let rows = '';
            users.forEach(user => {
                rows += `
                    <tr>
                        <td>${user.id}</td>
                        <td>${user.username}</td>
                        <td>${user.email}</td>
                        <td>
                            <select class="role-select" data-id="${user.id}">
                                <option value="user" ${user.role === 'user' ? 'selected' : ''}>User</option>
                                <option value="admin" ${user.role === 'admin' ? 'selected' : ''}>Admin</option>
                            </select>
                        </td>
                        <td><button class="update-btn" data-id="${user.id}">Përditëso</button></td>
                    </tr>
                `;
            });
            $('#users-table tbody').html(rows);
        });
    }

    // Load users kur faqja hapet
    loadUsers();

    // Event për përditësim të rolit
    $(document).on('click', '.update-btn', function() {
        const id = $(this).data('id');
        const role = $(`select[data-id="${id}"]`).val();

        $.ajax({
            url: 'ajax_update_role.php',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ id: id, role: role }),
            success: function(response) {
                if (response.success) {
                    alert('Roli u përditësua me sukses!');
                } else {
                    alert('Gabim: ' + response.error);
                }
            }
        });
    });
});
