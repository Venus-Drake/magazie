<HTML>
<HEAD>
    <link rel="stylesheet" href="/ramira/magazie/styles.css">
    <STYLE>
        BODY
        {
            FONT-FAMILY:'GALANO GROTESQUE',ARIAL;
            FONT-SIZE: 1.5vw;
            WIDTH: 100%;
        }
        .receptieFORM
        {
		    WIDTH: 80%; 
			HEIGHT: 0;
			MARGIN-LEFT: 10vw; 
			MARGIN-TOP: 1.8vw; 
			BACKGROUND-COLOR: RGBA(1,1,1);
			COLOR: RGB(102,252,3);
			POSITION: FIXED; 
			BORDER: 1PX SOLID RGB(102,252,3);
			BORDER-RADIUS: 20px;
			TEXT-ALIGN: CENTER;
			ANIMATION: POP-LOAD 0.2s FORWARDS,
                       BORDER-BLINK 0.75s INFINITE LINEAR;
        }
        .workingIMG
        {
		    WIDTH: 0;
			HEIGHT: 0;
			MARGIN-LEFT: 37vw;
			MARGIN-TOP: 1.8vw;
			POSITION: FIXED;
			BORDER-RADIUS: 100%;
			OPACITY: .6;
			DISPLAY: NONE;
			ANIMATION: IMG-LOAD 0.2s FORWARDS;
        }
        .formularINTRO
        {
		    WIDTH: 40%;
			HEIGHT: 0;
			MARGIN-LEFT: 20vw;
			MARGIN-TOP: 9.1vw;
			POSITION: FIXED;
			BORDER-RADIUS: 20PX;
			BORDER: 2PX SOLID RGB(0,73,123);
			BACKGROUND-COLOR: WHITE;
			DISPLAY: NONE;
			ANIMATION: FORM-LOAD 0.2s FORWARDS;
        }
        @KEYFRAMES FORM-LOAD
		{
		    FROM{HEIGHT: 0%; MARGIN-TOP: 19vw;}
		    TO{HEIGHT: 40%; MARGIN-TOP: 9.1vw;}
		}
        .unit
        {
		    FONT-SIZE:0.9VW; 
			FONT-WEIGHT: BOLD; 
			WIDTH: 2.3VW;
			BACKGROUND-COLOR: TRANSPARENT;
			COLOR: RGB(102,252,3);
			BORDER: 0VW; 
			MARGIN-LEFT: 0.5vw;
        }
        .receptie
        {
		    background-color: RGBA(237,28,36);
        }
        .formPOPtable
        {
			WIDTH: 98%;
			MARGIN: 0 AUTO;
		    BORDER: 1px SOLID RGB(102,252,3);
			COLOR: RGB(102,252,3);
			FONT-SIZE: 1vw;
        }
        .formPOPtable tr:not(:first-child)
		{
		    cursor: pointer; 
			transition: all .15s ease-in-out;
		}
        @KEYFRAMES POP-LOAD
		{
		    FROM{HEIGHT: 0%; MARGIN-TOP: 19vw;}
		    TO{HEIGHT: 80%; MARGIN-TOP: 1.8vw;}
		}
		@KEYFRAMES BORDER-BLINK
		{
		    FROM { BORDER-COLOR: TRANSPARENT; }
      		TO { BORDER-COLOR: RGBA(102.252.3); }
		}
		@KEYFRAMES IMG-LOAD
		{
		    FROM{HEIGHT: 0%; WIDTH: 0%; MARGIN-TOP: 19vw;}
		    TO{HEIGHT: 40vh; WIDTH: 20vw; MARGIN-TOP: 20vh;}
		}
		.formPOPtable tr:not(:first-child):hover
		{
			background-color: RGB(102,252,3,.5);
		}
    </STYLE>
    <SCRIPT src="/ramira/magazie/main.script.js"></SCRIPT>
