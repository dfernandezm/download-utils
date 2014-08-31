<?php
namespace Morenware\DutilsBundle\Entity;
use Morenware\DutilsBundle\Entity\Enum;

class DownloadJobState extends Enum
{
    const COMPLETED = 'COMPLETED';
    const PROCESSING = 'PROCESSING';
    const FAILED = 'FAILED';
}