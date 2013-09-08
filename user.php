<html>
    <head>
        <title>pet4web</title>
        <link rel="stylesheet" type="text/css" href="css/scr_layout.css"  media="screen" />
		<link rel="stylesheet" type="text/css" href="css/scr_style.css"  media="screen" />
		<?php
        require_once 'util.php';
        session_start();
		?>
    </head>
    <body>

		<div id="wrap_top">
			<?php include "top.php";?>
		</div>
			
        <div id="wrapper">
            <div id="banner">
                <?php include "banner.php";?>            
            </div>
            <div id="content">
				<?php
                    // define a section value
                    if(isset($_GET['section']))
                        $section = $_GET['section'];
                    else
                        $section ='default';
                    
                    include "userContent.php";
                ?>
            </div>
       </div>
		<div id="wrap_footer">
			<div id="footer">
				<?php include "footer.php";?>
			</div>
		</div>
    </body>
</html>
