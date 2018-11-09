<html>
	<head>
	<title>PAR4DIGMA #2</title>
		<link rel="stylesheet" href="../fase2/compiled/flipclock.css">
		<link rel="shortcut icon" href="Logo_Semen_Indonesia.JPG">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

                <script src="../fase2/compiled/flipclock.js"></script>
                <!--<script src="../happynewyear/compiled/firework.js"></script>-->
                <style>
                    .centered {
    margin: 0 auto;
    text-align: left;
    width: 800px;
}

/*body {
    background-color: #000000;
    margin: 0px;
    overflow: hidden;
}*/
                </style>
	</head>
	<body>
       
            <div align="center">
                <img src="Logo_Semen_Indonesia.JPG"  alt="Smiley face" style=" margin-bottom: 30px; height: 30%" > 
                      <div class="clock centered" style="position:relative;margin:2em; margin-left: 100px;"></div>
               
                      <img src="paradig.png" alt="Smiley face" style="margin-top: 10px; margin-left: -40px; height: 15%"> 
                     <h1 style="font-size: 50"> <center>GO LIVE FASE #2</center></h1><h2><center>31 Mei 2017</center></h2>
            </div>
            
		<script type="text/javascript">
			var clock;

			$(document).ready(function() {

				// Grab the current date
				var currentDate = new Date();

				// Set some date in the future. In this case, it's always Jan 1
				var futureDate  = new Date(currentDate.getFullYear() + 0, 0, 152);

				// Calculate the difference in seconds between the future and current date
				var diff = futureDate.getTime() / 1000 - currentDate.getTime() / 1000;
                                //console.log(diff);
				// Instantiate a coutdown FlipClock
				clock = $('.clock').FlipClock(diff, {
					clockFace: 'DailyCounter',
					countdown: true,
                                        callbacks:{
                                            stop: function() {
                                               // alert('mantab');
                                            }
                                        }
				});
			});
                        
                        
                    
		</script>
		
	</body>
</html>