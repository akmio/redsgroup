<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

?>
<div class="wrap items-list">
<?
foreach ($arResult['ITEMS'] as $item)
{
	$this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
	$this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);

	?><div class="product_item item-content">
		<?if (empty($item['DETAIL_PICTURE'])) {
			$item['DETAIL_PICTURE'] = SITE_TEMPLATE_PATH.'/images/no_photo.png';
		}?>
		<a href="<?=$item['DETAIL_PAGE_URL']?>">
			<img src="<?=$item['DETAIL_PICTURE']?>" class ="img" alt="<?=$item['NAME']?>">
		</a>
		<div class="blockText">
			<a href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['NAME']?></a>

			<?if (empty($item['PREVIEW_TEXT'])) {
				$previewText = $item['DETAIL_TEXT'];
			}else{			
				$previewText = ['PREVIEW_TEXT'];
			}?>

			<div class="text">
				<p><?=$previewText?></p>
			</div>
		</div>
		<div class="vote">
			<?if (empty($item['PROPERTY_VOTE_VALUE'])) {
				$quantityVote = 0;
			}else{
				$quantityVote = $item['PROPERTY_VOTE_VALUE'];
			}?>
			<span class="button button-vote" data-id="<?=$item['ID']?>" data-vote="/?vote=plus&voteId=<?=$item['ID']?>">+</span>
			<span class="input<?=$item['ID']?>"><?=$quantityVote?></span>
  			<span class="button button-vote" data-id="<?=$item['ID']?>" data-vote="/?vote=minus&voteId=<?=$item['ID']?>">-</span>
		</div>
	</div><?

}
?>
</div>
<?/*pre><?print_r($arResult);?></pre*/?>
<div id="pag">
<?=$arResult['NAV_STRING']?>
</div>