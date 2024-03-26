<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Страница активации");
if(\Bitrix\Main\Engine\CurrentUser::get()->getId())
{
?><?$APPLICATION->IncludeComponent(
	"yanovich:certActivateComponent",
	"activateTemplate",
	Array(
		"IBLOCK_ID" => "5",
		"MODE" => "Y",
		"PAGE_SIZE" => "5"
	)
);?><?php
}
else {
    LocalRedirect("/login");
}
    ?>
    <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>