<?php include 'includes/header.php'; ?>

<link rel="stylesheet" href="css/news.css">
<div class="news-page">
  <div class="news-header">
    <h1>Community News</h1>
    <p>Stay updated with the latest news, events, and announcements from our mosque community</p>
  </div>

  <div class="container-fluid px-0"> <!-- Full width container -->
    <div class="row justify-content-center">
      <div class="col-12"> <!-- Full width column -->
        <div class="fb-card">
          <div class="card-header">
            <div class="card-header-content">
              <div class="logo-container">
                <img src="images/logo.png" alt="Mosque Logo">
              </div>
              <h2>Follow Our Community</h2>
              <p>Stay connected for news, events, and inspiration</p>
            </div>
          </div>
          
          <div class="card-body">
            <div class="fb-embed-container">
              <!-- Loading state -->
              <div class="fb-placeholder" id="fbLoading">
                <div class="loading-spinner"></div>
                <p>Loading Facebook feed...</p>
              </div>
              
              <!-- Facebook feed container -->
              <div class="fb-page-wrapper">
                <div class="fb-page" 
                  data-href="https://www.facebook.com/dmjmdundee"  
                  data-tabs="timeline"
                  data-height="700"
                  data-width="1000"
                  data-small-header="false"
                  data-adapt-container-width="true"
                  data-hide-cover="false"
                  data-show-facepile="true"
                  style="display: none;">
                  <blockquote cite="https://www.facebook.com/dmjmdundee" class="fb-xfbml-parse-ignore">
                    <a href="https://www.facebook.com/dmjmdundee">Our Mosque Facebook Page</a>
                  </blockquote>
                </div>
              </div>
            </div>
          </div>
          
          <div class="card-footer">
            <a href="https://www.facebook.com/dmjmdundee" target="_blank" rel="noopener" class="fb-btn">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path d="M22.675 0h-21.35C.595 0 0 .592 0 1.326v21.348C0 23.408.595 24 1.325 24h11.495v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.797.143v3.24l-1.918.001c-1.504 0-1.797.715-1.797 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116C23.406 24 24 23.408 24 22.674V1.326C24 .592 23.406 0 22.675 0"/>
              </svg>
              Like & Follow Us
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v19.0" nonce="fbplugin"></script>
<script>
// Facebook SDK initialization
document.addEventListener('DOMContentLoaded', function() {
  // Show loading state initially
  const loadingElement = document.getElementById('fbLoading');
  const fbElement = document.querySelector('.fb-page');
  
  // Function to check if Facebook SDK is loaded
  function checkFacebookSDK() {
    if (typeof FB !== 'undefined') {
      // SDK is loaded, hide loading and show feed
      if (loadingElement) loadingElement.style.display = 'none';
      if (fbElement) {
        fbElement.style.display = 'block';
        FB.XFBML.parse(); // Re-parse the Facebook widget
      }
    } else {
      // SDK not loaded yet, check again
      setTimeout(checkFacebookSDK, 100);
    }
  }
  
  // Start checking for Facebook SDK
  setTimeout(checkFacebookSDK, 1000);
  
  // Also set a timeout as fallback
  setTimeout(function() {
    if (loadingElement) loadingElement.style.display = 'none';
    if (fbElement) fbElement.style.display = 'block';
    
    // Re-parse the Facebook widget after making it visible if SDK is available
    if (typeof FB !== 'undefined') {
      FB.XFBML.parse();
    }
  }, 3000);
  
  // Card hover animations
  const cards = document.querySelectorAll('.fb-card');
  cards.forEach(card => {
    card.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-10px)';
      this.style.boxShadow = '0 30px 60px -15px rgba(0, 0, 0, 0.15)';
    });
    
    card.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
      this.style.boxShadow = '0 25px 50px -12px rgba(0, 0, 0, 0.1)';
    });
  });
  
  // Button hover effects
  const buttons = document.querySelectorAll('.fb-btn');
  buttons.forEach(button => {
    button.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-3px)';
    });
    
    button.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
    });
  });
});
</script>

<?php include 'includes/footer.php'; ?>