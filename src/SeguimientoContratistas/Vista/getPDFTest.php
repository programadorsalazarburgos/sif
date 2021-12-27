<?php
namespace SeguimientoContratistas\Controlador;
require_once "../../../Vendor/autoload.php";
use SeguimientoContratistas\Controlador\InformePagoController;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
try {
	ob_start();
	?> 
	<style type="text/css">
	table{
		mso-displayed-decimal-separator:"\,";
		mso-displayed-thousand-separator:"\.";
	}
	.font525986{
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
	}
	.font625986
	{
		color:windowtext;
		font-size:11.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
	}
	.font725986
	{
		color:windowtext;
		font-size:9.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
	}
	.font825986
	{
		color:windowtext;
		font-size:8.0pt;
		font-weight:400;
		font-style:italic;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
	}
	.font925986
	{
		color:black;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
	}
	.font1025986
	{
		color:black;
		font-size:9.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Tahoma, sans-serif;
		mso-font-charset:0;
	}
	.font1125986
	{
		color:black;
		font-size:9.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Tahoma, sans-serif;
		mso-font-charset:1;
	}
	.font1225986
	{
		color:black;
		font-size:9.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Tahoma, sans-serif;
		mso-font-charset:0;
	}
	.font1325986
	{
		color:black;
		font-size:8.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:"Times New Roman", serif;
		mso-font-charset:0;
	}
	.font1425986
	{
		color:black;
		font-size:9.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Tahoma, sans-serif;
		mso-font-charset:0;
	}
	.xl6325986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:general;
		vertical-align:bottom;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl6425986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:general;
		vertical-align:middle;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl6525986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:general;
		vertical-align:middle;
		border-top:none;
		border-right:none;
		border-bottom:none;
		border-left:.5pt solid black;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl6625986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:general;
		vertical-align:middle;
		border-top:none;
		border-right:.5pt solid black;
		border-bottom:none;
		border-left:none;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl6725986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:12.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl6825986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:12.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border-top:.5pt hairline black;
		border-right:.5pt solid black;
		border-bottom:.5pt solid black;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl6925986
	{
		padding:0px;
		mso-ignore:padding;
		color:black;
		font-size:8.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Arial Narrow", sans-serif;
		mso-font-charset:0;
		mso-number-format:"Short Date";
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl7025986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:9.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:general;
		vertical-align:middle;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl7125986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"\0022$ \0022\#\,\#\#0";
		text-align:general;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:none;
		border-bottom:.5pt solid black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl7225986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:none;
		border-bottom:none;
		border-left:.5pt solid black;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl7325986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl7425986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:.5pt solid black;
		border-bottom:none;
		border-left:none;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl7525986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:none;
		border-bottom:none;
		border-left:none;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl7625986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:general;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:none;
		border-bottom:none;
		border-left:none;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl7725986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:general;
		vertical-align:middle;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl7825986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl7925986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:general;
		vertical-align:middle;
		border-top:.5pt hairline black;
		border-right:none;
		border-bottom:.5pt hairline black;
		border-left:.5pt hairline black;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl8025986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:general;
		vertical-align:middle;
		border-top:none;
		border-right:none;
		border-bottom:.5pt solid black;
		border-left:.5pt solid black;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl8125986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:general;
		vertical-align:middle;
		border-top:none;
		border-right:none;
		border-bottom:.5pt solid black;
		border-left:none;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl8225986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:general;
		vertical-align:middle;
		border-top:none;
		border-right:.5pt solid black;
		border-bottom:.5pt solid black;
		border-left:none;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl8325986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:general;
		vertical-align:middle;
		border:.5pt hairline black;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl8425986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"\@";
		text-align:general;
		vertical-align:middle;
		background:white;
		mso-pattern:#E6E6E6 none;
		white-space:nowrap;
	}
	.xl8525986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:general;
		vertical-align:middle;
		background:white;
		mso-pattern:#E6E6E6 none;
		white-space:nowrap;
	}
	.xl8625986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"mm\/yy";
		text-align:general;
		vertical-align:middle;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl8725986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;
	}
	.xl8825986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:general;
		vertical-align:bottom;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;
	}
	.xl8925986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl9025986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		background:white;
		mso-pattern:#E6E6E6 none;
		white-space:nowrap;
	}
	.xl9125986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:none;
		border-bottom:.5pt solid black;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:normal;
	}
	.xl9225986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:none;
		border-bottom:.5pt solid black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:normal;
	}
	.xl9325986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:.5pt solid black;
		border-bottom:.5pt solid black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:normal;
	}
	.xl9425986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"Short Date";
		text-align:left;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:none;
		border-bottom:.5pt solid black;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl9525986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"Short Date";
		text-align:left;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:.5pt solid black;
		border-bottom:.5pt solid black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl9625986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:.5pt hairline black;
		border-right:none;
		border-bottom:none;
		border-left:.5pt solid black;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl9725986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:.5pt hairline black;
		border-right:none;
		border-bottom:none;
		border-left:none;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl9825986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:.5pt hairline black;
		border-right:.5pt solid black;
		border-bottom:none;
		border-left:none;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl9925986
	{
		padding:0px;
		mso-ignore:padding;
		color:black;
		font-size:11.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:.5pt hairline black;
		border-right:none;
		border-bottom:.5pt hairline black;
		border-left:.5pt solid black;
		background:white;
		mso-pattern:#E6E6E6 none;
		white-space:nowrap;
	}
	.xl10025986
	{
		padding:0px;
		mso-ignore:padding;
		color:black;
		font-size:11.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:.5pt hairline black;
		border-right:none;
		border-bottom:.5pt hairline black;
		border-left:none;
		background:white;
		mso-pattern:#E6E6E6 none;
		white-space:nowrap;
	}
	.xl10125986
	{
		padding:0px;
		mso-ignore:padding;
		color:black;
		font-size:11.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:.5pt hairline black;
		border-right:.5pt solid black;
		border-bottom:.5pt hairline black;
		border-left:none;
		background:white;
		mso-pattern:#E6E6E6 none;
		white-space:nowrap;
	}
	.xl10225986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:justify;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:none;
		border-bottom:none;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;
	}
	.xl10325986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:justify;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:none;
		border-bottom:none;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;
	}
	.xl10425986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:justify;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:.5pt solid black;
		border-bottom:none;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;
	}
	.xl10525986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:justify;
		vertical-align:middle;
		border-top:none;
		border-right:none;
		border-bottom:.5pt hairline black;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;
	}
	.xl10625986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:justify;
		vertical-align:middle;
		border-top:none;
		border-right:none;
		border-bottom:.5pt hairline black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;
	}
	.xl10725986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:justify;
		vertical-align:middle;
		border-top:none;
		border-right:.5pt solid black;
		border-bottom:.5pt hairline black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;
	}
	.xl10825986
	{
		padding:0px;
		mso-ignore:padding;
		color:silver;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"Short Date";
		text-align:left;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:none;
		border-bottom:.5pt solid black;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl10925986
	{
		padding:0px;
		mso-ignore:padding;
		color:silver;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"Short Date";
		text-align:left;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:none;
		border-bottom:.5pt solid black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl11025986
	{
		padding:0px;
		mso-ignore:padding;
		color:silver;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"Short Date";
		text-align:left;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:.5pt solid black;
		border-bottom:.5pt solid black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl11125986
	{
		padding:0px;
		mso-ignore:padding;
		color:red;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:none;
		border-bottom:.5pt solid black;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;
	}
	.xl11225986
	{
		padding:0px;
		mso-ignore:padding;
		color:red;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:none;
		border-bottom:.5pt solid black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;
	}
	.xl11325986
	{
		padding:0px;
		mso-ignore:padding;
		color:red;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:.5pt solid black;
		border-bottom:.5pt solid black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;
	}
	.xl11425986
	{
		padding:0px;
		mso-ignore:padding;
		color:silver;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"Short Date";
		text-align:center;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:none;
		border-bottom:.5pt solid black;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl11525986
	{
		padding:0px;
		mso-ignore:padding;
		color:silver;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"Short Date";
		text-align:center;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:.5pt solid black;
		border-bottom:.5pt solid black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl11625986
	{
		padding:0px;
		mso-ignore:padding;
		color:silver;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"Short Date";
		text-align:center;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:none;
		border-bottom:.5pt solid black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl11725986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"Short Date";
		text-align:center;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:none;
		border-bottom:.5pt solid black;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl11825986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"Short Date";
		text-align:center;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:.5pt solid black;
		border-bottom:.5pt solid black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl11925986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:9.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl12025986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"Short Date";
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl12125986
	{
		padding:0px;
		mso-ignore:padding;
		color:silver;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"Short Date";
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl12225986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:top;
		border:.5pt solid black;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl12325986
	{
		padding:0px;
		mso-ignore:padding;
		color:gray;
		font-size:8.0pt;
		font-weight:400;
		font-style:italic;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:justify;
		vertical-align:top;
		border:.5pt solid black;
		background:white;
		mso-pattern:#E6E6E6 none;
		mso-protection:unlocked visible;
		white-space:normal;
	}
	.xl12425986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		background:#E6E6E6;
		mso-pattern:white none;
		white-space:nowrap;
	}
	.xl12525986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;
	}
	.xl12625986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;
	}
	.xl12725986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		background:white;
		mso-pattern:#E6E6E6 none;
		white-space:nowrap;
	}
	.xl12825986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		background:white;
		mso-pattern:#E6E6E6 none;
		white-space:normal;
	}
	.xl12925986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:general;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;
	}
	.xl13025986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:400;
		font-style:italic;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;
	}
	.xl13125986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;
	}
	.xl13225986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:normal;
	}
	.xl13325986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"\0022$ \0022\#\,\#\#0";
		text-align:left;
		vertical-align:middle;
		border-top:none;
		border-right:.5pt solid black;
		border-bottom:.5pt solid black;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl13425986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"\[$$-240A\]\\ \#\,\#\#0";
		text-align:left;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;
	}
	.xl13525986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:general;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:normal;
	}
	.xl13625986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"\0022$ \0022\#\,\#\#0";
		text-align:left;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl13725986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"\[$$-240A\]\\ \#\,\#\#0";
		text-align:left;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl13825986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"\[$$-240A\]\\ \#\,\#\#0";
		text-align:left;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:.5pt solid black;
		border-bottom:none;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;
	}
	.xl13925986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"\0022$ \0022\#\,\#\#0";
		text-align:left;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;
	}
	.xl14025986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"\0022$ \0022\#\,\#\#0";
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl14125986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"\[$$-240A\]\\ \#\,\#\#0";
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl14225986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:top;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl14325986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:top;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;
	}
	.xl14425986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"\#\,\#\#0";
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;
	}
	.xl14525986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:9.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;
	}
	.xl14625986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:9.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		background:white;
		mso-pattern:#E6E6E6 none;
		white-space:nowrap;
	}
	.xl14725986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:top;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:normal;
	}
	.xl14825986
	{
		padding:0px;
		mso-ignore:padding;
		color:black;
		font-size:8.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Arial Narrow", sans-serif;
		mso-font-charset:0;
		mso-number-format:"Short Date";
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;
	}
	.xl14925986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border-top:none;
		border-right:.5pt solid black;
		border-bottom:.5pt solid black;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl15025986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:9.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:normal;
	}
	.xl15125986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:.5pt hairline black;
		border-right:.5pt hairline black;
		border-bottom:none;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;
	}
	.xl15225986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:.5pt hairline black;
		border-right:.5pt hairline black;
		border-bottom:none;
		border-left:.5pt hairline black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;
	}
	.xl15325986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:.5pt hairline black;
		border-right:none;
		border-bottom:none;
		border-left:.5pt hairline black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;
	}
	.xl15425986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"Short Date";
		text-align:center;
		vertical-align:middle;
		border:.5pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl15525986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:justify;
		vertical-align:top;
		border-top:.5pt hairline black;
		border-right:.5pt hairline black;
		border-bottom:none;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:normal;
	}
	.xl15625986
	{
		padding:0px;
		mso-ignore:padding;
		color:gray;
		font-size:8.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Arial Narrow", sans-serif;
		mso-font-charset:0;
		mso-number-format:"\@";
		text-align:center;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:.5pt solid black;
		border-bottom:none;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl15725986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:none;
		border-bottom:.5pt solid black;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:normal;
	}
	.xl15825986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl15925986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:.5pt solid black;
		border-bottom:.5pt solid black;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl16025986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:.5pt solid black;
		border-bottom:.5pt solid black;
		border-left:none;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl16125986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl16225986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:.5pt solid black;
		border-bottom:.5pt hairline black;
		border-left:.5pt solid black;
		background:#E6E6E6;
		mso-pattern:white none;
		white-space:nowrap;
	}
	.xl16325986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;
	}
	.xl16425986
	{
		padding:0px;
		mso-ignore:padding;
		color:black;
		font-size:12.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;
	}
	.xl16525986
	{
		padding:0px;
		mso-ignore:padding;
		color:black;
		font-size:12.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:.5pt solid black;
		border-bottom:none;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:normal;
	}
	.xl16625986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:justify;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:.5pt solid black;
		border-bottom:.5pt hairline black;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:normal;
	}
	.xl16725986
	{
		padding:0px;
		mso-ignore:padding;
		color:gray;
		font-size:8.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:"Arial Narrow", sans-serif;
		mso-font-charset:0;
		mso-number-format:"\@";
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl16825986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border:.5pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl16925986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:8.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border:.5pt solid windowtext;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl17025986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:normal;
	}
	.xl17125986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl17225986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;
	}
	.xl17325986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:.5pt solid black;
		border-bottom:none;
		border-left:.5pt solid black;
		background:#E6E6E6;
		mso-pattern:white none;
		white-space:normal;
	}
	.xl17425986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;
	}
	.xl17525986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border:.5pt solid black;
		background:#E6E6E6;
		mso-pattern:white none;
		white-space:nowrap;
	}
	.xl17625986
	{
		padding:0px;
		mso-ignore:padding;
		color:#E6E6E6;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"\@";
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl17725986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:none;
		border-right:.5pt solid black;
		border-bottom:.5pt hairline black;
		border-left:.5pt solid black;
		background:#E6E6E6;
		mso-pattern:white none;
		white-space:nowrap;
	}
	.xl17825986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:12.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:general;
		vertical-align:middle;
		border-top:.5pt hairline black;
		border-right:.5pt hairline black;
		border-bottom:.5pt solid black;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl17925986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border-top:.5pt hairline black;
		border-right:.5pt hairline black;
		border-bottom:none;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;
	}
	.xl18025986
	{
		padding:0px;
		mso-ignore:padding;
		color:gray;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:"\@";
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl18125986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:.5pt solid black;
		border-bottom:none;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		white-space:nowrap;
	}
	.xl18225986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:10.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border-top:.5pt solid black;
		border-right:.5pt solid black;
		border-bottom:none;
		border-left:.5pt solid black;
		mso-background-source:auto;
		mso-pattern:auto;
		mso-protection:unlocked visible;
		white-space:nowrap;
	}
	.xl18325986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:11.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		background:white;
		mso-pattern:#E6E6E6 none;
		white-space:nowrap;
	}
	.xl18425986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:12.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		background:white;
		mso-pattern:#E6E6E6 none;
		white-space:nowrap;
	}
	.xl18525986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:12.0pt;
		font-weight:400;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:left;
		vertical-align:middle;
		border:.5pt solid black;
		background:white;
		mso-pattern:#E6E6E6 none;
		white-space:nowrap;
	}
	.xl18625986
	{
		padding:0px;
		mso-ignore:padding;
		color:windowtext;
		font-size:12.0pt;
		font-weight:700;
		font-style:normal;
		text-decoration:none;
		font-family:Arial, sans-serif;
		mso-font-charset:0;
		mso-number-format:General;
		text-align:center;
		vertical-align:middle;
		border:.5pt solid black;
		background:white;
		mso-pattern:#E6E6E6 none;
		white-space:normal;
	}
	.tbl{
     width: 595pt;
    }

