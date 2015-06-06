<?php
namespace Morenware\DutilsBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="automated_search_config")
 *
 */
class AutomatedSearchConfig {

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;


	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $contentType;


	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $contentTitle;


	/**
	 * @ORM\Column(type="string", length=200)
	 */
	private $preferredQuality;


    /**
     * @ORM\Column(type="string", length=200)
     */
    private $preferredFormat;


    /**
     * @ORM\Column(name="subtitles_enabled", type="boolean", length=1, nullable=true)
     */
    private $subtitlesEnabled;


    /**
     * @ORM\Column(type="string", length=100)
     */
    private $contentLanguage;


    /**
     * @ORM\Column(name="download_starts_automatically", type="boolean", length=1, nullable=true)
     */
    private $downloadStartsAutomatically;


	/**
	 * @ORM\Column(type="datetime")
	 *
	 */
	private $referenceDate;


	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 *
	 */
	private $lastCheckedDate;


	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 *
	 */
	private $lastDownloadedDate;


	/**
	 * @ORM\Column(type="string", length=100, nullable=true)
	 */
	private $subtitlesLanguage;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * @param mixed $contentType
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * @return mixed
     */
    public function getContentTitle()
    {
        return $this->contentTitle;
    }

    /**
     * @param mixed $contentTitle
     */
    public function setContentTitle($contentTitle)
    {
        $this->contentTitle = $contentTitle;
    }

    /**
     * @return mixed
     */
    public function getPreferredQuality()
    {
        return $this->preferredQuality;
    }

    /**
     * @param mixed $preferredQuality
     */
    public function setPreferredQuality($preferredQuality)
    {
        $this->preferredQuality = $preferredQuality;
    }

    /**
     * @return mixed
     */
    public function getPreferredFormat()
    {
        return $this->preferredFormat;
    }

    /**
     * @param mixed $preferredFormat
     */
    public function setPreferredFormat($preferredFormat)
    {
        $this->preferredFormat = $preferredFormat;
    }

    /**
     * @return mixed
     */
    public function getSubtitlesEnabled()
    {
        return $this->subtitlesEnabled;
    }

    /**
     * @param mixed $subtitlesEnabled
     */
    public function setSubtitlesEnabled($subtitlesEnabled)
    {
        $this->subtitlesEnabled = $subtitlesEnabled;
    }

    /**
     * @return mixed
     */
    public function getContentLanguage()
    {
        return $this->contentLanguage;
    }

    /**
     * @param mixed $contentLanguage
     */
    public function setContentLanguage($contentLanguage)
    {
        $this->contentLanguage = $contentLanguage;
    }

    /**
     * @return mixed
     */
    public function getDownloadStartsAutomatically()
    {
        return $this->downloadStartsAutomatically;
    }

    /**
     * @param mixed $downloadStartsAutomatically
     */
    public function setDownloadStartsAutomatically($downloadStartsAutomatically)
    {
        $this->downloadStartsAutomatically = $downloadStartsAutomatically;
    }

    /**
     * @return mixed
     */
    public function getReferenceDate()
    {
        return $this->referenceDate;
    }

    /**
     * @param mixed $referenceDate
     */
    public function setReferenceDate($referenceDate)
    {
        $this->referenceDate = $referenceDate;
    }

    /**
     * @return mixed
     */
    public function getLastCheckedDate()
    {
        return $this->lastCheckedDate;
    }

    /**
     * @param mixed $lastCheckedDate
     */
    public function setLastCheckedDate($lastCheckedDate)
    {
        $this->lastCheckedDate = $lastCheckedDate;
    }

    /**
     * @return mixed
     */
    public function getLastDownloadedDate()
    {
        return $this->lastDownloadedDate;
    }

    /**
     * @param mixed $lastDownloadedDate
     */
    public function setLastDownloadedDate($lastDownloadedDate)
    {
        $this->lastDownloadedDate = $lastDownloadedDate;
    }

    /**
     * @return mixed
     */
    public function getSubtitlesLanguage()
    {
        return $this->subtitlesLanguage;
    }

    /**
     * @param mixed $subtitlesLanguage
     */
    public function setSubtitlesLanguage($subtitlesLanguage)
    {
        $this->subtitlesLanguage = $subtitlesLanguage;
    }

}