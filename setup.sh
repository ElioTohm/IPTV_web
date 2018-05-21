add-apt-repository ppa:ondrej/php

add-apt-repository ppa:nginx/stable

apt install build-essential yasm cmake libtool libc6 libc6-dev unzip wget libnuma-dev libfdk-aac-dev libmp3lame-dev libopus-dev autoconf automake build-essential libass-dev libfreetype6-dev libsdl2-dev libtheora-dev libva-dev libvdpau-dev libvorbis-dev libxcb1-dev libxcb-shm0-dev libxcb-xfixes0-dev mercurial pkg-config texinfo zlib1g-dev libx264-dev libvpx-dev software-properties-common php7.2-cli php7.2-gd zip unzip composer php7.2 php7.2-curl php7.2-gd php7.2-imap php7.2-json php7.2-mysql php7.2-opcache php7.2-xmlrpc php7.2-xml php7.2-fpm php7.2-mbstring php7.2-sqlite3 php7.2-zip nginx

curl -sL https://deb.nodesource.com/setup_9.x | sudo -E bash -
apt-get install -y nodejs

apt-get install -y mysql-server