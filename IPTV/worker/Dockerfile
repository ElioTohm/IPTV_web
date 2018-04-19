FROM ubuntu:16.04

################################################################################
#                   INSTALL FFMPEG DEPENDENCIES AND BUILD                      #
################################################################################
RUN apt-get update --fix-missing
RUN apt-get -y install \
    autoconf \
    automake \
    build-essential \
    cmake \
    git \
    libass-dev \
    libfreetype6-dev \
    libsdl2-dev \
    libtheora-dev \
    libtool \
    libva-dev \
    libvdpau-dev \
    libvorbis-dev \
    libxcb1-dev \
    libxcb-shm0-dev \
    libxcb-xfixes0-dev \
    mercurial \
    pkg-config \
    texinfo \
    wget \
    zlib1g-dev \
    yasm \
    libx264-dev \
    libvpx-dev \
    libfdk-aac-dev \
    libmp3lame-dev \
    libopus-dev 
RUN mkdir -p ~/ffmpeg_sources ~/bin
RUN cd ~/ffmpeg_sources && \
    wget -O ffmpeg-snapshot.tar.bz2 http://ffmpeg.org/releases/ffmpeg-snapshot.tar.bz2 && \
    tar xjvf ffmpeg-snapshot.tar.bz2 && \
    cd ffmpeg && \
    PATH="$HOME/bin:$PATH" PKG_CONFIG_PATH="$HOME/ffmpeg_build/lib/pkgconfig" ./configure \
    --prefix="$HOME/ffmpeg_build" \
    --pkg-config-flags="--static" \
    --extra-cflags="-I$HOME/ffmpeg_build/include" \
    --extra-ldflags="-L$HOME/ffmpeg_build/lib" \
    --extra-libs="-lpthread -lm" \
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
    --enable-nonfree && \
    PATH="$HOME/bin:$PATH" make && \
    make install
RUN hash -r

################################################################################
#                   INSTALL php7.2                                             #
################################################################################
ARG DEBIAN_FRONTEND=noninteractive
RUN apt-get install -y software-properties-common python-software-properties && \ 
    LC_ALL=C.UTF-8 add-apt-repository -y -u ppa:ondrej/php && apt-get update
RUN apt-get -y install php-pear \
    php7.2-curl \ 
    php7.2-dev \
    php7.2-gd \
    php7.2-mbstring \ 
    php7.2-zip \ 
    php7.2-mysql \ 
    php7.2-xml 

WORKDIR /home/worker