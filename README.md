# Instagram Caption Generator

Instagram Caption Generator is a single-page Laravel application for creating product captions, hashtags, and short AI suggestions for Instagram storefronts. The interface is built with raw HTML, CSS, and JavaScript, so it runs without npm or a frontend build step.

## Features

- AI-powered caption, hashtag, and suggestion generation
- Single-page workflow with all actions on the home page
- Multilingual UI support for English, Persian, and Arabic
- Language switching reflected in the URL via the `lang` query parameter
- File-based history stored locally in `storage/app`
- Modern glassmorphism-inspired interface with RTL support
- No database required

## Prerequisites

- PHP 8.3 or newer
- Composer
- A compatible AI chat completion endpoint

## Installation

1. Install PHP dependencies:
   ```bash
   composer install
   ```

2. Create your environment file if needed:
   ```bash
   cp .env.example .env
   ```

3. Generate the application key:
   ```bash
   php artisan key:generate
   ```

4. Configure AI settings in `.env`:
   ```dotenv
   AI_BASE_URL="https://ai.zarwan.co/v1/chat/completions"
   AI_TOKEN="your_token_here"
   AI_MODEL="cf/@cf/openai/gpt-oss-120b"
   ```

5. Start the application:
   ```bash
   php artisan serve
   ```

   The app will be available at `http://127.0.0.1:8000`.

## Usage

1. Open the app in your browser.
2. Choose a product type.
3. Choose the caption language.
4. Enter a product description.
5. Click generate to receive the caption, hashtags, and AI suggestion.
6. Copy the full result or any individual part directly from the page.

## Storage

- History is stored in a local JSON file at `storage/app/history/instagram-caption-generator.json`.
- No database migrations or seeders are required.

## License

This project is provided as-is for internal or personal use.
