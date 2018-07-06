     <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
        <section id="main-content">
          <section class="wrapper site-min-height">
        <div class="row">
            <div class="col-lg-12">
                <h3>Edit User </h3>
            </div>
        </div>
        <hr />


        <div class="row">
            <?php
            if (!empty($userInfo)) {
                foreach ($userInfo as $userDet) {
                    $id = $userDet->id;
                  
                    $firstname = $userDet->first_name;
                     $lastname = $userDet->last_name;
                     $email = $userDet->user_email;                    
                    $userType = $userDet->user_type;
                }
              
                ?>
                <div class="col-lg-12">
                    <div class="box">
                        <div style="color: red;float: left;width: 97%;margin: 10px auto 0 15px;">

                            <?php
                            if ($this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                            }

                            if (isset($error)) {
                                echo $error;
                            }
                            ?> 


                        </div>   
                        <div class="accordion-body collapse in body">
    <?php echo form_open('user/updateUserInfo', array('id' => 'inline-validate', 'class' => 'form-horizontal', 'novalidate' => 'novalidate')); ?>
                            <input type="hidden" name="id" value="<?php echo $id; ?>" >
                            <div class="form-group">
                                <label class="control-label col-lg-3">First Name</label>

                                <div class="col-lg-8">
                                    <input type="text" id="firstname" name="firstname" class="form-control col-lg-6" value="<?php echo $firstname; ?>" />
    <?php echo form_error('firstname'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3">Last Name</label>

                                <div class="col-lg-8">
                                    <input type="text" id="lastname" name="lastname" class="form-control col-lg-6" value="<?php echo $lastname; ?>"/>
    <?php echo form_error('lastname'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-3">E-mail</label>

                                <div class="col-lg-8">
                                    <input type="email" id="email" name="email" class="form-control col-lg-6" value="<?php echo $email; ?>"/>
    <?php echo form_error('email'); ?>
                                </div>
                            </div>
                            
                        
                           
                            <div class="form-actions" style="text-align:center">
                                <input type="submit" value="Update User Info" class="btn btn-primary btn-lg" />
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
<?php
} else {
    $this->load->view('dashboard/template/errorPage');
}
?>
        </div>

 </section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
<!--END MAIN WRAPPER -->
<script>
    $(function (){ //document is loaded so we can bind events

  $("#district").change(function (){ //change event for select
     $.ajax({  //ajax call
        type: "POST",      //method == POST 
        url: baseUrl + "user/getVdc", //url to be called
       data: { dId:  $("#district option:selected").val()} //data to be send 
     }).done(function( msg ) {
        // alert(msg);
//called when request is successful msg
       //do something with msg which is response
             $("#vdcMunic").html(msg); //this line will put the response to item with id `#txtHint`.
     });
   });
   
   $("#vdcMunic").change(function (){ //change event for select
     $.ajax({  //ajax call
        type: "POST",      //method == POST 
        url: baseUrl + "user/getWard", //url to be called
       data: { vmId:  $("#vdcMunic option:selected").val(), dId:  $("#district option:selected").val()} //data to be send 
     }).done(function( msg ) {
        // alert(msg);
//called when request is successful msg
       //do something with msg which is response
             $("#wardNo").html(msg); //this line will put the response to item with id `#txtHint`.
     });
   });
   
   
   
   
 });
    </script>
