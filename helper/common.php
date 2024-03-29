<?php
// Encryption and Decryption Functions (Using OpenSSL)
function encryptMessage($message, $key) {
    return openssl_encrypt($message, 'aes-256-cbc', $key, 0, substr($key, 0, 16));
}

function decryptMessage($encryptedMessage, $key) {
    return openssl_decrypt($encryptedMessage, 'aes-256-cbc', $key, 0, substr($key, 0, 16));
}
// Update message status to mark it as read
function markMessageAsRead($messageId) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE messages SET read_status = '1' WHERE id = ?");
    $stmt->execute([$messageId]);
}
?>