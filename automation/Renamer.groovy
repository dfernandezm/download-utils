package com.david.util
import groovy.transform.Field

import java.nio.file.Files
import java.nio.file.Path
import java.nio.file.Paths
import java.nio.file.StandardCopyOption
import java.util.regex.Matcher
import java.util.regex.Pattern
/**
 * Created by david on 01/06/14.
 */

basePath = args[0]
def folderToOrganize
def copyOriginal = false

if (args.length > 1 && args[1].equals("-organize")) {
    folderToOrganize = args[2]
    organizeFolder(folderToOrganize)
} else {
    renameFiles("$basePath/torrents", copyOriginal, false)
}

//def showName = args[1]
@Field
tvShowsTitles = [
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
        "Arrow"
]

@Field
String acceptedFileRegex = "\\.(avi|mp4|srt|mkv)\$"

@Field
String regex1 = "[Ss]([0-9]{1,2})[Ee]([0-9]{1,2})[^0-9]"

@Field
String regex2 = "([0-9]{1,2})x([0-9]{1,2})[^0-9]"

@Field
String seasonDirectory = "[Ss](eason)*([0-9]{1,2})[^0-9]"

@Field
String renamedRegex = "(\\w+\\s)+([0-9]{1,2})x([0-9]{1,2})\\.(avi|mp4|srt|mkv)\$"

@Field
String titleRegex = "^(((\\w|\\(|\\))+(\\s|\\.|\\-))+)(([Ss](eason|\\d{1,2}))|(\\d{1,2}x))"

@Field
Pattern pattern1 = Pattern.compile(regex2)

@Field
Pattern pattern2 = Pattern.compile(regex1)


@Field
Pattern renamedPattern = Pattern.compile(renamedRegex)



def isValidSubDirectory(File dir, String name, boolean enterAllSubdirectories) {
    File d = new File(dir.getAbsolutePath() + File.separator + name)
    if (d.exists() && d.isDirectory() && (name.find(regex1) || name.find(regex2)) || enterAllSubdirectories) {
        println("Found valid subdirectory $name")
        return true
    } else {
        println("Subdirectory not valid: $name")
    }
}


def getAndCheckTvDbStructure(showName, season) {
    // TV DB specific
    def baseFolderName = "TV Shows"
    def seasonName = "Season $season"
    def targetPath = "$basePath/$baseFolderName/$showName/$seasonName"

    File targetFile = new File(targetPath)
    targetFile.mkdirs()

    return targetFile
}

def moveToTvDbFolder(String sourceFilePath, showName, season) {
    File destination = getAndCheckTvDbStructure(showName, season)
    Path source = Paths.get(sourceFilePath)
    String destinationFilenamePath = destination.getAbsolutePath() + File.separator + source.fileName

    Files.move(source, Paths.get(destinationFilenamePath), StandardCopyOption.REPLACE_EXISTING)
}

def renameFiles(String path, boolean copyOriginal, boolean enterAllSubdirectories) {

    File folder = new File(path)

    if (folder.exists()) {

        File[] files = folder.listFiles(new FilenameFilter() {
            @Override
            boolean accept(File dir, String name) {
                println("Checking match for $name")
                return name.find(acceptedFileRegex) || isValidSubDirectory(dir, name, enterAllSubdirectories)
            }
        })

        println("Attempting to rename " + files.length + " files in folder " + folder.getAbsolutePath())

        for (int i = 0; i < files.length; i++) {

            File file = files[i]

            if (file.isDirectory()) {
                renameFiles(file.getAbsolutePath(), copyOriginal, enterAllSubdirectories)
                continue
            }

            String filename = file.getName()
            showName = getTVShowTitle(filename)

            if (filename.matches(renamedRegex)) {
                Matcher matcher = renamedPattern.matcher(filename)
                if (matcher.matches()) {
                    def name = matcher.group(1)
                    def season = matcher.group(2)
                    println("Already renamed $filename: $name $season -- moving")
                    moveToTvDbFolder(file.getAbsolutePath(), name.trim(), season)
                } else {
                    println ("Fail matcher")
                }
                continue
            }

            println("Renaming $filename")
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
            println("New name is $newName")

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

def getTVShowTitle(String filename) {
    println("Extracting title from $filename")
    Pattern titleContainer = Pattern.compile(titleRegex)
    Matcher matcher = titleContainer.matcher(filename)

    if (matcher.lookingAt()) {
        println("$filename contains a title, cleaning...")
        String titleSequence = matcher.group(1)
        String cleaned1 = titleSequence.replaceAll("\\.", " ")
        String cleaned2 = cleaned1.replaceAll("_", " ")
        String cleaned = cleaned2.replaceAll("-", " ")
        String lowerStr = cleaned.toLowerCase();
        for (int i = 0; i < tvShowsTitles.size(); i++) {
            String currentTitle = tvShowsTitles.get(i)
            def currentTitleNorm = currentTitle.toLowerCase()
            if (lowerStr.startsWith(currentTitleNorm)) {
                println("Title is $currentTitle")
                return currentTitle
            }
        }
    }
}

/**
Given a folder path, renames and moves files to baseTvDb folder root in order to be recognised by the scraper
*/
def organizeFolder(String path) {
   renameFiles(path, false, true)
}




