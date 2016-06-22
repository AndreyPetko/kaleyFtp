<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1251">
<meta name=ProgId content=Word.Document>
<meta name=Generator content="Microsoft Word 9">
<meta name=Originator content="Microsoft Word 9">
<link rel=File-List href="./ООО.files/filelist.xml">
<title>Счет</title>
<!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:Author>Reanimator Me User</o:Author>
  <o:Template>Normal</o:Template>
  <o:LastAuthor>Reanimator Me User</o:LastAuthor>
  <o:Revision>2</o:Revision>
  <o:TotalTime>5</o:TotalTime>
  <o:Created>2003-09-25T08:04:00Z</o:Created>
  <o:LastSaved>2003-09-25T08:04:00Z</o:LastSaved>
  <o:Pages>1</o:Pages>
  <o:Lines>1</o:Lines>
  <o:Paragraphs>1</o:Paragraphs>
  <o:Version>9.2812</o:Version>
 </o:DocumentProperties>
</xml><![endif]-->
<style>
<!--
 /* Style Definitions */
p.MsoNormal, li.MsoNormal, div.MsoNormal
	{mso-style-parent:"";
	margin:0cm;
	margin-bottom:.0001pt;
	mso-pagination:widow-orphan;
	font-size:12.0pt;
	font-family:"Times New Roman";
	mso-fareast-font-family:"Times New Roman";}
h1
	{mso-style-next:Обычный;
	margin:0cm;
	margin-bottom:.0001pt;
	text-align:center;
	mso-pagination:widow-orphan;
	page-break-after:avoid;
	mso-outline-level:1;
	font-size:10.0pt;
	font-family:Arial;
	mso-font-kerning:0pt;}
@page Section1
	{size:595.3pt 841.9pt;
	margin:2.0cm 42.5pt 2.0cm 63.0pt;
	mso-header-margin:35.4pt;
	mso-footer-margin:35.4pt;
	mso-paper-source:0;}
div.Section1
	{page:Section1;}
-->
</style>
</head>
<body lang=RU style='tab-interval:35.4pt'>

<script>
	function open_window(link,w,h)
	 {  
	 var win = "width="+w+",height="+h+",menubar=no,location=no,resizable=yes,scrollbars=yes,top=100,left=100";
	 newWin = window.open(link,'newWin',win);
	 };
</script>



<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:w="urn:schemas-microsoft-com:office:word"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">


<div class=Section1>

<p class=MsoNormal><b><u><span style='font-size:10.0pt;font-family:Arial'></span></u></b><b><u><span lang=EN-US style='font-size:
10.0pt;font-family:Arial;mso-ansi-language:EN-US'><o:p></o:p></span></u></b></p>


<p class=MsoNormal><b><span style='font-size:10.0pt;font-family:Arial'><br></span></b><b><span
lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-ansi-language:EN-US'><o:p></o:p></span></b></p>

<p class=MsoNormal><span lang=EN-US style='mso-ansi-language:EN-US'><![if !supportEmptyParas]>&nbsp;<![endif]><o:p></o:p></span></p>

<p class=MsoNormal style=text-align><b><span
style=font-size:14.0pt;font-family:Arial>ЗАКАЗ № ИНТ-{{$order->id}} от	<SCRIPT type=text/javascript> 
	<!--   // Array ofmonth Names
	var monthNames = new Array( "Января","Февраля","Марта","Апреля","Мая","Июня","Июля","Августа","Сентября","Октября","Ноября","Декабря");
	var now = new Date();
	thisYear = now.getYear();
	if(thisYear < 1900) {thisYear += 1900}; // corrections if Y2K display problem
	document.write(now.getDate() + " " + monthNames[now.getMonth()] + " " + thisYear+" г.");
	// -->
	</SCRIPT>	

</span></b><b><span lang=EN-US style='font-size:14.0pt;font-family:Arial;mso-ansi-language:EN-US'><o:p></o:p></span></b></p>

<br>
<p class=MsoNormal>
<span style=font-size:10.0pt;font-family:Arial><b>Доставлять:</b><span style=mso-spacerun: yes> {{$order->delivery_type}} </span><br><span style=font-size:10.0pt;font-family:Arial><b>Способ оплаты:</b><span style=mso-spacerun: yes> {{$order->payment_type}} </span><br>
<span style=font-size:10.0pt;font-family:Arial><b>Комментарий:</b><span style=mso-spacerun: yes> {{$order->comment}}  </span><br>
<br></span><span lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-ansi-language:EN-US'><o:p></o:p></span></p>
<p class=MsoNormal>
<span style=font-size:10.0pt;font-family:Arial><b>Покупатель:</b><span style=mso-spacerun: yes> {{$order->fio}} </span><br>
<span style=font-size:10.0pt;font-family:Arial><b>Телефон:</b><span style=mso-spacerun: yes> {{$order->phone}}  </span><br>
<span style=font-size:10.0pt;font-family:Arial><b>Адрес:</b><span style=mso-spacerun: yes> {{$order->address}} </span><br>
<!-- <span style=font-size:10.0pt;font-family:Arial><b>Ближайшее метро:</b><span style=mso-spacerun: yes>  </span><br> -->
<span style=font-size:10.0pt;font-family:Arial><b>Email:</b><span style=mso-spacerun: yes> {{$order->email}}  </span><br>
<span style=font-size:10.0pt;font-family:Arial><b>Примечание:</b><span style=mso-spacerun: yes>  </span><br>
<br></span><span lang=EN-US style='font-size:10.0pt;font-family:Arial;mso-ansi-language:EN-US'><o:p></o:p></span></p><table border=1 cellspacing=0 cellpadding=2 width=645 >

 <tr style='height:51.0pt'>
  <td nowrap bgcolor=white>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:Arial'>№<o:p></o:p></span></p>
  </td>
  <td width=306 bgcolor=white>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:Arial'>Наименование<br>
  товара<o:p></o:p></span></p>
  </td>
  <td width=58 bgcolor=white>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:Arial'>Единица<br>
  изме-<br>
  рения<o:p></o:p></span></p>
  </td>
  <td width=52 bgcolor=white>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:Arial'>Коли-<br>
  чество<o:p></o:p></span></p>
  </td>
  <td width=106 bgcolor=white>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:Arial'>Цена, грн<o:p></o:p></span></p>
  </td>
  <td width=106 bgcolor=white>
  <p class=MsoNormal align=center style='text-align:center'><span
  style='font-size:10.0pt;font-family:Arial'>Сумма, грн</span><span lang=EN-US
  style='font-size:10.0pt;font-family:Arial;mso-ansi-language:EN-US'><o:p></o:p></span></p>
  </td>
 </tr>


