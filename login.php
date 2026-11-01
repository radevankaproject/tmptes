<?php
if(isset($_POST['submit'])){
	if(!verify_csrf_token($_POST['csrf_token'] ?? '')){
		javascript('login','alert','Token CSRF tidak valid, silakan ulangi login');
		exit;
	}
	$u = clean_xss($_POST['us'] ?? '');
	$p = $_POST['pw'] ?? '';
	$stmt = $con->prepare("SELECT idUser, nama, username, password, level FROM user WHERE username = ? LIMIT 1");
	$stmt->bind_param("s", $u);
	$stmt->execute();
	$q = $stmt->get_result();
	$r = ($q && $q->num_rows > 0) ? $q->fetch_assoc() : null;
	$stmt->close();

	$validPassword = false;
	if($r){
		if(password_verify($p, $r['password'])){
			$validPassword = true;
			if(password_needs_rehash($r['password'], PASSWORD_DEFAULT)){
				$newHash = password_hash($p, PASSWORD_DEFAULT);
				$up = $con->prepare("UPDATE user SET password = ? WHERE idUser = ?");
				$up->bind_param("si", $newHash, $r['idUser']);
				$up->execute();
				$up->close();
				$r['password'] = $newHash;
			}
		}elseif($p === $r['password']){
			// Migrasi otomatis password plaintext lama ke password_hash
			$validPassword = true;
			$newHash = password_hash($p, PASSWORD_DEFAULT);
			$up = $con->prepare("UPDATE user SET password = ? WHERE idUser = ?");
			$up->bind_param("si", $newHash, $r['idUser']);
			$up->execute();
			$up->close();
			$r['password'] = $newHash;
		}
	}

	if($validPassword){
		session_regenerate_id(true);
		$_SESSION['csrf_token']   = bin2hex(random_bytes(32));
		$_SESSION['username']     = clean_xss($r['username']);
		$_SESSION['password']     = $r['password'];
		$_SESSION['nama']  		  = clean_xss($r['nama']);
		$_SESSION['level']        = (int)$r['level'];
		$_SESSION['idUser']  	  = (int)$r['idUser'];
		javascript('','redirect');
	}else{
		javascript('login','alert','Username / Password Salah');
	}
}
$csrfToken = csrf_token();
?>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $site;?>asts/plugins/images/f_tmp/favicon_tmp.png">
        <title><?php echo htmlspecialchars($website, ENT_QUOTES, 'UTF-8');?></title>
        <!-- Bootstrap Core CSS -->
        <link href="<?php echo $site;?>asts/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $site;?>asts/plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
        <!-- animation CSS -->
        <link href="<?php echo $site;?>asts/css/animate.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="<?php echo $site;?>asts/css/style.min.css" rel="stylesheet">
        <!-- Loader CSS -->
        <link href="<?php echo $site;?>assets/css/loader.css" rel="stylesheet">
        <!-- color CSS -->
        <link href="<?php echo $site;?>asts/css/colors/megna.css" id="theme" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
    <!-- Preloader -->
<!--    <div class="preloader">-->
<!--        <div class="cssload-speeding-wheel"></div>-->
<!--    </div>-->
    <section id="wrapper" class="login-register">
        <div class="login-box login-sidebar">
            <div class="white-box">
                <form class="form-horizontal form-material" id="loginform" action="" method="post" autocomplete="off">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                    <a href="javascript:void(0)" class="text-center db"><img src="<?php echo $site;?>asts/plugins/images/f_tmp/logo01.png" alt="Home" />
                        <br/><img src="<?php echo $site;?>asts/plugins/images/f_tmp/ls.png" alt="Home" /></a>
                    <div class="form-group m-t-40">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Username" name="us"> </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" placeholder="Password" name="pw"></div>
                    </div>

                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit" name="submit">Log In</button>
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <?php echo $footer;?>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- jQuery -->
    <script src="<?php echo $site;?>asts/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo $site;?>asts/bootstrap/dist/js/tether.min.js"></script>
    <script src="<?php echo $site;?>asts/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo $site;?>asts/plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="<?php echo $site;?>asts/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="<?php echo $site;?>asts/js/query.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?php echo $site;?>asts/js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="<?php echo $site;?>asts/js/custom.min.js"></script>
    <!--Style Switcher -->
    <script src="<?php echo $site;?>asts/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    </body>

    </html>