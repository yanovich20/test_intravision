<?php
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\ActionFilter\Csrf;
use Bitrix\Main\Engine\ActionFilter\HttpMethod;
use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Loader;
use Bitrix\Main\Type\Date;
use Bitrix\Main\Application;
use Bitrix\Main\Mail\Event;
class certactivaComponent extends \CBitrixComponent implements Controllerable
{
    public function configureActions()
    {
        return [ //один ВРОДЕ для всех action
            'activateCert' => [
                'prefilters' => [
                    new HttpMethod(
                        array(HttpMethod::METHOD_POST)
                    ),
                    new Csrf(),
                    new ActionFilter\Authentication()
                ],
                'postfilters' => []
            ],
        ];
    }

    private function getCertByParam(?string $name, int $iblockId){
        if(!$name) {
            $currentUserId = CurrentUser::get()->getId();
            $filter = array("PROP_USER.VALUE" => $currentUserId,
                "=IBLOCK_ID" => $iblockId,
                "=ACTIVE"=>"Y");
        }
        else {
            $filter = array("=NAME" => $name,
                "=IBLOCK_ID" => $iblockId);
        }
        $iblock = \Bitrix\Iblock\Iblock::wakeUp($iblockId)->getEntityDataClass();
        $certList = $iblock::getList(
            array(
                "filter" => $filter,
                "select" => array("ID","NAME","ACTIVE","PROP_USER","ACTIVATION_DATE")
            )
        );
        $arResult["CERT_ELEMENTS"]=array();
        $certCollection = $certList->fetchCollection();
        foreach($certCollection as $cert)
        {
            $arResult["CERT_ELEMENTS"][]=$cert;
        }

        return $arResult;
    }
    private function setResult(){

        $filter = array("=IBLOCK_ID"=>$this->arParams["IBLOCK_ID"]);
        $nav = new \Bitrix\Main\UI\PageNavigation("nav-more-certs");
        $nav->allowAllRecords(true)
        ->setPageSize($this->arParams["PAGE_SIZE"])
        ->initFromUri();
        $certList = \Bitrix\Iblock\ElementTable::getList(
            array(
            "filter" => $filter,
            "select" => array("ID","NAME","ACTIVE"),
            "count_total" => true,
            "offset" => $nav->getOffset(),
            "limit" => $nav->getLimit(),
            )
        );
        $nav->setRecordCount($certList->getCount());
        $this->arResult["CERT_ELEMENTS"]=array();
        while($cert = $certList->fetch())
        {
            $this->arResult["CERT_ELEMENTS"][$cert["ID"]]=$cert;
        }
        $this->arResult["NAV"] = $nav;
    }
    public function executeComponent(){
        if(!Loader::includeModule('iblock'))
            return;
        if($this->arParams["MODE"]!='Y')
            $this->setResult();
        else {
            if(CurrentUser::get()->getId()) {
                $this->arResult =  $this->getCertByParam(null, $this->arParams["IBLOCK_ID"]);
            }
            else
            {
                echo "не авторизованным пользователям доступ запрещен";
                return;
            }
        }
        $this->includeComponentTemplate();
    }
    public function activateCertAction(int $iblockId, string $name)
    {
        if(!Loader::includeModule('iblock'))
            return Loc::getMessage("IBLOCK_NOT_INSTALLED");
        if(!$name)
            return array("error"=>true,"message"=>Loc::getMessage("CERT_NOT_FOUND"));

        $items = $this->getCertByParam($name,$iblockId);
        foreach($items["CERT_ELEMENTS"] as $item)
        {
            $element = $item;
        }
        if(empty($element))
            return array("error"=>true,"message"=>Loc::getMessage("CERT_NOT_FOUND"));
        if($element->get("ACTIVE")==true)
            return array("error"=>true, "message"=>Loc::getMessage("CERT_ALREADY_ACTIVATED"));
        $element->set("ACTIVE",true);
        $element->setPropUser(CurrentUser::get()->getId());
        $activationDate = new Date();
        $element->setActivationDate($activationDate);
        $element->save();
        $documentRoot =Application::getDocumentRoot();
        require_once($documentRoot.'/local/vendor/tcpdf/tcpdf.php');

// create new PDF document
       // $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
// set document information
        $pdf->SetCreator("Создатель");
        $pdf->SetAuthor('Анатолий');
        $pdf->SetTitle('Сертификаты');
        $pdf->SetSubject('Активация сертификатов');
       // $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
// ---------------------------------------------------------
        $pdf->SetMargins(10, 40, 10, 10);
        $pdf->SetFont('dejavusans', '', 8);
// add a page
        $pdf->AddPage();

// create some HTML content
        $html = "<h1> Активация сертификата</h1><div><span> имя сертификата:".$name." </span><span>Дата активации:".$activationDate."</span></div>";
// output the HTML content
        $pdf->writeHTML($html, false, false, false, false, '');
        $fileName = $this->generateRandomString().".pdf";
        $fileDir =$documentRoot.'/upload/pdfs/';
        if (!file_exists($fileDir))
            mkdir($fileDir);
        $pdf->Output($fileDir.$fileName, 'F');

        $userName= CurrentUser::get()->getFirstName();
        $userMail = CurrentUser::get()->getEmail();
            Event::send(array( // or send
            "EVENT_NAME" => "CERTIFICATE_ACTIVATED",
            "LID" => SITE_ID,
            "C_FIELDS" => array(
                "EMAIL_TO" => $userMail,
                "CERTIFICATE_NAME" => $name,
                "NAME" => $userName
            ),
            "FILE" => array($fileDir.$fileName)));
        return array("error"=>false,"message"=>Loc::getMessage("CERT_ACTIVATED"));
    }
    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
?>