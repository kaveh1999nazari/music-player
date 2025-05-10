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

Search results include all relevant entities matching the query. Example endpoint:
