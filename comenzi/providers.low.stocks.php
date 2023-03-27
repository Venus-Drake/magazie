<HTML>
    <HEAD>
        <link rel="stylesheet" href="/ramira/magazie/comenzi/styling.css">
        <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    </HEAD>
    <BODY STYLE = "OVERFLOW: HIDDEN;">
            <DIV ID = "declarationINTRO" STYLE = "MARGIN: 0 AUTO; WIDTH: 100%; BACKGROUND-COLOR: WHITE;">
          	    <IMG SRC = "logo.jpg" STYLE = "WIDTH: 18vw; HEIGHT:4.5vw; MARGIN-TOP: 1.3vw; MARGIN-RIGHT: 1.3vw; MARGIN-BOTTOM: 1.3vw;"><BR>
		  		<B><CENTER><FONT STYLE = "FONT-SIZE: 2.5vw">

<?php
    global $produs; global $cantitate; global $UM; global $detalii; global $cantMIN; global $cantOPT; global $magazie; global $grupa;
    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/header.php';
    require $_SERVER['DOCUMENT_ROOT'].'/ramira/connect.inc.php';
    if(isset($_GET['nume']) && $_GET['nume'] != '') $nume = $_GET['nume'];
    else echo "<SCRIPT>window.location = '/ramira/magazie/index.php/';</SCRIPT>";
    if(isset($_GET['alarm']) && $_GET['alarm'] != '') 
	{
		$alarm = $_GET['alarm'];
		if($alarm == 'showPROVIDERS')
		{
		    if(!$que = $connect -> query("SELECT * FROM `furnizori_materiale` GROUP BY `furnizor` ORDER BY `furnizor`"))
			{
				$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				mysqli_close($connect);
			}
		    echo 'Lista furnizori materiale la '.$date.'</FONT><CENTER></B><BR><BR>
		</DIV>
		<DIV ID = "scrollableDIV" STYLE = "WIDTH: 99.5%; MAX-HEIGHT: 40vw; OVERFLOW: AUTO; PADDING: 0; BORDER: 2px SOLID BLACK;">
			<TABLE ID = "displayTABLE" class="table table-striped table-bordered" ALIGN = CENTER WIDTH = 100% STYLE = "BORDER-COLLAPSE: SEPARATE; MARGIN-TOP: 12vw; MARGIN: 0; BORDER-SPACING: 0;">
				<THEAD STYLE = "POSITION: STICKY; TOP: 0; BACKGROUND-COLOR: LIGHTGREY; BORDER: 2px SOLID BLACK;">
					<TR><TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 15%;">Furnizor</TH>
						<TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 10%;">Oras</TH>
						<TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 15%;">Adresa</TH>
						<TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 15%;">Email</TH>
						<TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 10%;">Nr.Telefon</TH>
					</THEAD></TR>';
			if(mysqli_num_rows($que) > 0)
			{
				while($row = $que -> fetch_assoc())
				{
					$furnizor = $row['furnizor'];
					$oras = $row['oras'];
					if($row['strada'] != '' && $row['str.nr'] != '' && $row['judet'] != '' && $row['tara'] != '') $adresa = $row['strada'].' '.$row['str.nr'].', '.$row['judet'].', '.$row['tara'].', '.$row['cod.postal'];
					else $adresa = '';
					$mail = $row['email'];
					$telefon = $row['telefon'];
					echo '<TR><TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$furnizor.'</TD>
							<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$oras.'</TD>
							<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$adresa.'</TD>
							<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$mail.'</TD>
							<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$telefon.'</TD></TR>';
				}
			}
			else
			{
				if(!$furnizorADD = $connect -> query("SELECT `denumire`, `furnizor`, `cod_SAP` FROM `magazie_stoc` ORDER BY `furnizor`"))
				{
					$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
					mysqli_close($connect);
				}
				if(mysqli_num_rows($furnizorADD) > 0)
				{
					while($furnizorROW = $furnizorADD -> fetch_assoc())
					{
						$denumire = $furnizorROW['denumire'];
						$furnizor = $furnizorROW['furnizor'];
						$codSAP = $furnizorROW['cod_SAP'];
						if(!$adding = $connect -> query("INSERT INTO `furnizori_materiale` VALUES('','$furnizor','','','','','$denumire','$codSAP')"))
						{
							$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
							require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
							mysqli_close($connect);
						}
						$oras = ''; $adresa = ''; $mail = ''; $telefon = '';
						echo 'Lista furnizori materiale la '.$date.'</FONT><CENTER></B><BR><BR>
				</DIV>
				<DIV ID = "scrollableDIV" STYLE = "WIDTH: 99.5%; MAX-HEIGHT: 40vw; OVERFLOW: AUTO; PADDING: 0; BORDER: 2px SOLID BLACK;">
					<TABLE ID = "displayTABLE" class="table table-striped table-bordered" ALIGN = CENTER WIDTH = 100% STYLE = "BORDER-COLLAPSE: SEPARATE; MARGIN-TOP: 12vw; MARGIN: 0; BORDER-SPACING: 0;">
						<THEAD STYLE = "POSITION: STICKY; TOP: 0; BACKGROUND-COLOR: LIGHTGREY; BORDER: 2px SOLID BLACK;">
							<TR><TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$furnizor.'</TD>
								<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$oras.'</TD>
								<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$adresa.'</TD>
								<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$mail.'</TD>
								<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$telefon.'</TD></TR>';
					}
				}
			}
		}
		else if($alarm == 'showDROPPINGstocks')
		{
		    if(!$que = $connect -> query("SELECT * FROM `magazie_stoc` ORDER BY `cod_SAP`"))
			{
				$mailerror = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>MySQL Error:<BR>'.__LINE__.". ".__FILE__.":<br>".mysqli_error($connect).'<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! '.mysqli_error($connect).'">warehouse-soft@ramira.ro</a>';
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				mysqli_close($connect);
			}
		    $codSAP = '';$count  = 0;
			echo 'Lista produse cu risc de epuizare stoc la '.$date.'</FONT><CENTER></B><BR><BR>
		</DIV>
		<DIV ID = "scrollableDIV" STYLE = "WIDTH: 99.5%; MAX-HEIGHT: 40vw; OVERFLOW: AUTO; PADDING: 0; BORDER: 2px SOLID BLACK;">
			<TABLE ID = "displayTABLE" class="table table-striped table-bordered" ALIGN = CENTER WIDTH = 100% STYLE = "BORDER-COLLAPSE: SEPARATE; MARGIN-TOP: 12vw; MARGIN: 0; BORDER-SPACING: 0;">
				<THEAD STYLE = "POSITION: STICKY; TOP: 0; BACKGROUND-COLOR: LIGHTGREY; BORDER: 2px SOLID BLACK;"><TR><TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 5%;">Cod SAP</TH>
						<TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 15%;">Denumire</TH>
						<TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 5%;">Cantitate</TH>
						<TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 5%;">U.M.</TH>
						<TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 5%;">Detalii</TH>
						<TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 5%;">Cant. Min.</TH>
						<TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 5%;">Cant. Optima</TH>
						<TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 5%;">Magazie</TH>
						<TH STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.5vw; WIDTH: 5%;">Grupa Mat.</TH>
					</THEAD></TR>';
			if(mysqli_num_rows($que) > 0)
			{
				while($row = $que -> fetch_assoc())
				{
					$count++;
					if($codSAP != $row['cod_SAP'])
					{
						if($codSAP != '' && $cantOPT >= $cantitate)echo '<TR><TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$codSAP.'</TD>
							<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$produs.'</TD>
							<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$cantitate.'</TD>
							<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$UM.'</TD>
							<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$detalii.'</TD>
							<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$cantMIN.'</TD>
							<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$cantOPT.'</TD>
							<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$magazie.'</TD>
							<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$grupa.'</TD></TR>';
						$codSAP = $row['cod_SAP'];
						$produs = $row['denumire'];
						$cantitate = $row['cantitate'];
						$UM = $row['UM'];
						$detalii = $row['size'];
						$cantMIN = $row['cantitate.minima'];
						$cantOPT = $row['cantitate.optima'];
						$magazie = $row['magazie'];
						$grupa = $row['grupa_MAT'];
					}
					else 
					{
						$cantitate = $cantitate + $row['cantitate'];
						if($count == mysqli_num_rows($que) && $codSAP != '' && $cantOPT >= $cantitate) echo '<TR><TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$codSAP.'</TD>
							<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$produs.'</TD>
							<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$cantitate.'</TD>
							<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$UM.'</TD>
							<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$detalii.'</TD>
							<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$cantMIN.'</TD>
							<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$cantOPT.'</TD>
							<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$magazie.'</TD>
							<TD STYLE = "BORDER: 1px SOLID BLACK; FONT-SIZE: 1.2vw; TEXT-ALIGN: CENTER;">'.$grupa.'</TD></TR>';
					}

				}
				echo '</TABLE>
					</DIV>
					<DIV STYLE = "MARGIN: 0 AUTO; WIDTH: 100%; POSITION: FIXED; BOTTOM: 0;">
						<DIV STYLE = "WIDTH: 10%; HEIGHT: 8vw; MARGIN: 0; TEXT-ALIGN: CENTER; FONT-WEIGHT: BOLD; FLOAT: LEFT; FONT-SIZE: 1.7vw;">
							<BUTTON ID = "printBUTTON" STYLE = "MARGIN-LEFT: 1vw; FONT-WEIGHT: BOLD;" ONCLICK = "goPRINT();"><B>Printeaza</BUTTON><BR><BR>
							<BUTTON ID = "exportBUTTON" STYLE = "MARGIN-LEFT: 1vw; FONT-WEIGHT: BOLD;" ONCLICK = "goEXPORT(this);"><B>Exporta</BUTTON>
						</DIV>
						<DIV STYLE = "WIDTH: 40%; HEIGHT: 8vw; MARGIN: 0; FONT-WEIGHT: BOLD; FLOAT: LEFT; FONT-SIZE: 1.7vw;">
							<P STYLE = "MARGIN-TOP: 0; MARGIN-LEFT: 2vw; TEXT-ALIGN: CENTER; WIDTH: 50%;">Data:<BR>'.$date.'</P>
						</DIV>
						<DIV STYLE = "WIDTH: 49%; HEIGHT: 8vw; MARGIN: 0; TEXT-ALIGN: CENTER; FONT-WEIGHT: BOLD; FLOAT: LEFT; FONT-SIZE: 1.7vw;">
							<P STYLE = "MARGIN-TOP: 0">Gestionar:<BR>'.$nume.'<P>
						</DIV>
							</DIV>
					</DIV>';
			}
		}
	}

