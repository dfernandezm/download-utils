<?php
namespace Morenware\DutilsBundle\Util;

use Symfony\Component\HttpFoundation\JsonResponse;
class ControllerUtils {
	
	public static function createJsonResponseForDto($serializer, $object, $statusCode = 200) {
		$data = json_decode($serializer->serialize($object, 'json'));
		return new JsonResponse($data, $statusCode);
	}
	
	public static function createJsonResponseForArray($array, $statusCode = 200) {
		return new JsonResponse($array, $statusCode);
	}
	
	public static function createJsonStringForDto($serializer, $object) {
		$jsonString = $serializer->serialize($object, 'json');
		return $jsonString;
	}

}