<?php


class UserProfileComponent implements GuiComponent{
	
	private $user;
	private $editable;
	
	function __construct($user){
		$this->user = $user;
		$this->editable = false;		
	}
	
	public function setEditable($editable){
		$this->editable = $editable;
	}
	
	public function renderCmp(){

		if($this->editable){
			?>
				<script type="text/javascript" charset="utf-8">
					var profile_edit = function(){
						//hide form
						$("#actual_form").fadeOut("slow", function(){
							$("#editable_form").fadeIn();	
						});
						//show editable form
					}
				</script>
				<a onClick='profile_edit()'>editar mi perfil</a>
			<?php
			
			//add editable form
			$editable_form = new DAOFormComponent( $this->user );
			
			$editable_form->hideField( array("solved", "password", "user_id", "submissions" )  );
			$editable_form->wrapWith("id", "editable_form");
			$editable_form->wrapWith("style", "display: none;");
			echo $editable_form->renderCmp();
			
		}
		
		?>
			
			<table border="0" id="actual_form">
				<tr>
					<td><img src="http://www.gravatar.com/avatar/<?php echo md5($this->user->getUsername()); ?>?s=128"></td>
					<td valign=top><h1>
						<?php 
							if(is_null( $this->user->getName() ))
								echo $this->user->getUserName();
							else
								echo $this->user->getName();
						?>
					</h1>
					
					<table border="0">
						<tr><td>Solved</td><td>
							<?php echo $this->user->getSolved(); ?>
						</td></tr>
						<tr><td>Submissions</td><td>
							<?php echo $this->user->getSubmissions(); ?>
						</td></tr>	
						<tr><td>Country</td><td>
							<?php echo $this->user->getCountryId(); ?>,
							<?php echo $this->user->getStateId(); ?>
						</td></tr>
						<tr><td>School</td><td>
							<?php echo $this->user->getSchoolId(); ?>
						</td></tr>
						
					</table>
					
					</td>
				</tr>
				<tr>
					<td>
						<h2>Badges</h2>
						<?php
							
							$badges = UsersBadgesDAO::search( new UsersBadges( array( "user_id" => $this->user->getUserId() ) ) );
							foreach( $badges as $badge ){
								//print badge name
								$actual_badge = BadgeDAO::getByPK($badge->getBadgeId());
								echo $actual_badge->getName();
							}
						?>
					</td>
				</tr>
				
				
				
				
			</table>
		
		<?php
		
		/*
		object(Users)#4 (14) { ["user_id":protected]=> string(1) "2" ["username":protected]=> string(19) "alan.gohe@gmail.com" ["password":protected]=> NULL ["main_email_id":protected]=> NULL ["name":protected]=> NULL ["solved":protected]=> string(1) "0" ["submissions":protected]=> string(1) "0" ["country_id":protected]=> NULL ["state_id":protected]=> NULL ["school_id":protected]=> NULL ["scholar_degree":protected]=> NULL ["graduation_date":protected]=> NULL ["birth_date":protected]=> NULL ["last_access":protected]=> string(19) "2011-12-31 04:15:45" }
		*/
	}
	
	
}