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

  <!-- Overlapping Timetable Box -->
  <div class="timetable-overlap">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="timetable-box bg-light p-4 shadow text-center">
            <h4 class="mb-3">Prayer Timetable</h4>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Prayer</th>
                    <th>Start</th>
                    <th>Jama'at</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>FAJR</td>
                    <td>4:34 am</td>
                    <td>5:00 am</td>
                  </tr>
                  <tr>
                    <td>ZHUR</td>
                    <td>12:20 pm</td>
                    <td>1:00 pm</td>
                  </tr>
                  <tr>
                    <td>ASR</td>
                    <td>4:03 pm</td>
                    <td>4:45 pm</td>
                  </tr>
                  <tr>
                    <td>MAGRIB</td>
                    <td>6:00 pm</td>
                    <td>6:10 pm</td>
                  </tr>
                  <tr>
                    <td>ISHA</td>
                    <td>8:02 pm</td>
                    <td>8:10 pm</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <small class="text-muted">Times are based on local calculations.</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Main Content -->

<!-- New Bigger Div -->
<div class="container my-6 big-div">
  <h1>Welcome to our Mosque</h1>
  <p>Our community center and place of worship offers services and community programs. Join us for prayers, events, and more.</p>
</div>


<?php include 'includes/footer.php'; ?>
