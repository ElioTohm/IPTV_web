#!/bin/bash

# Usage create-vod-hls.sh SOURCE_FILE [OUTPUT_NAME]
[[ ! "${1}" ]] && echo "Usage: create-vod-hls.sh SOURCE_FILE [OUTPUT_NAME]" && exit 1


source="${1}"
target="${2}"

#########################################################################

segment_target_duration=10
segment_list_size=3
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
misc_params=" -re -hide_banner"

master_playlist+="#EXTM3U\n"
master_playlist+="#EXT-X-MEDIA:TYPE=AUDIO,GROUP-ID=\"audio\",LANGUAGE=\"ost\",NAME=\"Arabic\",AUTOSELECT=YES,DEFAULT=YES,URI=\"A1.m3u8\"\n"
master_playlist+="#EXT-X-MEDIA:TYPE=AUDIO,GROUP-ID=\"audio\",LANGUAGE=\"eng\",NAME=\"English\",AUTOSELECT=YES,DEFAULT=YES,URI=\"A2.m3u8\"\n"
master_playlist+="#EXT-X-STREAM-INF:BANDWIDTH=263851,RESOLUTION=416x234,AUDIO=\"audio\"\n"
master_playlist+="V.m3u8\n"

cmd+=" -codec copy -map 0:0 ${static_params}"
cmd+=" -hls_segment_filename ${parent_dir}/${target}/V_%03d.ts ${parent_dir}/${target}/V.m3u8"
cmd+=" -codec copy -map 0:1 ${static_params}"
cmd+=" -hls_segment_filename ${parent_dir}/${target}/A1%v_%03d.ts ${parent_dir}/${target}/A1.m3u8"
cmd+=" -codec copy -map 0:2 ${static_params}"
cmd+=" -hls_segment_filename ${parent_dir}/${target}/A2%v_%03d.ts ${parent_dir}/${target}/A2.m3u8"

#create master playlist file
echo -e "${master_playlist}" > ${parent_dir}/${target}/master.m3u8

# start conversion
echo -e "Executing command:\nffmpeg ${misc_params} -i ${source} ${cmd}"
ffmpeg ${misc_params} -i ${source} ${cmd}
