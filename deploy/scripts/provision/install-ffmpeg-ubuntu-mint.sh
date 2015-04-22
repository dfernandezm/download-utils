#!/bin/bash

set -e

#sudo apt-get update
# apt-get -y --force-yes install autoconf automake build-essential libass-dev libfreetype6-dev libgpac-dev \
#   libtheora-dev libtool libva-dev libvdpau-dev libvorbis-dev \
#   pkg-config texi2html zlib1g-dev

# sudo apt-get install libsdl1.2-dev libva-dev libvdpau-dev libxcb1-dev libxcb-shm0-dev libxcb-xfixes0-dev

# mkdir -p ~/ffmpeg_sources
# mkdir -p ~/ffmpeg_build
# mkdir -p ~/bin
#
# # Yasm: version >= 1.3.0 or compile
# echo "Installing YASM..."
# cd ~/ffmpeg_sources
# wget http://www.tortall.net/projects/yasm/releases/yasm-1.3.0.tar.gz
# tar xzvf yasm-1.3.0.tar.gz
# cd yasm-1.3.0
# ./configure --prefix="$HOME/ffmpeg_build" --bindir="$HOME/bin"
# make
# make install
# make distclean
#
# echo "Installing libx264 (>=0.118)"
# apt-get install libx264-dev

# echo "Installing libx265..."
# apt-get install cmake mercurial
# cd ~/ffmpeg_sources
# hg clone https://bitbucket.org/multicoreware/x265
# cd ~/ffmpeg_sources/x265/build/linux
# PATH="$HOME/bin:$PATH" cmake -G "Unix Makefiles" -DCMAKE_INSTALL_PREFIX="$HOME/ffmpeg_build" -DENABLE_SHARED:bool=off ../../source
# make
# make install
# make distclean

# echo "Installing AAC"
# apt-get install unzip
# cd ~/ffmpeg_sources
# wget -O fdk-aac.zip https://github.com/mstorsjo/fdk-aac/zipball/master
# unzip fdk-aac.zip
# cd mstorsjo-fdk-aac*
# autoreconf -fiv
# ./configure --prefix="$HOME/ffmpeg_build" --disable-shared
# make
# make install
# make distclean
#
# echo "Installing mp3lame, >=3.98"
# apt-get install libmp3lame-dev
#
# echo "libopus >= 1.1"
# cd ~/ffmpeg_sources
# wget http://downloads.xiph.org/releases/opus/opus-1.1.tar.gz
# tar xzvf opus-1.1.tar.gz
# cd opus-1.1
# ./configure --prefix="$HOME/ffmpeg_build" --disable-shared
# make
# make install
# make distclean
#
# echo "libvpx"
# cd ~/ffmpeg_sources
# wget http://webm.googlecode.com/files/libvpx-v1.3.0.tar.bz2
# tar xjvf libvpx-v1.3.0.tar.bz2
# cd libvpx-v1.3.0
# PATH="$HOME/bin:$PATH" ./configure --prefix="$HOME/ffmpeg_build" --disable-examples --disable-unit-tests
# PATH="$HOME/bin:$PATH" make
# make install
# make clean

cd ~/ffmpeg_sources
#wget http://ffmpeg.org/releases/ffmpeg-snapshot.tar.bz2
#tar xjvf ffmpeg-snapshot.tar.bz2
cd ffmpeg
PATH="$HOME/bin:$PATH" PKG_CONFIG_PATH="$HOME/ffmpeg_build/lib/pkgconfig" ./configure \
  --prefix="$HOME/ffmpeg_build" \
  --pkg-config-flags="--static" \
  --extra-cflags="-I$HOME/ffmpeg_build/include" \
  --extra-ldflags="-L$HOME/ffmpeg_build/lib" \
  --bindir="$HOME/bin" \
  --enable-gpl \
  --enable-libass \
  --enable-libfdk-aac \
  --enable-libfreetype \
  --enable-libmp3lame \
  --enable-libopus \
  --enable-libtheora \
  --enable-libvorbis \
  --enable-libvpx \
  --enable-libx264 \
  --enable-libx265 \
  --enable-nonfree \
  --disable-ffplay
PATH="$HOME/bin:$PATH" make
make install
make distclean
hash -r
