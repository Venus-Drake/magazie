<HTML>
    <HEAD>
        <SCRIPT src='/ramira/magazie/imprumuturi/imprumut.script.js'></SCRIPT>
    </HEAD>
    <BODY>
<?PHP

//VERIFICAM DACA S-A INTRODUS CEVA DATA IN FORMULAR SI O PROCESAM, LA NEVOIE

global $worker;global $furnizor;global $observatii; global $product;global $SAPcode;global $marca;global $sectia; global $size;

$motiv = 'Uz temporar';
$price = '0.00';
$stock = "0.00";
$amount = '1';
$units = 'N.A.';
$endDate = $date;
$endMaxDate = $endDate;

if(isset($_GET['nume']) && !empty($_GET['nume']))
{
	$nume = $_GET['nume'];
	if(isset($_GET['userid']) && !empty($_GET['userid'])) $user = $_GET['userid'];
	else $user = 'Unknown User';
}
else
{
	$warning = '<font size = 5><center><b>FATAL ERROR!<BR>Something unexpected went wrong!<BR>User name not set<br>Please, contact program administrator at<br><a href = "mailto: warehouse-soft@ramira.ro?subject=Fatal error feedback&body=The program has returned the next fatal error: '.__LINE__.'. '.__FILE__.': Something unexpected went wrong! USER NAME NOT SET!">warehouse-soft@ramira.ro</a>';
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
}
if(isset($_POST['rekrowImprumut']) && $_POST['rekrowImprumut'] != '' && $worker != 'Angajat INEXISTENT')
{
	$marca = $_POST['rekrowImprumut'];
	require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/worker.chk.php';
}
else if(isset($_POST['nume_angajat']) && $_POST['nume_angajat'] != '')
{
    $worker = $_POST['nume_angajat'];
    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/worker.chk.php';
}

if(isset($_POST['action']) && $_POST['action'] != '')
{
	$action = $_POST['action'];
	if(isset($_POST['product']) && $_POST['product'] != '' && $worker != '' && $worker != 'Angajat INEXISTENT')
	{
		$SAPcode = $_POST['product'];
		require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/product.chk.php';
	}
	if(isset($_POST['motiv']) && $_POST['motiv'] != '') $motiv = $_POST['motiv'];
	if(isset($_POST['dataEnd']) && $_POST['dataEnd'] != '') $endDate = $_POST['dataEnd'];
	if(isset($_POST['amount']) && $_POST['amount'] != '') $amount = $_POST['amount'];
	if(isset($_POST['observatii']) && !empty($_POST['observatii'])) $observatii = $_POST['observatii'];
	//echo __LINE__.'. '.__FILE__.': OK!';
	if($action == 'Adauga')
	{
		if($marca == '' || $marca == 'Angajat INEXISTENT') echo "<SCRIPT>alert('Marca angajat incorecta!\nMarca: '.$marca);</SCRIPT>";
	    else if($SAPcode == '' || $SAPcode == 'Cod invalid') echo "<SCRIPT>flashProduct();</SCRIPT>";
	    else if($stock == 0) echo "<SCRIPT>alert('Produsul nu este pe stoc!');</SCRIPT>";
	    else if($amount == 0 || $amount == '') echo '<SCRIPT>flashQuantity();</SCRIPT>';
	    else require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/declaratie.imprumut.php';
	}
	else if($action == 'Sterge')
	{
		if($worker == '' || $worker == 'Angajat INEXISTENT') echo "<SCRIPT>alert('Nume angajat incorect!');</SCRIPT>";
	    else if($SAPcode == '' || $SAPcode == 'Cod invalid') echo "<SCRIPT>flashProduct()</SCRIPT>";
	    else if($stock == 0) echo "<SCRIPT>alert('Produsul nu este pe stoc!');</SCRIPT>";
	    else if($amount == '') echo "<SCRIPT>flashQuantity();</SCRIPT>";
	    else require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/imprumuturi/stergere.declaratie.php';
	}
}
else $action = "Adauga";

?>
    </BODY>
</HTML>