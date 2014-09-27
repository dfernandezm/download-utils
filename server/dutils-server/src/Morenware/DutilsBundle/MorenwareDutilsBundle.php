<?php

namespace Morenware\DutilsBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MorenwareDutilsBundle extends Bundle
{
	
	
	/* (non-PHPdoc)
	 * @see \Symfony\Component\HttpKernel\Bundle\Bundle::boot()
	 */
	public function boot() {
		
		$em = $this->container->get("doctrine.orm.entity_manager");
		$config = $em->getConfiguration();
		$config->addEntityNamespace("DU", "Morenware\\DutilsBundle\\Entity");

	}

	
}
