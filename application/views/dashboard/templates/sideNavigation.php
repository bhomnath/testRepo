<script>
    $(document).ready(function(){
       var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
     $('#sidebar ul#nav-accordion li a').each(function() {
      if (this.href === path) {
       $(this).addClass('active');
      }
      });
      
      $('#sidebar ul#nav-accordion li ul.sub li a').each(function() {
      if (this.href === path) {
       $(this).parent('li').addClass('active');
        $(this).removeClass('active');
       $(this).parent('li').parent('ul').parent('li').children('a').addClass('active');
      }
     });
   
    
});

//var ele = localStorage.getItem('active');
//$('#sidebar ul#nav-accordion:eq(' + ele + ')').find('a').addClass('active'); 
//$('#sidebar ul#nav-accordion li a').removeClass('active');
//    var $this = $(this);
//    $this.addClass('active');
</script>
<!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              	
                  <li class="mt">
                      <a href="<?php echo base_url().'dashboard'; ?>">
                          <i class="fa fa-dashboard"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>

                  <li class="sub-menu">
                      <a class="" href="javascript:;" >
                          <i class="fa fa-desktop"></i>
                          <span>Faculty</span>
                      </a>
                      <ul class="sub">
                          <li><a href="<?php echo base_url().'faculty/view'; ?>">Faculties</a></li>
                          <li><a href="<?php echo base_url().'faculty/addNew'; ?>">Add New</a></li>
                      </ul>
                  </li>

                  <li class="sub-menu">
                      <a class="" href="javascript:;" >
                          <i class="fa fa-book"></i>
                          <span>Program</span>
                      </a>
                      <ul class="sub">
                          
                          <li><a href="<?php echo base_url().'program/view'; ?>">Program</a></li>
                          <li><a href="<?php echo base_url().'program/addNew'; ?>">Add New</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a class="" href="javascript:;" >
                          <i class="fa fa-tasks"></i>
                          <span>Subject &amp; Syllabus</span>
                      </a>
                      <ul class="sub">
                          <li><a href="<?php echo base_url().'subjectSyllabus/index'; ?>">Subject &amp; Syllabus</a></li>
                          <li class=""><a href="<?php echo base_url().'subjectSyllabus/addNew'; ?>">Add New</a></li>
                      </ul>
                  </li>
                 
                  <li class="sub-menu">
                      <a class="" href="javascript:;" >
                          <i class="fa fa-bar-chart-o"></i>
                          <span>Users</span>
                      </a>
                      <ul class="sub">
                          <li><a href="<?php echo base_url().'user/view'; ?>">Users</a></li>
                          <li><a href="<?php echo base_url().'user/addNew'; ?>">Add New</a></li>
                          
                      </ul>
                  </li>

              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->