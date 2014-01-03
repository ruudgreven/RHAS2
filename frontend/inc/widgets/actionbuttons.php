<?php
  $iNumberOfButtons = sizeof($aContent);
  
  if ($iNumberOfButtons < 4) {
    $iSize = 4;
  } else {
    $iSize = $iNumberOfButtons;
  }
?>

<html>
<head>
  <meta application-name="RHAS2 Action Buttons" data-allows-resizing="NO" data-default-size="<?php echo $iSize ?>,1" data-min-size="<?php echo $iSize ?>,1" data-max-size="<?php echo $iSize ?>,1" data-allows-scrolling="NO" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
	<meta http-equiv="Cache-control" content="no-cache" />
	
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<style type="text/css">
	  /* RESET */
	  @font-face {
			font-family: "Roadgeek2005SeriesD";
			src: url("http://panic.com/fonts/Roadgeek 2005 Series D/Roadgeek 2005 Series D.otf");
		}
			
		body, * {
			
		}
		
		body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td { 
			margin: 0;
			padding: 0;
		}
		
		fieldset,img { 
				border: 0;
		}
				
		/* Style properties */
		html, body, #main {
			overflow: hidden; /* */
		}
			
		body {
			color: white;
			font-family: 'Roadgeek2005SeriesD', sans-serif;
			font-size: 20px;
			line-height: 24px;
		}
		body, html, #main {
			background: transparent !important;
		}
		
		.button {
		  height: 58px;
		  width: 58px;
		  padding-left: 2px;
		  padding-right: 2px;
		  text-align: center;
		  float: left;
		}
		
		.button I {
		  margin-top: 3px;
		  font-size: 50px;
		}
		
		.button IMG {
		  margin-top: 3px;
		  height: 50px;
		}
		
		.button-red {
		  background-color: #FF3000;
		}
		.button-green {
		  background-color: #00BA00;
		}
		.button-yellow {
		  background-color: #FFC600;
		}
		.button-purple {
		  background-color: #9B00C2;
		}
		.button-blue {
		  background-color: #006CE6;
		}
	</style>
	
	<script type="text/javascript">
	
	</script>
</head>
<body>
<?php foreach ($aContent as $aItem) { ?>
    <div class="button button-<?php echo $aItem["color"] ?>">
    <?php
      if (strpos($aItem['icon'], 'fa-') === 0) {
        echo "<i class=\"fa " . $aItem['icon'] . "\"></i>";
      } else {
        echo "<img src=\"widgets/icons/" . $aItem['icon'] . "\"/>";
      }
    ?>
    
    </div>
<?php } ?>
</body>
</html>