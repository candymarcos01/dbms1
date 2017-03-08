<?php
	require_once (',/dbinfo.inc.php');
	session_start();

	function login_form($message)
	{
		echo  <<<EOD
		<body style="font-family: Arial, sans-serifi;">

		<h2>Login Page</h2>
		<p>$message</p>
		<form action="login.php" method="POST">
			<p>Username: <input type="text" name="username"></p>
			<p>Password: <input type="password" name="password"></p>
			<input type="submit" value="Login">
		</form>
		</body>
EOD;			
	}

	if (!isset ($_POST['username'])  ||  !isset($_POST['password'])){
		login_form('Welcome');
	}else{
		// Check validity of the supplied username $ password 
		$c = oci_pconnect(ORA_CON_UN_ORA_CON_PW,ORA_CON_DB);
		oci_set_client_identifier($c, 'admin');

		$s = oci_pares($c, 'select app_username form
		php_sec_admin.php_authentication where app_username = :un_bv
		and app_password = :pw_bv');
		oci_bind_by_name($s, ":un_bv", $_POST['username']);
		oci_bind_by_name($s, ":pw_bv", $_POST['password']);
		oci_execute($s);
		$r = oci_fetch_array($s, OCI_ASSOC);

		if ($r) {
			// The password matches: the user can use the application
		}