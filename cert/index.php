<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Список сертификатов");
?><?$APPLICATION->IncludeComponent(
	"yanovich:certActivateComponent",
	"",
	Array(
		"IBLOCK_ID" => "5",
		"PAGE_SIZE" => "5"
	)
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>