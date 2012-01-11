<?php
function split_occupy_name($name, $color)
{
	$split = explode(' ', $name);	
	$result = '<span class="color:#'.$color.' !important;">'.$split[0].'</span> '.$split[1];
	return $result;
}