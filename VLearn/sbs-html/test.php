<?php
session_start();

if (!isset($_SESSION['myValue'])) {
    $_SESSION['myValue'] = "Duke përditësuar këtë fjali, ti mund të japësh info interesante rreth skateboard.";
}

if (isset($_GET['action'])) {
    header('Content-Type: application/json');
    $action = $_GET['action'];

    switch ($action) {
        case 'read':
            echo json_encode(['value' => $_SESSION['myValue']]);
            break;

        case 'update':
            $newValue = trim($_POST['value'] ?? '');
            if ($newValue !== '') {
                $_SESSION['myValue'] = $newValue;
                echo json_encode(['success' => true, 'newValue' => $_SESSION['myValue']]);
            } else {
                echo json_encode(['error' => 'Vlera është bosh']);
            }
            break;

        default:
            echo json_encode(['error' => 'Veprim i pavlefshëm']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8" />
    <title>Update info rreth skateboard me AJAX</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2em; }
        input[type="text"] { width: 60%; padding: 0.5em; }
        button { padding: 0.5em 1em; margin-left: 0.5em; }
        #message { margin-top: 1em; color: green; }
    </style>
</head>
<body>

    <h3 id="display">Duke ngarkuar...</h3>

    <input type="text" id="inputValue" placeholder="Shkruaj info rreth skateboard" />
    <button onclick="updateValue()">Përditëso Fjalinë</button>

    <div id="message"></div>

<script>
    function readValue() {
        fetch('?action=read')
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

        fetch('?action=update', {
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

    // Kur ngarkohet faqja, lexojmë vlerën
    readValue();
</script>
<?php


if (!isset($_SESSION['myValue'])) {
    $_SESSION['myValue'] = "Duke përditësuar këtë fjali, ti mund të japësh info interesante rreth skateboard.";
}

if (isset($_GET['action'])) {
    header('Content-Type: application/json');
    $action = $_GET['action'];

    switch ($action) {
        case 'read':
            echo json_encode(['value' => $_SESSION['myValue']]);
            break;

        case 'update':
            $newValue = trim($_POST['value'] ?? '');
            if ($newValue !== '') {
                $_SESSION['myValue'] = $newValue;
                echo json_encode(['success' => true, 'newValue' => $_SESSION['myValue']]);
            } else {
                echo json_encode(['error' => 'Vlera është bosh']);
            }
            break;

        default:
            echo json_encode(['error' => 'Veprim i pavlefshëm']);
    }
    exit;
}
?>

<h3 id="display">Duke ngarkuar...</h3>

<input type="text" id="inputValue" placeholder="Shkruaj info rreth skateboard" />
<button onclick="updateValue()">Përditëso Fjalinë</button>

<div id="message"></div>

<script>
    function readValue() {
        fetch('?action=read')
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

        fetch('?action=update', {
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
