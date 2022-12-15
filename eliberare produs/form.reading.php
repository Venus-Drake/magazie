<HTML>
    <HEAD>
	    <SCRIPT src='/ramira/magazie/eliberare produs/eliberare.script.js'></SCRIPT>
    </HEAD>

    <BODY>
		<?PHP
		
		global $worker; global $marca;global $product;global $SAPcode;global $furnizor;global $observatii; global $stornoOption;global $units;global $sectia; global $size;global $user;global $magazie;global $grupaMAT;global $masina;
		$stornoAmount = 1;
		$amount = 1;
		$stock = "0.00";
		$uzura = "Nou";
		if(isset($_GET['userid']) && $_GET['userid'] != '') $user = $_GET['userid'];
		else echo "<SCRIPT>window.location = '/ramira/magazie/index.php/';</SCRIPT>";
		if(isset($_GET['nume']) && $_GET['nume'] != '') $nume = $_GET['nume'];
		else echo "<SCRIPT>window.location = '/ramira/magazie/index.php/';</SCRIPT>";
		
		if(isset($_POST['rekrow']) && $_POST['rekrow'] != '' && $marca != 'Angajat INEXISTENT')
		{
			$marca = $_POST['rekrow'];
			require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/worker.chk.php';
		}
		else if(isset($_POST['nume_angajat']) && $_POST['nume_angajat'] != '')
		{
		    $worker = $_POST['nume_angajat'];
		    require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/worker.chk.php';
		}
		if(isset($_POST['action']) && $_POST['action'] != '' && isset($_POST['product']) && !empty($_POST['product']))
		{
			$action = $_POST['action'];
			if(isset($_POST['product']) && $_POST['product'] != '')
			{
				$SAPcode = $_POST['product'];
				require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/product.chk.php';
				if(isset($_POST['stornoOption']) && !empty($_POST['stornoOption']))
				{
					$stornoOption = $_POST['stornoOption'];
					$stornoAmount = $_POST['stornoAmount'];
					if($stornoOption == "casare") require 'C:\xampp\htdocs\ramira\magazie\eliberare produs\casare.produs.php';
					else if($stornoOption == "reascutire") require 'C:\xampp\htdocs\ramira\magazie\eliberare produs\storno.reascutire.php';
					$stornoOption = '';
				}
			}
			else
			{
				$product = ""; 
				$SAPcode = "";
				$furnizor = "";
				$price = '0.00';
				$units = "";
				echo '<SCRIPT>flashPRODUCT();</SCRIPT>';
			}
			if(isset($_POST['amount']) && !empty($_POST['amount']) && $worker != '' && $worker != 'Angajat INEXISTENT' && $SAPcode != '' && $SAPcode != 'Cod invalid') $amount = $_POST['amount'];
			else if(!isset($_POST['amount']) || empty($_POST['amount']) || $SAPcode == '' || $SAPcode == 'Cod invalid')
			{
				$amount = 1;
			}
			if(isset($_POST['observatii']) && !empty($_POST['observatii'])) $observatii = $_POST['observatii'];
			if($action == 'Adauga')
			{
				if($marca == '' || $marca == 'Angajat INEXISTENT')
				{
					echo '<SCRIPT>flashWORKER();</SCRIPT>';
				}
			    else if($SAPcode == '' || $SAPcode == 'Cod invalid') 
				{
					echo '<SCRIPT>flashPRODUCT();</SCRIPT>';
				}
			    else if($stock == 0 || $stock - $amount < 0)
			    {
				    echo '<SCRIPT>flashQuantity();</SCRIPT>';
			    }
			    else require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/bon.magazie.adaugare.php';
			}
			else if($action == 'Sterge')
			{
				if($worker == '' || $worker == 'Angajat INEXISTENT')
				{
				    $warning = '<font size = 5><center><B>Nume angajat incorect!<BR><FONT SIZE = 2>'.__LINE__.". ".__FILE__.'</FONT>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
				}
			    else if($SAPcode == '' || $SAPcode == 'Cod invalid')
			    {
				    echo '<SCRIPT>flashPRODUCT();</SCRIPT>';
			    }
			    else if($stock == 0)
			    {
				    $warning = '<font size = 5><center><B>Produsul nu este pe stoc!<BR><FONT SIZE = 2>'.__LINE__.". ".__FILE__.'</FONT>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
			    }
			    else if($amount == 0)
			    {
				    $warning = '<font size = 5><center><B>Introduceti cantitatea produsului!<BR><FONT SIZE = 2>'.__LINE__.". ".__FILE__.'</FONT>';
					require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/error.handler.php';
			    }
			    else require $_SERVER['DOCUMENT_ROOT'].'/ramira/magazie/eliberare produs/bon.magazie.stergere.php';
			}
		}
		else $action = "Adauga";
		
		?>

        <SCRIPT src='/ramira/magazie/main.script.js'></SCRIPT>

    </BODY>
</HTML>