<div class="container">

    <div class="left left_style_a">
        <img src="images/icon_step_00.jpg" />
    </div>

<div class="right right_style_a" style="padding-top:25px;">
	<h2>Installation Completed</h2>
    <p>
    Congratulations for completing Openbiz Cubi Setup Wizard. <br />
    For security reason, we strongly recommend you to delete this install folder now.<br />
    And also please change default login info before use.
    </p>
    <h4>Default Login Info</h4>
    <p>    
     Username : <strong>admin</strong><br />
     Password : <strong>admin</strong><br />
    </p>    
    <h4>User Reference Doucments</h4>
    
    <ul class="list">
    <li><a href="https://docs.google.com/leaf?id=0By0aXVMRD-nCNjE5NGZiZWItNjQ2ZC00N2JkLWI5OTYtOTg4Nzk0ZDQzYmEy&hl=en" target="_blank">Openbiz Cubi Guide</a></li>
    <li><a href="https://docs.google.com/leaf?id=0By0aXVMRD-nCMTFmZjBjMmQtNzBhOC00YWFjLThmMTQtZjBkNDg4ZjFjNTI2&hl=en" target="_blank">Openbiz Framework Guide</a></li>
    </ul>

    <a href="../index.php/user/login" class='button_w_highlight'>Launch Openbiz Cubi</a>

</div>

</div>
<script>//setTimeout("location.href='../index.php/user/login'",10000)</script>
<?php
$lockfile =  (dirname(dirname(dirname(__FILE__))).'/install.lock');
file_put_contents($lockfile, '1');
?>