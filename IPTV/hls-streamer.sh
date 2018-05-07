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

# exec
ffmpeg ${misc_params} -i ${source} -c: copy -hls_time 10 -hls_list_size 3 \
-hls_flags delete_segments -hls_segment_filename ${parent_dir}/${target}/'file%03d.ts' \
 ${parent_dir}/${target}/playlist.m3u8