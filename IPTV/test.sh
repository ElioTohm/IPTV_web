#!/bin/bash

# Usage create-vod-hls.sh SOURCE_FILE [OUTPUT_NAME]
[[ ! "${1}" ]] && echo "Usage: create-vod-hls.sh SOURCE_FILE [OUTPUT_NAME]" && exit 1


source="${1}"
target="${2}"

#########################################################################

segment_target_duration=5
segment_list_size=6
parent_dir="./storage/app/public/streams"
#########################################################################

if [[ ! "${target}" ]]; then
  target="${source##*/}" # leave only last component of path
fi

mkdir -p ${parent_dir}"/"${target}

# static parameters that are similar for all renditions
static_params+=" -hls_time $segment_target_duration"
static_params+=" -hls_list_size $segment_list_size"
static_params+=" -hls_flags delete_segments"

# misc params
misc_params=" -re -hide_banner -y -vsync 0 -hwaccel auto"

master_playlist+="#EXTM3U\n"
master_playlist+="#EXT-X-MEDIA:TYPE=AUDIO,GROUP-ID=\"audio\",LANGUAGE=\"ost\",NAME=\"Arabic\",AUTOSELECT=YES,DEFAULT=YES,URI=\"A1.m3u8\"\n"
master_playlist+="#EXT-X-MEDIA:TYPE=AUDIO,GROUP-ID=\"audio\",LANGUAGE=\"eng\",NAME=\"English\",AUTOSELECT=YES,DEFAULT=YES,URI=\"A1.m3u8\"\n"
master_playlist+="#EXT-X-STREAM-INF:BANDWIDTH=263851,RESOLUTION=416x234,AUDIO=\"audio\"\n"
master_playlist+="V.m3u8\n"

cmd+=" -sn -codec copy -map 0:0 ${static_params}"
cmd+=" -hls_segment_filename ${parent_dir}/${target}/V_%03d.ts ${parent_dir}/${target}/V.m3u8"
cmd+=" -sn -codec copy -map 0:1 ${static_params}"
cmd+=" -hls_segment_filename ${parent_dir}/${target}/A1%v_%03d.ts ${parent_dir}/${target}/A1.m3u8"
cmd+=" -codec copy -map 0:2 ${static_params}"
cmd+=" -hls_segment_filename ${parent_dir}/${target}/S%v_%03d.ts ${parent_dir}/${target}/S.m3u8"

#create master playlist file
echo -e "${master_playlist}" > ${parent_dir}/${target}/master.m3u8

# start conversion
echo -e "Executing command:\nffmpeg ${misc_params} -i ${source} ${cmd}"
ffmpeg ${misc_params} -i ${source} ${cmd}

# tests
# ffmpeg  -re -hide_banner \
# -i "udp://@224.1.10.74:1234?fifo_size=500000" \
# -c copy -map 0 -f hls \
# -var_stream_map "a:0,agroup:aud_low a:1,agroup:aud_low v:0,agroup:aud_low"  \
# -hls_time 10 -hls_list_size 3 -hls_flags delete_segments \
# -master_pl_name master.m3u8 ${parent_dir}/${target}/test3_%v.m3u8
