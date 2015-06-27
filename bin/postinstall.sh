#!/usr/bin/env bash

git config core.autocrlf input
./node_modules/.bin/grunt githooks
./node_modules/.bin/npm-check-updates
