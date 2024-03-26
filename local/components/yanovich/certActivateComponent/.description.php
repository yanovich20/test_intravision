<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use \Bitrix\Main\Localization\Loc;

$arComponentDescription = array(
    "NAME" =>Loc::getMessage("CERTIFICAT_NAME"),
    "DESCRIPTION" =>Loc::getMessage("CERTIFICAT_DESCRIPTION"),
    "ICON" => "",
    "CACHE_PATH" => "Y",
    "PATH" => array(
        "ID"=>"activateCerts",
        "NAME" => Loc::getMessage("CERTIFICAT_NAME")
    ),
    "COMPLEX" => "N"
);
?>