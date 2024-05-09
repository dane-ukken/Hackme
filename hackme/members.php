<?php
	// Connects to the Database 
	include('connect.php');
	connect();
	$mysqli = new mysqli("127.0.0.1","cs6324spring24","8mwni8URcsr08bCxx","cs6324spring24");

	require_once 'crypto.php';

	$test1 = "Reached 1";
	$test2 = "Reached 2";
	//if the login form is submitted 
	if (isset($_POST['submit'])) {
    
		$_POST['username'] = trim($_POST['username']);
		if (!$_POST['username'] || !$_POST['password']) {
			die('<p>You did not fill in a required field. Please go back and try again!</p>');
		}
		
		$post_uname = $_POST['username'];
		$post_password = $_POST['password'];

		$res = $mysqli->query("SELECT * FROM users WHERE username = '" . $post_uname . "'") or die(mysqli_error($mysqli));
	
		if ($res) {
			$row = $res->fetch_assoc();
			if ($row && password_verify($post_password, $row['pass'])) {
				$hour = time() + 3600;
				$encrypted_uname = encryptData($post_uname);
				setcookie('hackme', $encrypted_uname, $hour, '/~dsu220000', '', false, true);
				header("Location: members.php");
				exit;
			} else {
				die("<p>Sorry, incorrect password.</p>");
			}
			
		} else {
			die("<p>Sorry, username does not exist.</p>");
		}
	}
?>  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>hackme</title>
<link href="style.css" rel="stylesheet" type="text/css" media="screen" />
<?php
	include('header.php');
?>
<div class="post">
	<div class="post-bgtop">
		<div class="post-bgbtm">
        <h2 class = "title">hackme bulletin board</h2>
        	<?php
            if(!isset($_COOKIE['hackme'])){
				 die('Why are you not logged in?!');
			}else
			{
				$decryptedData = decryptData($_COOKIE['hackme']);
				print("<p>Logged in as <a>{$decryptedData}</a></p>");
			}
			?>
        </div>
    </div>
</div>

<?php
	$threads = mysql_query("SELECT * FROM threads ORDER BY date DESC")or die(mysql_error());
	while($thisthread = mysql_fetch_array( $threads )){
?>
	<div class="post">
	<div class="post-bgtop">
	<div class="post-bgbtm">
		<h2 class="title"><a href="show.php?pid=<?php echo $thisthread['id'] ?>"><?php echo $thisthread['title']?></a></h2>
							<p class="meta"><span class="date"> <?php echo date('l, d F, Y',$thisthread[date]) ?> - Posted by <a href="#"><?php echo $thisthread[username] ?> </a></p>

	</div>
	</div>
	</div> 

<?php
}
	include('footer.php');
?>
</body>
</html>
