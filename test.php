<HTML>
<HEAD>
    <STYLE>
        BODY
        {
		    OVERFLOW: VISIBLE;	
        }
        TABLE 
		{ 
			PAGE-BREAK-BEFORE: ALWAYS;
		}
		TR    { PAGE-BREAK-INSIDE:AVOID; PAGE-BREAK-AFTER:AUTO; }
  		THEAD { DISPLAY:TABLE-HEADER-GROUP;}
    </STYLE>
</HEAD>
<BODY WIDTH = 100%>
    <BUTTON STYLE = "WIDTH: 10vw; COLOR: WHITE; FONT-SIZE: 1.5vw;" ONCLICK = "printLONGSTUFF();">Print Me</BUTTON><BR><BR><BR><BR>
    Some text here, too...
    <TABLE WIDTH = 100% BORDER = 2>
        <THEAD>
            <TH WIDTH = 20%>Counter</TH>
            <TH>Some text</TH>
        </THEAD><TR>
    <?php
        $counter = 0;
        for($counter = 1; $counter <= 100; $counter++)
        {
		    echo '<TD>'.$counter.'</TD><TD>Display again!</TD></TR><TR>';
        }
	?>
	</TABLE>
<SCRIPT>
    function printLONGSTUFF()
    {
		window.print();
		  }
</SCRIPT>
</BODY>
</HTML>