<?php


	$last_tot_data = 0;
	$colorstyle = '#01a0e8';
	// create new PDF document
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('富祥牙體技術所');
	$pdf->SetTitle('學生繳費單');
	$pdf->SetSubject('匯出');
	$pdf->SetKeywords('TCPDF, PDF, mido-9, firm, guide');

	// set default header data
	//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

	// set header and footer fonts
	//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// remove default header/footer
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);

	// set auto page breaks
	$PDF_MARGIN_BOTTOM = 1;
	$pdf->SetAutoPageBreak(TRUE, $PDF_MARGIN_BOTTOM);
	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	// set font
	$pdf->SetFont('dejavuserifcondensedbi', '', 12, '', true);//這個字形可以解決中文亂碼
	//$_SESSION["puid"]=$paysheet_puid;

	
	//Close and output PDF document
	ob_end_clean();
	$pdf->Output('Mido9-bill.pdf','I');
?>
