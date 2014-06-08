#!/usr/bin/python

# List of url feeds to be parsed. This entry is just an _example_. Please
# do not download illegal torrents or torrents that you do not have permisson
# to own.
FEEDS = [
       "http://showrss.info/feeds/818.rss",

]
 # "http://showrss.info/feeds/505.rss",	
 # "http://showrss.info/feeds/27.rss"
TIMESTAMP    = "/home/pi/rsstorrent.stamp"
FORCED       = True

import feedparser
import pickle
import os
import urllib2
from datetime import datetime
import subprocess
from subprocess import check_output
import shlex

# items = []
# feed_bad = False
# current_file = " "

def execute_command(command):
    p = subprocess.Popen(shlex.split(command), stdout=subprocess.PIPE)
    (output, err) = p.communicate()
    print "Output is %s " % output  


def download(torrent_name, magnet_link):
   print "Downloading file  %s " % torrent_name
   print "Magnet link \n " + "\"" + magnet_link +"\""  
   execute_command("transmission-remote --add \"{magnet_link}\"".format(magnet_link=magnet_link))


def parse_feeds():
    global FEEDS
    items = []
    feed_bad = False

    # Build up a list of torrents to check
    for feed_url in FEEDS: 
        feed = feedparser.parse(feed_url)
        # print "feed %s " % str(feed) 
        # Valid feed ?
        if feed["bozo"] != 1 or True:
            for item in feed["items"]:
                title =  item["title"]
                print "Item read " + item["title"]
                if "720p" in title:    
                    items.append((item["published_parsed"], item))
        else:
            print "bad feed: " + feed_url     
            feed_bad = True
    
    if not feed_bad:
        # Sort by date
        items.sort();    
        return items


def check_timestamp():
    global TIMESTAMP
    timestamp_file = " "

    # Just default to now in case there is no stamp file
    # last_check_date = datetime.today()
    last_check_date = datetime(2014,6,6,1,0,0)
    print "Last check date %s" % last_check_date

    # Check to read the stamp file to see when we last checked for new torrents
    try:
        timestamp_file = open(TIMESTAMP, 'r')
    except IOError:
        print "Cannot open stamp file %s -- touching" % TIMESTAMP
        execute_command("touch {file}".format(file = TIMESTAMP))

    if timestamp_file != " ":
        try:
            last_check_date = pickle.load(timestamp_file)
            print "Last check date %s from file" % last_check_date
        except EOFError:
            print "Stamp file %s is empty" % TIMESTAMP

    return last_check_date


def process_feeds(items, last_check_date):
    downloading_torrent = False 
    
    for item in items:
        # The 0 element of each item is the parsed timestamp
        id = item[0]
        item_date = datetime(id[0], id[1], id[2], id[3], id[4])
        print "Item date %s " % str(item_date)

        if item_date > last_check_date:
            magnet_link = item[1]["link"].encode('unicode_escape')
            torrent_name = item[1]["title"]
            print "downloading: %s" % torrent_name
            magnet_link = item[1]["link"].encode('unicode_escape')
            torrent_name = item[1]["title"]
            download(torrent_name, magnet_link)
            downloading_torrent = True

    return downloading_torrent    


def save_timestamp(downloading_torrent):
    if downloading_torrent == False:
        print "No new torrents to download"
    else:
        try:
            timestamp_file = open(TIMESTAMP, 'w')
            pickle.dump(datetime.today(), timestamp_file)
        except IOError:
            print "Cannot stamp file %s" % TIMESTAMP 


items = parse_feeds()
last_check_date = check_timestamp()
downloading_torrent = process_feeds(items, last_check_date)
save_timestamp(downloading_torrent)













# if not feed_bad and len(items) > 0:
#    # stamp the timestamp file
#     try:
#         timestamp_file = open(TIMESTAMP, 'w')
#         last_item = items[len(items)-1][0]
#         last_item_date = datetime(last_item[0], last_item[1], last_item[2], last_item[3], last_item[4])

#         pickle.dump(last_item_date, timestamp_file)

#     except IOError:
#         if VERBOSE:
#             print "Cannot stamp file %s" % TIMESTAMP

