<div class="container">


	<div class="step_4">
		<div style="padding-left:330px;padding-top:65px;width:500px;">
		
			<table style="padding-bottom:20px;">
				<tr>
					<td style="padding-right:20px;">
						<img border="0" src="images/icon_finished.png" />
					</td>
					<td>
						<h2>Installation Completed</h2>
					    <p>
					    Congratulations for completing Openbiz Cubi Setup Wizard. <br />
					    For security reason, <strong style="color:#666666;">we strongly recommend you to delete install folder and remove write permission on applicaiton.xml now.</strong><br />
					    And also please change default login info before use.
					    </p>
					</td>
				</tr>
			</table>
			
		    <table style="padding-bottom:25px;">
				<tr>
					<td style="padding-right:80px;">
						<h4 style="font-size:18px;">Default Login Info</h4>
					    <p style="padding-bottom:0px;">    
					     Username : <strong style="color:#ff0000;">admin</strong><br />
					     Password : <strong style="color:#ff0000;">admin</strong><br />
					    </p>  
					</td>
					<td>
						<a href="../index.php/user/login" class='btn_highlight' style="text-align:center">Ready Go<span>Login to Openbiz Cubi</span></a>
					</td>
				</tr>
			</table>
		    
		      
		    <h4 style="font-size:18px;">Reference Doucments</h4>
		    
		    <ul class="list">
		    <li><a href="http://www.openbiz.me/" target="_blank">Openbiz Cubi International Website</a></li>
		    <li><a href="http://www.openbiz.cn/" target="_blank">Openbiz Cubi Chinese Website</a></li>
		    <li><a href="http://www.openbiz.web.id/" target="_blank">Openbiz Cubi Indonesia Website</a></li>
		    <li><a href="http://code.google.com/p/openbiz-cubi/" target="_blank">Openbiz Cubi Google Project</a></li>
		    <li><a href="http://code.google.com/p/openbiz-cubi/wiki/CubiCoreConcepts" target="_blank">Openbiz Cubi Reference Guide</a></li>
		    
		    </ul>
		
		
		</div>
	</div>

</div>
<script>//setTimeout("location.href='../index.php/user/login/do'",10000)</script>
<?php
$lockfile =  (dirname(dirname(dirname(__FILE__))).'/files/install.lock');
file_put_contents($lockfile, '1');
?>