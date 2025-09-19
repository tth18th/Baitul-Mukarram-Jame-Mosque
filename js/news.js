// Facebook SDK initialization and loading state
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