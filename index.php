<?php
    include "includes/guest.php";
    require_once "helpers/db.php";
?>

<!-- Hero Section with Animated Background -->
<section id="hero" class="position-relative overflow-hidden w-100">
    <canvas id="spiderCanvas" class="position-absolute top-0 start-0 w-100 h-100"></canvas>
    
    <div class="container text-center py-5 position-relative" style="z-index: 2;">
        <h1 class="fw-bold text-light">Welcome to b25studio</h1>
        <p class="text-white">Professional photography, videography, and editing services.</p>
        <h5 class="text-white">We capture Your moments</h5>
        <a href="../auth/" class="btn btn-outline-light mt-3">Get started</a>
    </div>
</section>

<!-- SERVICES SECTION -->
<section id="services" class="py-5 bg-light">
  <div class="container text-center mb-4">
    <h2 class="fw-bold">Our Services</h2>
  </div>

  <div class="container">
    <div class="row g-4 justify-content-center">
      <!-- Service Card 1 -->
      <div class="col-12 col-md-4">
        <div class="card h-100 border-0 shadow">
          <div class="card-img-top" style="background-image: url('assets/images/photography.jpg'); background-size: cover; background-position: center; height: 200px;">
            <div class="h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50">
              <h5 class="text-white fw-bold">Photo Shooting</h5>
            </div>
          </div>
          <div class="card-body text-center">
            <p>High-quality photography for events, products, and personal sessions.</p>
          </div>
        </div>
      </div>

      <!-- Service Card 2 -->
      <div class="col-12 col-md-4">
        <div class="card h-100 border-0 shadow">
          <div class="card-img-top" style="background-image: url('../assets/images/videography.jpg'); background-size: cover; background-position: center; height: 200px;">
            <div class="h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50">
              <h5 class="text-white fw-bold">Video shooting</h5>
            </div>
          </div>
          <div class="card-body text-center">
            <p>Professional video shooting for weddings, ads, music, and more.</p>
          </div>
        </div>
      </div>

      <!-- Service Card 3 -->
      <div class="col-12 col-md-4">
        <div class="card h-100 border-0 shadow">
          <div class="card-img-top" style="background-image: url('../assets/images/editing.jpg'); background-size: cover; background-position: center; height: 200px;">
            <div class="h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50">
              <h5 class="text-white fw-bold">Editing</h5>
            </div>
          </div>
          <div class="card-body text-center">
            <p>Professional video and photo editing using adobe</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

    <!-- CTA SECTION -->
    <div class="text-center">
        <a href="portfolio" class="btn btn-outline-secondary btn-lg me-3">View Portfolio</a>
        <a href="contact" class="btn btn-outline-secondary btn-lg">Contact Us</a> 
    </div>
<?php
    include "includes/footer.php";
?>