</HEAD>
<BODY>
    <?php
	    if(isset($_GET['nume']) && !empty($_GET['nume']))
		{
			$nume = $_GET['nume'];
			if(isset($_GET['userid']) && !empty($_GET['userid'])) 
			{
				$user = $_GET['userid'];
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/header.php';
			    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/meniu.principal.php';
			    $alarm = 'none'; $units = "N.A.";
			}
			else echo "<SCRIPT>window.location = '/ramira/magazie/index.php/';</SCRIPT>";
		}
	    else echo "<SCRIPT>window.location = '/ramira/magazie/index.php/';</SCRIPT>";

	?>
	<DIV CLASS = "container">
	    <DIV ID = "receptieFORM" CLASS = "receptieFORM" STYLE = "DISPLAY: NONE;">
	        <span ID = "FORMclose" CLASS = "close" STYLE = "POSITION: FIXED; MARGIN-LEFT: 36vw; COLOR: RGB(102,252,3);" ONCLICK = "showReceptieFORM();">&#187;&#187;&#187;</span><BR><BR>
	        <DIV STYLE = "WIDTH: 100%">
			    <CENTER>Receptie factura SERIA / NR. <INPUT ID = "facturaFIELD" ONKEYDOWN = "moveON();" STYLE = "WIDTH: 9.2vw; FONT-SIZE: 0.9vw; TEXT-ALIGN: CENTER; TEXT-TRANSFORM: UPPERCASE;" PLACEHOLDER = "FACTURA"></INPUT>&nbsp&nbsp/&nbsp&nbsp<INPUT ID = "invoicedateFIELD" TYPE = "date" ONKEYDOWN = "moveON();" STYLE = "WIDTH: 9.2vw; FONT-SIZE: 0.9vw; TEXT-ALIGN: CENTER;"></INPUT><BR>de la <INPUT ID = "furnizorFIELD" LIST = "resultsFURNIZOR" ONKEYDOWN = "moveON();" ONKEYUP = "cautareFURNIZOR();" ONCHANGE = "moveON();" STYLE = "WIDTH: 15.2vw; FONT-SIZE: 0.9vw; TEXT-ALIGN: CENTER;" PLACEHOLDER = "FURNIZOR"></INPUT>
				<DATALIST ID = "resultsFURNIZOR"></DATALIST><BR><BR></CENTER>
			</DIV>
			<DIV STYLE = "OVERFLOW: AUTO; HEIGHT: 20vw; BORDER-TOP: 1px SOLID RGB(102,252,3);">
	     	    <TABLE CLASS = "formPOPtable" ID = "formRECEPTIEtable" STYLE = "WIDTH: 100%; BACKGROUND-COLOR: BLACK;">
	     	        <THEAD STYLE = "POSITION: STICKY; TOP: 0; BACKGROUND-COLOR: BLACK; BORDER: 1px SOLID RGB(102,252,3);">
		    		    <TH STYLE = "WIDTH: 5%; BORDER: 1px SOLID RGB(102,252,3); FONT-WEIGHT: BOLD; TEXT-ALIGN: CENTER; FONT-SIZE: 1vw; BACKGROUND-COLOR: BLACK;">Cod SAP</TD>
		    		    <TH STYLE = "WIDTH: 7%; BORDER: 1px SOLID RGB(102,252,3);FONT-WEIGHT: BOLD; TEXT-ALIGN: CENTER; FONT-SIZE: 1vw; BACKGROUND-COLOR: BLACK;">Cod Furnizor</TD>
		    		    <TH STYLE = "WIDTH: 10%; BORDER: 1px SOLID RGB(102,252,3);FONT-WEIGHT: BOLD; TEXT-ALIGN: CENTER; FONT-SIZE: 1vw; BACKGROUND-COLOR: BLACK;">Denumire produs</TD>
		    		    <TH STYLE = "WIDTH: 5%; BORDER: 1px SOLID RGB(102,252,3);FONT-WEIGHT: BOLD; TEXT-ALIGN: CENTER; FONT-SIZE: 1vw; BACKGROUND-COLOR: BLACK;">Detalii</TD>
		    		    <TH STYLE = "WIDTH: 5%; BORDER: 1px SOLID RGB(102,252,3);FONT-WEIGHT: BOLD; TEXT-ALIGN: CENTER; FONT-SIZE: 1vw; BACKGROUND-COLOR: BLACK;">Magazie</TD>
		    		    <TH STYLE = "WIDTH: 5%; BORDER: 1px SOLID RGB(102,252,3);FONT-WEIGHT: BOLD; TEXT-ALIGN: CENTER; FONT-SIZE: 1vw; BACKGROUND-COLOR: BLACK;">Grupa materiale</TD>
		    		    <TH STYLE = "WIDTH: 8%; BORDER: 1px SOLID RGB(102,252,3);FONT-WEIGHT: BOLD; TEXT-ALIGN: CENTER; FONT-SIZE: 1vw; BACKGROUND-COLOR: BLACK;">Cantitate</TD>
		    		    <TH STYLE = "WIDTH: 8%; BORDER: 1px SOLID RGB(102,252,3);FONT-WEIGHT: BOLD; TEXT-ALIGN: CENTER; FONT-SIZE: 1vw; BACKGROUND-COLOR: BLACK;">Stoc final</TD>
		    		    <TH STYLE = "WIDTH: 8%; BORDER: 1px SOLID RGB(102,252,3);FONT-WEIGHT: BOLD; TEXT-ALIGN: CENTER; FONT-SIZE: 1vw; BACKGROUND-COLOR: BLACK;">Cantitate minima</TD>
		    		    <TH STYLE = "WIDTH: 8%; BORDER: 1px SOLID RGB(102,252,3);FONT-WEIGHT: BOLD; TEXT-ALIGN: CENTER; FONT-SIZE: 1vw; BACKGROUND-COLOR: BLACK;">Cantitate optima</TD>
		    		    <TH STYLE = "WIDTH: 5%; BORDER: 1px SOLID RGB(102,252,3);FONT-WEIGHT: BOLD; TEXT-ALIGN: CENTER; FONT-SIZE: 1vw; BACKGROUND-COLOR: BLACK;">Pret/<BR>Unitate</TD>
		    		    <TH STYLE = "WIDTH: 5%; BORDER: 1px SOLID RGB(102,252,3);FONT-WEIGHT: BOLD; TEXT-ALIGN: CENTER; FONT-SIZE: 1vw; BACKGROUND-COLOR: BLACK;">Valoare totala</TD>
					</THEAD><TR>
					<TD ID = "tableCELL1" STYLE = "BORDER: 1px SOLID RGB(102,252,3);"><INPUT ID = "codsapFIELD" LIST = "sapRESULTS" STYLE = "WIDTH: 4vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "COD SAP" ONKEYDOWN = "sapKEYSchk();" ONKEYUP = "findSAP();" ONCHANGE = "SAPprocess();" REQUIRED></INPUT>
					<DATALIST ID = "sapRESULTS"></DATALIST></TD>
					<TD ID = "tableCELL2" STYLE = "BORDER: 1px SOLID RGB(102,252,3);"><INPUT ID = "codfurnizorFIELD" STYLE = "WIDTH: 6vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "COD FURNIZOR"  ONKEYDOWN = "cffKEYSchk();"></INPUT></TD>
					<TD ID = "tableCELL3" STYLE = "BORDER: 1px SOLID RGB(102,252,3);"><INPUT ID = "denumireFIELD" STYLE = "WIDTH: 9.2vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "DENUMIRE" READONLY></INPUT></TD>
					<TD ID = "tableCELL4" STYLE = "BORDER: 1px SOLID RGB(102,252,3);"><INPUT ID = "detaliiFIELD" STYLE = "WIDTH: 3.2vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "DETALII" ONKEYDOWN = "moveON();"></INPUT></TD>
					<TD ID = "tableCELL5" STYLE = "BORDER: 1px SOLID RGB(102,252,3);"><INPUT ID = "magazieFIELD" STYLE = "WIDTH: 3.5vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "MAGAZIE" READONLY></INPUT></TD>
					<TD ID = "tableCELL6" STYLE = "BORDER: 1px SOLID RGB(102,252,3);"><INPUT ID = "grupaFIELD" STYLE = "WIDTH: 3.2vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "GRUPA" READONLY></INPUT></TD>
					<TD ID = "tableCELL7" STYLE = "BORDER: 1px SOLID RGB(102,252,3);"><INPUT ID = "amountFIELD" STYLE = "WIDTH: 4vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "CANTITATE" ONKEYDOWN = "moveON();"></INPUT><INPUT ID = "unit" CLASS = "unit" READONLY VALUE = <?php echo $units;?>></INPUT></TD>
					<TD ID = "tableCELL8" STYLE = "BORDER: 1px SOLID RGB(102,252,3);"><INPUT ID = "stocfinalFIELD" STYLE = "WIDTH: 4vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "STOC" READONLY></INPUT><INPUT ID = "unitSTOC" CLASS = "unit" READONLY VALUE = <?php echo $units;?>></INPUT></TD>
					<TD ID = "tableCELL9" STYLE = "BORDER: 1px SOLID RGB(102,252,3);"><INPUT ID = "cantminFIELD" STYLE = "WIDTH: 4vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "CANTITATE MIN." ONKEYDOWN = "moveON();"></INPUT><INPUT ID = "unitMIN" CLASS = "unit" READONLY VALUE = <?php echo $units;?>></INPUT></TD>
					<TD ID = "tableCELL10" STYLE = "BORDER: 1px SOLID RGB(102,252,3);"><INPUT ID = "cantoptFIELD" STYLE = "WIDTH: 4vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "CANTITATE OPT." ONKEYDOWN = "moveON();"></INPUT><INPUT ID = "unitOPT" CLASS = "unit" READONLY VALUE = <?php echo $units;?>></INPUT></TD>
					<TD ID = "tableCELL11" STYLE = "BORDER: 1px SOLID RGB(102,252,3);"><INPUT ID = "pretFIELD" STYLE = "WIDTH: 4vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "PRET/UNIT" ONKEYDOWN = "moveON();"></INPUT></TD>
					<TD ID = "tableCELL12" STYLE = "BORDER: 1px SOLID RGB(102,252,3);"><INPUT ID = "valueFIELD" STYLE = "WIDTH: 4vw; FONT-SIZE: 0.7vw;" PLACEHOLDER = "VALOARE" READONLY></INPUT></TD>
				</TABLE><BR><BR>
			</DIV>
			<DIV STYLE = "POSITION: ABSOLUTE; WIDTH: 100%; BOTTOM: 0; TEXT-ALIGN: LEFT;">
			    <P STYLE = "MARGIN-LEFT: 1vw; FONT-SIZE: 1.2vw;">
					Date contact furnizor:<BR>
				    <FONT STYLE = "FONT-SIZE: 0.9vw"><CENTER>Localitate: <INPUT ID = "adLOCFIELD" PLACEHOLDER = "LOCALITATE" STYLE = "WIDTH: 10vw;"></INPUT>&nbsp&nbsp
 		 			                                         Strada: <INPUT ID = "adSTRFIELD" PLACEHOLDER = "STRADA" STYLE = "WIDTH: 15vw;"></INPUT>&nbsp&nbsp
					   										 Nr. Str.: <INPUT ID = "adNRFIELD" PLACEHOLDER = "NR.STR." STYLE = "WIDTH: 3vw;"></INPUT>&nbsp&nbsp
					   										 Cod Postal: <INPUT ID = "adCPFIELD" PLACEHOLDER = "COD POSTAL" STYLE = "WIDTH: 5vw;"></INPUT>&nbsp&nbsp
															 Judet: <INPUT ID = "adJUDFIELD" PLACEHOLDER = "JUDET" STYLE = "WIDTH: 10vw;"></INPUT>&nbsp&nbsp
															 Tara: <INPUT ID = "adTARAFIELD" PLACEHOLDER = "TARA" STYLE = "WIDTH: 10vw;"></INPUT>&nbsp&nbsp<BR>
				    Nr. tel: <INPUT ID = "telFIELD" PLACEHOLDER = "TELEFON" STYLE = "WIDTH: 10vw;"></INPUT>&nbsp&nbsp
				    Email: <INPUT ID = "mailFIELD" PLACEHOLDER = "EMAIL" STYLE = "WIDTH: 15vw;"></INPUT>&nbsp&nbsp
				    Persoana contact: <DIV ID = "apelFIELD" STYLE = "BACKGROUND-COLOR: TRANSPARENT; WIDTH: 3vw;"></DIV><INPUT ID = "persFIELD" PLACEHOLDER = "PERSOANA CONTACT" STYLE = "WIDTH: 15vw;"></INPUT>&nbsp&nbsp
				    Departament: <INPUT ID = "departFIELD" PLACEHOLDER = "DEPARTAMENT" STYLE = "WIDTH: 10vw;"></INPUT>
				    </FONT></CENTER>
			    </P>
				<BUTTON ID = "doneBUTTON" STYLE = "HEIGHT: 1.5vw; WIDTH: 6.5vw; FONT-WEIGHT: BOLD; MARGIN-LEFT: 3vw;" ONCLICK = "recordRECEPTIE();">Finalizeaza</BUTTON>
				<BUTTON ID = "cancelBUTTON" ONCLICK = "showReceptieFORM();" STYLE = "HEIGHT: 1.5vw; WIDTH: 6.5vw; FONT-WEIGHT: BOLD; MARGIN-LEFT: 3vw;">Anuleaza</BUTTON><BR><BR>
			</DIV>
        </DIV>
        <DIV CLASS = "LEFT_BAR"><BR><BR>
            <DIV STYLE = "WIDTH: 100%">
                <BUTTON ID = "formBUTTON" STYLE = "FONT-WEIGHT: BOLD; FONT-SIZE: 1.3vw; WIDTH: 18vw; HEIGHT: 1.8vw; MARGIN-LEFT: 1vw;" ONCLICK = "showReceptieFORM();">Incepe receptia</BUTTON><BR><BR>
            </DIV>
    	</DIV>
    	<DIV ID = "numeGESTIONAR" STYLE = "DISPLAY: NONE"><?php echo $nume;?></DIV>
    	<DIV CLASS = "bon_magazie">
    	    <IFRAME CLASS = "bon_magazie_frame" ID = "recINVOICE" SRC = "/ramira/magazie/receptie marfa/funny.php"></IFRAME>
	    </DIV>
	    <DIV ID = "workingIMAGE" CLASS = "workingIMG" STYLE = "BACKGROUND-IMAGE: url('/ramira/magazie/images/Working.gif');BACKGROUND-POSITION: CENTER; BACKGROUND-SIZE: COVER;">
	    </DIV>
	    <DIV ID = "furnizorFORM" CLASS = "formularINTRO">
	        <span ID = "FORMclose" CLASS = "close" STYLE = "POSITION: FIXED; MARGIN-LEFT: 36vw; COLOR: RGB(1,1,1);" ONCLICK = "hideIntroFORM();">&#187;&#187;&#187;</span><BR>
	        <CENTER><BR>FORMULAR INTRODUCERE FURNIZOR NOU</CENTER><BR>
	        <TABLE STYLE = "WIDTH: 100%; MARGIN-TOP: 1VH;">
	            <TD STYLE = "WIDTH: 33%; TEXT-ALIGN: RIGHT;">Nume furnizor:&nbsp&nbsp</TD>
				<TD STYLE = "TEXT-ALIGN: LEFT;"><INPUT ID = "numeFURNIZORnou" ONKEYDOWN = "chkINPUTfurnizor()" STYLE = "WIDTH: 22VW;"></INPUT><BR><INPUT ID = "codFURNIZORnou" PLACEHOLDER = "COD FURNIZOR" READONLY STYLE = "WIDTH: 7VW;"></INPUT></TD><TR>
				<TD STYLE = "WIDTH: 33%; TEXT-ALIGN: RIGHT;">Adresa:&nbsp&nbsp</TD>
				<TD STYLE = "TEXT-ALIGN: LEFT;">
				    <INPUT ID = "locFURNIZORnou" ONKEYDOWN = "chkINPUTlocalitate();" PLACEHOLDER = "LOCALITATEA" STYLE = "WIDTH: 16VW; MARGIN-TOP: 1VH;"></INPUT><INPUT ID = "codpostalFURNIZORnou" ONKEYDOWN = "chkINPUTpost();" PLACEHOLDER = "COD POSTAL" STYLE = "WIDTH: 6VW;"></INPUT><BR>
				    <INPUT ID = "stradaFURNIZORnou" ONKEYDOWN = "chkINPUTstrada();" PLACEHOLDER = "STRADA" STYLE = "WIDTH: 17VW;"></INPUT><INPUT ID = "nrstrFURNIZORnou" ONKEYDOWN = "chkINPUTnrstr();" PLACEHOLDER = "NR. STR." STYLE = "WIDTH: 5VW;"></INPUT><BR>
				    <INPUT ID = "judetFURNIZORnou" ONKEYDOWN = "chkINPUTjudet();" PLACEHOLDER = "JUDET"></INPUT><INPUT ID = "taraFURNIZORnou" ONKEYDOWN = "chkINPUTtara();" PLACEHOLDER = "TARA"></INPUT><BR>
				</TD><TR>
				<TD STYLE = "WIDTH: 33%; TEXT-ALIGN: RIGHT;">Date contact:&nbsp&nbsp</TD>
				<TD STYLE = "TEXT-ALIGN: LEFT;">
				    <SELECT ID = "apelativFURNIZORnou" ONCHANGE = "moveFOCUSapelativ();" PLACEHOLDER = "APELATIV" STYLE = "MARGIN-TOP:1VH; WIDTH: 5VW;">
				        <OPTION></OPTION>
				        <OPTION>Dn.</OPTION>
				        <OPTION>Dna.</OPTION>
					</SELECT><INPUT ID = "persoanaFURNIZORnou" ONKEYDOWN = "chkINPUTpers();" PLACEHOLDER = "PERSOANA CONTACT" STYLE = "WIDTH: 17VW;"></INPUT><BR>
				    <INPUT ID = "telFURNIZORnou" ONKEYDOWN = "chkINPUTtel();" PLACEHOLDER = "NUMAR TELEFON" STYLE = "WIDTH: 22VW"></INPUT><BR>
				    <INPUT TYPE = "EMAIL" ID = "emailFURNIZORnou" ONKEYDOWN = "chkINPUTmail();" PLACEHOLDER = "E-MAIL" STYLE = "WIDTH: 22VW;"></INPUT><BR>
				    <INPUT ID = "departFURNIZORnou" ONKEYDOWN = "chkINPUTdepart();" PLACEHOLDER = "DEPARTAMENT"></INPUT><BR>
				</TD>
			</TABLE>
	    </DIV>
	    <DIV ID = "sapcodeFORM" CLASS = "formularINTRO">
	        <span ID = "FORMclose" CLASS = "close" STYLE = "POSITION: FIXED; MARGIN-LEFT: 36vw; COLOR: RGB(1,1,1);" ONCLICK = "hideSapFORM();">&#187;&#187;&#187;</span><BR>
	        <CENTER><BR>FORMULAR INTRODUCERE FURNIZOR NOU</CENTER><BR>
	        <TABLE STYLE = "WIDTH: 100%; MARGIN-TOP: 1VH;">
	            <TD STYLE = "WIDTH: 33%; TEXT-ALIGN: RIGHT;">Nume furnizor:&nbsp&nbsp</TD>
				<TD STYLE = "TEXT-ALIGN: LEFT;"><INPUT ID = "numeFURNIZORnou" ONKEYDOWN = "chkINPUTfurnizor()" STYLE = "WIDTH: 22VW;"></INPUT><BR><INPUT ID = "codFURNIZORnou" PLACEHOLDER = "COD FURNIZOR" READONLY STYLE = "WIDTH: 7VW;"></INPUT></TD><TR>
				<TD STYLE = "WIDTH: 33%; TEXT-ALIGN: RIGHT;">Adresa:&nbsp&nbsp</TD>
				<TD STYLE = "TEXT-ALIGN: LEFT;">
				    <INPUT ID = "locFURNIZORnou" ONKEYDOWN = "chkINPUTlocalitate();" PLACEHOLDER = "LOCALITATEA" STYLE = "WIDTH: 16VW; MARGIN-TOP: 1VH;"></INPUT><INPUT ID = "codpostalFURNIZORnou" ONKEYDOWN = "chkINPUTpost();" PLACEHOLDER = "COD POSTAL" STYLE = "WIDTH: 6VW;"></INPUT><BR>
				    <INPUT ID = "stradaFURNIZORnou" ONKEYDOWN = "chkINPUTstrada();" PLACEHOLDER = "STRADA" STYLE = "WIDTH: 17VW;"></INPUT><INPUT ID = "nrstrFURNIZORnou" ONKEYDOWN = "chkINPUTnrstr();" PLACEHOLDER = "NR. STR." STYLE = "WIDTH: 5VW;"></INPUT><BR>
				    <INPUT ID = "judetFURNIZORnou" ONKEYDOWN = "chkINPUTjudet();" PLACEHOLDER = "JUDET"></INPUT><INPUT ID = "taraFURNIZORnou" ONKEYDOWN = "chkINPUTtara();" PLACEHOLDER = "TARA"></INPUT><BR>
				</TD><TR>
				<TD STYLE = "WIDTH: 33%; TEXT-ALIGN: RIGHT;">Date contact:&nbsp&nbsp</TD>
				<TD STYLE = "TEXT-ALIGN: LEFT;">
				    <SELECT ID = "apelativFURNIZORnou" ONCHANGE = "moveFOCUSapelativ();" PLACEHOLDER = "APELATIV" STYLE = "MARGIN-TOP:1VH; WIDTH: 5VW;">
				        <OPTION></OPTION>
				        <OPTION>Dn.</OPTION>
				        <OPTION>Dna.</OPTION>
					</SELECT><INPUT ID = "persoanaFURNIZORnou" ONKEYDOWN = "chkINPUTpers();" PLACEHOLDER = "PERSOANA CONTACT" STYLE = "WIDTH: 17VW;"></INPUT><BR>
				    <INPUT ID = "telFURNIZORnou" ONKEYDOWN = "chkINPUTtel();" PLACEHOLDER = "NUMAR TELEFON" STYLE = "WIDTH: 22VW"></INPUT><BR>
				    <INPUT TYPE = "EMAIL" ID = "emailFURNIZORnou" ONKEYDOWN = "chkINPUTmail();" PLACEHOLDER = "E-MAIL" STYLE = "WIDTH: 22VW;"></INPUT><BR>
				    <INPUT ID = "departFURNIZORnou" ONKEYDOWN = "chkINPUTdepart();" PLACEHOLDER = "DEPARTAMENT"></INPUT><BR>
				</TD>
			</TABLE>
	    </DIV>
    </DIV>

    <SCRIPT TYPE = "text/javascript">
		window.onload=function()
		{
			display_ct();
		}
    </SCRIPT>
    <SCRIPT src="/ramira/magazie/receptie marfa/receptie.script.js"></SCRIPT>
</BODY>
</HTML>