<HTML>
    <HEAD>
        <SCRIPT src='/ramira/magazie/users accounts/users.js'></SCRIPT>
    </HEAD>
    <BODY>
        <span ID = "newsCLOSE" CLASS = "close" STYLE = "FLOAT: RIGHT; TEXT-ALIGN: RIGHT; MARGIN-RIGHT: 1vw; FONT-SIZE: 1vw;" ONCLICK = "closeGRIDmail()">Inchide &#187;&#187;&#187;</span><BR>
        <BR><CENTER><FONT STYLE = "FONT-SIZE: 2.5vw;">Lista mail-uri de trimis<BR><BR></FONT></CENTER>
        <DIV STYLE = "OVERFLOW: AUTO; WIDTH: 100%; HEIGHT: 76%;">
		    <FONT STYLE = "FONT-SIZE: 1vw; FONT-WEIGHT: NORMAL;">&nbsp&nbsp&nbsp&nbspMail-urile netrimise au butonul de trimitere activ:<BR>
			<TABLE ID = "mail_TABLE" STYLE = "WIDTH: 90%; MARGIN: 0 AUTO; BORDER: 2px SOLID BLACK; MARGIN-TOP: 2vh;">
			    <TH STYLE = "WIDTH: 20%; BORDER: 1px SOLID BLACK; BORDER-BOTTOM: 2PX SOLID BLACK; FONT-SIZE: 1VW;">Nume angajat</TH>
			    <TH STYLE = "WIDTH: 15%; BORDER: 1px SOLID BLACK; BORDER-BOTTOM: 2PX SOLID BLACK; FONT-SIZE: 1VW;">Adresa mail</TH>
			    <TH STYLE = "WIDTH: 15%; BORDER: 1px SOLID BLACK; BORDER-BOTTOM: 2PX SOLID BLACK; FONT-SIZE: 1VW;">Subiect mail</TH>
			    <TH STYLE = "WIDTH: 40%; BORDER: 1px SOLID BLACK; BORDER-BOTTOM: 2PX SOLID BLACK; FONT-SIZE: 1VW;">Continut mail</TH>
			    <TH STYLE = "WIDTH: 10%; BORDER: 1px SOLID BLACK; BORDER-BOTTOM: 2PX SOLID BLACK; FONT-SIZE: 1VW;">Trimite mail</TH>
			</TABLE><BR>
        </DIV>
		<SCRIPT src='/ramira/magazie/users accounts/users.js'></SCRIPT>
		<SCRIPT>
		    function closeGRIDmail()
			{
				var mailDIV = document.getElementById('mailLIST');
				var mailTABLE = document.getElementById('mail_TABLE');
				mailDIV.style.display = 'none';
			    if(mailTABLE.rows.length > 0)
			    {
				    for(i = mailTABLE.rows.length -1; i > 0; i--)
				    {
					    mailTABLE.deleteRow(i);
				    }
			    }
			}
		</SCRIPT>
    </BODY>
</HTML>