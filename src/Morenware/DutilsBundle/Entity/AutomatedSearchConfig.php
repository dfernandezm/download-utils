<?php
namespace Morenware\DutilsBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\AccessType;


/**
 *
 * @ORM\Entity
 * @ORM\Table(name="automated_search_config")
 * @ExclusionPolicy("none")
 * @AccessType("public_method")
 */
class AutomatedSearchConfig {

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;


	/**
	 * @ORM\Column(name="content_type", type="string", length=100)
	 */
	private $contentType;


	/**
	 * @ORM\Column(name="content_title", type="string", length=100)
	 */
	private $contentTitle;


	/**
	 * @ORM\Column(name="preferred_quality", type="string", length=200)
	 */
	private $preferredQuality;


    /**
     * @ORM\Column(name="preferred_format", type="string", length=200)
     */
    private $preferredFormat;


    /**
     * @ORM\Column(name="subtitles_enabled", type="boolean", length=1, nullable=true)
     */
    private $subtitlesEnabled;


    /**
     * @ORM\Column(name="content_language", type="string", length=100)
     */
    private $contentLanguage;


    /**
     * @ORM\Column(name="download_starts_automatically", type="boolean", length=1, nullable=true)
     */
    private $downloadStartsAutomatically;


	/**
	 * @ORM\Column(name="reference_date", type="datetime")
	 *
	 */
	private $referenceDate;


	/**
	 * @ORM\Column(name="last_checked_date", type="datetime", nullable=true)
	 *
	 */
	private $lastCheckedDate;


	/**
	 * @ORM\Column(name="last_download_date", type="datetime", nullable=true)
	 *
	 */
	private $lastDownloadDate;


	/**
	 * @ORM\Column(name="subtitles_languages", type="string", length=100, nullable=true)
	 */
	private $subtitlesLanguages;

    /**
     * @ORM\Column(name="active", type="boolean", length=1, nullable=false)
     */
    private $active = true;


    /**
     * @ORM\OneToMany(targetEntity="Feed", mappedBy="automatedSearchConfig", cascade={"merge"})
     *
     * @Exclude
     *
     */
    private $feeds;


    /**
     * @Type("array<integer>")
     */
    private $feedIds;


    public function __construct() {
        $this->feeds = new ArrayCollection();

    }

    /**
     * @return mixed
     */
    public function getFeedIds()
    {
        return $this->feedIds;
    }

    /**
     * @param mixed $feedIds
     */
    public function setFeedIds($feedIds)
    {
        $this->feedIds = $feedIds;
    }

    //TO Remove!!
    public function collectIds() {

        $ids = array();

        if ($this->feeds !== null) {
            foreach ($this->feeds as $feed) {
                $ids[] = $feed->getId();
            }
        }

        $this->feedIds = $ids;
    }




    /**
     * @return mixed
     */
    public function getFeeds()
    {
        return $this->feeds;
    }

    /**
     * @param mixed $feeds
     */
    public function setFeeds($feeds)
    {
        $this->feeds = $feeds;
    }



    public function _construct() {
        $this->active = true;
    }
    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

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
    public function getLastDownloadDate()
    {
        return $this->lastDownloadDate;
    }

    /**
     * @param mixed $lastDownloadDate
     */
    public function setLastDownloadDate($lastDownloadDate)
    {
        $this->lastDownloadDate = $lastDownloadDate;
    }

    /**
     * @return mixed
     */
    public function getSubtitlesLanguages()
    {
        return $this->subtitlesLanguages;
    }

    /**
     * @param mixed $subtitlesLanguages
     */
    public function setSubtitlesLanguages($subtitlesLanguages)
    {
        $this->subtitlesLanguages = $subtitlesLanguages;
    }

}