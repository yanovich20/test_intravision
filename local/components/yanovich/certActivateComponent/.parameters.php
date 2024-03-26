<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?php
use Bitrix\Main\Localization\Loc;
$arComponentParameters = array(
    "PARAMETERS" => array(
        "IBLOCK_ID" => Array(
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage("IBLOCK_ID_NAME"),
            "TYPE" => "STRING",
            "DEFAULT" => '',
            ),
        "PAGE_SIZE" => Array(
            "PARENT" => "BASE",
            "NAME" => Loc::getMessage("PAGE_SIZE_NAME"),
            "TYPE" => "STRING",
            "DEFAULT" => '',
            ),
        "MODE"=>Array(
                "PARENT" => "BASE",
                "NAME" => Loc::getMessage("MODE"),
                "TYPE" => "CHECKBOX",
                "DEFAULT" => '',
            )
    )
);