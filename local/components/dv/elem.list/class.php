<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Application;

class ElemList extends CBitrixComponent
{
	public function onPrepareComponentParams($params)
	{
		$params = parent::onPrepareComponentParams($params);
		return $params;
	}

	public function executeComponent()
    {

    	$re = Application::getInstance()->getContext()->getRequest();
		$arSelect = ['*', 'PROPERTY_VOTE'];
		$arFilter = ['IBLOCK_ID' => $this->arParams['IBLOCK_ID']];
		$resElem = CIBlockElement::GetList(Array(), $arFilter, false, ['nPageSize' => 10], $arSelect);

		while($arElem = $resElem->GetNext())
		{	
			if (!empty($arElem['DETAIL_PICTURE'])) {
				$arElem['DETAIL_PICTURE'] = CFile::GetPath($arElem['DETAIL_PICTURE']);
			}

			if (!empty($re->get('vote')) && !empty($re->get('voteId'))) {
				if ($arElem['ID'] == $re->get('voteId')) {
					if ($re->get('vote') == 'plus') {
						$voteCount = $arElem['PROPERTY_VOTE_VALUE']+1;
					}elseif ($re->get('vote') == 'minus') {
						$voteCount =  $arElem['PROPERTY_VOTE_VALUE']-1;
					}

					CIBlockElement::SetPropertyValuesEx($re->get('voteId'), $this->arParams['IBLOCK_ID'], array('VOTE' => $voteCount));
	    			$arElem['PROPERTY_VOTE_VALUE'] = $voteCount;
				}			
	    	}
			
			$this->arResult['ITEMS'][$arElem['ID']] = $arElem;			
		}

		$this->arResult['NAV_STRING'] = $resElem->GetPageNavStringEx($navComponentObject, 'Товары', 'more');

		$this->IncludeComponentTemplate();
	}

}