<SCRIPT src='/ramira/magazie/main.script.js'></SCRIPT>
<?php global $mailerror; global $warning; global $alert_bon;?>
<DIV id="myModal" class="modal"><BR><BR><BR><BR><BR>
    <DIV class="modal-content" <?php if($mailerror != '') echo 'style = "background-color: red; color: white; font-weight: bold;"';
                                     else if($warning != '') echo 'style = "background-color: yellow; font-weight: bold;"';
			             			 else if($alert_bon != '') echo 'style = "background-color: white; font-weight: bold;"'?>>
        <span ID="close" CLASS = "close">&times;</span><CENTER><?php if($mailerror != '')echo $mailerror;
                                                                     else if($warning != '') echo $warning;
										 							 else if($alert_bon != '') echo $alert_bon;?><BR><BR>
        <?php
    	    if($mailerror != '' || $warning != '') echo '<BUTTON ID = "setoff" CLASS = "setoff"><B>Inchide</BUTTON>&nbsp&nbsp<BUTTON ID = "setsend" CLASS = "setoff"><B>Trimite</BUTTON></CENTER>';
      		else if($alert_bon != '') echo '<BUTTON ID = "setoff_bon" CLASS = "setoff"><B>Ignora</BUTTON>&nbsp&nbsp<BUTTON ID = "agreed_bon" CLASS = "agreed_bon" VALUE = '.$marcachk.'><B>Accept</BUTTON></CENTER>';
        ?>
    </DIV>
	<BR><BR>
</DIV>

<?php
    if($mailerror != '' || $warning != '' || $alert_bon != '') 
	{
		echo '<SCRIPT>modalShow();</SCRIPT>';
	}
	else echo 'Error: '.$mailerror.'<BR>Warning: '.$warning.'<BR>Alert: '.$alert_bon;
?>
<SCRIPT src='/ramira/magazie/main.script.js'></SCRIPT>



