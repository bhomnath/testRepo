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
      
        <div class="row">
            <div class="col-lg-12">
                <h3>Subject &amp; Syllabus </h3>

            </div>
        </div>
        <div class="row">
            <?php if (!empty($subject)) { ?>
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
                            
                            <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>S.N.</th>
                                        <th>ID</th>
                                        <th>Faculty</th>
                                        <th>Program</th>
                                        <th>Semester</th>
                                        <th>Subject Code</th>
                                        <th>Subject Name</th>
                                        <th>Credit Hour</th>
                                        <th>File Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
    <?php $i = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    foreach ($subject as $subjects) {
        $i++;
        ?>
                                        <tr>
                                            <td><?php echo "<strong>" . $i . ".</strong>"; ?></td>
                                            <td><?php echo $subjects->subId; ?></td>
                                            <td></td>
                                            <td></td>
                                            <td><?php echo $subjects->semester; ?></td>
                                            <td><?php echo $subjects->code; ?></td>
                                            <td><?php echo $subjects->name; ?></td>
                                            <td><?php echo $subjects->credit; ?></td>
                                            <td><?php echo $subjects->syllabusText; ?></td>
                                            <td><a href="<?php echo base_url().'SubjectSyllabus/edit/'.$subjects->subId; ?>">Edit</a> / <a href="<?php echo base_url().'SubjectSyllabus/delete/'.$subjects->subId; ?>">Delete</a></td>
                                        </tr>
                                <?php } ?>

                                </tbody>
                            </table>
                            
                            
                            <div class="col-md-12">    
                <?php echo $links; ?>
                            </div> 
                        </section>
                    </div><!-- /content-panel -->
                </div><!-- /col-lg-4 -->	
<?php } else { ?>




                <div class="col-lg-12">
                    <div class="content-panel">
                        <section id="unseen">
                            <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>Sorry , No data available.</th>
                                    </tr>
                                </thead>
                            </table>
                        </section>
                    </div><!-- /content-panel -->
                </div><!-- /col-lg-4 -->			

<?php } ?>
        </div><!-- /row -->
    </section><! --/wrapper -->
</section><!-- /MAIN CONTENT -->

<!--main content end-->