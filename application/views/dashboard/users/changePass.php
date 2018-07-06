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
                    <div class="alert alert-info">
                        <p>Please enter valid Email Id below. You will get link to update password in your email inbox.</p>
                    </div>
                    <div class="accordion-body collapse in body">
<?php echo form_open('user/email', array('id' => 'inline-validate', 'class' => 'form-horizontal', 'novalidate' => 'novalidate')); ?>

                        <div class="form-group">
                            <label class="control-label col-lg-3">Email ID</label>

                            <div class="col-lg-8">
                                <input type="email" id="emailId" name="emailId" class="form-control col-lg-6" value="<?php echo set_value('emailId'); ?>" />
<?php echo form_error('emailId'); ?>
                            </div>
                        </div>
                        
                        <div class="form-actions" style="text-align:center">
                            <input type="submit" value="Send link" class="btn btn-primary btn-lg" />
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
                                       
                   
                     </section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->