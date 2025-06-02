<?php
// donation.php
include 'includes/header.php';
include 'StripePayment.php';

$stripeSecretKey = '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';
$baseUrl = 'https://dmjmdundee.com';

$successUrl = $baseUrl . '/donation-success.php';
$cancelUrl = $baseUrl . '/donation.php';

$processor = new DonationProcessor($stripeSecretKey, $successUrl, $cancelUrl);

$checkoutSession = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = isset($_POST['donation_amount']) ? floatval($_POST['donation_amount']) : 0;

    if ($amount > 0) {
        try {
            $checkoutSession = $processor->createCheckoutSession($amount);
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    } else {
        $error = "Please enter a valid donation amount.";
    }
}
?>

<div class="container my-4 my-md-5">
  <h1 class="text-center mb-4">Support Our Mosque</h1>
  <p class="lead text-center mb-5">Your generous donations help us maintain our facilities and continue serving the community.</p>

  <!-- Stripe Donation Card -->
  <div class="card shadow-sm border-0 rounded-3 mb-5">
    <div class="card-header bg-success text-white text-center py-3">
      <h5 class="mb-0 fw-bold"><i class="bi bi-credit-card me-2"></i>Secure Online Donation</h5>
    </div>
    <div class="card-body p-3 p-md-4">

      <?php if ($error): ?>
        <div class="alert alert-danger mb-4"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <!-- Preset Amounts - Mobile First Design -->
      <div class="row g-2 mb-4">
        <?php foreach ([5, 10, 20, 50] as $preset): ?>
          <div class="col-6 col-md-3">
            <form method="post" class="h-100">
              <input type="hidden" name="donation_amount" value="<?= $preset ?>">
              <button type="submit" class="btn btn-outline-success w-100 h-100 py-3">
                <span class="d-block fw-bold fs-5">£<?= $preset ?></span>
                <span class="d-block small text-muted mt-1">Quick Donate</span>
              </button>
            </form>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Custom Amount Form -->
      <div class="bg-light p-3 rounded mb-4">
        <form method="post" id="donationForm">
          <div class="mb-3">
            <label class="form-label fw-bold">Enter Custom Amount (£)</label>
            <div class="input-group">
              <span class="input-group-text bg-white border-end-0"><i class="bi bi-currency-pound"></i></span>
              <input type="number" step="0.01" min="0.50" name="donation_amount"
                     class="form-control form-control-lg border-start-0 px-1"
                     placeholder="10.00" required
                     value="<?= isset($_POST['donation_amount']) ? htmlspecialchars($_POST['donation_amount']) : '' ?>">
            </div>
            <div class="form-text">Minimum donation: £0.50</div>
          </div>

          <!-- Mobile Optimized Submit Button -->
          <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
            <button type="submit" class="btn btn-success btn-lg w-100">
              <i class="bi bi-lock-fill me-2"></i>Donate Securely
            </button>
          </div>
        </form>
      </div>

      <!-- Info Message -->
      <div class="alert alert-info text-center small mt-3 mb-0" role="alert">
      <h6> Your donation is processed securely through <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/Stripe_Logo%2C_revised_2016.svg/2560px-Stripe_Logo%2C_revised_2016.svg.png" alt="Stripe Payments" height="40">. No storage of card details.
      </h6>
      </div>

    </div>
  </div>

  <!-- Bank Transfer Option -->
  <div class="card shadow border-0">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0"><i class="bi bi-bank me-2"></i>Bank Transfer</h4>
    </div>
    <div class="card-body">
      <p>Prefer bank transfer? Use these details:</p>

      <div class="table-responsive">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <th class="bg-light">Bank Name</th>
              <td>BANK OF SCOTLAND</td>
            </tr>
            <tr>
              <th class="bg-light">Account Name</th>
              <td>DUNDEE MUSLIM COMMUNITY TRUST</td>
            </tr>
            <tr>
              <th class="bg-light">Account Number</th>
              <td>27899669</td>
            </tr>
            <tr>
              <th class="bg-light">Sort Code</th>
              <td>80-22-60</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="alert alert-info mt-3">
        <i class="bi bi-info-circle me-2"></i>Please include your name in the transfer reference
      </div>
    </div>
  </div>
</div>

<?php if ($checkoutSession): ?>
  <script src="https://js.stripe.com/v3/"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var stripe = Stripe('pk_live_51RRfOOFlnk9NHsaiWEA0OU6bESsf5WWKFM7FAacyHxAc2dXbFT2IiXuR3jEgTWUkflwPD5x3PD95EBfAfol8KtCb005BwSG78M');

      stripe.redirectToCheckout({
        sessionId: '<?= $checkoutSession->id ?>'
      }).then(function(result) {
        if (result.error) {
          alert('Payment Error: ' + result.error.message);
        }
      });
    });
  </script>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
