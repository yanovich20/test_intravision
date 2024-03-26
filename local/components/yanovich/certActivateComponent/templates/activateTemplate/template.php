<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?php

 use Bitrix\Main\Localization\Loc;
\CJSCOre::init(array("jquery"));
\Bitrix\Main\UI\Extension::load("ui.dialogs.messagebox");
\Bitrix\Main\UI\Extension::load("ui.bootstrap4");
$this->addExternalCss($this->GetFolder()."/styles.css");
?>
<div class="block-input-cert">
<input type="text"  id="cert-name" placeholder="<?php echo Loc::getMessage(code: "CERT_NUMBER")?>"/>
<input type="button" class="btn-info btn-activate" value="<?php echo Loc::getMessage("ACTIVATE")?>"/>
<input type="hidden"  id="iblock-id" value="<?php echo $arParams["IBLOCK_ID"] ?>"/>
    </div>
    <table id="cert">
    <thead>
        <tr> <td>
                Название сертификата
                </td>
                <td>
                Дата активации
                </td>
            </tr>
    </thead>
    <tbody>
        <?php
        foreach($arResult["CERT_ELEMENTS"] as $cert)
            {
        ?>
        <tr>
            <td>
            <?php echo $cert->get("NAME")?>
            </td>
            <td>
            <?php echo $cert->getActivationDate()->getValue()?>
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    </table>
        <a class="center-block" href="/cert/index.php"><?php echo Loc::getMessage("TO_LIST")?></a>