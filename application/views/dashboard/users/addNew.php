<!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
        <section id="main-content">
          <section class="wrapper site-min-height">
        <div class="row">
            <div class="col-lg-12">
                <h3>Add New Admin </h3>
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
                        
                        ?> 


                    </div>   
                    <div class="accordion-body collapse in body">
<?php echo form_open_multipart('user/addNewUser', array('id' => 'inline-validate', 'class' => 'form-horizontal', 'novalidate' => 'novalidate')); ?>

                        <div class="form-group">
                            <label class="control-label col-lg-3">First Name</label>

                            <div class="col-lg-8">
                                <input type="text" id="firstname" name="firstname" class="form-control col-lg-6" value="<?php echo set_value('firstname'); ?>" />
<?php echo form_error('firstname'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3">Last Name</label>

                            <div class="col-lg-8">
                                <input type="text" id="lastname" name="lastname" class="form-control col-lg-6" value="<?php echo set_value('lastname'); ?>" />
<?php echo form_error('lastname'); ?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-lg-3">E-mail</label>

                            <div class="col-lg-8">
                                <input type="email" id="email" name="email" class="form-control col-lg-6" value="<?php echo set_value('email'); ?>"/>
<?php echo form_error('email'); ?>
                            </div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label class="control-label col-lg-3">Password</label>

                            <div class="col-lg-8">
                                <input type="password" id="password" name="password" class="form-control col-lg-6" value="<?php echo set_value('password'); ?>"/>
<?php echo form_error('password'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3">Re-Password</label>

                            <div class="col-lg-8">
                                <input type="password" id="rePassword" name="rePassword" class="form-control col-lg-6" value="<?php echo set_value('rePassword'); ?>"/>
<?php echo form_error('rePassword'); ?>
                            </div>
                        </div>
                        
                        <div class="form-actions" style="text-align:center">
                            <input type="submit" value="Add User" class="btn btn-primary btn-lg" />
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->

