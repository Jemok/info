<?php
	session_start();
	include_once '../includes/dbconnect.php';
	
	if(!isset($_SESSION['admin_user']))
	{
		Header("Location: http://localhost/benki/admin/index.php");	
	}
	$res=mysql_query("SELECT * FROM tbl_users WHERE user_id=".$_SESSION['admin_user']);
	$userRow=mysql_fetch_array($res);
	
	if(isset($_POST['set_rates']))
	{
		date_default_timezone_set('Africa/Nairobi');
		
		$date= date("d/m/Y");
		$time= date("h:i a");
		$var=$_SESSION['admin_user'];
		$rate_1=filter_input(INPUT_POST, 'rate_1', FILTER_SANITIZE_STRING);
		$rate_2=filter_input(INPUT_POST, 'rate_2', FILTER_SANITIZE_STRING);
		$rate_3=filter_input(INPUT_POST, 'rate_3', FILTER_SANITIZE_STRING);
		$rates_password=filter_input(INPUT_POST, 'rates_password', FILTER_SANITIZE_STRING);
		$password=md5($rates_password);
		
		//Check if such a user exists
		$resa=mysql_query("SELECT password FROM tbl_users WHERE user_id='$var' AND password = '$password' ")or die(mysql_error());
		if(mysql_num_rows($resa)==1)
		{
			$resz=mysql_query(" SELECT fixed_account FROM tbl_fixed_account ")or die(mysql_error());
			$resq=mysql_query(" SELECT savings_account FROM tbl_savings_account ")or die(mysql_error());
			while($rowz=mysql_fetch_array($resz))
			{
				$fixed_account=$rowz['fixed_account'];
				//Check rates
				if($fixed_account >= 1000)	//Rate_3
				{
					$total_fixed_account=(($rate_3/100) * $fixed_account) + $fixed_account;
					$ress=mysql_query("DROP EVENT IF EXISTS auto_fixed_interest")or die(mysql_error());
					$res=mysql_query("	CREATE EVENT auto_fixed_interest
										ON SCHEDULE EVERY 1 MONTH 
										STARTS CURRENT_TIMESTAMP
										ON COMPLETION PRESERVE ENABLE 
										DO
											BEGIN
											UPDATE tbl_fixed_account SET fixed_account='$total_fixed_account';
										END;")or die(mysql_error());
				}
				else if($fixed_account >= 100)	//Rate_2
				{
					$total_fixed_account=(($rate_2/100) * $fixed_account)+$fixed_account;
					$ress=mysql_query("DROP EVENT IF EXISTS auto_fixed_interest")or die(mysql_error());
					$res=mysql_query("	CREATE EVENT auto_fixed_interest
										ON SCHEDULE EVERY 1 MONTH 
										STARTS CURRENT_TIMESTAMP
										ON COMPLETION PRESERVE ENABLE 
										DO
											BEGIN
											UPDATE tbl_fixed_account SET fixed_account='$total_fixed_account';
										END;")or die(mysql_error());
				}
				else if($fixed_account > 0)	//Rate_1
				{
					$total_fixed_account=($rate_1/100 * $fixed_account)+$fixed_account;
					$ress=mysql_query("DROP EVENT IF EXISTS auto_fixed_interest")or die(mysql_error());
					$res=mysql_query("	CREATE EVENT auto_fixed_interest
										ON SCHEDULE EVERY 1 MONTH 
										STARTS CURRENT_TIMESTAMP
										ON COMPLETION PRESERVE ENABLE 
										DO
											BEGIN
											UPDATE tbl_fixed_account SET fixed_account='$total_fixed_account';
										END;")or die(mysql_error());
				}
				else
				{
					
				}
			}
			while($rowq=mysql_fetch_array($resq))
			{
				$savings_account=$rowq['savings_account'];
				//Check rates
				if($savings_account >= 1000)	//Rate_3
				{
					$total_savings_account=(($rate_3/100) * $savings_account) + $savings_account;
					$ress=mysql_query("DROP EVENT IF EXISTS auto_savings_interest")or die(mysql_error());
					$res=mysql_query("	CREATE EVENT auto_savings_interest
										ON SCHEDULE EVERY 1 MONTH 
										STARTS CURRENT_TIMESTAMP
										ON COMPLETION PRESERVE ENABLE 
										DO
											BEGIN
											UPDATE tbl_savings_account SET savings_account='$total_savings_account';
										END;")or die(mysql_error());
				}
				else if($savings_account >= 100)	//Rate_2
				{
					$total_savings_account=(($rate_2/100) * $savings_account)+$savings_account;
					$ress=mysql_query("DROP EVENT IF EXISTS auto_savings_interest")or die(mysql_error());
					$res=mysql_query("	CREATE EVENT auto_savings_interest
										ON SCHEDULE EVERY 1 MONTH 
										STARTS CURRENT_TIMESTAMP
										ON COMPLETION PRESERVE ENABLE 
										DO
											BEGIN
											UPDATE tbl_savings_account SET savings_account='$total_savings_account';
										END;")or die(mysql_error());
				}
				else if($savings_account > 0)	//Rate_1
				{
					$total_savings_account=($rate_1/100 * $savings_account)+$savings_account;
					$ress=mysql_query("DROP EVENT IF EXISTS auto_savings_interest")or die(mysql_error());
					$res=mysql_query("	CREATE EVENT auto_savings_interest
										ON SCHEDULE EVERY 1 MONTH 
										STARTS CURRENT_TIMESTAMP
										ON COMPLETION PRESERVE ENABLE 
										DO
											BEGIN
											UPDATE tbl_savings_account SET savings_account='$total_savings_account';
										END;")or die(mysql_error());
				}
				else
				{
					
				}
			}
			$resc=mysql_query(" INSERT INTO tbl_rates (id,rate_1,rate_2,rate_3,updated_by,date,time) VALUES ('4036','$rate_1','$rate_2','$rate_3','$var','$date','$time')
								ON DUPLICATE KEY UPDATE rate_1='$rate_1',
																rate_2='$rate_2',
																rate_3='$rate_3',
																updated_by='$var',
																date='$date',
																time='$time' ")or die(mysql_error());
		}
		else
		{
			?>
				<script>
					alert("Error: Wrong Password");
					window.location.replace("http://localhost/benki/admin/general.php");
				</script>
			<?php
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Benki | Admin <?php echo $userRow['full_names']; ?></title>

    <!-- Bootstrap CSS -->    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="css/elegant-icons-style.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <script src="js/lte-ie7.js"></script>
    <![endif]-->
  </head>

  <body>

  <!-- container section start -->
  <section id="container" class="">
      <!--header start-->
      <header class="header dark-bg">
            <div class="toggle-nav">
                <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"></div>
            </div>

            <!--logo start-->
           <a href="http://localhost/benki/admin/home.php" class="logo">Benki <span class="lite">Admin</span></a>
            <!--logo end-->

            <div class="nav search-row" id="top_menu">
                <!--  search form start -->
                <?php include 'search_function.php';?>
                <!--  search form end -->                              
            </div>

            <div class="top-nav notification-row">                
                <!-- notificatoin dropdown start-->
                <ul class="nav pull-right top-menu">
                    
                    <!-- task notificatoin start -->
                    <li id="task_notificatoin_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="icon-task-l"></i>
                      <!--      <span class="badge bg-important">5</span>-->
                        </a>
                        <ul class="dropdown-menu extended tasks-bar">
                            <div class="notify-arrow notify-arrow-blue"></div>
                            <li>
                                <p class="blue">Benki graphs</p>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="task-info">
                                        <div class="desc">Total members </div>
                                        <div class="percent">7000000</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 2%">
                                            <span class="sr-only">2% Complete (success)</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="task-info">
                                        <div class="desc">
                                            Total chamas
                                        </div>
                                        <div class="percent">30</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%">
                                            <span class="sr-only">30% Complete (warning)</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="task-info">
                                        <div class="desc">Days Withdrawal requests</div>
                                        <div class="percent">5000000</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 7%">
                                            <span class="sr-only">7% Complete</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="task-info">
                                        <div class="desc">Days Point Awarded</div>
                                        <div class="percent">78000000</div>
                                    </div>
                                    <div class="progress progress-striped">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 78%">
                                            <span class="sr-only">78% Complete (danger)</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                      
                            <li class="external">
                           <!--     <a href="#">See All Tasks</a>-->
                            </li>
                        </ul>
                    </li>
                    
                    <li id="alert_notificatoin_bar" class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                            <i class="icon-bell-l"></i>
                         <!--   <span class="badge bg-important">7</span>-->
                        </a>
                        <ul class="dropdown-menu extended notification">
                            <div class="notify-arrow notify-arrow-blue"></div>
                            <li>
                                <p class="blue">Withdrawal requests</p>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-primary"><i class="icon_profile"></i></span> 
                                    Name<br>email<br>phone<br>amount<br><button class="btn btn-primary" type="submit">sorted</button>
                                              
                                    <span class="small italic pull-right">5 mins</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-warning"><i class="icon_pin"></i></span>  
                                    Name<br>email<br>phone<br>amount<br><button class="btn btn-primary" type="submit">sorted</button>
                                    <span class="small italic pull-right">50 mins</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-danger"><i class="icon_book_alt"></i></span> 
                                    Name<br>email<br>phone<br>amount<br><button class="btn btn-primary" type="submit">sorted</button>
                                    <span class="small italic pull-right">1 hr</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="label label-success"><i class="icon_like"></i></span> 
                                    Name<br>email<br>phone<br>amount<br><button class="btn btn-primary" type="submit">sorted</button>
                                    <span class="small italic pull-right"> Today</span>
                                </a>
                            </li>                            
                            <li>
                                <a href="#">See all notifications</a>
                            </li>
                        </ul>
                    </li>
                    <!-- alert notification end-->
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="profile-ava">
                                <img alt="" src="img/avatar1_small.jpg">
                            </span>
                            <span class="username"><?php echo $userRow['full_names']; ?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li class="eborder-top">
                          <!--      <a href="#"><i class="icon_profile"></i> My Profile</a>-->
                            </li>
                            <li>
                         <!--       <a href="#"><i class="icon_mail_alt"></i> My Inbox</a>-->
                            </li>
                            <li>
                         <!--       <a href="#"><i class="icon_clock_alt"></i> Timeline</a>-->
                            </li>
                            <li>
                         <!--       <a href="#"><i class="icon_chat_alt"></i> Chats</a>-->
                            </li>
                            <li>
                                <a href="http://localhost/benki/includes/logout.php?logout"><i class="icon_key_alt"></i> Log Out</a>
                            </li>
                            <li>
                          <!--      <a href="documentation.php"><i class="icon_key_alt"></i> Documentation</a>-->
                            </li>
                            <li>
                           <!--     <a href="documentation.php"><i class="icon_key_alt"></i> Documentation</a>-->
                            </li>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!-- notificatoin dropdown end-->
            </div>
      </header>      
      <!--header end-->

      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu">                
                  <li class="active">
                      <a class="" href="http://localhost/benki/admin/home.php">
                          <i class="icon_house_alt"></i>
                          <span>Dashboard</span>
                      </a>
                  </li>
				  <li class="sub-menu">
                      <a href="javascript:;" class="">
                          <i class="icon_document_alt"></i>
                          <span>Reward Panel</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                      <ul class="sub">
                     <!--     <li><a class="" href="form_component.php">Form Elements</a></li>-->                          
                          <li><a class="" href="form_validation.php">Reward points</a></li>
                      </ul>
                  </li>       
                  <li class="sub-menu">
                      <a href="javascript:;" class="">
                          <i class="icon_desktop"></i>
                          <span>Set Rates</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                      <ul class="sub">
                          <li><a class="" href="general.php">Set</a></li>
                          
                      </ul>
                  </li>
                <!--  <li>
                      <a class="" href="widgets.php">
                          <i class="icon_genius"></i>
                          <span>Widgets</span>
                      </a>
                  </li>-->
                <!--  <li>                     
                      <a class="" href="chart-chartjs.php">
                          <i class="icon_piechart"></i>
                          <span>Charts</span>
                          
                      </a>
                                         
                  </li>-->
                             
                <!--  <li class="sub-menu">
                      <a href="javascript:;" class="">
                           <i class="icon_table"></i>
                         <span>Tables</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                      <ul class="sub">
                          <li><a class="" href="basic_table.php">Basic Table</a></li>
                      </ul>-->
                  </li>
                  
                  <li class="sub-menu">
                      <a href="javascript:;" class="">
                          <i class="icon_documents_alt"></i>
                          <span>Pages</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                      <ul class="sub">                          
                          <li><a class="" href="profile.php">Clients Details</a></li>
                      </ul>
                  </li>
                  
              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->

      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <div class="row">
			  <!--  search form results -->
				<?php include ("search_results.php"); ?>
			  <!--  search form end -->
				<div class="col-lg-12">
					<h3 class="page-header"><i class="fa fa-list-alt"></i> Set</h3>
					<ol class="breadcrumb">
						<li><i class="fa fa-home"></i><a href="http://localhost/benki/admin/home.php">Home</a></li>
						<li><i class="fa fa-desktop"></i>UI Fitures</li>
						<li><i class="fa fa-list-alt"></i>Components</li>
					</ol>
				</div>
			</div>
              <div class="row">
                  <div class="col-lg-6">
                      <!--notification start-->
                      <section class="panel">
                          <header class="panel-heading">
                            Advanced Form validations
                          </header>
                          <div class="panel-body">
                              <div class="form">
                                  <form class="form-validate form-horizontal "  method="post" action="">
                                      <div class="form-group ">
                                          <label for="fullname" class="control-label col-lg-2">1-100<span class="required">*</span></label>
                                          <div class="col-lg-10">
                                              <input class=" form-control" name="rate_1" type="text" placeholder="Insert Rate per month" required />
                                          </div>
                                      </div>
									  <div class="form-group ">
                                          <label for="fullname" class="control-label col-lg-2">100-1000<span class="required">*</span></label>
                                          <div class="col-lg-10">
                                              <input class=" form-control" name="rate_2" type="text" placeholder="Insert Rate per month" required />
                                          </div>
                                      </div>
                                      <div class="form-group ">
                                          <label for="address" class="control-label col-lg-2">1000-10000 <span class="required">*</span></label>
                                          <div class="col-lg-10">
                                              <input class=" form-control" name="rate_3" type="text" placeholder="Insert Rate per month" required />
                                          </div>
                                      </div>
                                      <div class="form-group ">
                                          <label for="password" class="control-label col-lg-2">Password <span class="required">*</span></label>
                                          <div class="col-lg-10">
                                              <input class="form-control "  name="rates_password" type="password" required />
                                          </div>
                                      </div>
                                      <div class="form-group">
                                          <div class="col-lg-offset-2 col-lg-10">
                                              <button class="btn btn-primary" name="set_rates" type="submit">Set Rates</button>
                                              <button class="btn btn-default" type="button">Cancel</button>
                                          </div>
                                      </div>
                                  </form>
                              </div>
                          </div>
                      </section>
                  </div>

                  </div>

              </div>
          </section>
      </section>
      <!--main content end-->
  </section>
  <!-- container section end -->

    <!-- javascripts -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- nice scroll -->
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <!-- gritter -->
   
    <!-- custom gritter script for this page only-->
    <script src="js/gritter.js" type="text/javascript"></script>
    <!--custome script for all page-->
    <script src="js/scripts.js"></script>

    


  </body>
</html>
