import groovy.util.logging.Log4j
import org.apache.log4j.*

import java.nio.charset.Charset
import java.nio.file.Files
import java.nio.file.Path
import java.nio.file.Paths
import java.nio.file.StandardCopyOption
import java.util.regex.Matcher
import java.util.regex.Pattern

@Log4j
class RenamerScript {

    static Logger LOG
    final static String TVDB_TV_SHOWS_FOLDER = "TV Shows"
    final static String MOVIES_FOLDER = "Movies"
    final static String LOG_FILE_LOCATION = "/opt/download-utils/logs/renamer.log"

    static {
        String PATTERN = "%d{dd-MM-yyyy HH:mm:ss} %-5p [%c{1}] %m%n"
        def simple = new PatternLayout(PATTERN)
        LogManager.rootLogger.level = Level.DEBUG
        LogManager.rootLogger.removeAllAppenders()
        LogManager.rootLogger.addAppender(new FileAppender(simple, LOG_FILE_LOCATION, true))
        LOG = Logger.getLogger(Renamer.class)
    }

    def tvShowsTitles = []
    String acceptedFileRegex = "\\.(avi|mp4|srt|mkv)\$"

    // Seasons and episodes regex
    String regex1 = "[Ss](\\d{1,2})[Ee](\\d{1,2})\\D"
    String regex2 = "(\\d{1,2})x(\\d{1,2})\\D"
    String seasonDirectoryRegex = "[Ss](eason(\\s|\\.|_)(\\d{1,2}))?(\\d{1,2})?\\D"
    String renamedRegex = "^(\\w+\\s)+([0-9]{1,2})x([0-9]{1,2})\\.(avi|mp4|srt|mkv)\$"
    String titleRegex = "^(([\\w\\(\\)]+[\\s\\.\\-_]+)+)(\\[)?(([Ss](eason|\\d{1,2}))|(\\d{1,2}x))(\\])?"



    // Pre compiled patterns
    Pattern pattern1 = Pattern.compile(regex2)
    Pattern pattern2 = Pattern.compile(regex1)
    Pattern renamedPattern = Pattern.compile(renamedRegex)

    // Base path
    String basePath
    String folderToOrganize

    public RenamerScript(String basePath, String folderToOrganize) {
        this.basePath = basePath
        this.folderToOrganize = folderToOrganize
    }

    def readTvShowsListing(String tvShowsFilePath) {
        File f = new File(tvShowsFilePath)

        f.eachLine { line ->
            tvShowsTitles << line
        }

        LOG.debug("Read file containing TV Shows");
        tvShowsTitles.each {
            LOG.debug(it)
        }
    }




