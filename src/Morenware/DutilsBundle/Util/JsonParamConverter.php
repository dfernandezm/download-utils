<?php
namespace Morenware\DutilsBundle\Util;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class JsonParamConverter implements ParamConverterInterface {
	
	private $serializer;
	
	public function __construct(SerializerInterface $serializer) {
		$this->serializer = $serializer;
	}
	
	function apply(Request $request, ParamConverter $configuration) {
		$name    = $configuration->getName();
		$class   = "Morenware\\DutilsBundle\\" . $configuration->getClass();
		$options = $this->getOptions($configuration);
		
		try {
			
			$jsonStr = $request->getContent();
		
			// if present, deserialize only this part of the object
			$specificProperty = $options['json_property']; 
			
			if ( $specificProperty !== null) {
				$requestStr = $request->getContent();
				$jsonArray = json_decode($requestStr, true);
				$jsonStr = json_encode($jsonArray[$specificProperty]);
			}
			
			$object = $this->serializer->deserialize(
					$jsonStr,
					$class,
					'json'
			);
	
			$request->attributes->set($name, $object);
			
			return true;
		} catch (Exception $e) {
			throw new NotFoundHttpException(sprintf('Could not deserialize request content to object of type "%s"',
					$class));
		}
	}

	function supports(ParamConverter $configuration) {
		if (!$configuration->getClass()) {
			return false;
		}
		
		// for simplicity, everything that has a "class" type hint is supported
		return true;
	}
	
	protected function getOptions(ParamConverter $configuration)
	{
		return array_replace(array(
				'json_property' => null
		), $configuration->getOptions());
	}
}