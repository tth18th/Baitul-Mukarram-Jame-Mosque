<?php
require_once 'donation.php';

// Configure these constants
const STRIPE_SECRET_KEY = 'sk_test_51RRfOOFlnk9NHsaiMDht9ilwE2DssGZVH45a5FGreu25edWvmGh6Bcd0NM3KrPWbNRV2w2JaZWRVLoRJ2ISwHsML00nuJLjBBB';
const STRIPE_PUBLIC_KEY = 'pk_test_51RRfOOFlnk9NHsaiVZ4V1hMcaQ0GcFxjQZecrJR54Puyv8jqhswr8XD74aNDyb5Xrj56gxX08DOCK55p48RjWWvn00ptFvXwtw';

header('Content-Type: application/json');

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $amount = filter_var($input['amount'], FILTER_VALIDATE_FLOAT);
    $email = filter_var($input['email'], FILTER_VALIDATE_EMAIL);

    if (!$amount || $amount < 1) {
        throw new Exception('Invalid amount');
    }

    $donation = new Donation(STRIPE_SECRET_KEY);
    $sessionId = $donation->createCheckoutSession($amount, $email);

    if ($sessionId) {
        echo json_encode(['id' => $sessionId]);
    } else {
        throw new Exception('Failed to create session');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
