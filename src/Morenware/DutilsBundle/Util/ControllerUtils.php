<?php
namespace Morenware\DutilsBundle\Util;

use Symfony\Component\HttpFoundation\JsonResponse;

class ControllerUtils {
	
	public static function createJsonResponseForDto($serializer, $object, $statusCode = 200, $field = null) {
		
		if ($field == null) {
			$data = json_decode($serializer->serialize($object, 'json'));
		} else {
			$jsonString =  "{ \"$field\": " . self::createJsonStringForDto($serializer, $object) . " }";
			$data = json_decode($jsonString);
		}
		
		return new JsonResponse($data, $statusCode);
	}
	
	public static function createJsonResponseForArray($array, $statusCode = 200) {
		return new JsonResponse($array, $statusCode);
	}
	
	public static function createJsonResponseForDtoArray($serializer, $array, $statusCode = 200, $field = null ) {
		
		if ($field == null) {
			return self::createJsonResponseForDto($serializer, $array, $statusCode = 200);
		} else {
			$jsonString =  "{ \"$field\": " . self::createJsonStringForDto($serializer, $array) . " }";
			$data = json_decode($jsonString);
			return new JsonResponse($data, $statusCode);			
		}
		
	}
	
	public static function createJsonStringForDto($serializer, $object) {
		$jsonString = $serializer->serialize($object, 'json');
		return $jsonString;
	}
	
	public static function sendError($code, $message, $statusCode ) {
		$error = array(
				"error" => $message,
				"errorCode" => $code,
				"statusCode" => $statusCode
		);
		
		return self::createJsonResponseForArray($error, $statusCode);
	}

}