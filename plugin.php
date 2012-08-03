<?php

add_filter(array('Display', 'Item', 'Item Type Metadata', 'Volksverhaal_type'), 'my_type_link_function');
add_filter(array('Display', 'Item', 'Item Type Metadata', 'Tekst'), 'my_text_link_function');



function my_type_link_function($text, $record, $elementText)
{
	$btext = str_replace(" ", "+", $text);
	$return_this = "<a href='/verhalenbank_omeka/items/browse?search=&advanced%5B0%5D%5Belement_id%5D=160&advanced%5B0%5D%5Btype%5D=is+exactly&advanced%5B0%5D%5Bterms%5D=$btext'>$text</a>";
#	$return_this .= $elementText;
    return $return_this;
}


function my_text_link_function($text, $record, $elementText)
{
	$return_this = "<div class = 'story-text'><pre>$text</pre></div>";
    return $return_this;
}

?>