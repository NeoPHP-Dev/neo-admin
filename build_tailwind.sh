#!/usr/bin/env bash
#
# build_tailwind.sh — build or watch Tailwind CSS for every NeoPHP project.
#
# Usage:
#   ./bin/build_tailwind.sh --entry=css/input.css --output=tailwind/output.css [--watch|--compile]
#
# --entry   Path relative to  src/<Project>/Assets/
# --output  Path relative to  public/builds/<Project>/
# --project Restrict to a single project (name under src/). Without it, every
#           project that has the entry file is built/watched.
# --watch   Watch mode (all matching projects run in parallel, Ctrl+C to stop)
# --compile Single build with --minify (default if neither flag is given)
#
# Downloads the standalone Tailwind CSS CLI automatically if not present.

set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
ROOT_DIR="$(cd "$SCRIPT_DIR/.." && pwd)"

ENTRY=""
OUTPUT=""
PROJECT=""
MODE="compile"

usage() {
    echo "Usage: $0 --entry=<path relative to src/*/Assets/> --output=<path relative to public/builds/*/> [--project=<Name>] [--watch|--compile]" >&2
    exit 1
}

for arg in "$@"; do
    case "$arg" in
        --entry=*)
            ENTRY="${arg#*=}"
            ;;
        --output=*)
            OUTPUT="${arg#*=}"
            ;;
        --project=*)
            PROJECT="${arg#*=}"
            ;;
        --watch)
            MODE="watch"
            ;;
        --compile)
            MODE="compile"
            ;;
        --help|-h)
            usage
            ;;
        *)
            echo "✘ Unknown argument: $arg" >&2
            usage
            ;;
    esac
done

if [[ -z "$ENTRY" || -z "$OUTPUT" ]]; then
    echo "✘ Both --entry and --output are required." >&2
    usage
fi

if [[ -n "$PROJECT" && ! -d "$ROOT_DIR/src/$PROJECT" ]]; then
    echo "✘ Project '$PROJECT' not found in src/." >&2
    exit 1
fi

# ---------------------------------------------------------------------------
# 1. Ensure the Tailwind CLI binary is present, download it otherwise.
# ---------------------------------------------------------------------------

detect_platform() {
    local os arch
    os="$(uname -s)"
    arch="$(uname -m)"

    case "$os" in
        Linux*)
            case "$arch" in
                x86_64) echo "linux-x64" ;;
                aarch64|arm64) echo "linux-arm64" ;;
                *) echo "unsupported" ;;
            esac
            ;;
        Darwin*)
            case "$arch" in
                x86_64) echo "macos-x64" ;;
                arm64) echo "macos-arm64" ;;
                *) echo "unsupported" ;;
            esac
            ;;
        MINGW*|MSYS*|CYGWIN*)
            case "$arch" in
                x86_64) echo "windows-x64" ;;
                *) echo "unsupported" ;;
            esac
            ;;
        *)
            echo "unsupported"
            ;;
    esac
}

PLATFORM="$(detect_platform)"

if [[ "$PLATFORM" == "unsupported" ]]; then
    echo "✘ Unsupported OS/architecture: $(uname -s) $(uname -m)" >&2
    exit 1
fi

if [[ "$PLATFORM" == windows-* ]]; then
    TAILWIND_BIN="$ROOT_DIR/tailwind.exe"
    ASSET_NAME="tailwindcss-${PLATFORM}.exe"
else
    TAILWIND_BIN="$ROOT_DIR/tailwind"
    ASSET_NAME="tailwindcss-${PLATFORM}"
fi

if [[ ! -f "$TAILWIND_BIN" ]]; then
    echo "→ Tailwind CLI not found, downloading ($PLATFORM)…"
    DOWNLOAD_URL="https://github.com/tailwindlabs/tailwindcss/releases/latest/download/${ASSET_NAME}"

    if command -v curl >/dev/null 2>&1; then
        curl -fsSL "$DOWNLOAD_URL" -o "$TAILWIND_BIN"
    elif command -v wget >/dev/null 2>&1; then
        wget -q "$DOWNLOAD_URL" -O "$TAILWIND_BIN"
    else
        echo "✘ Neither curl nor wget is available. Cannot download the Tailwind CLI." >&2
        exit 1
    fi

    chmod +x "$TAILWIND_BIN"
    echo "✔ Tailwind CLI downloaded to $(basename "$TAILWIND_BIN")"
fi

# ---------------------------------------------------------------------------
# 2. Build (or watch) the target project(s).
#    --project=X restricts to a single one; otherwise every project under
#    src/ that has the requested entry file is processed.
# ---------------------------------------------------------------------------

if [[ -n "$PROJECT" ]]; then
    PROJECT_DIRS=("$ROOT_DIR/src/$PROJECT")
else
    PROJECT_DIRS=("$ROOT_DIR"/src/*/)
fi

PIDS=()
FOUND=0

for project_dir in "${PROJECT_DIRS[@]}"; do
    project_dir="${project_dir%/}"
    project_name="$(basename "$project_dir")"
    entry_path="$project_dir/Assets/$ENTRY"

    if [[ ! -f "$entry_path" ]]; then
        if [[ -n "$PROJECT" ]]; then
            echo "✘ Entry file not found: src/$project_name/Assets/$ENTRY" >&2
            exit 1
        fi
        continue
    fi

    FOUND=1

    output_path="$ROOT_DIR/public/builds/$project_name/$OUTPUT"
    mkdir -p "$(dirname "$output_path")"

    echo "→ [$project_name] Assets/$ENTRY → public/builds/$project_name/$OUTPUT"

    if [[ "$MODE" == "watch" ]]; then
        "$TAILWIND_BIN" -i "$entry_path" -o "$output_path" --watch &
        PIDS+=("$!")
    else
        "$TAILWIND_BIN" -i "$entry_path" -o "$output_path" --minify
        echo "✔ [$project_name] build done"
    fi
done

if [[ "$FOUND" -eq 0 ]]; then
    echo "✘ No project found with Assets/$ENTRY" >&2
    exit 1
fi

if [[ "$MODE" == "watch" ]]; then
    echo ""
    echo "Watching $((${#PIDS[@]})) project(s) — press Ctrl+C to stop."
    trap 'kill "${PIDS[@]}" 2>/dev/null' INT TERM
    wait
fi