?>
</TABLE>
            </DIV>
            <DIV STYLE = "MARGIN: 0 AUTO; WIDTH: 100%; POSITION: FIXED; BOTTOM: 0;">
			    <DIV STYLE = "WIDTH: 10%; HEIGHT: 8vw; MARGIN: 0; TEXT-ALIGN: CENTER; FONT-WEIGHT: BOLD; FLOAT: LEFT; FONT-SIZE: 1.7vw;">
			        <BUTTON ID = "printBUTTON" STYLE = "MARGIN-LEFT: 1vw; FONT-WEIGHT: BOLD;" ONCLICK = "goPRINT();"><B>Printeaza</BUTTON><BR><BR>
			        <BUTTON ID = "exportBUTTON" STYLE = "MARGIN-LEFT: 1vw; FONT-WEIGHT: BOLD;" ONCLICK = "goEXPORT(this);"><B>Exporta</BUTTON>
				</DIV>
			    <DIV STYLE = "WIDTH: 40%; HEIGHT: 8vw; MARGIN: 0; FONT-WEIGHT: BOLD; FLOAT: LEFT; FONT-SIZE: 1.7vw;">
			        <P STYLE = "MARGIN-TOP: 0; MARGIN-LEFT: 2vw; TEXT-ALIGN: CENTER; WIDTH: 50%;">Data:<BR><?php echo $date;?></P>
				</DIV>
				<DIV STYLE = "WIDTH: 49%; HEIGHT: 8vw; MARGIN: 0; TEXT-ALIGN: CENTER; FONT-WEIGHT: BOLD; FLOAT: LEFT; FONT-SIZE: 1.7vw;">
				    <P STYLE = "MARGIN-TOP: 0">Gestionar:<BR><?php echo $nume;?><P>
				</DIV>
            </DIV>
        </DIV>
        <SCRIPT>
		    function goPRINT()
		    {
			    document.getElementById("printBUTTON").style.visibility = "hidden";
			    document.getElementById("exportBUTTON").style.visibility = "hidden";
			    window.print();
			    document.getElementById("printBUTTON").style.visibility = "visible";
			    document.getElementById("exportBUTTON").style.visibility = "visible";
		    }
		    function goEXPORT()
		    {
		        var data = document.getElementById('displayTABLE');
		
		        var file = XLSX.utils.table_to_book(data, {sheet: "Furnizori"});
		
		        XLSX.write(file, { bookType: 'ods', bookSST: true, type: 'base64' });
		
		        XLSX.writeFile(file, "<?php if($alarm == 'showPROVIDERS') echo 'Lista Furnizori RAMIRA SA.ods'; else if($alarm == 'showDROPPINGstocks') echo 'Produse cu risc de epuizare stoc.ods';?>");
		    }
		</SCRIPT>
    </BODY>
</HTML>