</style>
<page style="font-size: 11px">
	<div class="form-group text-center row">
		<div align=center>
			<table border=0 cellpadding=0 cellspacing=0 width=1107 class=tbl style='border-collapse:collapse;table-layout:fixed;width:831pt'>
				<col class=xl6325986 width=9 style='mso-width-source:userset;mso-width-alt:
				329;width:7pt'>
				<col class=xl6425986 width=26 style='mso-width-source:userset;mso-width-alt:
				950;width:20pt'>
				<col class=xl6425986 width=31 style='mso-width-source:userset;mso-width-alt:
				1133;width:23pt'>
				<col class=xl6425986 width=40 style='mso-width-source:userset;mso-width-alt:
				1462;width:30pt'>
				<col class=xl6425986 width=4 style='mso-width-source:userset;mso-width-alt:
				146;width:3pt'>
				<col class=xl6425986 width=35 style='mso-width-source:userset;mso-width-alt:
				1280;width:26pt'>
				<col class=xl6425986 width=45 style='mso-width-source:userset;mso-width-alt:
				1645;width:34pt'>
				<col class=xl6425986 width=24 span=2 style='mso-width-source:userset;
				mso-width-alt:877;width:18pt'>
				<col class=xl6425986 width=63 style='mso-width-source:userset;mso-width-alt:
				2304;width:47pt'>
				<col class=xl6425986 width=64 style='mso-width-source:userset;mso-width-alt:
				2340;width:48pt'>
				<col class=xl6425986 width=0 style='display:none;mso-width-source:userset;
				mso-width-alt:0'>
				<col class=xl6425986 width=11 style='mso-width-source:userset;mso-width-alt:
				402;width:8pt'>
				<col class=xl6425986 width=67 style='mso-width-source:userset;mso-width-alt:
				2450;width:50pt'>
				<col class=xl6425986 width=34 style='mso-width-source:userset;mso-width-alt:
				1243;width:26pt'>
				<col class=xl6425986 width=39 style='mso-width-source:userset;mso-width-alt:
				1426;width:29pt'>
				<col class=xl6425986 width=33 style='mso-width-source:userset;mso-width-alt:
				1206;width:25pt'>
				<col class=xl6425986 width=24 style='mso-width-source:userset;mso-width-alt:
				877;width:18pt'>
				<col class=xl6425986 width=19 style='mso-width-source:userset;mso-width-alt:
				694;width:14pt'>
				<col class=xl6425986 width=44 style='mso-width-source:userset;mso-width-alt:
				1609;width:33pt'>
				<col class=xl6425986 width=23 style='mso-width-source:userset;mso-width-alt:
				841;width:17pt'>
				<col class=xl6425986 width=19 style='mso-width-source:userset;mso-width-alt:
				694;width:14pt'>
				<col class=xl6425986 width=0 style='display:none;mso-width-source:userset;
				mso-width-alt:0'>
				<col class=xl6425986 width=40 style='mso-width-source:userset;mso-width-alt:
				1462;width:30pt'>
				<col class=xl6425986 width=51 style='mso-width-source:userset;mso-width-alt:
				1865;width:38pt'>
				<col class=xl6425986 width=34 style='mso-width-source:userset;mso-width-alt:
				1243;width:26pt'>
				<col class=xl6425986 width=22 style='mso-width-source:userset;mso-width-alt:
				804;width:17pt'>
				<col class=xl6425986 width=50 style='mso-width-source:userset;mso-width-alt:
				1828;width:38pt'>
				<col class=xl6425986 width=40 style='mso-width-source:userset;mso-width-alt:
				1462;width:30pt'>
				<col class=xl6425986 width=34 style='mso-width-source:userset;mso-width-alt:
				1243;width:26pt'>
				<col class=xl6425986 width=19 span=2 style='mso-width-source:userset;
				mso-width-alt:694;width:14pt'>
				<col class=xl6425986 width=30 style='mso-width-source:userset;mso-width-alt:
				1097;width:23pt'>
				<col class=xl6425986 width=19 style='mso-width-source:userset;mso-width-alt:
				694;width:14pt'>
				<col class=xl6425986 width=16 style='mso-width-source:userset;mso-width-alt:
				585;width:12pt'>
				<col class=xl6425986 width=43 style='mso-width-source:userset;mso-width-alt:
				1572;width:32pt'>
				<col class=xl6425986 width=12 style='mso-width-source:userset;mso-width-alt:
				438;width:9pt'>
				<col class=xl6425986 width=0 span=13 style='display:none;mso-width-source:
				userset;mso-width-alt:0'>
				<col class=xl6425986 width=0 span=13 style='display:none;mso-width-source:
				userset;mso-width-alt:0'>
				<tr height=10 style='height:7.5pt'>
					<td height=10 class=xl6325986 width=9 style='height:7.5pt;width:7pt'></td>
					<td class=xl6425986 width=26 style='width:20pt'>&nbsp;</td>
					<td class=xl6425986 width=31 style='width:23pt'>&nbsp;</td>
					<td class=xl6425986 width=40 style='width:30pt'>&nbsp;</td>
					<td class=xl6425986 width=4 style='width:3pt'>&nbsp;</td>
					<td class=xl6425986 width=35 style='width:26pt'>&nbsp;</td>
					<td class=xl6425986 width=45 style='width:34pt'>&nbsp;</td>
					<td class=xl6425986 width=24 style='width:18pt'>&nbsp;</td>
					<td class=xl6425986 width=24 style='width:18pt'>&nbsp;</td>
					<td class=xl6425986 width=63 style='width:47pt'>&nbsp;</td>
					<td class=xl6425986 width=64 style='width:48pt'>&nbsp;</td>
					<td class=xl6425986 width=0>&nbsp;</td>
					<td class=xl6425986 width=11 style='width:8pt'>&nbsp;</td>
					<td class=xl6425986 width=67 style='width:50pt'>&nbsp;</td>
					<td class=xl6425986 width=34 style='width:26pt'>&nbsp;</td>
					<td class=xl6425986 width=39 style='width:29pt'>&nbsp;</td>
					<td class=xl6425986 width=33 style='width:25pt'>&nbsp;</td>
					<td class=xl6425986 width=24 style='width:18pt'>&nbsp;</td>
					<td class=xl6425986 width=19 style='width:14pt'>&nbsp;</td>
					<td class=xl6425986 width=44 style='width:33pt'>&nbsp;</td>
					<td class=xl6425986 width=23 style='width:17pt'>&nbsp;</td>
					<td class=xl6425986 width=19 style='width:14pt'>&nbsp;</td>
					<td class=xl6425986 width=0>&nbsp;</td>
					<td class=xl6425986 width=40 style='width:30pt'>&nbsp;</td>
					<td class=xl6425986 width=51 style='width:38pt'>&nbsp;</td>
					<td class=xl6425986 width=34 style='width:26pt'>&nbsp;</td>
					<td class=xl6425986 width=22 style='width:17pt'>&nbsp;</td>
					<td class=xl6425986 width=50 style='width:38pt'>&nbsp;</td>
					<td class=xl6425986 width=40 style='width:30pt'>&nbsp;</td>
					<td class=xl6425986 width=34 style='width:26pt'>&nbsp;</td>
					<td class=xl6425986 width=19 style='width:14pt'>&nbsp;</td>
					<td class=xl6425986 width=19 style='width:14pt'>&nbsp;</td>
					<td class=xl6425986 width=30 style='width:23pt'>&nbsp;</td>
					<td class=xl6425986 width=19 style='width:14pt'>&nbsp;</td>
					<td class=xl6425986 width=16 style='width:12pt'>&nbsp;</td>
					<td class=xl6425986 width=43 style='width:32pt'>&nbsp;</td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:14.25pt'>
					<td height=19 class=xl6325986 style='height:14.25pt'></td>
					<td colspan=8 rowspan=8 height=136 width=100 style='height:120.2pt;
					width:100pt' align=left valign=top><span style='mso-ignore:vglayout;
					position:absolute;z-index:21;margin-left:29px;margin-top:5px;width:100px;
					height:127px'><img width=138 height=127
					src="../../../public/imagenes/logo_alcaldia_largo.png"
					v:shapes="_x0035__x0020_Imagen"></span>
					<span style='mso-ignore:vglayout2'>
						<table cellpadding=0 cellspacing=0>
							<tr>
								<td colspan=8 rowspan=8 height=136 class=xl18325986 width=229
								style='height:120.2pt;width:172pt'><a name="RANGE!B2:AJ85">&nbsp;</a></td>
							</tr>
						</table></span>
					</td>
					<td colspan=16 rowspan=5 class=xl18425986>GESTIÓN FINANCIERA</td>
					<td colspan=11 rowspan=2 class=xl18525986>Código: 3TR-GFI-F-01</td>
				</tr>
				<tr height=10 style='mso-height-source:userset;height:7.5pt'>
					<td height=10 class=xl6325986 style='height:7.5pt'></td>
				</tr>
				<tr height=10 style='mso-height-source:userset;height:7.5pt'>
					<td height=10 class=xl6325986 style='height:7.5pt'></td>
					<td colspan=11 rowspan=3 class=xl18525986>Fecha: 05/02/2018</td>
				</tr>
				<tr height=13 style='mso-height-source:userset;height:9.75pt'>
					<td height=13 class=xl6325986 style='height:9.75pt'></td>
				</tr>
				<tr height=10 style='mso-height-source:userset;height:7.5pt'>
					<td height=10 class=xl6325986 style='height:7.5pt'></td>
				</tr>

				<tr height=16 style='mso-height-source:userset;height:12.6pt'>
					<td height=16 class=xl6325986 style='height:12.6pt'></td>
					<td colspan=16 rowspan=3 class=xl18625986 width=531 style='width:397pt'>INFORME
						PARA PAGO (PERSONA NATURAL Y/O JURÍDICA)
					</td>
					<td colspan=11 rowspan=3 class=xl18525986>Versión: 1</td>
				</tr>
				<tr height=4 style='mso-height-source:userset;height:3.0pt'>
					<td height=4 class=xl6325986 style='height:3.0pt'></td>

				</tr>
				<tr height=4 style='mso-height-source:userset;height:3.0pt'>
					<td height=4 class=xl6325986 style='height:3.0pt'></td>

				</tr>
				<tr height=28 style='mso-height-source:userset;height:21.0pt'>
					<td height=28 class=xl6325986 style='height:21.0pt'></td>
					<td colspan=8 class=xl17525986>Fecha del Informe
					</td>
					<td colspan=8 class=xl18025986 data-toggle="tooltip" title="Este campo se colocará automaticamente al descargar el PDF" data-placement="right">DD/MM/AAAA</td>

					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6625986>&nbsp;</td>
				</tr>
				<tr height=36 style='mso-height-source:userset;height:27.0pt'>
					<td height=36 class=xl6325986 style='height:27.0pt'></td>
					<td colspan=7 class=xl17425986>PERÍODO DEL INFORME</td>
					<td colspan=5 class=xl18025986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=5 class=xl18025986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=10 class=xl17425986 style='border-left:none;height:  10px;color:black;'>No. DEL CONTRATO
					</td>
					<td colspan=8 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
				</tr>
				<tr height=39 style='mso-height-source:userset;height:29.25pt'>
					<td height=39 class=xl6325986 style='height:29.25pt'></td>
					<td colspan=13 class=xl17425986>NOMBRES Y APELLIDOS DEL CONTRATISTA</td>
					<td colspan=14 class=xl17125986 st style='border-left:none;height: 10px;'></td>
					<td colspan=3 class=xl17425986 style='border-left:none;height:  10px;color:black;'>

					</td>
					<td colspan=5 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
				</tr>
				<tr height=39 style='mso-height-source:userset;height:29.25pt'>
					<td height=39 class=xl6325986 style='height:29.25pt'></td>
					<td colspan=13 class=xl17425986>ACTIVIDAD ECONÓMICA (CIIU)</td>
					<td colspan=14 class=xl12025986 style='border-left:none;height:  10px;color:black;'> </td>
					<td colspan=8 class=xl12025986></td>
				</tr>
				<tr height=49 style='mso-height-source:userset;height:36.75pt'>
					<td height=49 class=xl6325986 style='height:36.75pt'></td>
					<td colspan=13 class=xl17025986 width=434 style='width:325pt'>NOMBRES Y
						APELLIDOS DEL CONTRATISTA CEDENTE<br>(Diligencie este item, en caso de cesión de contrato)
					</td>
					<td colspan=14 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=3 class=xl17425986 style='border-left:none;height:  10px;color:black;'>

					</td>
					<td colspan=5 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
				</tr>

				<tr height=23 style='mso-height-source:userset;height:17.25pt'>
					<td height=23 class=xl6325986 style='height:17.25pt'>
					</td>
					<td colspan=35 class=xl17325986 width=1086 style='width:815pt'>INFORMACIÓN
						BANCARIA DEL CONTRATISTA A QUIEN SE LE VA A GIRAR
					</td>
				</tr>
				<tr height=23 style='mso-height-source:userset;height:17.25pt'>
					<td height=23 class=xl6325986 style='height:17.25pt'></td>
					<td colspan=3 rowspan=2 class=xl17425986>BANCO:</td>
					<td colspan=9 rowspan=2 class=xl16125986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=5 rowspan=2 class=xl17425986>TIPO DE CUENTA:</td>
					<td colspan=6 rowspan=2 class=xl17125986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=4 rowspan=2 class=xl17425986>No. CUENTA:</td>
					<td colspan=8 rowspan=2 class=xl16125986 style='border-left:none;height:  10px;color:black;'></td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:14.25pt'>
					<td height=19 class=xl6325986 style='height:14.25pt'></td>
				</tr>
				<tr height=24 style='mso-height-source:userset;height:18.0pt'>
					<td height=24 class=xl6325986 style='height:18.0pt'></td>
					<td colspan=35 class=xl16225986>INFORMACIÓN DEL CONTRATO</td>
				</tr>
				<tr height=50 style='mso-height-source:userset;height:37.5pt'>
					<td height=50 class=xl6325986 style='height:37.5pt'></td>
					<td colspan=4 class=xl16325986>Objeto:</td>
					<td colspan=31 class=xl16425986 width=985 style='border-left:none;height:  10px;color:black;'></td>
				</tr>

				<tr height=30 style='mso-height-source:userset;height:22.5pt'>
					<td height=30 class=xl6325986 style='height:22.5pt'></td>
					<td colspan=4 class=xl16325986 width=101 style='width:76pt'>Fecha de
						Inicio
					</td>
					<td colspan=5 class=xl18025986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=4 rowspan=2 class=xl16325986>Plazo Inicial:</td>
					<td colspan=4 rowspan=2 class=xl15925986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=4 rowspan=2 class=xl16325986>Prórrogas:
					</td>
					<td colspan=5 rowspan=2 class=xl15925986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=4 rowspan=2 class=xl16325986>Fecha Final:</td>
					<td colspan=5 rowspan=2 class=xl15925986 style='border-left:none;height:  10px;color:black;'></td>
				</tr>
				<tr height=32 style='mso-height-source:userset;height:24.0pt'>
					<td height=32 class=xl6325986 style='height:24.0pt'></td>
					<td colspan=4 class=xl16325986 width=101 style='width:76pt'>Fecha Terminación</td>
					<td colspan=5 class=xl18025986 style='border-left:none;height:  10px;color:black;'></td>
				</tr>
				<tr height=23 style='mso-height-source:userset;height:17.25pt'>
					<td height=23 class=xl6325986 style='height:17.25pt'></td>
					<td colspan=9 class=xl15725986 width=292 style='width:219pt'>Número de pagos pactados
					</td>
					<td colspan=4 class=xl12025986 style='height: 10px;color:black;'></td>
					<td colspan=22 class=xl15925986>&nbsp;</td>
				</tr>
				<tr height=32 style='mso-height-source:userset;height:24.0pt'>
					<td height=32 class=xl6325986 style='height:24.0pt'></td>
					<td colspan=4 class=xl14725986 width=101 style='width:76pt'>Pago No.
					</td>
					<td colspan=2 class=xl12025986 style='height: 10px;color:black;'></td>
					<td colspan=2 class=xl12025986 style='height:  10px;color:black;'>de</td>
					<td class=xl12025986 style='height:10px;color:black;'></td>
					<td colspan=26 class=xl6425986>&nbsp;</td>
				</tr>
				<tr height=32 style='mso-height-source:userset;height:24.0pt'>
					<td height=32 class=xl6325986 style='height:24.0pt'></td>
					<td colspan=35 class=xl12425986>INFORMACIÓN FINANCIERA DEL CONTRATO</td>
				</tr>
				<tr height=45 style='mso-height-source:userset;height:33.75pt'>
					<td height=45 class=xl6325986 style='height:33.75pt'></td>
					<td colspan=4 class=xl15025986 width=101 style='width:76pt'>No REGISTRO<br>PRESUPUESTAL</td>
					<td colspan=5 class=xl15025986>CÓDIGO FUENTE</td>
					<td colspan=4 class=xl15025986>CONVENIO</td>
					<td colspan=4 class=xl15025986>VALOR A PAGAR</td>
					<td colspan=5 class=xl15025986 width=105 style='border-left:none;width:78pt'>No
						REGISTRO<br>
						PRESUPUESTAL
					</td>
					<td colspan=5 class=xl15025986>CÓDIGO FUENTE
					</td>
					<td colspan=4 class=xl15025986>CONVENIO</td>
					<td colspan=4 class=xl15025986>VALOR A PAGAR</td>
				</tr>
				<tr height=23 style='mso-height-source:userset;height:17.25pt'>
					<td height=23 class=xl6325986 style='height:17.25pt'></td>
					<td colspan=4 class=xl14225986 style='height:10px;color:black;'></td>
					<td colspan=5 class=xl14225986 style='border-left:none;height:  10px;color:black;'>
					</td>
					<td colspan=4 class=xl14225986 style='border-left:none;height:  10px;color:black;'>
					</td>
					<td colspan=4 class=xl14225986 style='height:10px;color:black;'></td>
					<td colspan=5 class=xl14225986 style='height:10px;color:black;'></td>
					<td colspan=5 class=xl14225986 style='border-left:none;height:  10px;color:black;'>
					</td>
					<td colspan=4 class=xl14225986 style='border-left:none;height:  10px;color:black;'>
					</td>
					<td colspan=4 class=xl14225986 style='height:10px;color:black;'></td>
				</tr>

				<tr height=23 style='mso-height-source:userset;height:17.25pt'>
					<td height=23 class=xl6325986 style='height:17.25pt'></td>
					<td colspan=4 class=xl14225986 style='height:10px;color:black;'></td>
					<td colspan=5 class=xl14225986 style='border-left:none;height:  10px;color:black;'>
					</td>
					<td colspan=4 class=xl14225986 style='border-left:none;height:  10px;color:black;'>
					</td>
					<td colspan=4 class=xl14225986 style='height:10px;color:black;'></td>
					<td colspan=5 class=xl14225986 style='height:10px;color:black;'></td>
					<td colspan=5 class=xl14225986 style='border-left:none;height:  10px;color:black;'>
					</td>
					<td colspan=4 class=xl14225986 style='border-left:none;height:  10px;color:black;'>
					</td>
					<td colspan=4 class=xl14225986 style='height:10px;color:black;'></td>
				</tr>
				<tr height=38 style='mso-height-source:userset;height:28.5pt'>
					<td height=38 class=xl6325986 style='height:28.5pt'></td>
					<td colspan=6 class=xl8725986>Valor inicial Contrato:</td>
					<td colspan=29 class=xl13625986  style='height:10px;color:black;'></td>
				</tr>


				<tr height=38 style='mso-height-source:userset;height:28.5pt'>
					<td height=38 class=xl6325986 style='height:28.5pt'></td>
					<td colspan=6 class=xl8725986>Valor Adición 1</td>
					<td colspan=29 class=xl13625986  style='height:10px;color:black;'></td>
				</tr>
				<tr height=38 style='mso-height-source:userset;height:28.5pt'>
					<td height=38 class=xl6325986 style='height:28.5pt'></td>
					<td colspan=6 class=xl8725986>Valor Adición 2</td>
					<td colspan=29 class=xl13625986  style='height:10px;color:black;'></td>
				</tr>
				<tr height=38 style='mso-height-source:userset;height:28.5pt'>
					<td height=38 class=xl6325986 style='height:28.5pt'></td>
					<td colspan=6 class=xl8725986>Valor Adición 3</td>
					<td colspan=29 class=xl13625986  style='height:10px;color:black;'></td>
				</tr>
				<tr height=38 style='mso-height-source:userset;height:28.5pt'>
					<td height=38 class=xl6325986 style='height:28.5pt'></td>
					<td colspan=6 class=xl13225986 width=181 style='width:136pt'>Valor total del Contrato (Incluidas adiciones)</td>
					<td colspan=29 class=xl13625986  style='height:10px;color:black;'></td>
				</tr>
				<tr height=60 style='mso-height-source:userset;height:45.0pt'>
					<td height=60 class=xl6325986 style='height:45.0pt'></td>
					<td colspan=6 class=xl9125986 width=181 style='width:136pt'>Valor pago a efectuar</td>
					<td colspan=5 class=xl13625986 style='height:10px;color:black;'></td>
					<td colspan=3 class=xl13925986>Valor en letras</td>
					<td colspan=21 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
				</tr>

				<tr height=43 style='mso-height-source:userset;height:32.25pt'>
					<td height=43 class=xl6325986 style='height:32.25pt'></td>
					<td colspan=6 class=xl13225986 width=181 style='width:136pt'>Giros efectuados a la fecha
					</td>
					<td colspan=29 class=xl13625986 style='height:10px;color:black;'></td>
				</tr>
				<tr height=43 style='mso-height-source:userset;height:32.25pt'>
					<td height=43 class=xl6325986 style='height:32.25pt'></td>
					<td colspan=6 class=xl13225986 width=181 style='width:136pt'>Saldo pendiente de giro
					</td>
					<td colspan=29 class=xl13625986 style='height:10px;color:black;'></td>
				</tr>
				<tr height=43 style='mso-height-source:userset;height:32.25pt'>
					<td height=43 class=xl6325986 style='height:32.25pt'></td>
					<td colspan=6 class=xl13525986 width=181 style='width:136pt'>Valor a liberar
					</td>
					<td colspan=29 class=xl13625986 style='height:10px;color:black;'></td>
				</tr>
				<tr height=25 style='mso-height-source:userset;height:18.75pt'>
					<td height=25 class=xl6325986 style='height:18.75pt'></td>
					<td colspan=35 class=xl12425986>ACTIVIDADES DEL CONTRATISTA DURANTE EL PERÍODO DEL INFORME
					</td>
				</tr>
				<tr height=43 style='mso-height-source:userset;height:25.25pt'>
					<td height=43 class=xl6325986 style='height:32.25pt'></td>
					<td colspan=6 class=xl13525986 width=181 style='width:136pt'>Cantidad de Obligaciones</td>
					<td colspan=29 class=xl13625986 style='height:10px;color:black;'></td>
				</tr>
				<tr height=43 style='mso-height-source:userset;height:32.25pt'>
					<td height=43 class=xl6325986 style='height:32.25pt'></td>
					<td colspan=35 class=xl12425986>PRODUCTOS ENTREGADOS DURANTE EL PERÍODO DEL
						PRESENTE INFORME
					</td>
				</tr>
				<tr height=36 style='page-break-before:always;mso-height-source:userset;height:27.0pt'>
					<td height=36 class=xl6325986 style='height:27.0pt'></td>
					<td colspan=13 class=xl12725986>PRODUCTO ENTREGADO</td>
					<td colspan=6 class=xl12825986 width=193 style='border-left:none;width:145pt'>FECHA DE ENTREGA  DEL PRODUCTO</td>
					<td colspan=16 class=xl12725986 >MECANISMO DE VERIFICACIÓN</td>
				</tr>
				<tr height=46 style='mso-height-source:userset;height:34.5pt'>
					<td height=46 class=xl6325986 style='height:34.5pt'></td>
					<td colspan=13 class=xl12225986 style='height:  10px;color:black;'></td>
					<td colspan=6 class=xl12225986 style='border-left:none;height:  10px;color:black;' ><div style="height:100%" data-toggle="tooltip" title="Este campo se colocará automaticamente al descargar el PDF" data-placement="right"><br><br>DD/MM/AAAA</div></td>
					<td colspan=16 class=xl12225986 style='border-left:none;height:  10px;color:black;'>
						
					</td>
				</tr>
				<tr height=53 style='mso-height-source:userset;height:39.75pt'>
					<td height=53 class=xl6325986 style='height:39.75pt'></td>
					<td colspan=35 class=xl12425986>DECLARACIÓN JURAMENTADA
					</td>
				</tr>
				<tr height=22 style='mso-height-source:userset;height:16.7pt'>
					<td height=22 class=xl6325986 style='height:16.7pt'></td>
					<td colspan=11 class=xl12525986>&nbsp;</td>
					<td colspan=2 class=xl12825986 >SI</td>
					<td colspan=2 class=xl12825986 >NO</td>
					<td colspan=20 class=xl12825986 >OBSERVACIONES</td>
				</tr>
				<tr height=22 style='mso-height-source:userset;height:16.7pt'>
					<td height=22 class=xl6325986 style='height:16.7pt'></td>
					<td colspan=11 class=xl8725986>¿Es usted persona natural del régimen común?</td>
					<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
				</tr>
				<tr height=22 style='mso-height-source:userset;height:16.7pt'>
					<td height=22 class=xl6325986 style='height:16.7pt'></td>
					<td colspan=11 class=xl8725986>¿Es usted persona natural del régimen simplificado?
					</td>
					<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
				</tr>
				<tr height=22 style='mso-height-source:userset;height:16.7pt'>
					<td height=22 class=xl6325986 style='height:16.7pt'></td>
					<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black;
					width:267pt'>¿Es responsable de declaración de renta año inmediatamente anterior?</td>
					<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
				</tr>
				<tr height=34 style='mso-height-source:userset;height:25.9pt'>
					<td height=34 class=xl6325986 style='height:25.9pt'></td>
					<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black;
					width:267pt'>Tiene dependientes a su cargo? (Decreto 1070 de 2013 Art. 387	E.T.)</td>

					<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'> </td>
				</tr>
				<tr height=36 style='mso-height-source:userset;height:27.0pt'>
					<td height=36 class=xl6325986 style='height:27.0pt'></td>
					<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black; width:267pt'>¿Efectua pago en su cuenta AFC? De ser así en observaciones
						indique el valor mensual
					</td>

					<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'> </td>
				</tr>
				<tr height=35 style='mso-height-source:userset;height:26.45pt'>
					<td height=35 class=xl6325986 style='height:26.45pt'></td>
					<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black;width:267pt'>Efectua pagos por concepto de medicina prepagada? (Art. 387
					E.T.) de ser así, en observaciones indique el valor mensual que paga</td>

					<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'> </td>
				</tr>
				<tr height=52 style='mso-height-source:userset;height:39.6pt'>
					<td height=52 class=xl6325986 style='height:39.6pt'></td>
					<td colspan=11 class=xl9125986 width=356 style='border-right:.5pt solid black; width:267pt'>¿Actualmente tiene suscrito otros contratos con el Distrito o la Nación?</td>

					<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=2 class=xl12025986 style='border-left:none;height:  10px;color:black;'></td>
					<td colspan=20 class=xl12025986 style='border-left:none;height:  10px;color:black;'> </td>
				</tr>
				<tr height=24 style='mso-height-source:userset;height:18.0pt'>
					<td height=24 class=xl6325986 style='height:18.0pt'></td>
					<td colspan=35 rowspan=2 class=xl10225986 width=1086 style='border-right:.5pt solid black;border-bottom:.5pt hairline black;width:815pt'>Yo <span id="nombre-contratista-juramento"> JAVIER LEONARDO LEON NUÑEZ</span>,
						en mi calidad de contratista del IDARTES certifico bajo la gravedad de
						juramento, que los documentos soporte del pago de Salud, Pensión y ARL,
						corresponden a los ingresos provenientes del contrato materia del pago sujeto
						a retención y que estos aportes <font class="font625986">NO</font><font
						class="font525986"> </font><font class="font625986">SI</font><font class="font525986">sirvieron para la disminución de la base de Retención en la Fuente de Renta o del impuesto de Industria y Comercio en otro cobro, por lo tanto </font><font
						class="font625986">NO</font><font class="font525986"></font><font
						class="font625986">SI</font><font
						class="font525986"> pueden ser tomados para tal fin por el IDARTES.<br>
						<br> El (los) número(s) o referencias(s) de las(s) planilla(s) por el aporte de(l) (los) mes(es) de es(son):<br>
						 (Anexo copia(s) de la(s) planilla(s).</font>
					</td>
				</tr>
				<tr height=139 style='mso-height-source:userset;height:104.45pt'>
					<td height=139 class=xl6325986 style='height:104.45pt'></td>
				</tr>
				<tr height=12 style='mso-height-source:userset;height:9.4pt'>
					<td height=12 class=xl6325986 style='height:9.4pt'></td>
					<td colspan=35 class=xl9925986 style='border-right:.5pt solid black'>LOS
						PRODUCTOS QUE SE CERTIFICAN Y EL CUMPLIMIENTO DE OBLIGACIONES CONTRACTUALES
						HAN SIDO VERIFICADOS POR:
					</td>
				</tr>
				<tr height=20 style='mso-height-source:userset;height:15.0pt'>
					<td height=20 class=xl6325986 style='height:15.0pt'></td>
					<td colspan=35 rowspan=2 class=xl9625986 style='border-right:.5pt solid black'>&nbsp;</td>
				</tr>
				<tr height=21 style='mso-height-source:userset;height:16.15pt'>
					<td height=21 class=xl6325986 style='height:16.15pt'></td>
				</tr>
				<tr height=21 style='mso-height-source:userset;height:16.15pt'>
					<td height=21 class=xl6325986 style='height:16.15pt'></td>
					<td class=xl7225986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7425986>&nbsp;</td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:14.25pt'>
					<td height=19 class=xl6325986 style='height:14.25pt'></td>
					<td class=xl6525986>&nbsp;</td>
					<td class=xl7525986 colspan=9><span id="nombre-supervisor"></span></td>
					<td class=xl7525986>&nbsp;</td>
					<td class=xl7525986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl7525986 colspan=9><span id="nombre-contratista"></span></td>
					<td class=xl7525986>&nbsp;</td>
					<td class=xl7525986>&nbsp;</td>
					<td class=xl7625986>&nbsp;</td>
					<td class=xl7625986>&nbsp;</td>
					<td class=xl7625986>&nbsp;</td>
					<td class=xl7425986>&nbsp;</td>
				</tr>
				<tr height=21 style='mso-height-source:userset;height:16.15pt'>
					<td height=21 class=xl6325986 style='height:16.15pt'></td>
					<td class=xl6525986>&nbsp;</td>
					<td class=xl7725986 colspan=2><span id="cargo-supervisor"></span></td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td colspan=11 class=xl9025986><span id="cargo-contratista"></span></td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6625986>&nbsp;</td>
				</tr>
				<tr height=23 style='mso-height-source:userset;height:17.65pt'>
					<td height=23 class=xl6325986 style='height:17.65pt'></td>
					<td class=xl6525986>&nbsp;</td>
					<td colspan=12 class=xl9025986><span id="rol-supervisor"></span></td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6625986>&nbsp;</td>
				</tr>
				<tr height=21 style='mso-height-source:userset;height:16.15pt'>
					<td height=21 class=xl6325986 style='height:16.15pt'></td>
					<td colspan=35 rowspan=2 class=xl9625986 style='border-right:.5pt solid black'>&nbsp;</td>
				</tr>
				<tr height=21 style='mso-height-source:userset;height:16.15pt'>
					<td height=21 class=xl6325986 style='height:16.15pt'></td>
				</tr>
				<tr height=21 style='mso-height-source:userset;height:16.15pt'>
					<td height=21 class=xl6325986 style='height:16.15pt'></td>
					<td class=xl7225986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7425986>&nbsp;</td>
				</tr>
				<tr height=19 style='mso-height-source:userset;height:14.25pt'>
					<td height=19 class=xl6325986 style='height:14.25pt'></td>
					<td class=xl6525986>&nbsp;</td>
					<td class=xl7525986 colspan=9><span id="nombre-apoyo"></span></td>
					<td class=xl7525986>&nbsp;</td>
					<td class=xl7525986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl8925986>&nbsp;</td>
					<td class=xl8925986>&nbsp;</td>
					<td class=xl8925986>&nbsp;</td>
					<td class=xl8925986>&nbsp;</td>
					<td class=xl8925986>&nbsp;</td>
					<td class=xl8925986>&nbsp;</td>
					<td class=xl8925986>&nbsp;</td>
					<td class=xl8925986>&nbsp;</td>
					<td class=xl8925986>&nbsp;</td>
					<td class=xl8925986>&nbsp;</td>
					<td class=xl8925986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6625986>&nbsp;</td>
				</tr>
				<tr height=21 style='mso-height-source:userset;height:16.15pt'>
					<td height=21 class=xl6325986 style='height:16.15pt'></td>
					<td class=xl6525986>&nbsp;</td>
					<td class=xl7725986 colspan=2><span id="cargo-apoyo"></span></td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl7325986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td colspan=11 class=xl9025986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6625986>&nbsp;</td>
				</tr>
				<tr height=23 style='mso-height-source:userset;height:17.65pt'>
					<td height=23 class=xl6325986 style='height:17.65pt'></td>
					<td class=xl6525986>&nbsp;</td>
					<td colspan=12 class=xl9025986><span id="rol-apoyo"></span></td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6625986>&nbsp;</td>
				</tr>
				<tr height=21 style='mso-height-source:userset;height:16.15pt'>
					<td height=21 class=xl6325986 style='height:16.15pt'></td>
					<td class=xl6525986>&nbsp;</td>
					<td class=xl7825986>&nbsp;</td>
					<td class=xl7825986>&nbsp;</td>
					<td class=xl7825986>&nbsp;</td>
					<td class=xl7825986>&nbsp;</td>
					<td class=xl7825986>&nbsp;</td>
					<td class=xl7825986>&nbsp;</td>
					<td class=xl7825986>&nbsp;</td>
					<td class=xl7825986>&nbsp;</td>
					<td class=xl7825986>&nbsp;</td>
					<td class=xl7825986>&nbsp;</td>
					<td class=xl7825986>&nbsp;</td>
					<td class=xl7825986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6425986>&nbsp;</td>
					<td class=xl6625986>&nbsp;</td>
				</tr>
				<tr class=xl6425986 height=21 style='mso-height-source:userset;height:16.15pt'>
					<td height=21 class=xl7925986 style='height:16.15pt'>&nbsp;</td>
					<td colspan="35">&nbsp;</td>
				</tr>
			</table>
		</div>
	</div>
</page>
<?php

$content = ob_get_clean();
$html2pdf = new Html2Pdf('P', 'pt', 'en');
$html2pdf->writeHTML($content);
$html2pdf->output('exemple02.pdf');
} catch (Html2PdfException $e) {
	$html2pdf->clean();
	$formatter = new ExceptionFormatter($e);
	echo $formatter->getHtmlMessage();
}
$objControlador = new InformePagoController();
unset($objControlador);
