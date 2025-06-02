<?php include 'includes/header.php'; ?>

<!-- Banner Carousel -->
<div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel" style="position: relative;">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/banner1.jpg" class="d-block w-100" alt="News 1">
      <div class="carousel-caption d-none d-md-block">
        <h5>Community News 1</h5>
        <p>Latest community updates and notices.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/banner2.jpg" class="d-block w-100" alt="News 2">
      <div class="carousel-caption d-none d-md-block">
        <h5>Community News 2</h5>
        <p>Important announcement for upcoming events.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/banner3.jpg" class="d-block w-100" alt="News 3">
      <div class="carousel-caption d-none d-md-block">
        <h5>Community News 3</h5>
        <p>Join us for community prayers and gatherings.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
  <?php
   include_once("js/script.php");
   $t = new PrayerTimeTable();
   $ttbl = $t->dynamicTimetable();
 ?>
  
<!-- Welcome Section -->
<div class="container my-6 big-div text-center">
  <h1>Welcome to our Mosque</h1>
  <p>Our community center and place of worship offers services and community programs. Join us for prayers, events, and more.</p>
</div>



<!-- Social Media Links -->
<div class="container text-center my-6">
  <h2>Follow Us</h2>
  <p>Stay connected through our social media channels.</p>
  <div class="d-flex justify-content-center flex-wrap gap-3 mt-3">
    <a href="https://www.facebook.com/dmjmdundee" class="social-btn facebook" target="_blank">
      <i class="fa-brands fa-facebook-f"></i> Facebook
    </a>
    <a href="https://www.instagram.com/bmjmdundee/" class="social-btn instagram" target="_blank">
      <i class="fa-brands fa-instagram"></i> Instagram
    </a>
    <a href="https://www.threads.net/@bmjmdundee" class="social-btn threads" target="_blank">
      <i class="fa-brands fa-threads"></i> Threads
    </a>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
