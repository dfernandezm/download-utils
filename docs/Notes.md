# Notes

## Development

# Build the client

Only available in `dev` mode for now.

```
npm run gulp-dev
``` 

# Launch a server

PHP 5.4 or newer and Apache 2 or newer need to be installed.

```
TODO
```

## Permission and folders

* `/data/downloads-processing`: temporary area for template scripts used by Symfony 2 commands engine. The permission is 777 as users `debian-transmission`, `www-data` and a regular user write there
* `/data/transmission/downloads`: transmission Torrents / Downloads path, only Transmission writes here, so `debian-transmission` should be the owner
* `/data/mediacenter`: Media center root (with TV Shows, Movies, Unsorted folders), Filebot writes here,  `debian-transmission` (?) and regular user. Make this universal writable 777 will prevent issues.
* `/opt/software/filebot` and subfolders: the regular user can own this as other users will impersonate as it to execute the renamer

## Workflows

### Torrent is added directly from Transmission Web UI

Transmission should notify the app that a Torrent has been added, so the app queries the state of torrents in Transmission.
With that info, updates the torrents state in database based on their hash:

* If they already exist, the progress is updated. If the progress is 100, the torrent is marked as DOWNLOAD_COMPLETED which puts it ready to be renamed

* If they don't exist in DB, they are created with state DOWNLOADING. Then the Transmission API is used to set up a renamer script (if it is not set already) and the relocation of the torrent being downloaded to a known folder is done as well. This prepares the further steps in the workflow

* When the torrent finishes downloading in Transmission, the renamer script is called which will launch Filebot on the download folders renaming, moving, getting subtitles and notifying XBMC of new content being added to the mediacenter.

* When Filebot finishes, a process parses the log file to detect and updated the state of the torrents that have been moved.  

### Torrent is discovered via Feed

* Torrents are created from Feeds matching the date ranges and quality criteria. These torrents are created in AWAITING_DOWNLOAD state and are enqueued in Transmission. A monitoring process starts then following the workflow previously explained

### Torrent is discovered via Search (cron or direct)

* It should be the same as Feed

### Torrent is added through Torrents API 

* The same as Feed

