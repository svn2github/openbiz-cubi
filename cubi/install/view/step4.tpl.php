<div class="container">

    <div class="left left_style_a">
        <img src="images/icon_step_00.jpg" />
    </div>

<div class="right right_style_a" style="padding-top:25px;">
	<h2>Installation Completed</h2>
    <p>
    Congratulations for completing Openbiz Cubi Setup Wizard. <br />
    <img src="../themes/default/images/icon_alert.gif" align='top'/> For security reason, <b>we strongly recommend you to delete install folder and remove write permission on applicaiton.xml now.</b><br />
    And also please change default login info before use.
    </p>
    <h4>Default Login Info</h4>
    <p>    
     Username : <strong>admin</strong><br />
     Password : <strong>admin</strong><br />
    </p>    
    <h4>User Reference Doucments</h4>
    
    <ul class="list">
    <li><a href="http://code.google.com/p/openbiz-cubi/" target="_blank">Openbiz Cubi web site</a></li>
    <li><a href="http://code.google.com/p/openbiz-cubi/wiki/CubiCoreConcepts" target="_blank">Openbiz Cubi reference guide</a></li>
    </ul>

    <a href="../index.php/user/login/do" class='button_w_highlight'>Launch Openbiz Cubi</a>

</div>

</div>
<script>//setTimeout("location.href='../index.php/user/login/do'",10000)</script>
<?php
$lockfile =  (dirname(dirname(dirname(__FILE__))).'/files/install.lock');
file_put_contents($lockfile, '1');
?>