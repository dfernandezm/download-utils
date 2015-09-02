<?php
namespace Morenware\DutilsBundle\Service;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;
use Doctrine\Common\Persistence\ObjectManager;
use Morenware\DutilsBundle\Entity\FileInListing;
use Morenware\DutilsBundle\Util\GeneralUtils;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;


/** @Service("filemanager.service") */
class FileManagerService {

	/** @DI\Inject("settings.service")
	 *  @var \Morenware\DutilsBundle\Service\SettingsService $settingsService
	 */
	public $settingsService;

	private $logger;

	const TV_SHOWS_FOLDER_NAME = "TV Shows";
	const MOVIES_FOLDER_NAME = "Movies";

	/**
	 * @DI\InjectParams({
	 *     "logger" = @DI\Inject("logger")
	 * })
	 * @param Logger $logger
	 */
	public function __construct($logger) {
		$this->logger = $logger;
	}


	public function getRootMediacenterListing($mediaLibraryRoot) {

        $fileList = array();

        $tvShowsFolderPath = $mediaLibraryRoot . "/" . self::TV_SHOWS_FOLDER_NAME;
        $permissions = $this->readFilePermissions($tvShowsFolderPath);
        $modificationDate = date ("Y-m-d H:i:s", filemtime($tvShowsFolderPath));

        $tvShowsFolder = new FileInListing();
        $tvShowsFolder->setType("dir");
        $tvShowsFolder->setName(self::TV_SHOWS_FOLDER_NAME);

        $tvShowsFolder->setRights($permissions);
        $tvShowsFolder->setSize(filesize($tvShowsFolderPath));
        $tvShowsFolder->setDate($modificationDate);

        $fileList[] = $tvShowsFolder;

        $moviesFolderPath = $mediaLibraryRoot . "/" . self::MOVIES_FOLDER_NAME;
        $moviesFolder = new FileInListing();
        $moviesFolder->setType("dir");
        $moviesFolder->setName(self::MOVIES_FOLDER_NAME);

        $moviesFolderPermissions = $this->readFilePermissions($moviesFolderPath);
        $moviesFolder->setRights($moviesFolderPermissions);
        $moviesFolder->setSize(filesize($moviesFolderPath));
        $moviesFolderModificationDate = date ("Y-m-d H:i:s", filemtime($moviesFolderPath));
        $moviesFolder->setDate($moviesFolderModificationDate);

        $fileList[] = $moviesFolder;

        return $fileList;
	}

	public function getFileInfoForListing($filePath) {

		$fileForListing = new FileInListing();

		if (is_dir($filePath)) {
			$fileForListing->setType("dir");
			$fileForListing->setName(basename($filePath));
		} else {
			$fileForListing->setType("file");
			$fileForListing->setName(basename($filePath));
		}

		$permissions = $this->readFilePermissions($filePath);
		$fileForListing->setRights($permissions);
		$fileForListing->setSize(filesize($filePath));

		$modificationDate = date ("Y-m-d H:i:s", filemtime($filePath));
		$fileForListing->setDate($modificationDate);

		return $fileForListing;

	}

	public function listFiles($path) {

		$fileList = array();
		$mediaLibraryRoot = $this->settingsService->getDefaultMediacenterSettings()->getBaseLibraryPath();

		if ($path === '/') {

			// Requesting the root
			$this->logger->debug("[FILEMANAGER] Requesting listing of root path");

			$fileList = $this->getRootMediacenterListing($mediaLibraryRoot);

		} else {

			// convert to full path
            if (is_link($mediaLibraryRoot)) {
                $this->logger->debug("[FILEMANAGER] Root $mediaLibraryRoot ");
                $mediaLibraryRoot = readlink($mediaLibraryRoot);
                $this->logger->debug("[FILEMANAGER] Real path from symlink is $mediaLibraryRoot");
            }

			$filePath = $mediaLibraryRoot . $path;

			// List files inside if dir
			if (is_dir($filePath)) {
				$fileList = $this->readDirectoryAsFileInfos($filePath);
			} else {
				$fileList[] = $this->getFileInfoForListing($filePath);
			}

		}

		return $fileList;
	}

	private function getMediaLibraryRootPath() {

		$mediaLibraryRoot = $this->settingsService->getDefaultMediacenterSettings()->getBaseLibraryPath();

		if (is_link($mediaLibraryRoot)) {
			$this->logger->debug("[FILEMANAGER] Root $mediaLibraryRoot ");
			$mediaLibraryRoot = readlink($mediaLibraryRoot);
			$this->logger->debug("[FILEMANAGER] Real path from symlink is $mediaLibraryRoot");
		}

		return $mediaLibraryRoot;

	}


