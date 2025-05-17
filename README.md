# 🎵 Music Player API — Built with Laravel

This is a **Music Player API** built using the [Laravel](https://laravel.com) framework. It provides endpoints to manage songs, artists, albums, custom albums, and playlists. The project is designed to serve as the backend for a music streaming application, supporting rich metadata and relationships between music entities.

---

## 📌 Features

- 🔍 **Advanced Search**  
  Search across songs, artists, albums, and custom albums using a single endpoint.

- 🎶 **Songs Management**  
  Create, update, delete, and list songs along with their metadata such as title, duration, artist, album, etc.

- 🎤 **Artist Support**  
  Each song is associated with an artist, making it easy to categorize and filter.

- 💿 **Albums & Custom Albums**  
  Organize songs into standard albums or user-defined custom albums.

- 📻 **Playlists**  
  Users can create custom playlists and add/remove songs.

- 🌐 **RESTful API**  
  Clean and structured endpoints following REST principles.

---

## 🔍 Search System

The API supports a **multi-model search** functionality, which allows users to search for:

- Song titles
- Artist names
- Album titles
- Custom album titles

Search results include all relevant entities matching the query.

---

## 🚀 How to Run the Project

To run the project locally using Docker, follow these steps:

### 1. Install PHP and Composer

Make sure you have **PHP** and **Composer** installed on your machine.

You can verify this by running:

```bash
php -v
composer -V
```

### 2. Install Dependencies
Once you're sure PHP and Composer are installed, navigate to the project directory and run:

```bash
composer install
```

This will install all PHP dependencies for the project.

### 3. Build and Run Docker Containers

```bash
docker compose up -d --build
```
This will build the image and run the application in the background.


### 🛠️ Environment Variables

Don't forget to set your .env file appropriately. After copying .env.example to .env, you can run:

```bash
php artisan key:generate
```
you will see in .env this :
```bash
FFMPEG_PATH=/usr/bin/ffmpeg
FFPROBE_PATH=/usr/bin/ffprobe
```

after that use this command to make tables:
```bash
php artisan migrate
```


