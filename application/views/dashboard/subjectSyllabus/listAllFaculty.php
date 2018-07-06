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
                <h3>Please Choose Program Name under Faculty to move ahead</h3>

            </div>
        </div>
        <div class="row">
            <?php if (!empty($faculty)) { ?>
                <div class="col-lg-12">
                    <div class="content-panel">
                        <section id="unseen">
<?php foreach($faculty as $facData){
    $program = $this->subSyllModel->get_all_program_by_faculty_id($facData->id);
    ?>
                            
                            <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $facData->name; ?></h3>
                </div>
                <ul class="list-group">
                    <?php if(!empty($program)){ foreach($program as $prmData){ ?>
                    <a href="<?php echo base_url().'subjectSyllabus/view/'.$prmData->id; ?>" class="list-group-item"><?php echo $prmData->fullName.' ('.$prmData->name.')'; ?></a>
                    
                    <?php } } ?>
                </ul>
            </div>
        </div>                      
                            
                            
                            
<?php } ?>
                            
                            
                        
                            
                            
                            
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