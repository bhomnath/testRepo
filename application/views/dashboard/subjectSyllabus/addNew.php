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
                <h3>Subject &amp; Syllabus >> Add New </h3>

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
                            <?php echo form_open_multipart('SubjectSyllabus/addsubject', array('id' => 'inline-validate', 'class' => 'form-horizontal', 'novalidate' => 'novalidate')); ?>
                           <?php if(!empty($faculty)){ ?>
                               <div class="col-lg-9">
                                <div class="form-group">
                            <label class="control-label col-lg-3">Faculty Name</label>

                            <div class="col-lg-6">
                                <select class="form-control col-lg-12" name="facultyName" id="facultyName">
                                <option value="0"> Select Faculty </option>
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
                            <label class="control-label col-lg-3">Program Name</label>

                            <div class="col-lg-6">
                                <select class="form-control col-lg-12" name="programName" id="programName" required ></select>
                            <?php echo form_error('programName'); ?>
                            </div>
                        </div>
                            </div>
                                
                                <div class="col-lg-9">
                                <div class="form-group">
                            <label class="control-label col-lg-3">Subject Code</label>

                            <div class="col-lg-6">
                                <input type="text" class="form-control col-lg-12" name="subjectCode" id="subjectCode" value="<?php echo set_value('subjectCode'); ?>" required >
                            <?php echo form_error('subjectCode'); ?>
                            </div>
                        </div>
                            </div>
                                
                                <div class="col-lg-9">
                                <div class="form-group">
                            <label class="control-label col-lg-3">Subject Name</label>

                            <div class="col-lg-6">
                                <input type="text" class="form-control col-lg-12" name="subjectName" id="subjectName" value="<?php echo set_value('subjectName'); ?>" required >
                            <?php echo form_error('subjectName'); ?>
                            </div>
                        </div>
                            </div>
                                
                                <div class="col-lg-9">
                                <div class="form-group">
                            <label class="control-label col-lg-3">Sections in syllabus</label>

                            <div class="col-lg-6">
                                <input type="checkbox" class="" name="sections" id="sections" value="" required >Objectives<br/>
                                <input type="checkbox" class="" name="sections" id="sections" value="" required >Syllabus Contents<br/>
                                <input type="checkbox" class="" name="sections" id="sections" value="" required >Course Books<br/>
                                <input type="checkbox" class="" name="sections" id="sections" value="" required >Reference Books<br/>
                                <input type="checkbox" class="" name="sections" id="sections" value="" required >Laboratory Tasks<br/>
                                <input type="checkbox" class="" name="sections" id="sections" value="" required >Projects
                            <?php echo form_error('subjectName'); ?>
                            </div>
                        </div>
                            </div>
                                
                                <div class="col-lg-9">
                                <div class="form-group">
                            <label class="control-label col-lg-3">Semester</label>

                            <div class="col-lg-6">
                                <select class="form-control col-lg-12" name="semester" id="semester">
                                    <option value="I"> I</option>
                                    <option value="II"> II</option>
                                    <option value="III"> III</option>
                                    <option value="IV"> IV</option>
                                    <option value="V"> V</option>
                                    <option value="VI"> VI</option>
                                    <option value="VII"> VII</option>
                                    <option value="VIII"> VIII</option>
                                </select>
                                    <?php echo form_error('semester'); ?>
                            </div>
                        </div>
                            </div>
                                
                                <div class="col-lg-9">
                                <div class="form-group">
                            <label class="control-label col-lg-3">Credit</label>

                            <div class="col-lg-6">
                                <select class="form-control col-lg-12" name="credit" id="credit">
                                    <option value="1"> 1</option>
                                    <option value="2"> 2</option>
                                    <option value="3"> 3</option>
                                    <option value="4"> 4</option>
                                    <option value="5"> 5</option>
                                    <option value="6"> 6</option>
                                    <option value="7"> 7</option>
                                    <option value="8"> 8</option>
                                </select>
                                    <?php echo form_error('credit'); ?>
                            </div>
                        </div>
                            </div>
                                
                                
                                <div class="col-lg-9">
                                <div class="form-group">
                            <label class="control-label col-lg-3">Syllabus File</label>

                            <div class="col-lg-6">
                                <input type="file" class="form-control col-lg-12" name="syllabusFile" id="syllabusFile" required >
                            <?php echo form_error('subjectName'); ?>
                            </div>
                        </div>
                            </div>
                                
                                
                                
                             <div class="col-lg-12">
                            <button class="" type="submit">Add Subject &amp; Syllabus</button>
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
<script type="text/javascript">
  $(document).ready(function(){ /* PREPARE THE SCRIPT */
    $("#facultyName").change(function(){ /* WHEN YOU CHANGE AND SELECT FROM THE SELECT FIELD */
      var facId = $(this).val(); /* GET THE VALUE OF THE SELECTED DATA */
      var dataString = "faculty="+facId; /* STORE THAT TO A DATA STRING */

      $.ajax({ /* THEN THE AJAX CALL */
        type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
        url: "<?php echo base_url() . 'SubjectSyllabus/getFacultyProgram'; ?>", /* PAGE WHERE WE WILL PASS THE DATA */
        data: dataString, /* THE DATA WE WILL BE PASSING */
        success: function(result){ /* GET THE TO BE RETURNED DATA */
          $("#programName").html(result); /* THE RETURNED DATA WILL BE SHOWN IN THIS DIV */
        }
      });

    });
  });
</script>