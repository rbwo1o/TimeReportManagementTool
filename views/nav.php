<!-- Navigation -->
<nav class = "navbar navbar-expand-lg navbar-dark sticky-top">
  <a class = "navbar-brand animate__animated animate__fadeInLeft" href = "/"><i class="fas fa-cubes"></i> <?php 
  
  if($_SESSION['access_level'] == 1) {
    echo $_SESSION['name'] . "'s Timeline";
  }
  else if($_SESSION['access_level'] == 2){
    echo $_SESSION['name'] . " (Admin)";
  }
  else{
    echo $_SESSION['name'] . " (Super)";
  }
  
  ?></a>
  <button class = "navbar-toggler animate__animated animate__fadeInDown" data-toggle = "collapse" data-target = ".collapseALL">
    <i class="fas fa-bars"></i>
  </button>

  <div class = "collapse navbar-collapse collapseALL">
    <ul class = "navbar-nav ml-auto">

    <?php 
    
        if($_SESSION['access_level'] == 2 || $_SESSION['access_level'] == 3){

            echo "<li class=\"nav-item dropdown\">
            <a href class=\"nav-link dropdown-toggle\" data-toggle=\"collapse\" data-toggle=\"collapse\" data-target=\".collapseADMIN\">Admin</a>
            <div>
              <div class=\"dropdown-menu collapse collapseADMIN\">
                <a class=\"dropdown-item\" href=\"/report\">Report <i class=\"fas fa-chart-line\"></i></a>
                <div class=\"dropdown-divider\"></div>
                <a id = \"cpp\" class=\"dropdown-item drop-link\" href=\"/report_history\">Report History <i class=\"fas fa-history\"></i></a>
                <a id = \"python\" class=\"dropdown-item drop-link\" href=\"/user_accounts\">User Accounts <i class=\"fas fa-users\"></i></a>
              </div>
            </div>
          </li>";


        }
    
        
        if($_SESSION['access_level'] == 1 || $_SESSION['access_level'] == 3){
            echo "<li class = \"nav-item\" href = \"#\">
            <div class = \"colorContainer\">
              <a class = \"nav-link\" href = \"/current_timesheet\">Current Time Sheet <i class=\"fas fa-table\"></i>
              </a>
            </div>
          </li>";
            
          echo "<li class = \"nav-item\" href = \"#\">
            <div class = \"colorContainer\">
              <a class = \"nav-link\" href = \"/history\">History <i class=\"fas fa-history\"></i>
              </a>
            </div>
          </li>";
        }
    
    ?>

      <li class = "nav-item" href = "#">
        <div class = "colorContainer">
          <a href = "/settings" class = "nav-link">Settings <i class="fas fa-cog"></i>
        </a>
      </div>
      </li>

      <li class = "nav-item" href = "#">
        <div class = "colorContainer">
          <a href = "/logout" class = "nav-link">Log Out <i class="fas fa-sign-out-alt"></i>
        </a>
      </div>
      </li>

    </ul>
  </div>
</nav>
<!-- Navigation End -->

<center>
        <img id = "logo" alt = "HG_logo" src = "https://d2q79iu7y748jz.cloudfront.net/s/_logo/634630f90ae7d2470e042cbb47e2393b" style = "margin: 2%;">
</center>