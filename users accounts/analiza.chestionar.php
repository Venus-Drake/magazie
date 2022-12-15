<HTML>
    <HEAD>
        <SCRIPT src='/ramira/magazie/users accounts/users.js'></SCRIPT>
    </HEAD>
    <BODY>
        <IMG SRC = "logo.jpg" STYLE = "WIDTH: 12vw; HEIGHT:3vw; MARGIN-TOP: 1.3vw; MARGIN-LEFT: 1.3vw; MARGIN-BOTTOM: 1.3vw;">
        <span ID = "newsCLOSE" CLASS = "close" STYLE = "FLOAT: RIGHT; TEXT-ALIGN: RIGHT; MARGIN-RIGHT: 1vw; FONT-SIZE: 1vw;" ONCLICK = "closeGRIDana()">Inchide &#187;&#187;&#187;</span><BR>
        <BR><CENTER><FONT STYLE = "FONT-SIZE: 1.5vw; FONT-WEIGHT: BOLD;">Vizualizarea si analiza ultimului chestionar lansat<BR><BR></FONT></CENTER>
        <DIV STYLE = "OVERFLOW: AUTO; WIDTH: 90%; HEIGHT: 70%; BORDER-TOP: 1PX SOLID BLACK; FLOAT: NONE; MARGIN: 0 AUTO;">
			<TABLE ID = "analiza_TABLE" STYLE = "WIDTH: 100%; MARGIN: 0 AUTO; BORDER: 2px SOLID BLACK; FONT-SIZE: 1vw; BORDER-COLLAPSE: SEPARATE; PADDING: 0; BORDER-SPACING: 0;">
			    <TR STYLE = " BORDER: 2px SOLID BLACK;POSITION: STICKY; TOP: 0;">
				    <THEAD STYLE = "POSITION: STICKY; TOP: 0.1vh;  BORDER: 2px SOLID BLACK; BACKGROUND-COLOR: LIGHTGREY;">
						<TH STYLE = " BORDER: 2px SOLID BLACK; WIDTH: 15%; FONT-SIZE: 1vw;">Nume angajat</TH>
					    <TH STYLE = " BORDER: 2px SOLID BLACK; WIDTH: 5%; FONT-SIZE: 1vw;">Nr. Chest.</TH>
					    <TH STYLE = " BORDER: 2px SOLID BLACK; WIDTH: 25%; FONT-SIZE: 1vw;">Intrebare</TH>
					    <TH STYLE = " BORDER: 2px SOLID BLACK; WIDTH: 25%; FONT-SIZE: 1vw;">Raspuns</TH>
					    <TH STYLE = " BORDER: 2px SOLID BLACK; WIDTH: 5%; FONT-SIZE: 1vw;">Punctaj</TH>
			        </THEAD>
			    </TR>
			</TABLE><BR>
			<DIV ID = "endFORM" STYLE = "VISIBILITY: COLLAPSE;">&nbsp&nbsp&nbsp&nbsp Va multumim pentru timpul acordat si va dorim o zi minunata!</DIV>
        </DIV>
		<SCRIPT src='/ramira/magazie/users accounts/users.js'></SCRIPT>
		<SCRIPT>
		    function closeGRIDana()
			{
				var analizaDIV = document.getElementById('analiza');
				var analizaTABLE = document.getElementById('analiza_TABLE');
				analizaDIV.style.display = 'none';
			    if(analizaTABLE.rows.length > 1)
			    {
				    for(i = analizaTABLE.rows.length -1; i > 1; i--)
				    {
					    analizaTABLE.deleteRow(i);
				    }
			    }
			}
		</SCRIPT>
		<SCRIPT src='/ramira/magazie/users accounts/users.js'></SCRIPT>
    </BODY>
</HTML>