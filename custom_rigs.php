<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Custom Rigs</title>
    <link rel="stylesheet" href="./styles/custom_rig.css" />
    
    <!-- Internal Styles for Enhanced Futuristic Design and Animations -->
    <style>
      /* Main Container */
      .customrig-main {
        background: linear-gradient(135deg, #0a0f1d, #1a237e);
        min-height: 100vh;
        padding: 40px;
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 40px;
        align-items: start;
        position: relative;
        overflow: hidden;
      }

      /* Remove animated background */
      .customrig-main::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(59, 130, 246, 0.1);
      }

      /* Build Image Section */
      .build_image {
        position: sticky;
        top: 40px;
        background: rgba(10, 15, 29, 0.8);
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        border: 2px solid rgba(59, 130, 246, 0.3);
        backdrop-filter: blur(10px);
        z-index: 1;
      }

      .build_image img {
        max-width: 100%;
        height: auto;
      }

      /* Build Inputs Section */
      .build_inputs {
        background: rgba(10, 15, 29, 0.8);
        border-radius: 20px;
        padding: 30px;
        border: 2px solid rgba(59, 130, 246, 0.3);
        backdrop-filter: blur(10px);
        z-index: 1;
      }

      /* Select Styling */
      select {
        width: 100%;
        padding: 15px 20px;
        margin-bottom: 20px;
        background: rgba(13, 17, 23, 0.95);
        border: 2px solid rgba(59, 130, 246, 0.3);
        border-radius: 10px;
        color: #fff;
        font-size: 1rem;
        cursor: pointer;
        -webkit-appearance: none;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%233b82f6%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E");
        background-repeat: no-repeat;
        background-position: right 15px top 50%;
        background-size: 12px auto;
      }

      /* Option Styling */
      select option {
        background: #0d1117;
        color: #fff;
        padding: 15px;
        font-size: 1rem;
      }

      /* Component Label Styling */
      .component-label {
        color: #3b82f6;
        font-size: 0.9rem;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.8;
      }

      /* Total Label */
      #total_label {
        display: block;
        font-size: 2rem;
        color: #3b82f6;
        text-align: center;
        margin: 30px 0;
        padding: 20px;
        background: rgba(59, 130, 246, 0.1);
        border-radius: 10px;
        border: 2px solid rgba(59, 130, 246, 0.3);
      }

      /* Button Container */
      .button-container {
        display: flex;
        gap: 20px;
        margin-top: 30px;
      }

      /* Button Styling */
      .button-inp {
        flex: 1;
        padding: 15px;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 2px;
      }

      /* Reset Button */
      button.button-inp {
        background: transparent;
        color: #ff4d4d;
        border: 2px solid #ff4d4d;
      }

      /* Submit Button */
      input[type="submit"].button-inp {
        background: #3b82f6;
        color: white;
        border: none;
      }

      /* Responsive Design */
      @media (max-width: 1024px) {
        .customrig-main {
          grid-template-columns: 1fr;
          padding: 20px;
        }

        .build_image {
          position: relative;
          top: 0;
        }
      }
    </style>
  </head>
  <body>
    <!-- header -->
    <?php 
      include 'navigation.php';
      include 'connect_database.php';//$database connection
      
      $total=0;
      $cabinet=$cpu=$gpu=$ram=$mb=$ssd=$hdd=$power_supply=$cpu_cooler="";

      if (isset($_POST['submit'])) // fetching values
      {
         if(!empty($_POST['cabinet']))
         {
           $cabinet=$_POST['cabinet'];
         }
         if(!empty($_POST['cpu']))
         {
           $cpu=$_POST['cpu'];
         }
         if(!empty($_POST['gpu']))
         {
           $gpu=$_POST['gpu'];
         }
         if(!empty($_POST['ram']))
         {
           $ram=$_POST['ram'];
         }
         if(!empty($_POST['mb']))
         {
           $mb=$_POST['mb'];
         }
         if(!empty($_POST['ssd']))
         {
           $ssd=$_POST['ssd'];
         }
         if(!empty($_POST['hdd']))
         {
           $hdd=$_POST['hdd'];
         }
         if(!empty($_POST['power_supply']))
         {
           $power_supply=$_POST['power_supply'];
         }
         if(!empty($_POST['cpu_cooler']))
         {
           $cpu_cooler=$_POST['cpu_cooler'];
         }
              
        //  setting $_SESSION['cabinet_price'] and $_SESSION['cabinet_full_name']
         $new1=(int)$cabinet;
         $_SESSION['cabinet_price']=$new1;
         $res1=mysqli_query($database, "select full_name from cabinet where price= $new1");
         $data1=mysqli_fetch_assoc($res1);
         $_SESSION['cabinet_full_name'] = $data1['full_name'];
         echo $_SESSION['cabinet_full_name'];
          
        //  setting $_SESSION['cpu_price'] and $_SESSION['cpu_full_name']
         $new2=(int)$cpu;
         $_SESSION['cpu_price']=$new2;
         $res2=mysqli_query($database, "select cpu_full_name from processor where price= $new2");
         $data2=mysqli_fetch_assoc($res2);
         $_SESSION['cpu_full_name'] = $data2['cpu_full_name'];
         
        //  setting $_SESSION['gpu_price'] and $_SESSION['gpu_full_name']
         $new3=(int)$gpu;
         $_SESSION['gpu_price']=$new3;
         $res3=mysqli_query($database, "select gpu_full_name from gpu where price= $new3");
         $data3=mysqli_fetch_assoc($res3);
         $_SESSION['gpu_full_name'] = $data3['gpu_full_name'];
         
        //  setting $_SESSION['ram_price'] and $_SESSION['ram_full_name']
         $new4=(int)$ram;
         $_SESSION['ram_price']=$new4;
         $res4=mysqli_query($database, "select ram_full_name from ram where price= $new4");
         $data4=mysqli_fetch_assoc($res4);
         $_SESSION['ram_full_name'] = $data4['ram_full_name'];
         
        //  setting $_SESSION['mb_price'] and $_SESSION['mb_full_name']
         $new5=(int)$mb;
         $_SESSION['mb_price']=$new5;
         $res5=mysqli_query($database, "select mb_full_name from motherboard where price= $new5");
         $data5=mysqli_fetch_assoc($res5);
         $_SESSION['mb_full_name'] = $data5['mb_full_name'];
         
        //  setting $_SESSION['ssd_price'] and $_SESSION['ssd_full_name']
         $new6=(int)$ssd;
         $_SESSION['ssd_price']=$new6;
         $res6=mysqli_query($database, "select ssd_full_name from ssd where price= $new6");
         $data6=mysqli_fetch_assoc($res6);
         $_SESSION['ssd_full_name'] = $data6['ssd_full_name'];
         
        //  setting $_SESSION['hdd_price'] and $_SESSION['hdd_full_name']
         $new7=(int)$hdd;
         $_SESSION['hdd_price']=$new7;
         $res7=mysqli_query($database, "select hdd_full_name from hdd where price= $new7");
         $data7=mysqli_fetch_assoc($res7);
         $_SESSION['hdd_full_name'] = $data7['hdd_full_name'];
         
        //  setting $_SESSION['power_supply_price'] and $_SESSION['power_supply_full_name']
         $new8=(int)$power_supply;
         $_SESSION['power_supply_price']=$new8;
         $res8=mysqli_query($database, "select ps_full_name from power_supply where price= $new8");
         $data8=mysqli_fetch_assoc($res8);
         $_SESSION['power_supply_full_name'] = $data8['ps_full_name'];
         
        //  setting $_SESSION['cpu_cooler_price'] and $_SESSION['cpu_cooler_full_name']
         $new9=(int)$cpu_cooler;
         $_SESSION['cpu_cooler_price']=$new9;
         $res9=mysqli_query($database, "select cooler_full_name from cpu_cooler where price= $new9");
         $data9=mysqli_fetch_assoc($res9);
         $_SESSION['cpu_cooler_full_name'] = $data9['cooler_full_name'];

        //  redirecting
         echo '<script>
                window.location.href = "cart.php";
              </script>';
        }
       

    ?>

    <!-- header end -->

    <!-- main content -->
    <div class="customrig-main">

      <div class="build_image"> <!-- cabinet images -->
        <img id='cabinet_image' src="images/placeholder-pc.png" alt="Please select a cabinet" style="width: 250px;">
      </div>

      <div class="build_inputs"> <!-- form inputs -->
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="component-group">
            <div class="component-label">Case</div>
            <select required name="cabinet" id="cabinet_select" onchange="input_entered(this.name);calc_total(this.value);display(this.text)">
              <option disabled selected value='0'>-- Select Your Cabinet --</option>
              <?php
                
                $res=mysqli_query($database, "select * from cabinet");
                while($data=mysqli_fetch_array($res))
                { 
                  echo "<option value='". $data['price'] ."'>" .$data['full_name'] ."</option>";
                  // echo "<option value='". $data['price'] ."'>" .$data['full_name'] ."</option>";
                  
                  
                }
              ?>
            </select>
          </div>
          
          <!-- PROCESSOR -->
          <div class="component-group">
            <div class="component-label">Processor</div>
            <select  name="cpu" id="cpu_select" onchange="input_entered(this.name);calc_total(this.value);"> 
              <option disabled selected value='0'>-- Select Your Processor --</option>
              <?php
                // $sql = "select company from cabinet where company='Corsair'";
                $res=mysqli_query($database, "select * from processor");
                while($data=mysqli_fetch_array($res))
                { 
                  echo "<option value='". $data['price'] ."'>" .$data['cpu_full_name'] ."</option>";
                  
                }
              ?>
            </select>
          </div>

          <!-- GPU -->
          <div class="component-group">
            <div class="component-label">Graphic Card</div>
            <select  name="gpu" id="gpu_select" onchange="input_entered(this.name);calc_total(this.value);">
              <option disabled selected value='0'>-- Select Your Graphic Card --</option>
              <?php
                // $sql = "select company from cabinet where company='Corsair'";
                $res=mysqli_query($database, "select * from gpu");
                while($data=mysqli_fetch_array($res))
                { 
                  echo "<option value='". $data['price'] ."'>" .$data['gpu_full_name'] ."</option>";
                  
                }
              ?>
            </select>
          </div>

          <!-- RAM -->
          <div class="component-group">
            <div class="component-label">RAM</div>
            <select  name="ram" id="ram_select" onchange="input_entered(this.name);calc_total(this.value);">
              <option disabled selected value='0'>-- Select Your RAM --</option>
              <?php
                // $sql = "select company from cabinet where company='Corsair'";
                $res=mysqli_query($database, "select * from ram");
                while($data=mysqli_fetch_array($res))
                { 
                  echo "<option value='". $data['price'] ."'>" .$data['ram_full_name'] ."</option>";
                  
                }
              ?>
            </select>
          </div>

          <!-- MOTHERBOARD -->
          <div class="component-group">
            <div class="component-label">Motherboard</div>
            <select  name="mb" id="mb_select" onchange="input_entered(this.name);calc_total(this.value);">
              <option disabled selected value='0'>-- Select Your Motherboard --</option>
              <?php
                // $sql = "select company from cabinet where company='Corsair'";
                $res=mysqli_query($database, "select * from motherboard");
                while($data=mysqli_fetch_array($res))
                { 
                  echo "<option value='". $data['price'] ."'>" .$data['mb_full_name'] ."</option>";
                  
                }
              ?>
            </select>
          </div>

          <!-- SSD -->
          <div class="component-group">
            <div class="component-label">SSD</div>
            <select  name="ssd" id="ssd_select" onchange="input_entered(this.name);calc_total(this.value);">
              <option disabled selected value='0'>-- Select Your SSD --</option>
              <?php
                // $sql = "select company from cabinet where company='Corsair'";
                $res=mysqli_query($database, "select * from ssd");
                while($data=mysqli_fetch_array($res))
                { 
                  echo "<option value='". $data['price'] ."'>" .$data['ssd_full_name'] ."</option>";
                  
                }
              ?>
            </select>
          </div>

          <!-- HDD -->
          <div class="component-group">
            <div class="component-label">HDD</div>
            <select  name="hdd" id="hdd_select" onchange="input_entered(this.name);calc_total(this.value);">
              <option disabled selected value='0'>-- Select Your HDD --</option>
              <?php
                // $sql = "select company from cabinet where company='Corsair'";
                $res=mysqli_query($database, "select * from hdd");
                while($data=mysqli_fetch_array($res))
                { 
                  echo "<option value='". $data['price'] ."'>" .$data['hdd_full_name'] ."</option>";
                  
                }
              ?>
            </select>
          </div>

          <!-- POWER SUPPLY -->
          <div class="component-group">
            <div class="component-label">Power Supply</div>
            <select  name="power_supply" id="psu_select" onchange="input_entered(this.name);calc_total(this.value);">
              <option disabled selected value='0'>-- Select Your Power Supply --</option>
              <?php
                // $sql = "select company from cabinet where company='Corsair'";
                $res=mysqli_query($database, "select * from power_supply");
                while($data=mysqli_fetch_array($res))
                { 
                  echo "<option value='". $data['price'] ."'>" .$data['ps_full_name'] ."</option>";
                  
                }
              ?>
            </select>
          </div>

          <!-- CPU COOLER -->
          <div class="component-group">
            <div class="component-label">CPU Cooler</div>
            <select  name="cpu_cooler" id="cpu_cooler_select" onchange="input_entered(this.name);calc_total(this.value);">
              <option disabled selected value='0'>-- Select Your CPU Cooler --</option>
              <?php
                // $sql = "select company from cabinet where company='Corsair'";
                $res=mysqli_query($database, "select * from cpu_cooler");
                while($data=mysqli_fetch_array($res))
                { 
                  echo "<option value='". $data['price'] ."'>" .$data['cooler_full_name'] ."</option>";
                  
                }
              ?>
            </select>
          </div>
          
          <div id="total_label">Total: ₹0</div>
          
          <div class="button-container">
            <button class="button-inp" onclick="reset_selection()">Reset Build</button>
            <input class="button-inp" type="submit" name="submit" value="Place Order" onclick="submit_redirect()">
          </div>
        </form>
      </div>
        
    </div>
    
    <!-- main content end -->
    
    <!-- footer -->
    <?php include 'footer.php' ?>

    <script src="./script/custom-rigs.js"></script>
    
    <!-- Add this JavaScript for enhanced interactions -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Keep empty for future functionality if needed
      });
    </script>
  </body>
</html>
