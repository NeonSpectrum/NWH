<?php 
	use setasign\Fpdi\Fpdi;
	use setasign\Fpdi\PdfReader;
	require '../fpdf/fpdf.php';
	require '../fpdi/autoload.php';
	require_once '../files/db.php';
	if(isset($_GET['BookingID']))
	{
	$query = "SELECT FirstName,LastName,BookingID,account.EmailAddress,RoomID,CheckInDate,CheckOutDate FROM booking JOIN account ON booking.EmailAddress = account.EmailAddress WHERE BookingID={$_GET['BookingID']}";
		$result = mysqli_query($db,$query);
		while($row = mysqli_fetch_assoc($result)){
			$pdf = new Fpdi();
			$pdf->AddPage();
			$pdf->setSourceFile('reservation.pdf');
			$tpl = $pdf->importPage(1);
			$pdf->useTemplate($tpl, 5, 10, 200);
			$pdf->SetFont('Arial');
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFontSize('10');

			$pdf->SetFont('Arial','B','9');
			$pdf->SetXY(25, 60.7);
			$pdf->Write(0, "{$row['FirstName']} {$row['LastName']}");
			$pdf->SetFontSize('10');
			$pdf->SetFont('Arial');
			$pdf->SetXY(48, 87.5);
			$pdf->Write(0, date("d F Y", strtotime($row['CheckInDate'])));
			$pdf->SetXY(48, 92);
			$pdf->Write(0, date("d F Y", strtotime($row['CheckOutDate'])));
			$pdf->SetXY(48, 97);
			$pdf->SetFont('Arial','B');
			$pdf->Write(0, "{$row['FirstName']} {$row['LastName']}");
			$pdf->SetFont('Arial');
			$pdf->SetXY(48, 101.5);
			$pdf->Write(0, sprintf("%'06d\n",$row['BookingID']));
			$pdf->SetXY(135, 87.5);
			$pdf->Write(0, "2:00pm");
			$pdf->SetXY(135, 92);
			$pdf->Write(0, "12:00nn");
			$pdf->SetXY(135, 97);
			$pdf->Write(0, "{$row['RoomID']}");
			$pdf->SetXY(135, 101.5);
			$pdf->Write(0, "P5000.00");

			$pdf->Output();
		}
	}
?>