@foreach($products as $product)
   <tr>
  <td bgcolor="white">
  <p class="MsoNormal" align="right" style="text-align:right"><span lang="EN-US" style="font-size:10.0pt;font-family:Arial;mso-ansi-language:EN-US">1<o:p></o:p></span></p>
  </td>

  <td width="306" valign="top" bgcolor="white">
  <p class="MsoNormal"><span lang="EN-US" style="font-size:10.0pt;font-family:Arial;" mso-ansi-language:en-us="">{{$product->product_name}}<o:p></o:p></span></p>
  </td>

  <td nowrap="" valign="bottom" bgcolor="white">
  <p class="MsoNormal" align="center" style="text-align:center"><span style="font-size:10.0pt;font-family:Arial">шт</span><span lang="EN-US" style="font-size:10.0pt;font-family:Arial;mso-ansi-language:EN-US"><o:p></o:p></span></p>
  </td>

  <td nowrap="" valign="bottom" bgcolor="white">
  <p class="MsoNormal" align="right" style="text-align:right"><span lang="EN-US" style="font-size:10.0pt;font-family:Arial;mso-ansi-language:EN-US">{{$product->product_count}}<o:p></o:p></span></p>
  </td>

  <td nowrap="" valign="bottom" bgcolor="white">
  <p class="MsoNormal" align="right" style="text-align:right'"><span lang="EN-US" style="font-size:10.0pt;font-family:Arial;mso-ansi-language:EN-US">{{$product->product_price}},00<o:p></o:p></span></p>
  </td>

  <td nowrap="" valign="bottom" bgcolor="white">
  <p class="MsoNormal" align="right" style="text-align:right"><span lang="EN-US" style="font-size:10.0pt;font-family:Arial;mso-ansi-language:EN-US">{{$product->product_price * $product->product_count}},00<o:p></o:p></span></p>
  </td>
 </tr>


 @endforeach



 <tr bgcolor=white>
  <td nowrap bgcolor=white>
  <p class=MsoNormal><![if !supportEmptyParas]>&nbsp;<![endif]><span
  style=font-size:10.0pt;font-family:Arial><o:p></o:p></span></p>
  </td>

  <td nowrap bgcolor=white colspan=4>
  <p class=MsoNormal align=right style=text-align:right><b><span
  style='font-size:10.0pt;font-family:Arial'>Скидка:<o:p></o:p></span></b></p>
  </td><td nowrap bgcolor=white>
  <p class=MsoNormal align=right style=text-align:right><b><span
  style='font-size:10.0pt;font-family:Arial'>{{$order->discount}}%<o:p></o:p></span></b></p>
  </td>
 </tr>



  <tr bgcolor=white>
  <td nowrap bgcolor=white>
  <p class=MsoNormal><![if !supportEmptyParas]>&nbsp;<![endif]><span
  style=font-size:10.0pt;font-family:Arial><o:p></o:p></span></p>
  </td>

  <td nowrap bgcolor=white colspan=4>
  <p class=MsoNormal align=right style=text-align:right><b><span
  style='font-size:10.0pt;font-family:Arial'>Итого к оплате:<o:p></o:p></span></b></p>
  </td><td nowrap bgcolor=white>
  <p class=MsoNormal align=right style=text-align:right><b><span
  style='font-size:10.0pt;font-family:Arial'>{{$order->totalprice}},00<o:p></o:p></span></b></p>
  </td>
 </tr>
 


</table>
<p class=MsoNormal><span lang=EN-US style='mso-ansi-language:EN-US'><![if !supportEmptyParas]>&nbsp;<![endif]><o:p></o:p></span></p>


<p class=MsoNormal><span style=font-size:10.0pt;font-family:Arial>Всего
наименований {{$namesCount}}, на сумму {{$order->totalprice}},00 грн.</span><span lang=EN-US style=font-size:
10.0pt;font-family:Arial;mso-ansi-language:EN-US><o:p></o:p></span></p>
<p class=MsoNormal><b><span style='font-size:10.0pt;font-family:Arial'><o:p></o:p></span></b></p>

<p class=MsoNormal><b><span style='font-size:10.0pt;font-family:Arial'><![if !supportEmptyParas]>&nbsp;<![endif]><o:p></o:p></span></b></p>

<p class=MsoNormal><b><span style='font-size:10.0pt;font-family:Arial'><![if !supportEmptyParas]>&nbsp;<![endif]><o:p></o:p></span></b></p>

<p class=MsoNormal><span style='font-size:10.0pt;font-family:Arial'>Подпись
получателя   _____________________</span><span lang=EN-US
style='font-size:10.0pt;font-family:Arial;mso-ansi-language:EN-US'><o:p></o:p></span></p>

</div>
</body>
</html>