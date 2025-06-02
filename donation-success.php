<?php
// donation-success.php
include 'includes/header.php';
include 'StripePayment.php';

$stripeSecretKey = 'sk_test_51RRfOOFlnk9NHsaiMDht9ilwE2DssGZVH45a5FGreu25edWvmGh6Bcd0NM3KrPWbNRV2w2JaZWRVLoRJ2ISwHsML00nuJLjBBB';
$processor = new DonationProcessor($stripeSecretKey, '', '');

$paymentSuccess = false;
$paymentDetails = [];

try {
    if (isset($_GET['session_id'])) {
        $session = \Stripe\Checkout\Session::retrieve($_GET['session_id']);

        if ($session->payment_status === 'paid') {
            $paymentSuccess = true;
            $paymentDetails = [
                'amount' => $session->amount_total / 100,
                'currency' => strtoupper($session->currency)
            ];
        }
    }
} catch (Exception $e) {
    // Handle error
}
?>

<div class="container my-5 text-center">
  <?php if ($paymentSuccess): ?>
    <div class="card border-success shadow-sm mx-auto" style="max-width: 500px;">
      <div class="card-header bg-success text-white py-4">
        <i class="bi bi-check-circle display-4"></i>
        <h2 class="mt-3 mb-0">Donation Successful!</h2>
      </div>
      <div class="card-body p-4">
        <p class="lead">Thank you for your generous support!</p>
        <div class="alert alert-light">
          <p class="mb-1">Amount: <strong>£<?= number_format($paymentDetails['amount'], 2) ?></strong></p>
          <p class="mb-0">Transaction ID: <code><?= htmlspecialchars($_GET['session_id']) ?></code></p>
        </div>
        <p>A receipt has been sent to your email address.</p>
        <a href="donation.php" class="btn btn-outline-success mt-3">
          <i class="bi bi-arrow-left me-2"></i>Back to Donation Page
        </a>
      </div>
    </div>
  <?php else: ?>
    <div class="card border-danger shadow-sm mx-auto" style="max-width: 500px;">
      <div class="card-header bg-danger text-white py-4">
        <i class="bi bi-exclamation-circle display-4"></i>
        <h2 class="mt-3 mb-0">Payment Processing</h2>
      </div>
      <div class="card-body p-4">
        <p class="lead">Your donation is still being processed.</p>
        <p>Please check your email for payment confirmation or try again later.</p>
        <a href="donation.php" class="btn btn-danger mt-3">
          <i class="bi bi-credit-card me-2"></i>Try Again
        </a>
      </div>
    </div>
  <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
