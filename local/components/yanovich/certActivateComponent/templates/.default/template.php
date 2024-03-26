<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?php use Bitrix\Main\Localization\Loc;?>
<ul>
<?php
$this->addExternalCss($this->GetFolder()."/styles.css");
foreach($arResult["CERT_ELEMENTS"] as $cert)
{
    $active = $cert["ACTIVE"]=='Y'?"Активирован":"Не активирован";
    ?>
    <li class="cert-item"><span class="cert-name"><?php echo $cert["NAME"]?></span><span class="active"><?php echo $active?></span></li>
    <?php
}
?>
</ul>

<?php

$APPLICATION->IncludeComponent(
    "bitrix:main.pagenavigation",
    "",
    array(
        "NAV_OBJECT" => $arResult["NAV"],//$nav,
        "SEF_MODE" => "N",
    ),
    false
);
?>
<a class="center-block" href="/cert/activate.php"><?php echo Loc::getMessage("ACTIVATE")?></a>
