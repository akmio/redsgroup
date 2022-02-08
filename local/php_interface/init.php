<?
use \Bitrix\Catalog;

AddEventHandler("sale", "OnOrderNewSendEmail", "bxModifySaleMails");

function bxModifySaleMails($orderID, &$eventName, &$arFields)
{
   //id текущего пользователя
   $idUser = CSaleBasket::GetBasketUserID();

   //Получаем id товаров заказа
   $resOrder = CSaleBasket::GetList(
      [],
      ['ORDER_ID' => $orderID, 'MODULE' => 'catalog'], 
      false, 
      false, 
      ['PRODUCT_ID']
   );

   while ($arOrder = $resOrder->Fetch()) {
      $products[] = $arOrder['PRODUCT_ID'];

      //получаем id элемента, по id торгового предложения
      $resElem[] = CCatalogSku::GetProductInfo($arOrder['PRODUCT_ID']);
   }

   foreach ($resElem as  $elem) {
      $arElem[$elem['ID']] = $elem['ID'];

   }

   //получаем id просмотренных товаров
   $resViewedProducts = Catalog\CatalogViewedProductTable::getList([
      // 'select' => ['PRODUCT_ID'],
      'select' => ['ELEMENT_ID'],
      'filter' => ['FUSER_ID' => $idUser, '!ELEMENT_ID'=> $arElem],
      'order' => array('ID' => 'DESC'),
      'limit' => 10
   ]);
   while ($arViewProduct = $resViewedProducts->fetch())
   {
      $arProduct[] = $arViewProduct['ELEMENT_ID'];
   }

   //Получаем ссылку и название просмотренных элементов
   $resViewElem = CIBlockElement::GetList(
      ['ID' => 'ASC'],
      ['ID' => $arProduct],
      false,
      false,
      ['NAME', 'DETAIL_PAGE_URL', 'PRICE_1', 'SCALED_PRICE_1','QWERTY']
   );
   while ($arViewElem = $resViewElem->GetNext()) {
      $arFields['VIEWED_PRODUCTS'] .= '<a href ="'.$_SERVER['SERVER_NAME'].$arViewElem['DETAIL_PAGE_URL'].'">'.$arViewElem['NAME'].'</a><br>';
   }
}

//автозаполнение св-ва  "Стоит меньше тысячи" работает только с товарами без ТП
AddEventHandler("catalog", "OnBeforePriceAdd", "OnBeforePriceAddHandler");

function OnBeforePriceAddHandler(&$arFields)
{
   if ($arFields['PRICE'] < 1000) {
      CIBlockElement::SetPropertyValuesEx($arFields['PRODUCT_ID'], 2, ['PRICE_MENEE' => 18]);
   }
}