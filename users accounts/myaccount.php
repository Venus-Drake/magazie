<HTML>
    <HEAD>
        <link rel="stylesheet" href="\ramira\magazie\styles.css">
        <STYLE>
            .formularSUGESTII
	        {
			    WIDTH: 35%;
				HEIGHT: 0%;
				MARGIN-LEFT: 2vw;
				MARGIN-TOP: 20.8vw;
				BACKGROUND-COLOR: RGBA(255,255,255);
				COLOR: RGB(102,252,3);
				POSITION: FIXED;
				DISPLAY: none;
				BORDER: 1PX SOLID RGB(102,252,3);
				BORDER-RADIUS: 20px;
				TEXT-ALIGN: CENTER;
				ANIMATION: POP-LOAD 0.1s FORWARDS,
	                       BORDER-BLINK 0.75s INFINITE LINEAR;
	        }
	        .chestionar,.ziar
	        {
			    WIDTH: 90%;
				HEIGHT: 0%;
				MARGIN-LEFT: 4vw;
				MARGIN-TOP: 3.5vh;
				BACKGROUND-COLOR: RGBA(255,255,255);
				POSITION: FIXED;
				DISPLAY: none;
				BORDER: 1PX SOLID RGB(102,252,3);
				BORDER-RADIUS: 20px;
				ANIMATION: NEWS-LOAD 0.1s FORWARDS,
	                       BORDER-BLINK 0.75s INFINITE LINEAR;
            }
	        .statusBUTTON
	        {
			    BORDER-RADIUS: 20px;
				WIDTH: 0.5vw;
				HEIGHT: 0.5vw;
				BORDER: 2px SOLID BLACK;
				BACKGROUND-COLOR: red;
				MARGIN-LEFT: 1vw;
            }
	        @KEYFRAMES POP-LOAD
			{
			    FROM{HEIGHT: 0%;}
			    TO{HEIGHT: 40%;}
			}
			@KEYFRAMES NEWS-LOAD
			{
			    FROM{HEIGHT: 0%;}
			    TO{HEIGHT: 78%;}
			}
			@KEYFRAMES BORDER-BLINK
			{
			    FROM { BORDER-COLOR: TRANSPARENT; }
	      		TO { BORDER-COLOR: RGBA(102.252.3); }
			}
        </STYLE>
    </HEAD>
    <BODY>
		<?php
		    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/header.php';
		    global $genDB; global $genName; global $oldpass; global $newPASS; global $newpassrepeat;global $desfasuratorDEV;
		    if(isset($_GET['nume']) && !empty($_GET['nume'])) 
			{
				$nume = $_GET['nume'];
				if(isset($_GET['userid']) && !empty($_GET['userid'])) $user = $_GET['userid'];
				else echo "<SCRIPT>window.location = '/ramira/magazie/index.php/';</SCRIPT>";
			}
			if(isset($_POST['update_process']) && !empty($_POST['update_process']))
			{
				$updatePROCESS = $_POST['update_process'];
			    require $_SERVER['DOCUMENT_ROOT'].'\ramira\magazie\connect.inc.php';
			    $datetime = date('Y-m-d h:i:s', time());
			    $azi = date('Y-m-d', time());
			    $acum = date('h:i', time());
			    $chkarhive = "SELECT `schimbariEFECTUATE` FROM `arhiva_dezvoltare` WHERE DATE(`data`) = '$azi'";
			    if($chkarhiveRUN = mysql_query($chkarhive))
			    {
				    if(mysql_num_rows($chkarhiveRUN) > 0)
				    {
					    $chkarhiveROW = mysql_fetch_assoc($chkarhiveRUN);
					    $schimbare = $chkarhiveROW['schimbariEFECTUATE'];
					    $updatePROCESS = '<b>'.$acum.'</b> - '.$updatePROCESS.'<BR>'.$schimbare;
					    $update = "UPDATE `arhiva_dezvoltare` SET `schimbariEFECTUATE` = '$updatePROCESS', `data` = '$datetime' WHERE DATE(`data`) = '$azi'";
						if($updateRUN = mysql_query($update))
						{
							$readUPDATES = "SELECT * FROM `arhiva_dezvoltare` ORDER BY `data` DESC";
							if($readUPDATESrun = mysql_query($readUPDATES))
							{
							    if(mysql_num_rows($readUPDATESrun) > 0)
							    {
									$desfasuratorDEV = '<DIV><TABLE STYLE = "WIDTH: 99%; FONT-SIZE: 0.9vw; BORDER: 2px SOLID BLACK; MARGIN: 0 AUTO; MARGIN-TOP: 1VW;">
		                                                <TH STYLE = "FONT-SIZE: 1.2VW; FONT-WEIGHT: BOLD; WIDTH: 20%; BORDER: 1px SOLID BLACK;">DATA</TH>
										  				<TH STYLE = "FONT-SIZE: 1.2VW; FONT-WEIGHT: BOLD; BORDER: 1px SOLID BLACK;">OPERATIUNI DE DEZVOLTARE EFECTUATE</TH><TR>';
								    while($readUPDATESrow = mysql_fetch_assoc($readUPDATESrun))
								    {
										$updateDATA = date('d M Y - H:i',strtotime($readUPDATESrow['data']));
									    $updateREAD = $readUPDATESrow['schimbariEFECTUATE'];
									    $desfasuratorDEV = $desfasuratorDEV.'<TD STYLE = "FONT-SIZE: 0.7VW; BORDER: 1px SOLID BLACK;">'.$updateDATA.'</TD>
										                                       <TD STYLE = "FONT-SIZE: 0.7VW; BORDER: 1px SOLID BLACK; TEXT-ALIGN: LEFT;">'.$updateREAD.'</TD><TR>';
								    }
								    $desfasuratorDEV = $desfasuratorDEV.'</TABLE></DIV>';
							    }
							}
							else
							{
								$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
								require 'C:\xampp\htdocs\ramira\magazie\error.handler.php';
							}
		                }
						else
						{
							$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
							require 'C:\xampp\htdocs\ramira\magazie\error.handler.php';
						}
				    }
				    else
				    {
						$updatePROCESS = '<b>'.$acum.'</b> - '.$updatePROCESS;
					    $update = "INSERT INTO `arhiva_dezvoltare` VALUES('','$updatePROCESS','$datetime')";
						if($updateRUN = mysql_query($update))
						{
							$readUPDATES = "SELECT * FROM `arhiva_dezvoltare` ORDER BY `data` DESC";
							if($readUPDATESrun = mysql_query($readUPDATES))
							{
							    if(mysql_num_rows($readUPDATESrun) > 0)
							    {
									$desfasuratorDEV = '<DIV><TABLE STYLE = "WIDTH: 99%; FONT-SIZE: 0.9vw; BORDER: 2px SOLID BLACK; MARGIN: 0 AUTO; MARGIN-TOP: 1VW;">
		                                                <TH STYLE = "FONT-SIZE: 1.2VW; FONT-WEIGHT: BOLD; WIDTH: 20%; BORDER: 1px SOLID BLACK;">DATA</TH>
										  				<TH STYLE = "FONT-SIZE: 1.2VW; FONT-WEIGHT: BOLD; BORDER: 1px SOLID BLACK;">OPERATIUNI DE DEZVOLTARE EFECTUATE</TH><TR>';
								    while($readUPDATESrow = mysql_fetch_assoc($readUPDATESrun))
								    {
										$updateDATA = date('d M Y - H:i',strtotime($readUPDATESrow['data']));
									    $updateREAD = $readUPDATESrow['schimbariEFECTUATE'];
									    $desfasuratorDEV = $desfasuratorDEV.'<TD STYLE = "FONT-SIZE: 0.7VW; BORDER: 1px SOLID BLACK;">'.$updateDATA.'</TD>
										                                       <TD STYLE = "FONT-SIZE: 0.7VW; BORDER: 1px SOLID BLACK; TEXT-ALIGN: LEFT;">'.$updateREAD.'</TD><TR>';
								    }
								    $desfasuratorDEV = $desfasuratorDEV.'</TABLE></DIV>';
							    }
							}
							else
							{
								$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
								require 'C:\xampp\htdocs\ramira\magazie\error.handler.php';
							}
		                }
						else
						{
							$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
							require 'C:\xampp\htdocs\ramira\magazie\error.handler.php';
						}
				    }
			    }
			    else
				{
					$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
					require 'C:\xampp\htdocs\ramira\magazie\error.handler.php';
				}
			}
			else
			{
				require 'C:\xampp\htdocs\ramira\magazie\connect.inc.php';
			    $readUPDATES = "SELECT * FROM `arhiva_dezvoltare` ORDER BY `data` DESC";
				if($readUPDATESrun = mysql_query($readUPDATES))
				{
				    if(mysql_num_rows($readUPDATESrun) > 0)
				    {
						$desfasuratorDEV = '<DIV><TABLE STYLE = "WIDTH: 99%; FONT-SIZE: 0.9vw; BORDER: 2px SOLID BLACK; MARGIN: 0 AUTO; MARGIN-TOP: 1VW;">
                                                <TH STYLE = "FONT-SIZE: 1.2VW; FONT-WEIGHT: BOLD; WIDTH: 20%; BORDER: 1px SOLID BLACK;">DATA</TH>
								  				<TH STYLE = "FONT-SIZE: 1.2VW; FONT-WEIGHT: BOLD; BORDER: 1px SOLID BLACK;">OPERATIUNI DE DEZVOLTARE EFECTUATE</TH><TR>';
					    while($readUPDATESrow = mysql_fetch_assoc($readUPDATESrun))
					    {
							$updateDATA = date('d M Y - H:i',strtotime($readUPDATESrow['data']));
						    $updateREAD = $readUPDATESrow['schimbariEFECTUATE'];
						    $desfasuratorDEV = $desfasuratorDEV.'<TD STYLE = "FONT-SIZE: 0.7VW; BORDER: 1px SOLID BLACK;">'.$updateDATA.'</TD>
							                                       <TD STYLE = "FONT-SIZE: 0.7VW; BORDER: 1px SOLID BLACK; TEXT-ALIGN: LEFT;">'.$updateREAD.'</TD><TR>';
					    }
					    $desfasuratorDEV = $desfasuratorDEV.'</TABLE></DIV>';
				    }
				}
				else
				{
					$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
					require 'C:\xampp\htdocs\ramira\magazie\error.handler.php';
				}
			}
			if(isset($_POST['genderSELECT']) && $_POST['genderSELECT'] != '')
			{
				$gender = $_POST['genderSELECT'];
				require 'C:\xampp\htdocs\ramira\magazie\connect.inc.php';
			    $genCHK = "SELECT `gender`, `nivel_ACCES` FROM `utilizatori` WHERE `username` = '$user'";
			    if($genRUN = mysql_query($genCHK))
			    {
				    if(mysql_num_rows($genRUN) > 0)
				    {
					    $genROW = mysql_fetch_assoc($genRUN);
					    $genDB = $genROW['gender'];
					    $acces = $genROW['nivel_ACCES'];
					    if($acces == "ADMIN" || $acces == "DEVELOPER") $accesDETAILS = "- vizionare rapoarte<BR>- efectuare tranzactii(eliberari produse, imprumut produse, receptionare produse, storno produse, returnari produse)<BR>- creere cont utilizator nou<BR>- recuperari parole<BR>- schimbare parola personala<BR>- modificare username utilizatori";
					    else if($acces == "USER") $accesDETAILS = "- vizionare rapoarte<BR>- efectuare tranzactii(eliberari produse, imprumut produse, receptionare produse, storno produse, returnari produse)<BR>-schimbare parola personala";
					    else if($acces == "GUEST") $accesDETAILS = "- vizionare rapoarte<BR>- schimbare parola personala";
					    if($gender != $genDB)
					    {
						    $genUPDATE = "UPDATE `utilizatori` SET `gender` = '$gender' WHERE `username` = '$user'";
						    if($genURUN = mysql_query($genUPDATE))
						    {
							    if($gender == 0) $genName = 'Feminin';
							    else if($gender == 1) $genName = 'Masculin';
							    else if($gender == 2) $genName = 'Nu conteaza';
						    }
						    else
							{
								$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
								require 'C:\xampp\htdocs\ramira\magazie\error.handler.php';
							}
					    }
				    }
				    else echo '<SCRIPT>alert("No data found for '.$user.'");</SCRIPT>';
			    }
                else
				{
					$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
					require 'C:\xampp\htdocs\ramira\magazie\error.handler.php';
				}
			}
			else
			{
			    require 'C:\xampp\htdocs\ramira\magazie\connect.inc.php';
				$userDATA = "SELECT `gender`, `nivel_ACCES` FROM `utilizatori` WHERE `username` = '$user'";
				if($userDATArun = mysql_query($userDATA))
				{
				    if(mysql_num_rows($userDATArun) > 0)
				    {
					    $userDATArow = mysql_fetch_assoc($userDATArun);
					    $gender = $userDATArow['gender'];
					    $acces = $userDATArow['nivel_ACCES'];
					    if($acces == "ADMIN" || $acces == "DEVELOPER") $accesDETAILS = "- vizionare rapoarte<BR>- efectuare tranzactii(eliberari produse, imprumut produse, receptionare produse, storno produse, returnari produse)<BR>- creere cont utilizator nou<BR>- recuperari parole<BR>- schimbare parola personala<BR>- modificare username utilizatori";
					    else if($acces == "USER") $accesDETAILS = "- vizionare rapoarte<BR>- efectuare tranzactii(eliberari produse, imprumut produse, receptionare produse, storno produse, returnari produse)<BR>-schimbare parola personala";
					    else if($acces == "GUEST") $accesDETAILS = "- vizionare rapoarte<BR>- schimbare parola personala";
				    }
				    else echo '<SCRIPT>alert("No data found for '.$user.'");</SCRIPT>';
				}
                else
				{
					$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
					require 'C:\xampp\htdocs\ramira\magazie\error.handler.php';
				}
			}
		    require 'C:\xampp\htdocs\ramira\magazie\header.php';
			require 'C:\xampp\htdocs\ramira\magazie\meniu.principal.php';
			if($gender == 0) $genName = 'Feminin';
		    else if($gender == 1) $genName = 'Masculin';
		    else if($gender == 2) $genName = 'Nu conteaza';
		    
		    //SCHIMBAM PAROLA
		    if(isset($_POST['oldpass']) && isset($_POST['newpass']) && isset($_POST['newpassrepeat']) && !empty($_POST['oldpass']) && !empty($_POST['newpass']) && !empty($_POST['newpassrepeat']) && $_POST['newpass'] == $_POST['newpassrepeat'] && $_POST['oldpass'] != '')
		    {
				$oldpass = $_POST['oldpass'];
				$newPASS = $_POST['newpass'];
			    $updatePass = "UPDATE `utilizatori` SET `password` = '$newPASS' WHERE `username` = '$user'";
			    if($passRUN = mysql_query($updatePass))
			    {
					$oldpass = ''; $newPASS = ''; $newpassrepeat = '';
				    echo "<SCRIPT>window.location = '/ramira/magazie/index.php/';</SCRIPT>";
			    }
			    else
				{
					$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysql_error().'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysql_error().'">warehouse-soft@ramira.ro</a>';
					require 'C:\xampp\htdocs\ramira\magazie\error.handler.php';
				}
		    }
		
		?>
		<DIV CLASS = "LEFT_BAR" STYLE = "WIDTH: 99.3%; HEIGHT: 78%; MARGIN-TOP: 3.5VH;">
		    <BR>
		    <DIV>
			    <FORM ID = "passCHANGER" METHOD = "POST" STYLE = "MARGIN-LEFT: 2VW; FLOAT: LEFT; WIDTH: 26vw">
			        Schimba parola:<BR>
			        <INPUT TYPE = "PASSWORD" ID = "oldpass" NAME = "oldpass" REQUIRED PLACEHOLDER = "PAROLA VECHE" STYLE = "HEIGHT: 2VW; WIDTH: 15VW; FONT-SIZE: 1.2VW; BORDER-RADIUS: 10PX; MARGIN-TOP: 0.5VW; FONT-WEIGHT: BOLD; TEXT-ALIGN: CENTER;" ONCHANGE = "checkOldINPUT();" VALUE = <?php echo $oldpass?>></INPUT><DIV ID = "opWARNING" STYLE = "FLOAT: RIGHT;HEIGHT: 2VW; MARGIN-TOP: 0.5VW; WIDTH: 10.6vw; FONT-SIZE: 1vw; LINE-HEIGHT: 2vw"></DIV><INPUT ID = "userNAME" STYLE = "WIDTH: 0; HEIGHT: 0; BACKGROUND-COLOR: TRANSPARENT; BORDER: 0;" VALUE = "<?php echo $user;?>"></INPUT><BR>
			        <INPUT TYPE = "PASSWORD" ID = "newpass" NAME = "newpass" REQUIRED PLACEHOLDER = "PAROLA NOUA" STYLE = "HEIGHT: 2VW; WIDTH: 15VW; FONT-SIZE: 1.2VW; BORDER-RADIUS: 10PX; MARGIN-TOP: 0.5VW; FONT-WEIGHT: BOLD; TEXT-ALIGN: CENTER;" ONKEYDOWN = "return /[a-z0-9]/i.test(event.key)" ONKEYUP = "checkNewINPUT();" ONCHANGE = "comparePasswords();" VALUE = "<?php echo $newPASS?>" MINLENGTH = "8" MAXLENGTH = "16"></INPUT><DIV ID = "npWARNING" STYLE = "FLOAT: RIGHT;HEIGHT: 2VW; MARGIN-TOP: 0.5VW; WIDTH: 10.6vw; FONT-SIZE: 1vw; LINE-HEIGHT: 1vw">8 - 16 caractere<BR>(doar litere si cifre)</DIV><BR>
			        <INPUT TYPE = "PASSWORD" ID = "newpassrepeat" NAME = "newpassrepeat" REQUIRED PLACEHOLDER = "REPETA PAROLA NOUA" STYLE = "HEIGHT: 2VW; WIDTH: 15VW; FONT-SIZE: 1.2VW; BORDER-RADIUS: 10PX; MARGIN-TOP: 0.5VW; FONT-WEIGHT: BOLD; TEXT-ALIGN: CENTER;" ONKEYDOWN = "return /[a-z0-9]/i.test(event.key)" ONFOCUS = "checkNewINPUTrepeat();" ONKEYUP = "checkNewINPUTrepeat();" ONCHANGE = "compareRepeat();" VALUE = "<?php echo $newpassrepeat?>" MINLENGTH = "8" MAXLENGTH = "16"></INPUT><DIV ID = "nprWARNING" STYLE = "FLOAT: RIGHT;HEIGHT: 2VW; MARGIN-TOP: 0.5VW; WIDTH: 10.6vw; FONT-SIZE: 1vw; LINE-HEIGHT: 2vw">8 - 16 caractere</DIV><BR>
			        <FONT STYLE = "FONT-SIZE: .7vw;">(Schimbarea parolei va deloga actualul utilizator, necesitand relogare!)</FONT><BR>
			        <BUTTON ID = "validator" ONCLICK = "validareParola();" STYLE = "BACKGROUND-COLOR: ORANGE; HEIGHT: 2VW; FONT-WEIGHT: BOLD; MARGIN-TOP: 0.5VW;">Schimba!</BUTTON>
			    </FORM><BR>
			    <BUTTON STYLE = "BACKGROUND-COLOR: ORANGE; HEIGHT: 2VW; WIDTH: 20vw; FONT-WEIGHT: BOLD; MARGIN-TOP: 0.5VW; MARGIN-LEFT: 2VW;" ONCLICK = "formularSUGESTII();">Am o sugestie / Am gasit o eroare!!</BUTTON><BR>
                <BUTTON STYLE = "BACKGROUND-COLOR: ORANGE; HEIGHT: 2VW; WIDTH: 20vw; FONT-WEIGHT: BOLD; MARGIN-TOP: 0.5VW; MARGIN-LEFT: 2VW;" ONCLICK = "chestionarul();">Chestionarul zilei</BUTTON><BR>
                <BUTTON STYLE = "BACKGROUND-COLOR: ORANGE; HEIGHT: 2VW; WIDTH: 20vw; FONT-WEIGHT: BOLD; MARGIN-TOP: 0.5VW; MARGIN-LEFT: 2VW;" ONCLICK = "ziarulZILEI();">Ziarul de dimineata ;)</BUTTON>
                <?php
				    if($acces == 'DEVELOPER' || $acces == 'ADMIN')echo '<BR><BUTTON STYLE = "BACKGROUND-COLOR: ORANGE; HEIGHT: 2VW; WIDTH: 20vw; FONT-WEIGHT: BOLD; MARGIN-TOP: 0.5VW; MARGIN-LEFT: 2VW;" ONCLICK = "analizaCHESTIONAR();">Analiza chestionare</BUTTON><BR><BUTTON STYLE = "BACKGROUND-COLOR: ORANGE; HEIGHT: 2VW; WIDTH: 20vw; FONT-WEIGHT: BOLD; MARGIN-TOP: 0.5VW; MARGIN-LEFT: 2VW;" ONCLICK = "mailingLIST();">Mailing list</BUTTON>';
				?>
		    </DIV>
		    <DIV>
			    <FORM METHOD = "POST" STYLE = "MARGIN-LEFT: 2.5VW; FLOAT: LEFT; WIDTH: 26vw">
			        Sex: &nbsp
			        <SELECT NAME = "genderSELECT" ONCHANGE = "this.form.submit()" STYLE = "HEIGHT: 2VW; WIDTH: 15VW; FONT-SIZE: 1.2VW; BORDER-RADIUS: 10PX; FONT-WEIGHT: BOLD; TEXT-ALIGN: CENTER;">
			            <OPTION VALUE = <?php echo $genDB;?>><?php echo $genName;?></OPTION>
			            <OPTION VALUE = 0>Feminin</OPTION>
			            <OPTION VALUE = 1>Masculin</OPTION>
			            <OPTION VALUE = 2>Nu conteaza</OPTION>
					</SELECT><BR><BR>
					<DIV>Nivel de acces:&nbsp&nbsp</DIV><DIV ID = "accesLEVEL"><?php echo ucfirst(strtolower($acces));?></DIV><BR><DIV ID = "numeUSER"><?php echo $nume;?></DIV>
			        <DIV><FONT STYLE = "FONT-SIZE: .7vw;">(<?php echo $accesDETAILS?>)</FONT></DIV>
			    </FORM>
		    </DIV>
		    <DIV STYLE = "WIDTH: 35vw; HEIGHT: 95%; MARGIN-LEFT: 2.5VW;">
		        <CENTER>Procesul de dezvoltare a programului<BR><BR>
		        <?php
		            if($acces == "DEVELOPER")
		            {
					    echo '
						<FORM METHOD = "POST">
						    <TEXTAREA NAME = "update_process" STYLE = "RESIZE: NONE; WIDTH: 33VW; FONT-SIZE: .9VW; HEIGHT: 20%; FONT-FAMILY: ARIAL;"></TEXTAREA><BR>
						    <BUTTON STYLE = "BACKGROUND-COLOR: ORANGE; HEIGHT: 4%; FONT-WEIGHT: BOLD; MARGIN-TOP: 0.5VW;" ID = "insertDEVELOPING">Adauga</BUTTON><BR>
						</FORM>';
                    }
                    if($desfasuratorDEV != '') 
					{
						echo '<DIV STYLE = "OVERFLOW: AUTO; BACKGROUND-COLOR: WHITE; BORDER-TOP-LEFT-RADIUS: 20px;BORDER-BOTTOM-LEFT-RADIUS: 20px; BORDER: 2px SOLID RGBA(0,73,123); HEIGHT:';
						if($acces == "DEVELOPER") echo '60%;';
						else echo '75%;';
						echo ' MARGIN: 0 AUTO;">'.$desfasuratorDEV.'</DIV>';
					}
				?>
		    </DIV>
		</DIV>
		<DIV ID = "chestionar" CLASS = "chestionar">
		    <?php require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/users accounts/chestionar_1.php';?>
		</DIV>
		<DIV ID = "ziar" CLASS = "ziar">
		    <?php require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/users accounts/newspaper.php';?>
		</DIV>
		<DIV ID = "analiza" CLASS = "ziar">
		    <?php require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/users accounts/analiza.chestionar.php';?>
		</DIV>
		<DIV ID = "mailLIST" CLASS = "ziar">
		    <?php require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/users accounts/mailing.list.php';?>
		</DIV>
		<DIV ID = "formularSUGESTII" CLASS = "formularSUGESTII">
		    <TEXTAREA ID = "sugestieINPUT" PLACEHOLDER = "INTRODUCETI SUGESTIA DUMNEAVOASTRA" STYLE = "RESIZE: NONE; WIDTH: 33VW; FONT-SIZE: .9VW; HEIGHT: 4vw; FONT-FAMILY: ARIAL; TEXT-ALIGN: CENTER; MARGIN-TOP: .5vw;"></TEXTAREA><BR>
		    <BUTTON STYLE = "BACKGROUND-COLOR: ORANGE; HEIGHT: 2VW; FONT-WEIGHT: BOLD; MARGIN-TOP: 0.5VW; MARGIN-LEFT: 1vw;" ONCLICK = "adaugaSUGESTIE();">Adauga</BUTTON><BR><BR>
		    <DIV STYLE = "BORDER: 2px SOLID RGBA(0,73,123); BORDER-BOTTOM-LEFT-RADIUS: 20px; BORDER-BOTTOM-RIGHT-RADIUS: 20px; HEIGHT: 11.2vw; WIDTH: 33vw; MARGIN: 0 AUTO; COLOR: BLACK; TEXT-ALIGN: LEFT; MARGIN-LEFT: 0.9vw; OVERFLOW: AUTO;">
		        <TABLE ID = "sugestionsTABLE" STYLE = "WIDTH: 99%; FONT-SIZE: 0.9vw; BORDER: 2px SOLID BLACK; MARGIN: 0 AUTO; MARGIN-TOP: 1VW;">
          		    <TH STYLE = "FONT-SIZE: 1VW; FONT-WEIGHT: BOLD; WIDTH: 80%; BORDER: 1px SOLID BLACK;">SUGESTIE / RAPORT</TH>
  					<TH STYLE = "FONT-SIZE: 1VW; FONT-WEIGHT: BOLD; BORDER: 1px SOLID BLACK;">STATUS</TH><TR>
			</DIV>
		</DIV>


		<SCRIPT src='/ramira/magazie/main.script.js'></SCRIPT>
		<SCRIPT src='/ramira/magazie/users accounts/users.js'></SCRIPT>
		<SCRIPT TYPE = "text/javascript">
			window.onload=function()
			{
				display_ct();
			}
	    </SCRIPT>
    </BODY>
</HTML>