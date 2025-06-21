#!/bin/bash

echo "🛠️  Setting up environment..."

REPO="DKA-Docker/LARAVELPINE-Template"
BRANCH="dev"
RAW_URL="https://raw.githubusercontent.com/$REPO/$BRANCH"
API_URL="https://api.github.com/repos/$REPO/contents/scripts?ref=$BRANCH"

COMPOSE_FILE="compose.yml"
ENV_FILE=".env"

# Download compose.yml
curl -sSL "$RAW_URL/compose.yml" -o "$COMPOSE_FILE"

# Buat folder scripts
mkdir -p scripts

# Ambil semua file dari folder scripts/
echo "📦 Fetching and downloading scripts/ files..."
curl -s "$API_URL" | grep '"name"' | cut -d '"' -f4 | while read -r file; do
    echo "⬇️  Downloading $file"
    curl -sSL "$RAW_URL/scripts/$file" -o "scripts/$file"
done

# Jalankan Docker
echo "🐳 Running Docker Compose..."
docker compose up -d

# Inject .env ke compose.yml
if [ -f "$ENV_FILE" ]; then
    echo "🔧 Injecting .env into $COMPOSE_FILE..."

    # Convert .env ke YAML tanpa quotes
    ENV_YAML=""
    while IFS='=' read -r key value; do
        [[ -z "$key" || "$key" =~ ^# ]] && continue
        key=$(echo "$key" | xargs)
        value=$(echo "$value" | xargs)
        ENV_YAML+="      $key: $value\n"
    done < "$ENV_FILE"

    # Backup
    cp "$COMPOSE_FILE" "$COMPOSE_FILE.bak"

    # Proses overwrite
    awk -v env_block="$ENV_YAML" '
    BEGIN {
      in_service = 0
      target_service = 0
      inside_env = 0
    }

    # Masuk blok service
    /^[[:space:]]+[a-zA-Z0-9_-]+:/ {
      in_service = 1
      target_service = 0
      inside_env = 0
    }

    # Deteksi service target
    /image:[[:space:]]+yovanggaanandhika\/laravelpine:.*/ {
      if (in_service) {
        target_service = 1
      }
    }

    # Timpa environment lama
    /^[[:space:]]+environment:/ {
      if (target_service) {
        print "    environment:"
        split(env_block, lines, "\n")
        for (i in lines) {
          if (length(lines[i])) {
            print lines[i]
          }
        }
        inside_env = 1
        next
      }
    }

    # Lewati isi environment lama
    /^[[:space:]]+[A-Z0-9_]+:[[:space:]]+.*$/ {
      if (inside_env) next
    }

    # Keluar dari blok environment
    /^[[:space:]]+[^[:space:]]+:.*$/ {
      inside_env = 0
    }

    {
      print
    }
    ' "$COMPOSE_FILE.bak" > "$COMPOSE_FILE"

    echo "✅ Environment block injected!"
else
    echo "⚠️  No .env file found. Skipping environment injection."
fi
