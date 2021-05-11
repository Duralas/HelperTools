#!/usr/bin/env bash

set -eu

if [ $(which docker || false) ]; then
    source bin/common.inc.bash

    dockerPhpExec bin/console.bash "$@"
else
    php bin/console "$@"
fi
