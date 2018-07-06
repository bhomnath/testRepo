<!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              
              <!--Update alert starts from here -->  
    <?php if(((!empty($colorantFlag)) && ($colorantFlag == 'true')) || ((!empty($baseKgFlag)) && ($baseKgFlag == 'true')) || ((!empty($baseLtrFlag)) && ($baseLtrFlag == 'true'))){ ?>
     <div class="row mt mb">
                  <div class="col-md-12">
                      <section class="task-panel tasks-widget alert alert-info" style="margin-bottom: 0px;">
	                	<div class="panel-heading">
	                        <div class="pull-left"><h5><i class="fa fa-tasks"></i> Price Update Info</h5></div>
	                        <br>
	                 	</div>
                          <div class="panel-body">
                              <div class="task-content">
                                  <ul id="sortable" class="task-list ui-sortable">
                                      <?php if((!empty($colorantFlag)) && ($colorantFlag == 'true')){ ?>
                                      <li class="list-primary">
                                          
                                          <div class="task-title">
                                              <span class="label label-info">Info</span>
                                              <span class="task-title-sp">You have updated Colorant Price but not published yet. Do you want to publish it and notify mobile device about price update?</span>
                                              
                                              <div class="pull-right hidden-phone">
                                                  <a class="btn btn-success btn-sm pull-right" href="<?php echo base_url().'colorants/applyPrice'; ?>">Publish and Notify</a>
                                              </div>
                                          </div>
                                      </li>
                                      <?php } ?>
                                      
                                      <?php if((!empty($baseKgFlag)) && ($baseKgFlag == 'true')){ ?>
                                      <li class="list-primary">
                                          
                                          <div class="task-title">
                                              <span class="label label-info">Info</span>
                                              <span class="task-title-sp">You have updated Base (KG) Price but not published yet. Do you want to publish it and notify mobile device about price update?</span>
                                              
                                              <div class="pull-right hidden-phone">
                                                  <a class="btn btn-success btn-sm pull-right" href="<?php echo base_url().'base/applyPriceKg'; ?>">Publish and Notify</a>
                                              </div>
                                          </div>
                                      </li>
                                      <?php } ?>
                                      
                                      <?php if((!empty($baseLtrFlag)) && ($baseLtrFlag == 'true')){ ?>
                                      <li class="list-primary">
                                          
                                          <div class="task-title">
                                              <span class="label label-info">Info</span>
                                              <span class="task-title-sp">You have updated Base (Ltr) Price but not published yet. Do you want to publish it and notify mobile device about price update?</span>
                                              
                                              <div class="pull-right hidden-phone">
                                                  <a class="btn btn-success btn-sm pull-right" href="<?php echo base_url().'base/applyPriceLtr'; ?>">Publish and Notify</a>
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
    <!--Update alert ends from here --> 
              
          	<h3><i class="fa fa-angle-right"></i> Blank Page</h3>
          	<div class="row mt">
          		<div class="col-lg-12">
          		<p>Place your content here.</p>
          		</div>
          	</div>
			
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->