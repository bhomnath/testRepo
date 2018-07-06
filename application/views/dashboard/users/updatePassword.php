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
                        if(isset($validation_message)){
                            echo $validation_message;
                        }
                        ?> 


                    </div>   
                    <div class="accordion-body collapse in body">
<?php echo form_open('user/updatePassword', array('id' => 'inline-validate', 'class' => 'form-horizontal', 'novalidate' => 'novalidate')); ?>

                        <div class="form-group">
                            <label class="control-label col-lg-3">Current Password</label>

                            <div class="col-lg-8">
                                <input type="password" id="oldPassword" name="oldPassword" class="form-control col-lg-6" value="<?php echo set_value('currentPass'); ?>" />
<?php echo form_error('oldPassword'); ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-lg-3">New Password</label>

                            <div class="col-lg-8">
                                <input type="password" id="password" name="password" class="form-control col-lg-6" value="<?php echo set_value('currentPass'); ?>" />
<?php echo form_error('password'); ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-lg-3">Confirm New Password</label>

                            <div class="col-lg-8">
                                <input type="password" id="rePassword" name="rePassword" class="form-control col-lg-6" value="<?php echo set_value('currentPass'); ?>" />
<?php echo form_error('rePassword'); ?>
                            </div>
                        </div>
                        
                       
                        
                        <div class="form-actions" style="text-align:center">
                            <input type="submit" value="Update Password" class="btn btn-primary btn-lg" />
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
                                       
                  </section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->