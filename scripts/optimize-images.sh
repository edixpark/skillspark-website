#!/usr/bin/env bash
set -euo pipefail

# Creates derivatives in a separate directory. Originals are never overwritten.
SOURCE_DIR="${1:-public/assets/images/originals}"
OUTPUT_DIR="${2:-public/assets/images/optimized}"

if [[ ! -d "$SOURCE_DIR" ]]; then
  printf 'Source directory not found: %s\n' "$SOURCE_DIR" >&2
  exit 1
fi

mkdir -p "$OUTPUT_DIR"

if command -v magick >/dev/null 2>&1; then
  while IFS= read -r -d '' file; do
    name="$(basename "${file%.*}")"
    magick "$file" -auto-orient -strip -resize '1800x1800>' -quality 82 "$OUTPUT_DIR/$name.webp"
    magick "$file" -auto-orient -strip -resize '1800x1800>' -quality 55 "$OUTPUT_DIR/$name.avif" || true
  done < <(find "$SOURCE_DIR" -type f \( -iname '*.jpg' -o -iname '*.jpeg' -o -iname '*.png' \) -print0)
elif command -v cwebp >/dev/null 2>&1; then
  while IFS= read -r -d '' file; do
    name="$(basename "${file%.*}")"
    cwebp -quiet -q 82 "$file" -o "$OUTPUT_DIR/$name.webp"
  done < <(find "$SOURCE_DIR" -type f \( -iname '*.jpg' -o -iname '*.jpeg' -o -iname '*.png' \) -print0)
else
  printf 'Install ImageMagick or cwebp. No originals were changed.\n' >&2
  exit 2
fi

printf 'Optimized derivatives written to %s. Originals remain unchanged.\n' "$OUTPUT_DIR"
