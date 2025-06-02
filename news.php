<?php include 'includes/header.php'; ?>
<div class="container my-5">
  <h1>News</h1>
  <!-- <p>Stay updated with the latest news and community announcements.</p> -->

  <!-- Facebook Page Feed Embed -->
  <div class="row justify-content-center mt-5">
    <div class="col-lg-10 col-xl-8">
      <div class="card shadow border-0 rounded-4 overflow-hidden" style="background: linear-gradient(120deg, #f8fafc 60%, #e0e7ff 100%);">
        <div class="card-header text-center py-4 border-0" style="background: transparent;">
          <div class="d-flex flex-column align-items-center">
            <img src="images/logo.png" alt="Mosque Logo" style="height:60px;width:auto;" class="mb-2">
            <h2 class="mb-1" style="font-size:2.1rem; letter-spacing:1px; font-weight:700; color:#007bff;">Follow Our Community</h2>
            <p class="mb-0" style="font-size:1.1rem; font-weight:400; color:#333; opacity:0.85;">Stay connected for news, events, and inspiration</p>
          </div>
        </div>        
        <div class="card-body d-flex justify-content-center align-items-center p-0" style="min-height:650px; background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%);">
          <div style="min-width: 750px; text-align: center;">
            <div class="fb-page"
              data-href="https://www.facebook.com/dmjmdundee"
              data-tabs="timeline"
              data-height="600"
              data-width="750"
              data-small-header="false"
              data-adapt-container-width="true"
              data-hide-cover="false"
              data-show-facepile="true">
              <blockquote cite="https://www.facebook.com/dmjmdundee" class="fb-xfbml-parse-ignore">
                <a href="https://www.facebook.com/dmjmdundee">Our Mosque Facebook Page</a>
              </blockquote>
            </div>
          </div>
        </div>
        <div class="card-footer bg-white text-center py-4 border-0">
          <a href="https://www.facebook.com/dmjmdundee" target="_blank" rel="noopener" class="btn btn-outline-primary btn-lg rounded-pill px-5 shadow-sm" style="font-weight:600; letter-spacing:0.5px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#1877f3" class="me-2" viewBox="0 0 24 24"><path d="M22.675 0h-21.35C.595 0 0 .592 0 1.326v21.348C0 23.408.595 24 1.325 24h11.495v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.797.143v3.24l-1.918.001c-1.504 0-1.797.715-1.797 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116C23.406 24 24 23.408 24 22.674V1.326C24 .592 23.406 0 22.675 0"/></svg>
            Like & Follow Us
          </a>
        </div>
      </div>
    </div>
  </div>
  <div id="fb-root"></div>
  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v19.0" nonce="fbplugin"></script>
</div>
<?php include 'includes/footer.php'; ?>
