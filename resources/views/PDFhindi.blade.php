<?php 
$content = "
<!DOCTYPE html>
<html>
<head>
	<title>MPDF</title>
</head>
<body>
	<p style='font-family:ind_hi_1_001;'>
		 सुशांत ड्रग्स केस में एनसीबी ने चार्जशीट दाखिल कर दी है. इस चार्जशीट में 40 हजार पन्ने सॉफ्ट कॉपी में थे और 12 हजार पन्ने हार्ड कॉपी के थे.;
	</p>
</body>
</html>
";

include("/mpdf/mpdf.php");

$mpdf=new mPDF('utf-8','A4');
$mpdf->WriteHTML($content);
$mpdf->Output();

?>