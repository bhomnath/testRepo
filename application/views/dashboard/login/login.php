<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Login - PU Syllabus - Bihani Tech</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url().'content/assets/css/bootstrap.css'; ?>" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url().'content/assets/font-awesome/css/font-awesome.css'; ?>" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url().'content/assets/css/style.css'; ?>" rel="stylesheet">
    <link href="<?php echo base_url().'content/assets/css/style-responsive.css'; ?>" rel="stylesheet">
<script>
   var baseUrl = '<?php echo base_url(); ?>';
</script>
    <style>
	.form_errors
	{
		color: #f44336;
		margin-top: 0px;
		padding-bottom: 15px;
		padding-left: 5px;
                color:red;
	}

	.invalid 
	{
		text-align:center;
		font-size:18px;
		padding-bottom:15px;
		color: #f44336;
	}
</style>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

	  <div id="login-page">
	  	<div class="container">
	  	
		      <?php echo form_open('login/validate', array('id' => '','class'=>'form-login', 'novalidate'=>'novalidate'));?>
		        <h2 class="form-login-heading">sign in now</h2>
		        <div class="login-wrap">
                            
            <input type="hidden" name="requersUrl" value="<?php echo $link; ?>"/>
                
                <div class="invalid">
							 <?php
            $flashMessage = $this->session->flashdata('flashMessage');
            if (!empty($flashMessage)) {               
                 echo $flashMessage;
            }          
            if (isset($error)) {
                echo $error;
            }
            ?>
						</div>
		            <input type="email" name="userEmail" value="" class="form-control" placeholder="User ID" autofocus required>
                            <?php echo form_error('userEmail'); ?>
		            <br>
		            <input type="password" name="userPass" value="" class="form-control" placeholder="Password" required>
		            <label class="checkbox">
		                <span class="pull-right">
		                    <a data-toggle="modal" href="login.html#myModal"> Forgot Password?</a>
		
		                </span>
		            </label>
		            <button class="btn btn-theme btn-block" type="submit"><i class="fa fa-lock"></i> SIGN IN</button>
		            
                            
		        </div>
		<?php echo form_close(); ?>
		          <!-- Modal -->
		          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
		             <?php echo form_open('login/email', array('id' => '','class'=>'form-signin', 'novalidate'=>'novalidate'));?>
                              <div class="modal-dialog">
		                  <div class="modal-content">
		                      <div class="modal-header">
		                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                          <h4 class="modal-title">Forgot Password ?</h4>
		                      </div>
		                      <div class="modal-body">
		                          <p>Enter your e-mail address below to reset your password.</p>
		                          <input type="email" name="emailId" id="emailId" required="required" placeholder="Your E-mail"  class="form-control placeholder-no-fix" autocomplete="off"/>
		
		                      </div>
		                      <div class="modal-footer">
		                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
		                          <button class="btn btn-theme" type="button">Submit</button>
		                      </div>
		                  </div>
		              </div>
                              <?php echo form_close(); ?>
		          </div>
		          <!-- modal -->
		
		      </form>	  	
	  	
	  	</div>
	  </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url().'content/assets/js/jquery.js'; ?>"></script>
    <script src="<?php echo base_url().'content/assets/js/bootstrap.min.js'; ?>"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="<?php echo base_url().'content/assets/js/jquery.backstretch.min.js'; ?>"></script>
    <script>
        $.backstretch("<?php echo base_url().'content/assets/img/login-bg.jpg'; ?>", {speed: 500});
    </script>


  </body>
</html>
