       <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
        <section id="main-content">
          <section class="wrapper site-min-height">
                    <div class="row">
                    <div class="col-lg-12">
                                    <h3>User Profile</h3>
                            </div>
                    </div>
                          <hr />
                       

                    <div class="row">
                        <?php if(!empty($userInfo)){
     foreach ($userInfo as $userDet){
         $id = $userDet->id;
                 $firstName = $userDet->first_name;
                $lastName = $userDet->last_name;
                $email = $userDet->user_email;
               
                $userType = $userDet->user_type;
               
                
     }?>
                        <div class="col-lg-12">
                            <div class="box">
                                <div class="panel panel-info" style="border-radius: 0px;margin-bottom: 0px;">
            <div class="panel-heading" style="border-radius: 0px;">
              <h3 class="panel-title"><?php echo $firstName. ' ' .$lastName; ?></h3>
            </div>
            <div class="panel-body">
              <div class="row">
                  <div class="col-md-3 col-lg-3 " align="center"> <i class="icon-user icon-5x"></i> </div>
                
                <!--<div class="col-xs-10 col-sm-10 hidden-md hidden-lg"> <br>
                  <dl>
                    <dt>DEPARTMENT:</dt>
                    <dd>Administrator</dd>
                    <dt>HIRE DATE</dt>
                    <dd>11/12/2013</dd>
                    <dt>DATE OF BIRTH</dt>
                       <dd>11/12/2013</dd>
                    <dt>GENDER</dt>
                    <dd>Male</dd>
                  </dl>
                </div>-->
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Email</td>
                        <td><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></td>
                      </tr>
                      
                      
                                           
                     
                    </tbody>
                  </table>
                  
                  <a href="<?php echo base_url().'user/changePassword'; ?>" class="btn btn-primary">Change Password</a>
                  <a href="<?php echo base_url().'user/editUser/'.$id; ?>" class="btn btn-primary">Edit Info</a>
                </div>
              </div>
            </div>
                 
            
          </div>
                                
                            </div>
                        </div>
                        <?php }else{
                        $this->load->view('dashboard/template/errorPage');    
                        } ?>
                    </div>
                                       
                   
                     

                   </section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->