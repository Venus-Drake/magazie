<?php

    date_default_timezone_set('Europe/Bucharest');
    $time = time();
    $datetime = date('Y-m-d h:i:s',time());
    $azi = date('Y-m-d', time());
    $acum = date('h:i', time());
    
    if(isset($_POST['command']) && !empty($_POST['command']))
    {
	    $command = $_POST['command'];
	    if($command == 'sendingMAIL')
	    {
		    if(isset($_POST['myuser']) && !empty($_POST['myuser']))
		    {
				$myuser = $_POST['myuser'];
			    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
				$que = "UPDATE `mails2send` SET `sent` = '1' WHERE `userNAME` = '$myuser'";
				if($run = mysql_query($que))
				{
				    if(mysql_affected_rows() > 0) 
					{
						$chk = "SELECT `mailID`, `sent` FROM `mails2send` ORDER BY `sent` ASC";
						if($chkRUN = mysql_query($chk))
						{
						    echo 'OK';
						    if(mysql_num_rows($chkRUN) > 0)
						    {
								$chkROW = mysql_fetch_assoc($chkRUN);
								$mailID = $chkROW['mailID'];
								if($chkROW['sent'] == '1')
								{
								    $update = "UPDATE `mailuri` SET `sent` = '1' WHERE `nr.crt` = '$mailID'";
								    if($upRUN = mysql_query($update))
								    {
	                                    echo '^All mails sent';
								    }
								    else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
								}
						    }
						}
						else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
					}
					else echo 'Could not update '.$myuser;
				}
				else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
		    }
		    else echo 'User not set!';
	    }
	    else if($command == 'showmails')
	    {
		    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
			$que = "SELECT `nr.crt`, `subject`, `body` FROM `mailuri` WHERE `sent` = '0'";
			if($run = mysql_query($que))
			{
			    if(mysql_num_rows($run) > 0)
			    {
				    $row = mysql_fetch_assoc($run);
				    $mailID = $row['nr.crt'];
				    $subject = $row['subject'];
				    $body = $row['body'];
				    $chk = "SELECT * FROM `mails2send` WHERE `mailID` = '$mailID' ORDER BY `sent`";
				    if($chkRUN = mysql_query($chk))
				    {
					    if(mysql_num_rows($chkRUN) == 0)
					    {
						    echo 'OK';
						    $roll = "SELECT `username`, `password`, `nume`, `prenume`, `email` FROM `utilizatori` WHERE `email` != ''";
						    if($rollRUN = mysql_query($roll))
						    {
							    if(mysql_num_rows($rollRUN) > 0)
							    {
								    while($rollROW = mysql_fetch_assoc($rollRUN))
								    {
									    $accNAME = $rollROW['username'];
									    $accPASS = $rollROW['password'];
									    $preNAME = $rollROW['prenume'];
									    $mainNAME = $rollROW['nume'];
									    $fullNAME = $mainNAME.' '.$preNAME;
									    $email = $rollROW['email'];
									    $mailBODY = str_replace("%full name%",$fullNAME,$body);
									    $mailBODY = str_replace("%username%",$accNAME,$mailBODY);
									    $mailBODY = str_replace("%password%",$accPASS,$mailBODY);
									    $mailBODY = str_replace("<BR>","%0A",$mailBODY);
									    //die('^'.strlen());
									    $addMAIL = "INSERT INTO `mails2send` VALUES('','$mailID','$fullNAME','$email','$subject','$mailBODY','0')";
									    if($addRUN = mysql_query($addMAIL))
									    {
										    if(mysql_affected_rows() > 0) echo '^'.$fullNAME.'^'.$email.'^'.$subject.'^'.$mailBODY.'^0';
									    }
                                        else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
								    }
							    }
							    else echo 'No users found in DB';
						    }
						    else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
					    }
					    else
					    {
							echo 'OK';
						    while($chkROW = mysql_fetch_assoc($chkRUN))
						    {
							    $fullNAME = $chkROW['userNAME'];
							    $email = $chkROW['email'];
							    $subject = $chkROW['subject'];
							    $mailBODY = $chkROW['body'];
							    $sent = $chkROW['sent'];
							    echo '^'.$fullNAME.'^'.$email.'^'.$subject.'^'.$mailBODY.'^'.$sent;
						    }
					    }
				    }
				    else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
			    }
			    else echo 'No mail to send.';
			}
			else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
	    }
    }
	else if(isset($_POST['analiza']) && !empty($_POST['analiza']))
    {
	    $analiza = $_POST['analiza'];
	    if($analiza == 'show')
	    {
		    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
			$que = "SELECT * FROM `rezultate.chestionare` WHERE `procesat` = '0' ORDER BY `numeUSER`";
			if($run = mysql_query($que))
			{
			    if(mysql_num_rows($run) > 0)
			    {
					echo 'OK';
				    while($row = mysql_fetch_assoc($run))
				    {
					    $userNAME = $row['numeUSER'];
					    $cheNR = $row['nr.chestionar'];
					    $q1 = $row['q1'];
					    $a1 = $row['a1'];
					    $q2 = $row['q2'];
					    $a2 = $row['a2'];
					    $q3 = $row['q3'];
					    $a3 = $row['a3'];
					    $q4 = $row['q4'];
					    $a4 = $row['a4'];
					    $q5 = $row['q5'];
					    $a5 = $row['a5'];
					    $q6 = $row['q6'];
					    $a6 = $row['a6'];
					    $q7 = $row['q7'];
					    $a7 = $row['a7'];
					    $q8 = $row['q8'];
					    $a8 = $row['a8'];
					    $q9 = $row['q9'];
					    $a9 = $row['a9'];
					    $q10 = $row['q10'];
					    $a10 = $row['a10'];
					    $q11 = $row['q11'];
					    $a11 = $row['a11'];
					    echo '^'.$userNAME.'^'.$cheNR.'^'.$q1.'^'.$a1.'^'.$q2.'^'.$a2.'^'.$q3.'^'.$a3.'^'.$q4.'^'.$a4.'^'.$q5.'^'.$a5.'^'.$q6.'^'.$a6.'^'.$q7.'^'.$a7.'^'.$q8.'^'.$a8.'^'.$q9.'^'.$a9.'^'.$q10.'^'.$a10.'^'.$q11.'^'.$a11;
				    }
			    }
			    else echo 'OK^Nothing';
			}
			else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
	    }
    }
    else if(isset($_POST['alarm']) && !empty($_POST['alarm']))
    {
	    $alarm = $_POST['alarm'];
	    if($alarm == 'record')
	    {
			if(isset($_POST['user']) && !empty($_POST['user']))
			{
				$userNAME = $_POST['user'];
				if(isset($_POST['chestionar']) && !empty($_POST['chestionar']))$chestionar = $_POST['chestionar'];
				else $chestionar = 0;
				if(isset($_POST['queNR']) && !empty($_POST['queNR']))$qNR = $_POST['queNR'];
				else $qNR = 0;
				if(isset($_POST['question']) && !empty($_POST['question']))
				{
					$qTEXT = $_POST['question'];
					$qARRAY = explode("&nbsp;",$qTEXT);
					$qTEXT = $qARRAY[1];
				}
				else $qTEXT = '';
				if(isset($_POST['answer']) && !empty($_POST['answer']))$answer = $_POST['answer'];
				else $answer = '';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
				$que = "SELECT `numeUSER` FROM `rezultate.chestionare` WHERE `numeUSER` = '$userNAME' AND `nr.chestionar` = '$chestionar'";
				if($run = mysql_query($que))
				{
				    if(mysql_num_rows($run) > 0)
				    {
						$queDB = 'q'.$qNR;
						$ansDB = 'a'.$qNR;
					    $update = "UPDATE `rezultate.chestionare` SET `dataCOMPLETARE` = '$datetime', `$queDB` = '$qTEXT', `$ansDB` = '$answer', `procesat` = '0' WHERE `numeUSER` = '$userNAME' AND `nr.chestionar` = '$chestionar'";
					    if($uprun = mysql_query($update))
					    {
						    if(mysql_affected_rows() > 0) echo 'RECORDED';
							else echo __LINE__.'. RECORD FAILED';
					    }
					    else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
				    }
				    else
				    {
					    $intro = "INSERT INTO `rezultate.chestionare` VALUES('','$datetime','$chestionar','$userNAME','','','','','','','','','','','','','','','','','','','','','','','')";
					    if($introRUN = mysql_query($intro))
					    {
							$queDB = 'q'.$qNR;
							$ansDB = 'a'.$qNR;
						    $update = "UPDATE `rezultate.chestionare` SET `dataCOMPLETARE` = '$datetime', `$queDB` = '$qTEXT', `$ansDB` = '$answer', `procesat` = '0' WHERE `numeUSER` = '$userNAME' AND `nr.chestionar` = '$chestionar'";
						    if($uprun = mysql_query($update))
						    {
							    if(mysql_affected_rows() > 0) echo 'RECORDED';
								else echo __LINE__.'. RECORD FAILED';
						    }
						    else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
					    }
					    else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
				    }
				}
                else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
		    }
	    }
	    else if($alarm == 'done')
	    {
		    if(isset($_POST['user']) && !empty($_POST['user']))
			{
				$userNAME = $_POST['user'];
				if(isset($_POST['chestionar']) && !empty($_POST['chestionar']))$chestionar = $_POST['chestionar'];
				else $chestionar = 0;
				if(isset($_POST['queNR']) && !empty($_POST['queNR']))$qNR = $_POST['queNR'];
				else $qNR = 0;
				if(isset($_POST['question']) && !empty($_POST['question']))
				{
					$qTEXT = $_POST['question'];
					$qARRAY = explode("&nbsp;",$qTEXT);
					$qTEXT = $qARRAY[1];
				}
				if(isset($_POST['answer']) && !empty($_POST['answer']))$answer = $_POST['answer'];
				else $answer = '';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
		        //echo 'DONE^Heard you: user - '.$user.'; chestionar: '.$chestionar.'; question nr.: '.$qNR.'; question text: '.$qTEXT.'; user reply: '.$answer;
		        for($x = $qNR; $x < 11; $x++)
		        {
					$queDB = 'q'.$x;
					$ansDB = 'a'.$x;
					if($x > $qNR)
					{
					    $qTEXT = '';
						$answer = '';
					}
		            $update = "UPDATE `rezultate.chestionare` SET `dataCOMPLETARE` = '$datetime', `$queDB` = '$qTEXT', `$ansDB` = '$answer', `procesat` = '0' WHERE `numeUSER` = '$userNAME' AND `nr.chestionar` = '$chestionar'";
		            if($upRUN = mysql_query($update))
		            {
						
                    }
                    else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
		        }
		        echo 'DONE';
		    }
	    }
    }
    else if(isset($_POST['chestionar']) && !empty($_POST['chestionar']))
    {
		$stage = $_POST['chestionar'];
	    if($stage == "open")
	    {
		    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
		    $que = "SELECT `Q_Text`, `A_Type`, `A_Width`, `A_Height`, `A_Text` FROM `chestionare` WHERE `CHE_NR` = '1' AND `Q_NR` = '1'";
		    if($run = mysql_query($que))
		    {
			    if(mysql_num_rows($run) > 0)
			    {
					echo 'OK';
				    while($row = mysql_fetch_assoc($run))
				    {
        			    $question = $row['Q_Text'];
        			    $A_type = $row['A_Type'];
        			    $A_width = $row['A_Width'];
        			    $A_height = $row['A_Height'];
        			    $answer = $row['A_Text'];
        			    echo '^'.$question.'^'.$A_type.'^'.$A_width.'^'.$A_height.'^'.$answer;
				    }
			    }
		    }
            else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
	    }
	    else if($stage == "running")
	    {
		    if(isset($_POST['quest']) && !empty($_POST['quest']) && isset($_POST['answer']) && !empty($_POST['answer']) && isset($_POST['question']) && !empty($_POST['question']))
		    {
				$quest = $_POST['quest'];
				$answer = $_POST['answer'];
				$question = $_POST['question'];
				$index = strpos($question, '&nbsp');
				$stringoff = substr($question,0,$index+6);
				$question = str_replace($stringoff,'',$question);
			    //echo 'My answer: '.$answer.' to question: '.$quest;
			    //echo 'My question: '.$question;
			    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
			    $src = "SELECT `NR_CRT` FROM `chestionare` WHERE `Q_Text` = '$question' AND `Q_NR` = '$quest'";
			    if($srcRUN = mysql_query($src))
			    {
					if(mysql_num_rows($srcRUN) > 0)
					{
						$srcROW = mysql_fetch_assoc($srcRUN);
						$queID = $srcROW['NR_CRT'];
					    $que = "SELECT `Q_Text`, `A_Type`, `A_Width`, `A_Height`, `A_Text` FROM `chestionare` WHERE `CHE_NR` = '1' AND `Q_REF` = '$queID' AND `A_REF` = '$answer' AND `Q_NR` = ($quest + 1) ORDER BY `A_Index`";
					    if($run = mysql_query($que))
					    {
						    if(mysql_num_rows($run) > 0)
						    {
								echo 'OK';
							    while($row = mysql_fetch_assoc($run))
							    {
			        			    $question = $row['Q_Text'];
			        			    $A_type = $row['A_Type'];
			        			    $A_width = $row['A_Width'];
			        			    $A_height = $row['A_Height'];
			        			    $answer = $row['A_Text'];
			        			    echo '^'.$question.'^'.$A_type.'^'.$A_width.'^'.$A_height.'^'.$answer;
							    }
						    }
						    else echo $queID.' not found. Question nr.: '.$quest;
					    }
			            else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
			        }
			        else echo 'Question not found: '.$question;
		        }
		        else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
		    }
	    }
	    else echo 'Don\'t wanna talk to me?';
    }
    else if(isset($_POST['sugestion']) && !empty($_POST['sugestion']) && isset($_POST['name']) && !empty($_POST['name']) && isset($_POST['date']) && !empty($_POST['date']))
    {
		$sugestie = $_POST['sugestion'];
		$name = $_POST['name'];
		$date = $_POST['date'];
		$text = "Raportul efectuat de <b>$name</b> din <b>$date</b> cu continutul:<b><i><br>$sugestie<br></i></b>a fost solutionat cu succes!<br>Va multumim pentru ca ati ales sistemul nostru de raportare erori / sugestii!";
		$updatePROCESS = '<b>'.$acum.'</b> - '.$text;
        require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
        $chk = "SELECT `status` FROM `error.warnings` WHERE `message` = '$sugestie' AND `nume` = '$name' AND `date.time` = '$date' AND `status` < '3'";
        if($chkrun = mysql_query($chk))
		{
		    if(mysql_num_rows($chkrun) > 0)
		    {
				$chkarhive = "SELECT `schimbariEFECTUATE` FROM `arhiva_dezvoltare` WHERE DATE(`data`) = '$azi'";
		        if($arhrun = mysql_query($chkarhive))
		        {
					if(mysql_num_rows($arhrun) > 0)
					{
					    $arhROW = mysql_fetch_assoc($arhrun);
					    $recorded = $arhROW['schimbariEFECTUATE'];
					    $updatePROCESS = $updatePROCESS.'<br>'.$recorded;
					    $que = "UPDATE `arhiva_dezvoltare` SET `schimbariEFECTUATE` = '$updatePROCESS', `data` = '$datetime' WHERE DATE(`data`) = '$azi'";
					}
					else $que = "INSERT INTO `arhiva_dezvoltare` VALUES('','$updatePROCESS','$datetime')";
			        if($run = mysql_query($que))
			        {
						$update = "UPDATE `error.warnings` SET `status` = '3' WHERE `message` = '$sugestie' AND `nume` = '$name' AND `status` = '2' AND `date.time` = '$date'";
						if($uprun = mysql_query($update))
						{
						    if(mysql_affected_rows() > 0)echo 'OK^'.$sugestie;
						    else echo __LINE__.'. No line updated in '.__FILE__;
						}
						else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
			        }
			        else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
                }
        		else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
		    }
		    else echo 'Message not found!';
        }
        else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
    }
    else if(isset($_POST['statUP']) && !empty($_POST['statUP']) && isset($_POST['userNAME']) && !empty($_POST['userNAME']))
    {
	    $message = $_POST['statUP'];
	    $user = $_POST['userNAME'];
        require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
        $que = "SELECT `status`, `exact_TIME` FROM `error.warnings` WHERE `message` = '$message' AND `nume` = '$user'";
        if($run = mysql_query($que))
        {
		    if(mysql_num_rows($run) > 0)
		    {
			    $row = mysql_fetch_assoc($run);
			    $status = $row['status'];
			    $mydate = $row['exact_TIME'];
			    if($status == 1) $status++;
			    $update = "UPDATE `error.warnings` SET `status` = '$status' WHERE `message` = '$message' AND `nume` = '$user' AND `exact_TIME` = '$mydate'";
			    if($runup = mysql_query($update))
			    {
				    if(mysql_affected_rows() > 0)echo 'OK^ For '.$message;
				    else echo "'.$message.' could NOT be updated! My date = $mydate";
			    }
			    else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
            }
            else echo "'.$message.' not found!";
     	}
        else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
    }
    else if(isset($_POST['sugestie']) && !empty($_POST['sugestie']) && isset($_POST['username']) && !empty($_POST['username']))
    {
	    $sugestie = $_POST['sugestie'];
	    $user = $_POST['username'];
        require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
        $que = "SELECT `message`, `status`, `exact_TIME` FROM `error.warnings`";
        if($run = mysql_query($que))
        {
		    if(mysql_num_rows($run) > 0) 
			{
				$count = 0;
				while($row = mysql_fetch_assoc($run))
				{
					$mess = $row['message'];
					$status = $row['status'];
					$recTIME = $row['exact_TIME'];
					similar_text($mess, $sugestie, $result);
					if($result >= 90 && ($status != 3 || ($status == 3 && ($time - $recTIME >= 120))))
					{
				        echo 'Registered';
				        break;
				    }
				    else $count++;
				}
				if($count == mysql_num_rows($run))
				{
				    $insert = "INSERT INTO `error.warnings` VALUES('','$user','$sugestie','','1','$datetime','$time')";
				    if($inrun = mysql_query($insert))
				    {
					    echo 'Inserted';
				    }
				    else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
				}
			}
		    else
		    {
			    $insert = "INSERT INTO `error.warnings` VALUES('','$user','$sugestie','','1','$datetime','$time')";
			    if($inrun = mysql_query($insert))
			    {
				    echo 'Inserted';
			    }
			    else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
		    }
        }
        else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
    }
    else if(isset($_POST['tableACTION']) && !empty($_POST['tableACTION']))
    {
		$action = $_POST['tableACTION'];
		if($action == 'show')
		{
	        require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/connect.inc.php';
	        $que = "SELECT * FROM `error.warnings` ORDER BY `date.time` DESC";
	        if($run = mysql_query($que))
	        {
			    if(mysql_num_rows($run) > 0)
			    {
					echo 'OK^';
				    while($row = mysql_fetch_assoc($run))
				    {
					    $nume = $row['nume'];
						$message = $row['message'];
						$status = $row['status'];
						$data = $row['date.time'];
						echo $nume.'^'.$message.'^'.$status.'^'.$data.'^';
				    }
			    }
			    else echo 'None';
   			}
   			else echo __LINE__.'. MySQL error in '.__FILE__.': '.mysql_error();
	    }
    }
    else echo '...';

?>