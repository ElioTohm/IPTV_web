#!/bin/bash

# Usage create-vod-hls.sh SOURCE_FILE [OUTPUT_NAME]
[[ ! "${1}" ]] && echo "Usage: create-vod-hls.sh SOURCE_FILE [OUTPUT_NAME]" && exit 1


source="${1}"
target="${2}"
duration="${3}"
parent_dir="${4}"

#########################################################################

segment_target_duration=10
segment_list_size=$duration
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
misc_params="-re -hide_banner -y -hwaccel auto -stream_loop -1"
cmd+=" -codec copy -map 0:v -map 0:a ${static_params}"
cmd+=" -hls_segment_filename ${parent_dir}/${target}/${target}_%03d.ts ${parent_dir}/${target}/master.m3u8"

# start conversion
echo "ffmpeg ${misc_params} -i ${source} ${cmd}"

/home/user/bin/ffmpeg ${misc_params} -i ${source} ${cmd} </dev/null >/dev/null 2>/var/log/ffmpeg-${target}.log &