	private function readDirectoryAsFileInfos($dirPath) {
		$fileList = array();
        $this->logger->debug("[FILEMANAGER] About to read entries of directory $dirPath");
		if ($handle = opendir($dirPath)) {

			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != ".." && !GeneralUtils::startsWith($entry, ".")) {
					$entryFullPath =  "$dirPath/$entry";
					$this->logger->debug("[FILEMANAGER] Reading entries from directory $dirPath: " . "$entryFullPath");
					$fileList[] = $this->getFileInfoForListing($entryFullPath);
				}
			}
			closedir($handle);
		}

		return $fileList;
	}


	private function readFilePermissions($filePath) {

		$perms = fileperms($filePath);
		$info = "";

		// General
		if (($perms & 0xA000) == 0xA000) {
			// Symbolic Link
			$info = 'l';
		} else if (($perms & 0x8000) == 0x8000) {
			// Regular
			$info = '-';
		} elseif (($perms & 0x4000) == 0x4000) {
			// Directory
			$info = 'd';
		}

		// Owner
		$info .= (($perms & 0x0100) ? 'r' : '-');
		$info .= (($perms & 0x0080) ? 'w' : '-');
		$info .= (($perms & 0x0040) ?
			         (($perms & 0x0800) ? 's' : 'x' ) :
			         (($perms & 0x0800) ? 'S' : '-'));

		// Group
		$info .= (($perms & 0x0020) ? 'r' : '-');
		$info .= (($perms & 0x0010) ? 'w' : '-');
		$info .= (($perms & 0x0008) ?
			         (($perms & 0x0400) ? 's' : 'x' ) :
			         (($perms & 0x0400) ? 'S' : '-'));

        // World
		$info .= (($perms & 0x0004) ? 'r' : '-');
		$info .= (($perms & 0x0002) ? 'w' : '-');
		$info .= (($perms & 0x0001) ?
			         (($perms & 0x0200) ? 't' : 'x' ) :
			         (($perms & 0x0200) ? 'T' : '-'));

		return $info;
	}


	public function remove($path) {

		$mediaLibraryRootPath = $this->getMediaLibraryRootPath();
		$fullPath = $mediaLibraryRootPath . $path;

		if (file_exists($fullPath)) {

				if ($path != '/' && $path !== "/".self::TV_SHOWS_FOLDER_NAME && $path !== "/".self::MOVIES_FOLDER_NAME ) {

				    if (is_dir($fullPath)) {
                        $this->deleteDir($fullPath);
                    } else {
                        unlink($fullPath);
                    }

                } else {
                    $this->logger->warn("[FILEMANAGER] Reject deletion of root path " . $path);
                }
		} else {
            $this->logger->warn("[FILEMANAGER] Path requested for deletion does no exist " . $fullPath);
        }

	}


    public function editSubtitle($content, $path) {

        $mediaLibraryRootPath = $this->getMediaLibraryRootPath();
        $fullPath = $mediaLibraryRootPath . $path;

        // Only allow editing .srt files
        if (GeneralUtils::endsWith($fullPath, ".srt")) {

            if (file_exists($fullPath)) {
                file_put_contents($fullPath, $content);
            } else {
                $this->logger->warn("[FILEMANAGER] Cannot edit file in path $fullPath");
            }

        } else {
            $this->logger->warn("[FILEMANAGER] Cannot edit file in path $fullPath");
        }

    }

    public function getSubtitleContent($path) {
        $mediaLibraryRootPath = $this->getMediaLibraryRootPath();
        $fullPath = $mediaLibraryRootPath . $path;

        // Only allow editing .srt files
        if (GeneralUtils::endsWith($fullPath, ".srt")) {

            if (file_exists($fullPath)) {

                $content = file_get_contents($fullPath);
                return $content;

            } else {
                $this->logger->warn("[FILEMANAGER] Cannot edit file in path $fullPath");
            }

        } else {
            $this->logger->warn("[FILEMANAGER] Cannot edit file in path $fullPath");
        }

        return null;
    }

    public function renameOrMove($currentPath, $newPath) {

        $mediaLibraryRootPath = $this->getMediaLibraryRootPath();

        $fullCurrentPath = $mediaLibraryRootPath . $currentPath;
        $fullNewPath = $mediaLibraryRootPath . $newPath;

        if (file_exists($fullCurrentPath)) {

            if (!file_exists($fullNewPath)) {
                rename($fullCurrentPath, $fullNewPath);
            } else {
                $this->logger->warn("[FILEMANAGER] New path already exists $fullNewPath");
            }

        } else {
            $this->logger->warn("[FILEMANAGER] Current path does not exist $fullCurrentPath");
        }

    }

    public function uploadFileToLocation() {

    }

    public function downloadOrPreview() {
        
    }


    private function deleteDir($dirPath) {
        $it = new RecursiveDirectoryIterator($dirPath, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);

        foreach($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }

        rmdir($dirPath);
    }






}