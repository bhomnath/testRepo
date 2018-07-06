<style>
    .wrapword{
        white-space: -moz-pre-wrap !important;  /* Mozilla, since 1999 */
        white-space: -webkit-pre-wrap; /*Chrome & Safari */ 
        white-space: -pre-wrap;      /* Opera 4-6 */
        white-space: -o-pre-wrap;    /* Opera 7 */
        white-space: pre-wrap;       /* css-3 */
        word-wrap: break-word;       /* Internet Explorer 5.5+ */
        word-break: break-all;
        white-space: normal;
    }
</style>
<link rel="stylesheet" href="<?php echo base_url() . 'content/assets/css/jquery-confirm.css'; ?>" >
<script src="<?php echo base_url() . 'content/assets/js/confirm.js'; ?>" ></script>
<style>.jconfcontainer{width:360px;margin: 0 auto;}</style>
<!--PAGE CONTENT -->
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
        
        <div class="row">
            <div class="col-lg-12">
                <h3>Users </h3>

            </div>
        </div>
        <div class="row">
            <?php if (!empty($users)) { ?>
                <div class="col-lg-12">
                    <div class="content-panel">
                        <section id="unseen">

                            <div class="col-lg-12" style="color: red;">

                                <?php
                                if ($this->session->flashdata('message')) {
                                    echo $this->session->flashdata('message');
                                }
                                echo validation_errors();
                                if (isset($error)) {
                                    echo $error;
                                }
                                ?> 


                            </div>  
                            <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th>S.N.</th>
                                        <th>User ID</th>
                                        <th>Full Name</th>

                                        <th>Email</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
    <?php $i = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    foreach ($users as $userInfo) {
        $i++;
        ?>
                                        <tr>
                                            <td><?php echo "<strong>" . $i . ".</strong>"; ?></td>
                                            <td><?php $ID = sprintf('%04d', $userInfo->id);
        echo $ID; ?></td>
                                            <td><?php echo $userInfo->first_name . ' ' . $userInfo->last_name; ?></td>

                                            <td><?php echo $userInfo->user_email; ?></td>

                                            <?php if ($userInfo->user_type == 'administrator') { ?>


                                                <td class="center"><a href="<?php echo base_url() . 'user/editUser/' . $userInfo->id; ?>"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a> | <a class="cd-popup-trigger removee" href="<?php echo base_url() . 'user/deleteUser/' . $userInfo->id; ?>"><button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button> </a> | <a href="<?php echo base_url() . 'user/changePass'; ?>">Change Password</a></td>
        <?php } else { ?>
                                                <td class="center"></td>
        <?php } ?>
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
<script>
    $(document).ready(function () {
        $(document).on("click", ".removee", function (e) {
            e.preventDefault();
            var thiss = $(this);

            $.confirm({
                title: 'A critical action',
                content: 'Do you really want to delete this ?',
                confirmButton: 'Proceed',
                cancelButton: 'Cancel',
                animation: 'scale',
                animationSpeed: '400',
                animationBounce: '',
                confirm: function () {
                    var hr = thiss.attr('href');
                    window.location = hr;
                },
                cancel: function () {
                    // do something when No is clicked.
                }
            });



        });






        $(document).on("click", "#cancel", function () {
            $("#popbox").slideUp();
        });
    });
</script>  