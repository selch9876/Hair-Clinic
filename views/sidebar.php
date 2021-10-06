<?php include "../netting/connection.php"; ?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="../dist/img/beyaz-logo-2.png" alt="Hair Clinic Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Hair Clinic</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <!--<img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">-->
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['admin_name']; ?></a>
        </div>
      </div>

      

      <!-- Sidebar Menu -->
      <nav class="mt-2" id="nav-link">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

              <?php
                            //menu.php
              foreach($pages as $url=>$title){ ?>
              
                <li class="nav-item">
                    <a <?php if($url === $page){?>class="nav-link active"<?php } ?> href="<?php echo $url;?>" id="nav-link">
                      <p>
                        <?php echo $title;?>
                      </p>
                    </a>
                </li>

              <?php } ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    <script>
      $(function(){
    var current = location.pathname;
    $('#nav-link li a').each(function(){
        var $this = $(this);
        // if the current path is like this link, make it active
        if($this.attr('href').indexOf(current) !== -1){
            $this.addClass('nav-link active');
        }
    })
}) 
    </script>
  </aside>