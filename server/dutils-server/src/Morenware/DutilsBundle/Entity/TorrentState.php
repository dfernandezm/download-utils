<?php

namespace Morenware\DutilsBundle\Entity;

class TorrentState {

	const DOWNLOADING = "DOWNLOADING";
	const DOWNLOAD_COMPLETED = "DOWNLOAD_COMPLETED";
	const AWAITING_DOWNLOAD = "AWAITING_DOWNLOAD";
	const RENAMING_FILES = "RENAMING_FILES";
	const COMPLETED = "COMPLETED";
}