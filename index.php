<?
include("database.php");
global $db;
$db = new vt("root", "1234", "su", "localhost");

$islem = $_GET["islem"];
if($islem == "il")
{
    echo '<option value="">İl seçiniz</option>';
    $iller			= $db->tablo("select * from il where ilID order by ad asc");
	foreach($iller as $il)
	{
		echo '<option value="'.$il->ilID.'">'.$il->ad.'</option>';	
	}
}

if($islem == "ilce")
{
	$id				= trim(intval($_POST["ilID"]));
	$ilceler		= $db->tablo("select * from ilce where ilID=".$id." order by ad asc");
    echo '<option value="">İlçe seçiniz</option>';
	foreach($ilceler as $ilce)
	{
		echo '<option value="'.$ilce->ilceID.'">'.$ilce->ad.'</option>';	
	}
}

if($islem == "semt")
{
	$id				= trim(intval($_POST["ilceID"]));
	$semtler		= $db->tablo("select * from semt where ilceID=".$id." order by ad asc");
    echo '<option value="">Semt seçiniz</option>';
	foreach($semtler as $semt)
	{
		echo '<option value="'.$semt->semtID.'">'.$semt->ad.'</option>';	
	}
}

if($islem == "mahalle")
{
	$id				= trim(intval($_POST["semtID"]));
	$mahalleler		= $db->tablo("select * from mahalle where semtID=".$id." order by ad asc");
    echo '<option value="">Mahalle seçiniz</option>';
	foreach($mahalleler as $mahalle)
	{
		echo '<option value="'.$mahalle->mahalleID.'">'.$mahalle->ad.'</option>';	
	}
}

if($islem == "postakodu")
{
	$id				= trim(intval($_POST["mahalleID"]));
	$postakodlari	= $db->tablo("select * from postakodu where mahalleID=".$id." order by kod asc");
	foreach($postakodlari as $postakodu)
	{
		echo $postakodu->kod;	
	}
}

if($islem == "")
{
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>PTT İl İlçe Semt Mahalle Posta Kodu Listesi</title>
</head>
<body>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript">
	$.post("index.php?islem=il", function(data)
	{
		$("#il").html(data);
	});	

$(document).on('change','#il',function()
{
	$("#il option:selected").each(function()
	{
		var istek = jQuery(this).val();
		$.post("index.php?islem=ilce",{ilID: istek}, function(data)
		{
			$("#ilce, #semt, #mahalle, #postakodu").remove();
			$("#liste").append('<p><select name="ilce" id="ilce"></select></p>');
			$("#ilce").html(data).show('slow');
		});	
	});
});

$(document).on('change','#ilce',function()
{
	$("#ilce option:selected").each(function()
	{
		var istek = jQuery(this).val();
		$.post("index.php?islem=semt",{ilceID: istek}, function(data)
		{
			$("#semt, #mahalle, #postakodu").remove();
			$("#liste").append('<p><select name="semt" id="semt"></select></p>');
			$("#semt").html(data).show('slow');
		});	
	});
});

$(document).on('change','#semt',function()
{
	$("#semt option:selected").each(function()
	{
		var istek = jQuery(this).val();
		$.post("index.php?islem=mahalle",{semtID: istek}, function(data)
		{
			$("#mahalle, #postakodu").remove();
			$("#liste").append('<p><select name="mahalle" id="mahalle"></select></p>');
			$("#mahalle").html(data).show('slow');
		});	
	});
});

$(document).on('change','#mahalle',function()
{
	$("#mahalle option:selected").each(function()
	{
		var istek = jQuery(this).val();
		$.post("index.php?islem=postakodu",{mahalleID: istek}, function(data)
		{
			$("#postakodu").remove();
			$("#liste").append('<p><div id="postakodu"></div></p>');
			$("#postakodu").html("Posta Kodu: "+data).show('slow');
		});	
	});
});
</script>
<div id="liste">
	<select id="il"></select>
</div>
<?php
}
?>
</body>
</html>