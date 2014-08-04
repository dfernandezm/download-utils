#!/usr/bin/python

# List of url feeds to be parsed. This entry is just an _example_. Please
# do not download illegal torrents or torrents that you do not have permisson
# to own.

FEEDS = [
       "http://showrss.info/feeds/885.rss"
       # "http://showrss.info/feeds/584.rss"
]

TIMESTAMP = "/home/pi/rsstorrent.stamp"
AUTH_TOKEN = "transmission:ZVCvrasp"

import feedparser
import pickle
import os
import urllib2
from datetime import datetime
import subprocess
from subprocess import check_output
import shlex
import logging

logging.basicConfig(filename='/opt/download-utils/logs/feed-checker.log',format='%(asctime)s %(message)s',level=logging.DEBUG)

def execute_command(command):
    p = subprocess.Popen(shlex.split(command), stdout=subprocess.PIPE)
    (output, err) = p.communicate()
    logging.debug("Output for the command is %s", output)


def download(torrent_name, magnet_link):
   logging.info('Downloading file %s', torrent_name)
   logging.debug("The magnet link is %s", magnet_link)  
   execute_command("transmission-remote --auth {authToken} --add \"{magnet_link}\"".format(magnet_link=magnet_link,authToken=AUTH_TOKEN))

def print_items(items):
    items_str = ""
    for it in items:
        items_str += str(it[1]["title"]) + str(" // ")
    logging.debug("Items is %s",items_str)


# Given a read feed (current_item) checks whether to add it to the download list (items)
# based on the quality indicated by its title, keeping the best quality or defaulting to 
# regular quality
def check_quality_to_add(current_item, items):
    title = current_item["title"]
    title_no_quality = title.replace("720p","").strip()

    # Check if this title is already added to download (first match in the list)
    item = next((x for x in items if title_no_quality in x[1]["title"]), None)
    
    if item == None:
        logging.debug("Item was not previously added %s", title)
        items.append((current_item["published_parsed"], current_item))
    else:
        logging.debug("Item was previously added %s", title)
        logging.debug("Checking if new has better quality...")

        if "720p" in item[1]["title"]:
            logging.debug("Item already has best quality")
        elif "720p" in title:
            logging.debug("New item has 720p, replacing with new")
            items.remove(item)
            items.append((current_item["published_parsed"], current_item))
        else:
            logging.debug("No HD quality found for item. Keeping regular quality")


def parse_feeds():
    global FEEDS
    items = []
    feed_bad = False

    # Build up a list of torrents to check
    for feed_url in FEEDS: 
        feed = feedparser.parse(feed_url)

        # Valid feed?
        if feed["bozo"] != 1:
            for item in feed["items"]:
                check_quality_to_add(item, items)
        else:
            logging.warning("bad feed: %s",feed_url)     
            feed_bad = True
    
    if not feed_bad:
        items.sort()    
        return items


def check_timestamp():
    global TIMESTAMP
    timestamp_file = " "

    # Just default to now in case there is no stamp file
    # last_check_date = datetime.today()
    last_check_date = datetime(2014,6,6,1,0,0)
    logging.info("Default last_check_date is %s", last_check_date)

    # Check to read the stamp file to see when we last checked for new torrents
    try:
        timestamp_file = open(TIMESTAMP, 'r')
    except IOError:
        logging.warning("Cannot open stamp file %s -- touching it instead",TIMESTAMP)
        execute_command("touch {file}".format(file = TIMESTAMP))

    if timestamp_file != " ":
        try:
            last_check_date = pickle.load(timestamp_file)
            logging.info("Last check date read from file is %s",last_check_date)
        except EOFError:
            logging.warning("Stamp file %s is empty",TIMESTAMP)

    return last_check_date


def process_feeds(items, last_check_date):
    downloading_torrent = False 
    
    for item in items:
        # The 0 element of each item (tuple) is the parsed timestamp
        id = item[0]
        item_date = datetime(id[0], id[1], id[2], id[3], id[4])

        logging.info("Item %s has date %s", item[1]["title"], item_date)
        logging.info("Last check date %s", last_check_date)

        if item_date > last_check_date:
            magnet_link = item[1]["link"].encode('unicode_escape')
            torrent_name = item[1]["title"]
            logging.info("Item detected to download: %s",torrent_name)
            magnet_link = item[1]["link"].encode('unicode_escape')
            download(torrent_name, magnet_link)
            downloading_torrent = True

    return downloading_torrent    


def save_timestamp(downloading_torrent):
    if downloading_torrent == False:
        logging.info("No new torrents to download")
    else:
        try:
            logging.info("Saving timestamp file %s",TIMESTAMP)
            timestamp_file = open(TIMESTAMP, 'w')
            # year, month, day, minute, second 
            # date_dump = datetime(2014,7,21,2,0,0)
            date_dump = datetime.today()
            pickle.dump(date_dump, timestamp_file)
        except IOError:
            logging.warning("Cannot stamp file %s",TIMESTAMP) 

items = parse_feeds()
last_check_date = check_timestamp()
downloading_torrent = process_feeds(items, last_check_date)
save_timestamp(downloading_torrent)

