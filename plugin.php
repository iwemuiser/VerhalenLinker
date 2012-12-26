<?php

add_filter(array('Display', 'Item', 'Dublin Core', 'Type'), 'my_type_link_function');
add_filter(array('Display', 'Item', 'Item Type Metadata', 'Text'), 'my_text_link_function');


function get_type_info($search_string)
{
		$instance = Omeka_Context::getInstance();
#		$db = get_db();
        $db = $instance->getDb();
        $sql = "
        SELECT items.id 
        FROM {$db->Item} items 
        JOIN {$db->ElementText} element_texts 
        ON items.id = element_texts.record_id 
        JOIN {$db->Element} elements 
        ON element_texts.element_id = elements.id 
        JOIN {$db->ElementSet} element_sets 
        ON elements.element_set_id = element_sets.id 
        WHERE element_sets.name = 'Dublin Core' 
        AND elements.name = 'Identifier' 
        AND element_texts.text = ?";
        $itemIds = $db->fetchAll($sql, $search_string);
		print_r(get_class_methods($itemIds));
		
		if (count($itemIds) == 1){ //NOG EVEN MEE VERDER STOEIEN
			$temp_item = "";
#			$search_item_meta_data = show_item_metadata(array(), get_item_by_id($itemIds[0]["id"]));  //Show_item_metadata cancels the show of the actual item somehow :S
#			$search_item_meta_data = get_item_by_id($itemIds[0]["id"])->itemMetadataList();
#			set_current_item($temp_item);
#			return $search_item_meta_data;
			$search_item = get_item_by_id($itemIds[0]["id"]);
#			$itemIds->getElementTextsByElementNameAndSetName();
#			print "<PRE>";
			foreach ($search_item->getElementText() as $element_text){
#				print $item->getElementsBySetName("Dublin Core") . ":";
				$temp_item .= $element_text->text . "<br>";
#				print $item->record_type . "<br>";
				
			}
			return $temp_item;
#			print_r($search_item->getElementText());
#			print_r(get_class_methods($search_item));
#			print "</PRE>";
#			print_r(item(get_item_by_id($itemIds[0]["id"])));
#			return get_item_by_id($itemIds[0]["id"]);
			return "METADATA!";
		}
		return "no description";
}

function my_type_link_function($text, $record, $elementText)
{
	if ($text){
		$btext = str_replace(" ", "+", $text);
		$type_information = get_type_info($text);
#		$return_this = "test";
		$return_this = "<a class='hover-type' href='/verhalenbank/items/browse?search=&advanced%5B0%5D%5Belement_id%5D=51&advanced%5B0%5D%5Btype%5D=is+exactly&advanced%5B0%5D%5Bterms%5D=$btext'>$text<span class='classic'>$type_information</span></a>";
#		$return_this = "<a class='hover-type' href='/verhalenbank/items/browse?search=&advanced%5B0%5D%5Belement_id%5D=51&advanced%5B0%5D%5Btype%5D=is+exactly&advanced%5B0%5D%5Bterms%5D=$btext'>$text</a>";
    	return $return_this;
	}
	else{
		return false;
	}
}


function my_text_link_function($text, $record, $elementText)
{
	$return_this = "<div class = 'story-text'>$text</div>";
#	$return_this = "<div class='bl'><div class='br'><div class='tl'><div class='tr'><div class = 'story-text'>$text</div></div></div></div></div><div class='clear'>&nbsp;</div>";
    return $return_this;
}

?>