<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <?$APPLICATION->ShowHead();?>
    <link href="<?=SITE_TEMPLATE_PATH?>/common.css" type="text/css" rel="stylesheet" />
    <link href="<?=SITE_TEMPLATE_PATH?>/colors.css" type="text/css" rel="stylesheet" />

    <!--[if lte IE 6]>
	<style type="text/css">

		div.product-overlay {
			background-image: none;
			filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?=SITE_TEMPLATE_PATH?>images/product-overlay.png', sizingMethod = 'crop');
		}

	</style>
	<![endif]-->

    <title><?$APPLICATION->ShowTitle()?></title>
</head>
<body>
<div id="page-wrapper">
    <div id="panel"><?$APPLICATION->ShowPanel();?></div>
    <div id="header">

        <table id="logo">
            <tr>
                <td><a href="<?=SITE_DIR?>" title="<?=GetMessage('CFT_MAIN')?>"><?
                        $APPLICATION->IncludeFile(
                            SITE_DIR."include/company_name.php",
                            Array(),
                            Array("MODE"=>"html")
                        );
                        ?></a></td>
            </tr>
        </table>

        <div id="top-menu">
            <div id="top-menu-inner">
                <?$APPLICATION->IncludeComponent("bitrix:menu", "horizontal_multilevel", array(
                    "ROOT_MENU_TYPE" => "top",
                    "MAX_LEVEL" => "2",
                    "CHILD_MENU_TYPE" => "left",
                    "USE_EXT" => "Y",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_TIME" => "36000000",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => ""
                ),
                    false,
                    array(
                        "ACTIVE_COMPONENT" => "Y"
                    )
                );?>
            </div>
        </div>
    </div>

    <div id="content">

        <div id="sidebar">

            <div class="content-block">
                <div class="content-block-inner">

                    <?
                    $APPLICATION->IncludeComponent("bitrix:search.form", "flat", Array(
                        "PAGE" => "#SITE_DIR#search/",
                    ),
                        false
                    );
                    ?>
                </div>
            </div>


        </div>

        <div id="workarea">
            <h1 id="pagetitle"><?$APPLICATION->ShowTitle(false);?></h1>