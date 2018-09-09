<?php

session_start();

/*
 STEP1 This to check if user is login in web site ,Than include main component for web site
*/

if(isset($_SESSION['UserName']))
{
	$pageTitle='Members';
	include 'init.php';
/*
STEP2 Here Make Component for this page
*/
		if(isset($_GET['event'])){
		$event=$_GET['event'];


		if($event=='Edite'){  
		/*
		STEP2  PageOne -->( Edite Member pagetHere) Make Component for this page
		*/
		$userid=(isset($_GET['id'])&&is_numeric($_GET['id']))?intval($_GET['id']):0;
				$stm=$con->prepare("select 	* from users Where Id=? limit 1");
					$stm->execute(array($userid));
					$row=$stm->fetch();
					

		if($stm->rowCount()>0&&$_SESSION['UserId']==$userid){
		?>

		<h1 class="text-center"><span class="subtitle">Edit Profile</span></h1>

					<div class="updateform container">
						<form class="form-horizontal" action="?event=Update" method="POST">
						<!-- Start User Name Filed input -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 col-sm-offset-2 control-label">User Name</label>
								<div class="col-sm-10  col-md-4 ">
									<input class="form-control" value="<?php echo $row['UserName'];?>" type="text" name="userName" autocomplete="off" required="required" />
									<input type="hidden" name="userid" value="<?php echo $userid;?>">
								</div>
							</div>
						<!-- End User Name Filed input -->

						<!-- Start  Password Filed input -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 col-sm-offset-2 control-label">Password</label>
								<div class="col-sm-10 col-md-4">
									<input  type="hidden" name="oldPassword" value="<?php echo $row['Password'];?>" />
									<input class="form-control" type="password" name="newPassword" autocomplete="new-password" />
								</div>
							</div>
						<!-- End Password  Filed input -->

						<!-- Start  Fullname Filed input -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 col-sm-offset-2 control-label">Full Name</label>
								<div class="col-sm-10 col-md-4">
									<input class="form-control" value="<?php echo $row['FullName'];?>" type="text" name="fullName" autocomplete="off"  required="required"/>
								</div>
							</div>
						<!-- End Fullname  Filed input -->

						<!-- Start  Email Filed input -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 col-sm-offset-2  control-label">Email</label>
								<div class="col-sm-10 col-md-4">
									<input class="form-control" value="<?php echo $row['Email'];?>" type="email" name="email" autocomplete="off"  required="required"/>
								</div>
							</div>
						<!-- End Email  Filed input -->
						<!-- Start  Submit Filed input -->
							<div class="form-group ">
								
								<div class="col-sm-offset-4 col-sm-10">
									<input class="btn btn-primary btn-lg" type="submit" value="Save"  />
								</div>
							</div>
						<!-- End Submit  Filed input -->

						</form>
					</div>

			<?php	}
			else{
					echo'<h1 class="text-center"><span class="subtitle">This Information Is Not available For This User
					</span></h1>';

			}

		}

			elseif($event=='Update')
			{


			if($_SERVER['REQUEST_METHOD']=='POST'){
				$userid=$_POST['userid'];
				$userName=$_POST['userName'];
				$email=$_POST['email'];
				$fullName=$_POST['fullName'];
				$pass= empty($_POST['newPassword']) ? $_POST['oldPassword'] : sha1($_POST['newPassword']);

				// echo $userid  .' '.$userName.' '.$fullName.' '.$email;

			

			$ErrorAr=array();
					if(empty($userName))
					{
						$ErrorAr[]='<div class="alert alert-danger">User Name Cant Be <strong>Empty</strong></div>';
					}
					if(empty($email))
					{
						$ErrorAr[]='<div class="alert alert-danger">User Email Cant Be <strong>Empty</strong></div>';
					}
					if(empty($fullName))
					{
						$ErrorAr[]='<div class="alert alert-danger">User Full Name Cant Be <strong>Empty</strong></div>';
					}
					if(!empty($_POST['newPassword'])&&strlen($_POST['newPassword']<8))
					{
						$ErrorAr[]='<div class="alert alert-danger">Password Must Be  <strong>More Than 8 Charaters</strong></div>';
					}
					if(empty($ErrorAr)){

					$stm=$con->prepare("update users	SET UserName=?,FullName= ?, Password= ? ,Email= ?  Where Id= ? ");
					$stm->execute(array($userName,$fullName,$pass,$email,$userid));
					$count=$stm->rowCount();
				echo ' </br><div class="container">';
					echo '<div class="alert alert-success  ">Number Updated Members  <strong>'.$count.'</strong></div>';
						echo '</div>';

			

					}
					else{
						echo '</br><div class="container">';
					foreach ($ErrorAr as $e) {

						echo $e ;
						
					}
					echo '</div>';
				}

			}///////////

			else{
					echo'<h1 class="text-center"><span class="subtitle">This Paget Not Available
					</span></h1>';

			}

		}


}



	include $template."footer.php";
}
else
{
/*
STEP3 If user does not login in website redirect him to login paget
*/
	header('location:login.php');
		exit();
}







?>