#!/usr/bin/env bash

set -eu

function dockerPhpExec() {
    docker exec --interactive --tty duralas_helper_tools_php "$@"
}
