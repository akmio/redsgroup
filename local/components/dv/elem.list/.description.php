<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); 
$arComponentDescription = array(
	"NAME" => "Список элементов с рейтингом",
	"DESCRIPTION" => "Описание компонента",
	"PATH" => array(
		"ID" => "dv_components",
		"NAME" => "Свои компоненты",
		"CHILD" => array(
			"ID" => "printelem",
			"NAME" => "Вывод элементов"
		)
	),
	"ICON" => "/images/cat_list.gif",
);