    /**
     * Checks whether the subdirectory found is valid or not to explore it
     */
    def isValidSubDirectory(File dir, String name, boolean enterAllSubdirectories) {
        LOG.debug("Entering subdirectoy $name")
        File d = new File(dir.getAbsolutePath() + File.separator + name)
        if (d.exists() && d.isDirectory() && (name.find(regex1) || name.find(regex2)
                || name.find(seasonDirectoryRegex) || enterAllSubdirectories)) {
            return true
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
        File sourceDir = source.getParent().toFile()
        if (sourceDir.isDirectory() && !sourceDir.getName().contains("torrents") && sourceDir.listFiles().length == 0) {
            sourceDir.delete()
        }
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
                        def name = matcher.group(1) // TODO: check this!!
                        def season = matcher.group(2)
                        LOG.debug("Already renamed $filename: $name $season -- moving")
                        moveToTvDbFolder(file.getAbsolutePath(), showName, season)
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
                    Files.copy(file.toPath(), Paths.get(oldFilesFolder.getAbsolutePath() + File.separator + filename))
                }

                def newPath = folder.getAbsolutePath() + File.separator + newName

                // rename
                Files.move(file.toPath(), Paths.get(newPath), StandardCopyOption.REPLACE_EXISTING)

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
            String lowerStr = cleaned.toLowerCase().trim()
            for (int i = 0; i < tvShowsTitles.size(); i++) {
                String currentTitle = tvShowsTitles.get(i)
                def currentTitleNorm = currentTitle.toLowerCase().trim()
                if (currentTitleNorm.startsWith(lowerStr)) {
                    LOG.debug("Title is $currentTitle")
                    return currentTitle
                }
                if (lowerStr.startsWith(currentTitleNorm)) {
                    LOG.debug("Title is $currentTitle")
                    return currentTitle
                }

                String[] currentTitleNormSplit = currentTitleNorm.split(" ")
                String[] lowerStrNormSplit = lowerStr.split(" ")

                def maxCoincidences = currentTitleNormSplit.size()
                def actualCoincidences = 0
                for (int j = 0; j < lowerStrNormSplit.size() ; j++) {
                    if (j < currentTitleNormSplit.size() && lowerStrNormSplit[j].equals(currentTitleNormSplit[j])) {
                        actualCoincidences++
                    }
                }

                if (actualCoincidences > 0 && maxCoincidences > 2 && (actualCoincidences == (maxCoincidences - 1))) {
                    LOG.debug("Title is $currentTitle")
                    return currentTitle
                }
            }
            LOG.debug("Could not find a match for $lowerStr in list, leaving it as the title")
            return lowerStr
        }
    }


    /**
     * Renames and moves possible movies, matching with list
     */
    def renameAndMoveMovies(String path) {
        
        LOG.debug("Looking up movies in path $path...")

        File folder = new File(path)

        if (folder.exists()) {

            File[] files = folder.listFiles(new FilenameFilter() {
                @Override
                boolean accept(File dir, String name) {
                    return name.find(acceptedFileRegex) || isValidSubDirectory(dir, name, true)
                }
            })

            LOG.info("Checking " + files.length + " in folder " + folder.getAbsolutePath())

            for (int i = 0; i < files.length; i++) {

                File file = files[i]

                if (file.isDirectory()) {
                    renameAndMoveMovies(file.getAbsolutePath())
                    continue
                }

                String filename = file.getName();
                String extension = filename.substring(filename.lastIndexOf("."))

                String cleaned1 = filename.replaceAll("\\.", " ")
                String cleaned2 = cleaned1.replaceAll("_", " ")
                String cleaned = cleaned2.replaceAll("-", " ")
                String lowerStr = cleaned.toLowerCase().trim()

                String movieTitle = "movie_" + System.currentTimeInMillis()

                for (int i = 0; i < moviesTitles.size(); i++) {
                    
                    String currentTitle = moviesTitles.get(i)
                    def currentTitleNorm = currentTitle.toLowerCase().trim()
                    
                    if (currentTitleNorm.startsWith(lowerStr)) {
                        LOG.debug("Title is $currentTitle")
                        movieTitle = currentTitle
                        break
                    }
                    
                    if (lowerStr.startsWith(currentTitleNorm)) {
                        LOG.debug("Title is $currentTitle")
                        movieTitle = currentTitle
                        break
                    }

                    String[] currentTitleNormSplit = currentTitleNorm.split(" ")
                    String[] lowerStrNormSplit = lowerStr.split(" ")

                    def maxCoincidences = currentTitleNormSplit.size()
                    def actualCoincidences = 0
                    
                    for (int j = 0; j < lowerStrNormSplit.size() ; j++) {
                        if (j < currentTitleNormSplit.size() && lowerStrNormSplit[j].equals(currentTitleNormSplit[j])) {
                            actualCoincidences++
                        }
                    }

                    if (maxCoincidences > 1 && (actualCoincidences >= (maxCoincidences - 1))) {
                        LOG.debug("Title is $currentTitle")
                        movieTitle = currentTitle
                        break
                    }
                }

                String newMovieName = movieTitle + "." + extension 

                File movieFolder = new File(basePath + File.separator + MOVIES_FOLDER + File.separator + movieTitle)
                movieFolder.mkdirs()

                String moviePath = movieFolder.getAbsolutePath() + File.separator + newMovieName  

                // rename and move
                Files.move(file.toPath(), Paths.get(moviePath), StandardCopyOption.REPLACE_EXISTING)

                LOG.info("File moved $filename -> $moviePath")
            }                
        }
    }


    /**
    * Given a folder path, renames and moves files to baseTvDb folder root in order to be recognised by the scraper
    */
    def organizeFolder(String path) {
        renameFiles(path, false, true)
    }

    def cleanup(String path) {
        LOG.info("Cleaning up directory in path $path")
        File baseDir = new File(path)

        File[] files = baseDir.listFiles(new FilenameFilter() {
            @Override
            boolean accept(File dir, String name) {
                return !name.find(acceptedFileRegex) && !name.endsWith(".part");
            }
        })
        
        for (int i = 0; i < files.length; i++) {
            File f = files[i]
            if (f.isDirectory()) {
                String directoryName = f.getName()
                LOG.debug("Entering directory to cleanup... $directoryName")
                cleanup(f.getAbsolutePath())
                if (f.listFiles().length == 0) {
                    f.delete()
                    LOG.debug("Deleting empty directory $directoryName")
                }
            }
            def fileToDelete = f.getName()
            f.delete()
            LOG.debug("Deleting file $fileToDelete")
        }
    }
}

def main() {
    def cli = new CliBuilder(usage: 'Renamer.groovy [--base-path downloadPath --tv-shows-file file.txt] [--organize folder] [--cleanup]')

    cli.with {
        h longOpt: 'help', 'Show usage information'
        bp longOpt: 'base-path', args: 1, argName: 'path','Folder with downloads to organize'
        f longOpt: 'tv-shows-file', args: 1, argName: 'file.txt', 'File containing a list of TV Shows to match against'
        o longOpt: 'organize', args: 1, argName: 'path', 'Folder to organize into TVDB library'
        cl longOpt: 'cleanup', 'Folder to clean, clears everything but the accepted files [avi|mp4|mkv|srt]'
    }

    def options = cli.parse(args)
    if (!options) {
        return
    }

    if (options.h) {
        cli.usage()
        return
    }

    RenamerScript renamerScript;

    if (options.bp && options.f) {

        renamerScript = new RenamerScript(options.bp, null)
        renamerScript.readTvShowsListing(options.f)
        println(options.bp)
        def base = options.bp
        renamerScript.renameFiles("$base/torrents", false, true)
        return
    }

    if (options.o && options.f) {
        renamerScript = new RenamerScript(options.o, null)
        renamerScript.readTvShowsListing(options.f)
        renamerScript.organizeFolder(options.o)
        return
    }

    if (options.bp && options.cl) {
        renamerScript = new RenamerScript(options.bp, null)
        def base = options.bp
        renamerScript.cleanup("$base/torrents")
    }
}

try {
    main()
} catch (Throwable t) {
    RenamerScript.LOG.error("Error executing Groovy Script: " + t.getMessage(), t);
}

