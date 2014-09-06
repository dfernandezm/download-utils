<?php
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use JMS\Serializer\Serializer;

class ControllerArgumentsListener
{
	private $serializer;

	public function __construct(Serializer $serializer)
	{
		$this->serializer = $serializer;
	}

	public function onKernelController(FilterControllerEvent $event)
	{
		$request = $event->getRequest();

		// the controller is an attribute of the request
		$controller = $request->attributes->get('_controller');

		// controller looks like class::method, we need array(class, method)
		$controller = explode('::', $controller);

		try {
			new \ReflectionParameter($controller, 'comment');
		}
		catch (\ReflectionException $e) {
			// no controller argument named "comment" was found
			return;
		}

		if ($request->attributes->has('comment')) {
			// comment attribute already exists, do not overwrite it
			return;
		}

		
			// deserialize the request content into a Comment object
			$comment = $this->serializer->deserialize(
					$request->getContent(),
					'Matthias\\RestBundle\\DataTransferObject\\Comment',
					'json'
		
		// set the comment attribute on the request,
		// this will be used as the $comment argument of the controller
		$request->attributes->set('comment', $comment);
	}
}