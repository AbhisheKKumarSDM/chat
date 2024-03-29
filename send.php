<?php
include_once('config/database.php');
include_once('helper/common.php');

// Save Encrypted Message to Database
function saveEncryptedMessage($encryptedMessage, $recipient,$encryption_key, $expiry) {
    global $pdo;
    $createdAt = date('Y-m-d H:i:s');
    $stmt = $pdo->prepare("INSERT INTO messages (encrypted_message, recipient,encryption_key, created_at, expiry) VALUES (?, ?, ?,?, ?)");
    $stmt->execute([$encryptedMessage, $recipient,$encryption_key, $createdAt, $expiry]);
    return $pdo->lastInsertId();
}


// Check if form is submitted for sharing message
if (isset($_POST['share_message'])) {
    $message = $_POST['message'];
    $recipient = $_POST['recipient'];
    $encryptionKey = $_POST['encryption_key'];
    $expiry = isset($_POST['expiry']) ? date('Y-m-d H:i:s', strtotime("+1 day")) : null; // Expire after 1 day

    $encryptedMessage = encryptMessage($message, $encryptionKey);
    $messageId = saveEncryptedMessage($encryptedMessage, $recipient,$encryptionKey, $expiry);
    // echo "Message shared successfully !!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Message Sharing</title>
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
   
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Share Message</h2>
                        <?php
                            if(isset($messageId)) {
                                echo '<div class="alert alert-success" role="alert">"Message shared successfully !!"</div>';
                            }
                        ?>
                        <form method="post" onsubmit="return validateEncryptionKey()">
                            <div class="mb-3">
                                <label for="message" class="form-label">Message:</label>
                                <textarea id="message" name="message" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="recipient" class="form-label">Recipient:</label>
                                <input type="text" id="recipient" name="recipient" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="encryption_key" class="form-label">Encryption key:</label>
                                <input type="text" id="encryption_key" name="encryption_key" class="form-control" required>
                                <div id="encryptionKeyError" class="invalid-feedback">Encryption key must be exactly 16 characters long.</div>
                            </div>
                            <div class="mb-3">
                                <label for="expiry" class="form-label">Set expiry (In Days):</label>
                                <input type="number" id="expiry" name="expiry" class="form-control">
                            </div>
                            <div class="text-center">
                                <button type="submit" name="share_message" class="btn btn-primary">Share Message</button>
                                <!-- Home button -->
                                <a href="index.html" class="btn btn-secondary ms-2">Home</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS (optional) -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script>
        function validateEncryptionKey() {
            var encryptionKeyInput = document.getElementById("encryption_key");
            var encryptionKeyError = document.getElementById("encryptionKeyError");
            if (encryptionKeyInput.value.length !== 16) {
                encryptionKeyInput.classList.add("is-invalid");
                encryptionKeyError.style.display = "block";
                return false;
            } else {
                encryptionKeyInput.classList.remove("is-invalid");
                encryptionKeyError.style.display = "none";
                return true;
            }
        }
    </script>
</body>
</html>

