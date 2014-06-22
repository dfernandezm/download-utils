import groovy.util.logging.Log4j
import org.apache.log4j.*

import java.nio.file.Files
import java.nio.file.Path
import java.nio.file.Paths
import java.nio.file.StandardCopyOption
import java.util.regex.Matcher
import java.util.regex.Pattern

@Log4j
class Renamer {

    static Logger LOG
    final static String TVDB_TV_SHOWS_FOLDER = "TV Shows"
    final static String LOG_FILE_LOCATION = "/opt/download-utils/logs/renamer.log"

    static {
        String PATTERN = "%d{ABSOLUTE} %-5p [%c{1}] %m%n"
        def simple = new PatternLayout(PATTERN)
        LogManager.rootLogger.level = Level.DEBUG
        LogManager.rootLogger.removeAllAppenders()
        LogManager.rootLogger.addAppender(new FileAppender(simple, LOG_FILE_LOCATION, true))
        LOG = Logger.getLogger(Renamer.class)
    }

    def tvShowsTitles = [
                    "24",
                    "Supernatural",
                    "Big Bang Theory",
                    "The Big Bang Theory",
                    "Big Bang",
                    "How I Met Your Mother",
                    "The Wire",
                    "Dexter",
                    "Castle",
                    "Game of Thrones",
                    "The Walking Dead",
                    "Sanctuary",
                    "Spartacus",
                    "Touch",
                    "True Blood",
                    "Black Mirror",
                    "Bones",
                    "Breaking Bad",
                    "Sherlock",
                    "Homeland",
                    "Arrow",
                    "The IT Crowd",
                    "Family Guy",
                    "The Community"
            ]
    String acceptedFileRegex = "\\.(avi|mp4|srt|mkv)\$"

    // Seasons and episodes regex
    String regex1 = "[Ss](\\d{1,2})[Ee](\\d{1,2})\\D"
    String regex2 = "(\\d{1,2})x(\\d{1,2})\\D"
    String seasonDirectoryRegex = "[Ss](eason(\\s|\\.|_)(\\d{1,2}))?(\\d{1,2})?\\D"
    String renamedRegex = "(\\w+\\s)+([0-9]{1,2})x([0-9]{1,2})\\.(avi|mp4|srt|mkv)\$"
    String titleRegex = "^(((\\w|\\(|\\))+(\\s|\\.|\\-|_))+)(([Ss](eason|\\d{1,2}))|(\\d{1,2}x))"

    // Pre compiled patterns
    Pattern pattern1 = Pattern.compile(regex2)
    Pattern pattern2 = Pattern.compile(regex1)
    Pattern renamedPattern = Pattern.compile(renamedRegex)

    // Base path
    String basePath
    String folderToOrganize

    public Renamer(String basePath, String folderToOrganize) {
        this.basePath = basePath
        this.folderToOrganize = folderToOrganize
    }

    /**
     * Checks whether the subdirectory found is valid or not to explore it
     */
    def isValidSubDirectory(File dir, String name, boolean enterAllSubdirectories) {
        File d = new File(dir.getAbsolutePath() + File.separator + name)
        if (d.exists() && d.isDirectory() && (name.find(regex1) || name.find(regex2)
                || name.find(seasonDirectoryRegex) || enterAllSubdirectories)) {
           LOG.debug("Found valid subdirectory $name")
            return true
        } else {
            LOG.debug("Subdirectory not valid: $name")
        }
    }

    /**
     * Retrieves the folder structure for the TVDB Scraper or creates it if not yet exists
     *
     * @param showName
     * @param season
     * @return
     */
    def getAndCheckTvDbStructure(showName, season) {
        // TV DB specific
        def baseFolderName = TVDB_TV_SHOWS_FOLDER
        def seasonName = "Season $season"
        def targetPath = "$basePath/$baseFolderName/$showName/$seasonName"

        File targetFile = new File(targetPath)
        targetFile.mkdirs()

        return targetFile
    }

    /**
     * Moves the file denoted by sourceFilePath to its destination in the TVDB Scraper library
     *
     * @param sourceFilePath
     * @param showName
     * @param season
     * @return
     */
    def moveToTvDbFolder(String sourceFilePath, showName, season) {
        File destination = getAndCheckTvDbStructure(showName, season)
        Path source = Paths.get(sourceFilePath)
        String destinationFilenamePath = destination.getAbsolutePath() + File.separator + source.fileName
        Files.move(source, Paths.get(destinationFilenamePath), StandardCopyOption.REPLACE_EXISTING)
    }

