<?php
include_once('/config/database.php');
include_once('/helper/common.php');

// Retrieve Encrypted Message from Database
function retrieveEncryptedMessage($identifier, $key) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id,read_status,delete_status,encrypted_message, expiry FROM messages WHERE recipient = ? AND encryption_key = ?");
    $stmt->execute([$identifier, $key]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        if (strtotime($row['expiry']) > time() && $row['read_status'] != 1) {
            markMessageAsRead($row['id']);
            return "<b>Message :</b> ".decryptMessage($row['encrypted_message'], $key);
            // Mark the message as read
        } elseif($row['delete_status'] == 1) {
            return "Message has Deleted !";
        }elseif($row['read_status'] == 1) {
            return "Message has read already !";
        } else {
            return "Message has expired !";
        }
    } else {
        return "Invalid identifier or encryption key.";
    }
}


// Check if form is submitted for retrieving message
if (isset($_POST['retrieve_message'])) {
    $messageId = $_POST['message_id'];
    $decryptionKey = $_POST['decryption_key'];

    // Retrieve and decrypt message
    $decryptedMessage = retrieveEncryptedMessage($messageId, $decryptionKey);
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
                        <h2 class="card-title text-center mb-4">Retrieve Message</h2>
                        <?php
                        if(isset($decryptedMessage)) {
                            echo '<div class="alert alert-success" role="alert">' . $decryptedMessage . '</div>';
                            echo '<form method="post">';
                            echo '<button type="submit" name="remove_message" class="btn btn-danger">Back</button>';
                            echo '</form>';
                        } else {
                            echo '<form method="post">';
                            echo '<div class="mb-3">';
                            echo '<label for="message_id" class="form-label">Recipient:</label>';
                            echo '<input type="text" id="message_id" name="message_id" class="form-control" required>';
                            echo '</div>';
                            echo '<div class="mb-3">';
                            echo '<label for="decryption_key" class="form-label">Decryption Key:</label>';
                            echo '<input type="text" id="decryption_key" name="decryption_key" class="form-control" required>';
                            echo '</div>';
                            echo '<div class="text-center">';
                            echo '<button type="submit" name="retrieve_message" class="btn btn-primary">Retrieve Message</button>';
                            echo '<a href="index.html" class="btn btn-secondary ms-2">Home</a>';
                            echo '</div>';
                            echo '</form>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS (optional) -->
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
