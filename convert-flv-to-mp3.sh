#!/bin/sh

for i in *.flv;
  do name=`echo $i | cut -d'.' -f1`;
  echo $name;
  ffmpeg -i $i $name.mp3;
done
