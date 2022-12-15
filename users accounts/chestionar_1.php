<HTML>
    <HEAD>
        <SCRIPT src='/ramira/magazie/users accounts/users.js'></SCRIPT>
    </HEAD>
    <BODY>
        <DIV ID = "numarCHESTIONAR" STYLE = "DISPLAY:NONE;">1</DIV>
        <IMG SRC = "logo.jpg" STYLE = "WIDTH: 12vw; HEIGHT:3vw; MARGIN-TOP: 1.3vw; MARGIN-LEFT: 1.3vw; MARGIN-BOTTOM: 1.3vw;">
        <span ID = "newsCLOSE" CLASS = "close" STYLE = "FLOAT: RIGHT; TEXT-ALIGN: RIGHT; MARGIN-RIGHT: 1vw; FONT-SIZE: 1vw;" ONCLICK = "closeGRID()">Inchide &#187;&#187;&#187;</span><BR>
        <BR><CENTER><FONT STYLE = "FONT-SIZE: 1.5vw;">Hai sa vorbim despre...Lighthouse21<BR><BR></FONT></CENTER>
        <DIV STYLE = "WIDTH: 100%; HEIGHT: 76%;">
            <DIV STYLE = "WIDTH: 95%; MARGIN: 0 AUTO; BORDER-RADIUS: 20PX; BORDER: 2PX SOLID DARKGREY; POSITION: RELATIVE; TOP: 0; FLOAT: NONE;">
			    <FONT STYLE = "FONT-SIZE: 1vw; FONT-WEIGHT: NORMAL;">&nbsp&nbsp&nbsp&nbsp Dupa cum probabil stiti deja, implementarea utilizarii programului <B>Lighthouse21</B> ca si instrument principal de accesare / generare a diverse rapoarte necesare aproape oricaruia dintre dumneavoastra se apropie din ce in ce mai mult si se fac eforturi pentru a ne asigura ca utilizarea programului nu va crea si mai multe probleme in activitatea dumneavoastra, ci o va usura.<BR>
	        	&nbsp&nbsp&nbsp&nbsp In acest scop, trebuie sa asiguram buna functionare a programului si accesul facil al angajatilor companiei la acesta.<BR>
	        	&nbsp&nbsp&nbsp&nbsp O alta parte foarte importanta este sa stim, cat mai precis, <b>cui</b> ii este absolut necesar acest program, <b>cine</b> il foloseste, cat de des, sau cine l-ar folosi, daca ar avea posibilitatea.<BR>
	        	&nbsp&nbsp&nbsp&nbsp Am creat un mic sondaj pentru a deschide o cale de comunicare cu dumneavoastra in aceasta directie, asa ca, fara prea multe ceremonii, va invit pe fiecare in parte sa raspundeti la cateva intrebari, care ne vor ajuta sa ne cream o idee de ansamblu:<BR><CENTER><FONT STYLE = "FONT-SIZE: 0.8vw;">(completarea formularului se valideaza in momentul in care sub tabel apare mesajul de validare)</FONT><BR>
        	</DIV>
        	<DIV STYLE = "OVERFLOW: AUTO; WIDTH: 95%; MARGIN: 0 AUTO; FLOAT: NONE;">
				<TABLE ID = "chestionar_TABLE" STYLE = "WIDTH: 90%; MARGIN: 0 AUTO; BORDER: 2px SOLID BLACK; MARGIN-TOP: 1.5vh;">
				</TABLE><BR>
			</DIV>
			<DIV ID = "endFORM" STYLE = "VISIBILITY: COLLAPSE;">&nbsp&nbsp&nbsp&nbsp Formularul a fost validat!<BR>&nbsp&nbsp&nbsp&nbspVa multumim pentru timpul acordat si va dorim o zi minunata!</DIV>
        </DIV>
		<SCRIPT src='/ramira/magazie/users accounts/users.js'></SCRIPT>
		<SCRIPT>
		    function closeGRID()
			{
				var chestionarDIV = document.getElementById('chestionar');
				var cheTABLE = document.getElementById('chestionar_TABLE');
				chestionarDIV.style.display = 'none';
			    if(cheTABLE.rows.length > 0)
			    {
				    for(i = cheTABLE.rows.length -1; i >=0; i--)
				    {
					    cheTABLE.deleteRow(i);
				    }
			    }
			}
		</SCRIPT>
		<SCRIPT src='/ramira/magazie/users accounts/users.js'></SCRIPT>
    </BODY>
</HTML>