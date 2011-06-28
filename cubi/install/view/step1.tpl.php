<div class="container">
    <div class="left left_style_b">
        <img src="images/icon_step_01.jpg" />
        <h2>System Check</h2>
    </div>

	<div class="right right_style_b">
        <p>
        Please make sure the status of all necessary system component have installed before you click "Next" button,
        otherwise the application might would not work properly.
        </p>
        <table class="form_table" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:20px;">
        <tr>
            <th>Item</th>
            <th>Value</th>
            <th>Status</th>
        </tr>
        <?php
        $status = getSystemStatus();
        $i=0;
		$hasError = false;
        foreach ($status as $s) {
            if(fmod($i,2)){
                $default_style="even";
            }else{
                $default_style="odd";
            }
            
            if (strpos($s['status'],'OK') === 0) {
                $flag_icon="flag_y.gif";        
            }else{
                $flag_icon="flag_n.gif";
				$hasError = true;
            }
             $i++;
        ?>
        <tr
            class="<?php echo $default_style;?>"
            onmouseover="if(this.className!='selected')this.className='hover'" 
            onmouseout="if(this.className!='selected')this.className='<?php echo $default_style;?>'" 
        >
            <td><?php echo $s['item'];?></td>
            <td><?php echo $s['value'];?></td>
            <td><img src="../themes/default/images/<?php echo $flag_icon;?>" /></td>
        </tr>
        <?php
        }
        ?>
        </table>
        
        <a href="index.php?step=0" class="button">&lt; Back</a>
        <?php 
		if (!$hasError){
		?>
    	    <a href="index.php?step=2" class="button_highlight">Next &gt;</a>
        <?php
		}else{
		?>
	        <a href="index.php?step=1" class="button_m_highlight">Check Again</a>
        <?php
		}
		?>

	</div>
<div id="error_message" class="popup_dialog" onclick="this.style.display='none';"></div>
</div>
</div>



