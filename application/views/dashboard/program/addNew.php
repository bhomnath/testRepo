<!--PAGE CONTENT -->
<!-- **********************************************************************************************************************************************************
MAIN CONTENT
*********************************************************************************************************************************************************** -->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
       <?php if((!empty($subjectInFlag)) || (!empty($subjectUpFlag))){ ?>
     <div class="row mt mb">
                  <div class="col-md-12">
                      <section class="task-panel tasks-widget alert alert-info" style="margin-bottom: 0px;">
	                	<div class="panel-heading">
	                        <div class="pull-left"><h5><i class="fa fa-tasks"></i> Syllabus Info</h5></div>
	                        <br>
	                 	</div>
                          <div class="panel-body">
                              <div class="task-content">
                                 <ul id="sortable" class="task-list ui-sortable">
                                      <?php if(!empty($subjectInFlag)){ ?>
                                      <li class="list-primary">
                                          
                                          <div class="task-title">
                                              <span class="label label-info">Info</span>
                                              <span class="task-title-sp">You have Insert new subject and syllabus but not published yet. Do you want to publish it and notify mobile device about insert?</span>
                                              
                                              <div class="pull-right hidden-phone">
                                                  <a class="btn btn-success btn-sm pull-right" href="<?php echo base_url().'subjectSyllabus/applyInsert'; ?>">Publish and Notify</a>
                                              </div>
                                          </div>
                                      </li>
                                      <?php } ?>
                                      
                                      <?php if(!empty($subjectUpFlag)){ ?>
                                      <li class="list-primary">
                                          
                                          <div class="task-title">
                                              <span class="label label-info">Info</span>
                                              <span class="task-title-sp">You have updated subject and syllabus but not published yet. Do you want to publish it and notify mobile device about update?</span>
                                              
                                              <div class="pull-right hidden-phone">
                                                  <a class="btn btn-success btn-sm pull-right" href="<?php echo base_url().'subjectSyllabus/applyUpdate'; ?>">Publish and Notify</a>
                                              </div>
                                          </div>
                                      </li>
                                      <?php } ?>

                                  </ul>
                              </div>
                              
                          </div>
                      </section>
                  </div><!--/col-md-12 -->
              </div> 
    <?php } ?>  
    <!--Update alert starts from here -->  
   
    <!--Update alert ends from here -->    
        <div class="row">
            <div class="col-lg-12">
                <h3>Program >> Add New </h3>

            </div>
        </div>
        <div class="row">
           
                <div class="col-lg-12">
                    <div class="content-panel">
                        <section id="unseen">

                            <div class="col-lg-12" style="color: red;">

                                <?php
                                if ($this->session->flashdata('message')) {
                                    echo $this->session->flashdata('message');
                                }
                               
                                if (isset($error)) {
                                    echo $error;
                                }
                                ?> 


                            </div>
                            <div class="col-lg-12">
                            <?php echo form_open_multipart('program/addprogram', array('id' => 'inline-validate', 'class' => 'form-horizontal', 'novalidate' => 'novalidate')); ?>
                           <?php if(!empty($faculty)){ ?>
                               <div class="col-lg-9">
                                <div class="form-group">
                            <label class="control-label col-lg-3">Faculty Name</label>

                            <div class="col-lg-6">
                                <select class="form-control col-lg-12" name="facultyName" id="facultyName">
                                <?php foreach($faculty as $faculties){ ?>
                                    <option value="<?php echo $faculties->id; ?>"> <?php echo $faculties->name; ?> </option>
                                <?php } ?>
                                </select>
                                    <?php echo form_error('facultyName'); ?>
                            </div>
                        </div>
                            </div> 
                                
                           <?php } ?>
                            <div class="col-lg-9">
                                <div class="form-group">
                            <label class="control-label col-lg-3">Program Name in Short</label>

                            <div class="col-lg-6">
                                <input type="text" class="form-control col-lg-12" name="programNameShort" id="programNameShort" value="<?php echo set_value('programNameShort'); ?>" required >
                            <?php echo form_error('programNameShort'); ?>
                            </div>
                        </div>
                            </div>
                                
                                <div class="col-lg-9">
                                <div class="form-group">
                            <label class="control-label col-lg-3">Program Name in Full</label>

                            <div class="col-lg-6">
                                <input type="text" class="form-control col-lg-12" name="programNameFull" id="programNameFull" value="<?php echo set_value('programNameFull'); ?>" required >
                            <?php echo form_error('programNameFull'); ?>
                            </div>
                        </div>
                            </div>
                                
                             <div class="col-lg-12">
                            <button class="" type="submit">Add Program</button>
                            </div>
                        <?php echo form_close(); ?>  
                               
                </div>
                             
                        </section>
                    </div><!-- /content-panel -->
                </div><!-- /col-lg-4 -->	





                
        </div><!-- /row -->
    </section><! --/wrapper -->
</section><!-- /MAIN CONTENT -->

<!--main content end-->