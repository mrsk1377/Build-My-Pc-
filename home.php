<?php
// Start session at the very top of the file
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home Page</title>

    <!-- fonts -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="./styles/home.css" />

    <!-- Internal Animation Styles -->
    <style>
      /* Container Layout */
      .build-sections-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        padding: 60px;
        background: linear-gradient(135deg, #0f1923, #1f2937);
        min-height: 80vh;
      }

      /* Section Styling */
      .build-section {
        background: rgba(255, 255, 255, 0.03);
        border-radius: 15px;
        padding: 40px;
        position: relative;
        overflow: hidden;
      }

      /* Section Headers */
      .section-header {
        text-align: left;
        color: white;
        padding: 30px;
        background: rgba(0, 0, 0, 0.5);
      }

      .section-title {
        font-size: 2.8rem;
        margin-bottom: 10px;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 800;
      }

      .section-subtitle {
        color: #64748b;
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
      }

      /* Card Styling */
      .pc-card {
        background: transparent;
        overflow: hidden;
      }

      /* Image Container */
      .pc-image {
        position: relative;
        height: 400px;
        overflow: hidden;
      }

      .pc-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }

      /* Price Tag */
      .price-tag {
        position: absolute;
        top: 20px;
        right: -40px;
        background: #ff4d4d;
        color: white;
        padding: 10px 50px;
        font-weight: bold;
        font-size: 1.1rem;
        z-index: 2;
      }

      /* Content Styling */
      .pc-details {
        padding: 30px;
        color: white;
        background: rgba(0, 0, 0, 0.7);
      }

      .pc-details h3 {
        font-size: 2rem;
        margin-bottom: 20px;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 1px;
      }

      /* Specs List */
      .specs-list {
        list-style: none;
        padding: 0;
        margin: 25px 0;
      }

      .specs-list li {
        margin: 15px 0;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 15px;
        color: #a3a3a3;
      }

      .specs-list i {
        color: #3b82f6;
        font-size: 1.3rem;
      }

      /* Button Styling */
      .action-btn {
        display: inline-block;
        width: 100%;
        padding: 18px;
        background: #3b82f6;
        color: white;
        text-decoration: none;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: bold;
        font-size: 1rem;
      }

      /* Section Specific Styling */
      .prebuilt-side {
        border: 2px solid #3b82f6;
      }

      .custom-side {
        border: 2px solid #ff4d4d;
      }

      /* Responsive Design */
      @media (max-width: 1200px) {
        .build-sections-container {
          padding: 30px;
          gap: 30px;
        }

        .section-title {
          font-size: 2.2rem;
        }
      }

      @media (max-width: 968px) {
        .build-sections-container {
          grid-template-columns: 1fr;
          padding: 20px;
        }

        .pc-image {
          height: 300px;
        }
      }
    </style>
  </head>
  <body>
    <!-- header -->
    <?php include 'navigation.php' ?>
    

    <!-- sliding images -->
    <div class="slidershow-middle">
      <div class="slides">
        <input type="radio" name="r" id="r1" checked />
        <input type="radio" name="r" id="r2" />
        <input type="radio" name="r" id="r3" />
        <input type="radio" name="r" id="r4" />
        <input type="radio" name="r" id="r5" />
        <div class="slide s1">
          <img src="images/sliding_home/ElementCL-Pro-Apr2021-TV.webp" alt="" />
        </div>
        <div class="slide">
          <img src="images/sliding_home/iBP-PoweredByASUS-TV.webp" alt="" />
        </div>
        <div class="slide">
          <img src="images/sliding_home/Intel-11thGen-TV.webp" alt="" />
        </div>
        <div class="slide">
          <img src="images/sliding_home/Nvidia-30Series-TV.webp" alt="" />
        </div>
        <div class="slide">
          <img src="images/sliding_home/NVIDIA-Guardians-TV-Wall.webp" alt="" />
        </div>
      </div>

      <div class="navigation">
        <label
          for="r1"
          class="bar"
          id="bar1"
          onclick="change_counter(1)"
        ></label>
        <label
          for="r2"
          class="bar"
          id="bar2"
          onclick="change_counter(2)"
        ></label>
        <label
          for="r3"
          class="bar"
          id="bar3"
          onclick="change_counter(3)"
        ></label>
        <label
          for="r4"
          class="bar"
          id="bar4"
          onclick="change_counter(4)"
        ></label>
        <label
          for="r5"
          class="bar"
          id="bar5"
          onclick="change_counter(5)"
        ></label>
      </div>
    </div>

    <!-- main section -->
    <div class="main-content">
      <div class="build-sections-container">
        <!-- Pre-built Section -->
        <section class="build-section prebuilt-side">
          <div class="section-header">
            <h2 class="section-title">PRE-BUILT PCS</h2>
            <p class="section-subtitle">Ready to Game</p>
          </div>
          
          <div class="pc-showcase">
            <div class="pc-card">
              <div class="pc-image">
                <img src="images/s5-a01-01-multi-prebuilt-systems-rwd.jpg.rendition.intel.web.480.270.jpg" alt="Gaming PC">
                <div class="price-tag">₹59,999</div>
              </div>
              <div class="pc-details">
                <h3>Pro Gaming PC</h3>
                <ul class="specs-list">
                  <li><i class="fas fa-microchip"></i> RTX 3060</li>
                  <li><i class="fas fa-memory"></i> 16GB RAM</li>
                  <li><i class="fas fa-hdd"></i> 1TB SSD</li>
                </ul>
                <a href="prebuilt.php" class="action-btn">View Pre-built PCs</a>
              </div>
            </div>
          </div>
        </section>

        <!-- Custom Build Section -->
        <section class="build-section custom-side">
          <div class="section-header">
            <h2 class="section-title">CUSTOM BUILD</h2>
            <p class="section-subtitle">Design Your Dream PC</p>
          </div>
          
          <div class="pc-showcase">
            <div class="pc-card">
              <div class="pc-image">
                <img src="images/1658962667-why-buy-a-custom-bld-primary.png" alt="Custom PC">
                <div class="price-tag">From ₹30,000</div>
              </div>
              <div class="pc-details">
                <h3>Custom Gaming PC</h3>
                <ul class="specs-list">
                  <li><i class="fas fa-tools"></i> Full Customization</li>
                  <li><i class="fas fa-cog"></i> Choose Components</li>
                  <li><i class="fas fa-paint-brush"></i> RGB Options</li>
                </ul>
                <a href="custom_rigs.php" class="action-btn">Start Building</a>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>

    <!-- footer -->
    <?php include 'footer.php' ?>
    

    <script src="script/homepage.js"></script>
  </body>
</html>

