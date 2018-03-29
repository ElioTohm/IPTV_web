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

master_playlist+="#EXT-X-MEDIA:TYPE=AUDIO,GROUP-ID=\"bipbop_audio\",LANGUAGE=\"eng\",NAME=\"BipBop Audio 2\",AUTOSELECT=YES,DEFAULT=YES,URI=\"alternate_audio_aac/prog_index.m3u8\""
master_playlist+="#EXT-X-MEDIA:TYPE=SUBTITLES,GROUP-ID=\"subs\",NAME=\"English\",DEFAULT=YES,AUTOSELECT=YES,FORCED=NO,LANGUAGE=\"en\",URI=\"subtitles/eng/prog_index.m3u8\""

cmd+=" -codec copy -map 0 ${static_params}"
cmd+=" -hls_segment_filename ${parent_dir}/${target}/${target}_%03d.ts ${parent_dir}/${target}/master.m3u8"

# start conversion
echo -e "Executing command:\nffmpeg ${misc_params} -i ${source} ${cmd}"
ffmpeg ${misc_params} -i ${source} ${cmd}

# create master playlist file
echo -e "${master_playlist}" > ${target}/playlist.m3u8

#EXT-X-STREAM-INF:BANDWIDTH=263851,CODECS="mp4a.40.2, avc1.4d400d",RESOLUTION=416x234,AUDIO="bipbop_audio",SUBTITLES="subs"
gear1/prog_index.m3u8

# ffmpeg ${misc_params} -i ${source} -codec: copy \
#   -map 0 -f hls \
#   -var_stream_map "a:0,agroup:aud v:0,s:0,agroup:aud" \
#   -hls_time 10 \
#   -hls_list_size 3 \
#   -hls_flags delete_segments \
#   -master_pl_name master.m3u8 \
#   ${parent_dir}/${target}/${target}_%v.m3u8