<?php
namespace Morenware\DutilsBundle\Util;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

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

    public static function generateErrorResponse($message, $errorCode) {
        $error = array(
            "error" => "There was an error processing call: " . $message,
            "errorCode" => $errorCode);

        return ControllerUtils::createJsonResponseForArray($error, $errorCode);
    }



    public static function setupSerializer() {

        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(array('age'));
        $encoder = new JsonEncoder();

        $serializer = new Serializer(array($normalizer), array($encoder));

    }








}