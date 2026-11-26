#!/usr/bin/env bash
# Downloads the third-party PHP libraries that the backend expects at fixed paths.
# They are not stored in this repository (see .gitignore).
set -euo pipefail
cd "$(dirname "$0")/../backend"

PHPMAILER_VERSION="v6.9.3"
TMP="$(mktemp -d)"

echo "Downloading PHPMailer ${PHPMAILER_VERSION}..."
git clone --quiet --depth 1 --branch "$PHPMAILER_VERSION" https://github.com/PHPMailer/PHPMailer.git "$TMP/PHPMailer"

for dir in api admin; do
  mkdir -p "$dir/PHPMailer"
  cp -R "$TMP/PHPMailer/src" "$dir/PHPMailer/"
  cp "$TMP/PHPMailer/LICENSE" "$dir/PHPMailer/"
  # Some scripts include the class files directly from the same folder
  cp "$TMP/PHPMailer/src/PHPMailer.php" "$TMP/PHPMailer/src/SMTP.php" "$TMP/PHPMailer/src/Exception.php" "$dir/"
done

echo "Downloading PHP QR Code..."
git clone --quiet --depth 1 https://github.com/t0k4rt/phpqrcode.git "$TMP/phpqrcode"
mkdir -p admin/phpqrcode
cp -R "$TMP/phpqrcode/." admin/phpqrcode/

echo "Done. Libraries installed under backend/api and backend/admin."
