<?php
namespace Morenware\DutilsBundle\Util;

class GuidGenerator {
	
	const validCharacters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
	
	
	public static function generate() {
		$guid = '';
		$chars = self::validCharacters;
		
		for ($i = 0; $i < 12; $i++) {
			$guid = $guid . $chars[rand(0, strlen($chars)-1)];
		}
		
		return $guid;
	}
	
}