    /**
     * Given a base path, performs a lookup for TV Shows episodes, rename them and move them to a TVDB Scraper library
     * @param path
     * @param copyOriginal
     * @param enterAllSubdirectories
     */
    def renameFiles(String path, boolean copyOriginal, boolean enterAllSubdirectories) {

        LOG.debug("Executing Renamer for path $path")

        File folder = new File(path)

        if (folder.exists()) {

            File[] files = folder.listFiles(new FilenameFilter() {
                @Override
                boolean accept(File dir, String name) {
                    return name.find(acceptedFileRegex) || isValidSubDirectory(dir, name, enterAllSubdirectories)
                }
            })

            LOG.debug("Attempting to rename " + files.length + " files in folder " + folder.getAbsolutePath())

            for (int i = 0; i < files.length; i++) {

                File file = files[i]

                if (file.isDirectory()) {
                    renameFiles(file.getAbsolutePath(), copyOriginal, enterAllSubdirectories)
                    continue
                }

                String filename = file.getName()
                def showName = getTVShowTitle(filename)

                if (!tvShowsTitles.contains(showName)) {
                    LOG.debug("$filename match not found -- fix manually")
                    continue
                }

                if (filename.matches(renamedRegex)) {
                    Matcher matcher = renamedPattern.matcher(filename)
                    if (matcher.matches()) {
                        def name = matcher.group(1)
                        def season = matcher.group(2)
                        LOG.debug("Already renamed $filename: $name $season -- moving")
                        moveToTvDbFolder(file.getAbsolutePath(), name.trim(), season)
                    } else {
                        LOG.debug("Fail matcher")
                    }
                    continue
                }

                LOG.info("Renaming $filename")
                String extension = filename.substring(filename.lastIndexOf("."))

                def season
                def episode
                def newName

                Matcher matcher = pattern1.matcher(filename)
                Matcher matcher2 =  pattern2.matcher(filename)

                if (matcher.find()) {
                    season = Integer.parseInt(matcher.group(1))
                    episode = Integer.parseInt(matcher.group(2))
                } else if (matcher2.find()) {
                    season = Integer.parseInt(matcher2.group(1))
                    episode = Integer.parseInt(matcher2.group(2))
                }

                newName = showName + " " + season + "x" + (""+episode).padLeft(2,"0") + extension
                LOG.info("New name is $newName")

                if (copyOriginal) {
                    File oldFilesFolder = new File("$path/old")
                    oldFilesFolder.mkdirs()
                    Files.copy(Paths.get(file.getAbsolutePath()), Paths.get(oldFilesFolder.getAbsolutePath() + File.separator + filename))
                }

                def newPath = folder.getAbsolutePath() + File.separator + newName

                // rename
                Files.move(Paths.get(file.getAbsolutePath()), Paths.get(newPath), StandardCopyOption.REPLACE_EXISTING)

                moveToTvDbFolder(newPath, showName, season)
            }
        }
    }

    /**
     * Extracts a TV Show title from the given filename
     *
     * @param filename
     * @return
     */
    def getTVShowTitle(String filename) {
        LOG.debug("Extracting title from $filename")
        Pattern titleContainer = Pattern.compile(titleRegex)
        Matcher matcher = titleContainer.matcher(filename)

        if (matcher.lookingAt()) {
            LOG.debug("$filename contains a title, cleaning...")
            String titleSequence = matcher.group(1)
            String cleaned1 = titleSequence.replaceAll("\\.", " ")
            String cleaned2 = cleaned1.replaceAll("_", " ")
            String cleaned = cleaned2.replaceAll("-", " ")
            String lowerStr = cleaned.toLowerCase();
            for (int i = 0; i < tvShowsTitles.size(); i++) {
                String currentTitle = tvShowsTitles.get(i)
                def currentTitleNorm = currentTitle.toLowerCase()
                if (lowerStr.startsWith(currentTitleNorm)) {
                    LOG.debug("Title is $currentTitle")
                    return currentTitle
                }
            }
            LOG.debug("Could not find a match for $lowerStr in list, leaving it as the title")
            return lowerStr
        }
    }

    /**
     Given a folder path, renames and moves files to baseTvDb folder root in order to be recognised by the scraper
    */
    def organizeFolder(String path) {
        renameFiles(path, false, true)
    }
}

// Script handling
basePath = args[0]
def folderToOrganize
def copyOriginal = false

if (args.length > 1 && args[1].equals("-organize")) {
    folderToOrganize = args[2]
    Renamer renamerScript = new Renamer(basePath, folderToOrganize)
    renamerScript.organizeFolder(folderToOrganize)
} else {
    def renamerScript = new Renamer(basePath, null)
    renamerScript.renameFiles("$basePath/torrents", copyOriginal, false)
}





