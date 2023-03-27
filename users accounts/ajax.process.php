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
			    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
				if(!$que = $connect -> query("UPDATE `mails2send` SET `sent` = '1' WHERE `userNAME` = '$myuser'"))
				{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
				if(mysqli_affected_rows($connect) > 0) 
				{
					if(!$chk = $connect -> query("SELECT `mailID`, `sent` FROM `mails2send` ORDER BY `sent` ASC"))
					{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
					echo 'OK';
					if(mysqli_num_rows($chk) > 0)
					{
						$chkROW = $chk -> fetch_assoc();
						$mailID = $chkROW['mailID'];
						if($chkROW['sent'] == '1')
						{
							if(!$update = $connect -> query("UPDATE `mailuri` SET `sent` = '1' WHERE `nr.crt` = '$mailID'"))
							{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
							echo '^All mails sent';
						}
					}
				}
				else die('Could not update '.$myuser);
		    }
		    else die('User not set!');
	    }
	    else if($command == 'showmails')
	    {
		    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
			if(!$que = $connect -> query("SELECT `nr.crt`, `subject`, `body` FROM `mailuri` WHERE `sent` = '0'"))
			{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
			if(mysqli_num_rows($que) > 0)
			{
				$row = $que -> fetch_assoc();
				$mailID = $row['nr.crt'];
				$subject = $row['subject'];
				$body = $row['body'];
				if(!$chk = $connect -> query("SELECT * FROM `mails2send` WHERE `mailID` = '$mailID' ORDER BY `sent`"))
				{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
				if(mysqli_num_rows($chk) == 0)
				{
					echo 'OK';
					if(!$roll = $connect -> query("SELECT `username`, `password`, `nume`, `prenume`, `email` FROM `utilizatori` WHERE `email` != ''"))
					{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
					if(mysqli_num_rows($roll) > 0)
					{
						while($rollROW = $roll -> fetch_assoc())
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
							if(!$addMAIL = $connect -> query("INSERT INTO `mails2send` VALUES('','$mailID','$fullNAME','$email','$subject','$mailBODY','0')"))
							{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
							if(mysqli_affected_rows($connect) > 0) echo '^'.$fullNAME.'^'.$email.'^'.$subject.'^'.$mailBODY.'^0';
						}
					}
					else echo 'No users found in DB';
				}
				else
				{
					echo 'OK';
					while($chkROW = $chk -> fetch_assoc())
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
			else echo 'No mail to send.';
	    }
    }
	else if(isset($_POST['analiza']) && !empty($_POST['analiza']))
    {
	    $analiza = $_POST['analiza'];
	    if($analiza == 'show')
	    {
		    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
			if(!$que = $connect -> query("SELECT * FROM `rezultate.chestionare` WHERE `procesat` = '0' ORDER BY `numeUSER`"))
			{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
			if(mysqli_num_rows($que) > 0)
			{
				echo 'OK';
				while($row = $que -> fetch_assoc())
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
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
				if(!$que = $connect -> query("SELECT `numeUSER` FROM `rezultate.chestionare` WHERE `numeUSER` = '$userNAME' AND `nr.chestionar` = '$chestionar'"))
				{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
				if(mysqli_num_rows($que) > 0)
				{
					$queDB = 'q'.$qNR;
					$ansDB = 'a'.$qNR;
					if(!$update = $connect -> query("UPDATE `rezultate.chestionare` SET `dataCOMPLETARE` = '$datetime', `$queDB` = '$qTEXT', `$ansDB` = '$answer', `procesat` = '0' WHERE `numeUSER` = '$userNAME' AND `nr.chestionar` = '$chestionar'"))
					{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
					if(mysqli_affected_rows($connect) > 0) echo 'RECORDED';
					else echo __LINE__.'. RECORD FAILED';
				}
				else
				{
					if(!$intro = $connect -> query("INSERT INTO `rezultate.chestionare` VALUES('','$datetime','$chestionar','$userNAME','','','','','','','','','','','','','','','','','','','','','','','')"))
					{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
					$queDB = 'q'.$qNR;
					$ansDB = 'a'.$qNR;
					if(!$update = $connect -> query("UPDATE `rezultate.chestionare` SET `dataCOMPLETARE` = '$datetime', `$queDB` = '$qTEXT', `$ansDB` = '$answer', `procesat` = '0' WHERE `numeUSER` = '$userNAME' AND `nr.chestionar` = '$chestionar'"))
					{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
					if(mysqli_affected_rows($connect) > 0) echo 'RECORDED';
					else echo __LINE__.'. RECORD FAILED';
				}
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
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
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
		            if(!$update = $connect -> query("UPDATE `rezultate.chestionare` SET `dataCOMPLETARE` = '$datetime', `$queDB` = '$qTEXT', `$ansDB` = '$answer', `procesat` = '0' WHERE `numeUSER` = '$userNAME' AND `nr.chestionar` = '$chestionar'"))
					{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
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
		    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
		    if(!$que = $connect -> query("SELECT `Q_Text`, `A_Type`, `A_Width`, `A_Height`, `A_Text` FROM `chestionare` WHERE `CHE_NR` = '1' AND `Q_NR` = '1'"))
			{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
		    if(mysqli_num_rows($que) > 0)
			{
				echo 'OK';
				while($row = $que -> fetch_assoc())
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
			    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
			    if(!$src = $connect -> query("SELECT `NR_CRT` FROM `chestionare` WHERE `Q_Text` = '$question' AND `Q_NR` = '$quest'"))
				{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
			    if(mysqli_num_rows($src) > 0)
				{
					$srcROW = $src -> fetch_assoc();
					$queID = $srcROW['NR_CRT'];
					if(!$que = $connect -> query("SELECT `Q_Text`, `A_Type`, `A_Width`, `A_Height`, `A_Text` FROM `chestionare` WHERE `CHE_NR` = '1' AND `Q_REF` = '$queID' AND `A_REF` = '$answer' AND `Q_NR` = ($quest + 1) ORDER BY `A_Index`"))
					{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
					if(mysqli_num_rows($que) > 0)
					{
						echo 'OK';
						while($row = $que -> fetch_assoc())
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
				else echo 'Question not found: '.$question;
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
        require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
        if(!$chk = $connect -> query("SELECT `status` FROM `error.warnings` WHERE `message` = '$sugestie' AND `nume` = '$name' AND `date.time` = '$date' AND `status` < '3'"))
		{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
        if(mysqli_num_rows($chk) > 0)
		{
			if(!$chkarhive = $connect -> query("SELECT `schimbariEFECTUATE` FROM `arhiva_dezvoltare` WHERE DATE(`data`) = '$azi'"))
			{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
			if(mysqli_num_rows($chkarhive) > 0)
			{
				$arhROW = $chkarhive -> fetch_assoc();
				$recorded = $arhROW['schimbariEFECTUATE'];
				$updatePROCESS = $updatePROCESS.'<br>'.$recorded;
				$que = $connect -> query("UPDATE `arhiva_dezvoltare` SET `schimbariEFECTUATE` = '$updatePROCESS', `data` = '$datetime' WHERE DATE(`data`) = '$azi'");
				{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
			}
			else $que = $connect -> query("INSERT INTO `arhiva_dezvoltare` VALUES('','$updatePROCESS','$datetime')");
			if(!$que){die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
			if(!$update = $connect -> query("UPDATE `error.warnings` SET `status` = '3' WHERE `message` = '$sugestie' AND `nume` = '$name' AND `status` = '2' AND `date.time` = '$date'"))
			{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
			if(mysqli_affected_rows($connect) > 0)echo 'OK^'.$sugestie;
		}
		else echo 'Message not found!';
    }
    else if(isset($_POST['statUP']) && !empty($_POST['statUP']) && isset($_POST['userNAME']) && !empty($_POST['userNAME']))
    {
	    $message = $_POST['statUP'];
	    $user = $_POST['userNAME'];
        require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
        if(!$que = $connect -> query("SELECT `status`, `exact_TIME` FROM `error.warnings` WHERE `message` = '$message' AND `nume` = '$user'"))
		{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
        if(mysqli_num_rows($que) > 0)
		{
			$row = $que -> fetch_assoc();
			$status = $row['status'];
			$mydate = $row['exact_TIME'];
			if($status == 1) $status++;
			if(!$update = $connect -> query("UPDATE `error.warnings` SET `status` = '$status' WHERE `message` = '$message' AND `nume` = '$user' AND `exact_TIME` = '$mydate'"))
			{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
			if(mysqli_affected_rows($connect) > 0)echo 'OK^ For '.$message;
		}
		else echo "'.$message.' not found!";
    }
    else if(isset($_POST['sugestie']) && !empty($_POST['sugestie']) && isset($_POST['username']) && !empty($_POST['username']))
    {
	    $sugestie = $_POST['sugestie'];
	    $user = $_POST['username'];
        require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
        if(!$que = $connect -> query("SELECT `message`, `status`, `exact_TIME` FROM `error.warnings`"))
		{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
        if(mysqli_num_rows($que) > 0) 
		{
			$count = 0;
			while($row = $que -> fetch_assoc())
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
			if($count == mysqli_num_rows($que))
			{
				if(!$insert = $connect -> query("INSERT INTO `error.warnings` VALUES('','$user','$sugestie','','1','$datetime','$time')"))
				{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
				echo 'Inserted';
			}
		}
		else
		{
			if(!$insert = $connect -> query("INSERT INTO `error.warnings` VALUES('','$user','$sugestie','','1','$datetime','$time')"))
			{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
			echo 'Inserted';
		}
    }
    else if(isset($_POST['tableACTION']) && !empty($_POST['tableACTION']))
    {
		$action = $_POST['tableACTION'];
		if($action == 'show')
		{
	        require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
	        if(!$que = $connect -> query("SELECT * FROM `error.warnings` ORDER BY `date.time` DESC"))
			{die(__LINE__.'. MySQL error in '.__FILE__.': '.mysqli_error($connect));}
	        if(mysqli_num_rows($que) > 0)
			{
				echo 'OK^';
				while($row = $que -> fetch_assoc())
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
    }
    else echo '...';

?>