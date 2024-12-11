# Spotify Clone

A Spotify-like web app built with HTML, CSS, JavaScript, and PHP. This project replicates core functionality such as music playback, playlist navigation, and user authentication, delivering a responsive and interactive user experience.

## Screenshots

### Main Page
![Screenshot 2024-12-11 142752](https://github.com/user-attachments/assets/5e61cb31-8551-4ecf-8e89-bda9ba474a86)


### Login Page
![Screenshot 2024-12-11 142731](https://github.com/user-attachments/assets/19b3489b-d51f-4de2-9564-fd15d51d4dea)


### Signup Page
![Screenshot 2024-12-11 142820](https://github.com/user-attachments/assets/2c461f05-622e-4347-ac1f-a254a5b7fdb2)


## Features

- **Music Playback**: Play and pause audio tracks with a seamless interface.
- **Volume Control**: Adjust the playback volume via an intuitive slider.
- **Track Navigation**: Navigate through playlists using previous and next buttons.
- **Seek Functionality**: Use a progress slider to jump to specific points in a track.
- **Dynamic Track Info**: Display track titles and metadata dynamically.
- **Authentication**: User login and signup functionality with PHP integration.
- **Popup Interface**: A responsive popup player for music controls.

## Technologies Used

- **HTML**: For structuring the webpage.
- **CSS**: For styling the music player interface.
- **JavaScript**: For implementing music playback, volume control, track navigation, and UI interactivity.
- **PHP**: PHP for user authentication and dynamic features.
- **Additional Tools**: 
  - CSS animations for enhanced visuals.
  - JavaScript event listeners for seamless interactivity.

## Project Structure

- **index.html**: Main page of the music player.
- **style.css**: Stylesheet for the main page and popup interface.
- **script.js**: Handles audio playback, interactivity, and UI controls.
- **login.html**: Login page structure.
- **login.css**: Stylesheet for the login page.
- **signup.html**: Signup page structure.
- **signup.css**: Stylesheet for the signup page.
- **signup.php**: PHP backend for handling user authentication and server-side logic.
- **login.php**: PHP backend for handling user authentication and server-side logic.

## Installation

### 1. Install XAMPP
XAMPP is a free and open-source cross-platform web server solution package, including Apache and MySQL. It is required to run PHP scripts and set up a local database.

To install XAMPP:

1. Go to the official XAMPP download page: [XAMPP Downloads](https://www.apachefriends.org/download.html).
2. Download the installer suitable for your operating system (Windows, Linux, or macOS).
3. Run the installer and follow the on-screen instructions.

### 2. Start Apache and MySQL

1. Open the XAMPP Control Panel after installation.
2. Click on **Start** next to **Apache** and **MySQL**. This will start the web server (Apache) and the database server (MySQL) locally on your machine.

### 3. Create the Database and Table

1. Open your browser and go to `http://localhost/phpmyadmin`.
2. In phpMyAdmin, click on **Databases** in the top menu.
3. Under the "Create database" section, enter the name `spotifyclone` for the database and click **Create**.
4. After the database is created, click on the `spotifyclone` database in the left sidebar to open it.
5. Click on the **SQL** tab and paste the following SQL query to create the `users` table:

    ```sql
    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE, 
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        date_of_birth DATE NOT NULL,
        gender ENUM('Male','Female','Others') NOT NULL 
    );
    ```

6. Click **Go** to execute the query and create the table.

### 4. Access the App

1. Navigate to the project directory where you cloned the repository.
2. Place the project folder (SpotifyClone) inside the `htdocs` folder of your XAMPP installation. The default path is typically:

    - **Windows**: `C:\xampp\htdocs`
    - **MacOS/Linux**: `/Applications/XAMPP/htdocs`

3. Now, go to your browser and open `http://localhost/SpotifyClone/signup.html` to access the signup page.

## Usage

1. **Authentication**: 
   - Navigate to the login page to access the app or the signup page to create an account.
2. **Music Controls**: 
   - Select a track to play, pause, or skip to the next/previous track.
3. **Volume and Seeking**: 
   - Use sliders for volume control and track seeking.
4. **Track Display**: 
   - View the current track's title dynamically displayed above the player.

## Future Enhancements

- **Dynamic Playlists**: Fetch playlists dynamically from an API or database.
- **Advanced Playback Features**: Include shuffle, repeat, and queue functionalities.
- **User Profiles**: Add personalized user profiles and saved playlists.
- **Improved Responsiveness**: Optimize design for an enhanced mobile experience.
- **Dark Mode**: Add a toggle for light and dark themes.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

Feel free to contribute by submitting issues or pull requests. Enjoy exploring the Spotify Clone project!
