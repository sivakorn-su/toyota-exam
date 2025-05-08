# Topic Management System

A web application built with Laravel and Vue.js that allows users to create, edit, delete, and view topics, with support for comments and anonymous posts. This system also logs user activities such as topic creation and deletion.

## Features
- **Create, Read, Edit, and Delete Topics**: Users can create, view, edit, and delete topics.
- **Comment System**: Users can comment on topics and choose to post anonymously.
- **Activity Logging**: All activities (create, delete topics) are logged for auditing purposes.
- **Authentication**: Users must be authenticated to create, edit, or delete topics.
- **User-Specific Operations**: Only the author of a topic can edit or delete it.

## Installation

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js and npm (for front-end build)
- Laravel 9.x

### Steps to set up the project

1. Clone the repository:
    ```bash
    git clone https://github.com/your-username/topic-management-system.git
    cd topic-management-system
    ```

2. Install the backend dependencies:
    ```bash
    composer install
    ```

3. Set up your `.env` file:
    ```bash
    cp .env.example .env
    ```

4. Generate your application key:
    ```bash
    php artisan key:generate
    ```

5. Set up the database:
    - Configure the database connection in the `.env` file.
    - Run the migrations to create the necessary tables:
    ```bash
    php artisan migrate
    ```

6. Install front-end dependencies:
    ```bash
    npm install
    ```

7. Build the front-end assets:
    ```bash
    npm run dev
    ```

8. Start the development server:
    ```bash
    php artisan serve
    ```

9. Access the application at `http://localhost:8000`

### Environment Variables
In your `.env` file, ensure you have the following variables set correctly:

```env
APP_NAME=Topic Management System
APP_ENV=local
APP_KEY=base64:your_app_key_here
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password

# Other settings for mail, logging, etc.
```
## Log File

All activities, such as topic creation and deletion, are logged in the `storage/logs/laravel.log` file.

### How to View Logs

To view the logs:

1. **Using the Command Line:**

   You can view the log file directly using the `cat`, `less`, or `tail` command in the terminal:

    - To view the log content:
      ```bash
      cat storage/logs/laravel.log
      ```

    - To view the log content with paging (allows you to scroll):
      ```bash
      less storage/logs/laravel.log
      ```

    - To view the latest log entries in real-time:
      ```bash
      tail -f storage/logs/laravel.log
      ```

   `tail -f` will continuously display the newest log entries, which is useful for monitoring live actions.

2. **Using Laravel's Log Viewer Package:**

   If you want a more user-friendly way to view logs, you can install a Laravel log viewer package like [LogViewer](https://github.com/ARCANEDEV/LogViewer) or [Laravel Log Viewer](https://github.com/rap2hpoutre/laravel-log-viewer).

   To install LogViewer:

    - Run the following command to install the package via Composer:
      ```bash
      composer require arcane-dev/log-viewer
      ```

    - After installation, you can access the logs through your browser by navigating to the log viewer route. Typically, it would be something like:
      ```bash
      http://localhost/log-viewer
      ```

   This will provide a clean, web-based interface to browse your log entries.

### Log Content Format

Each log entry includes the following details:
- **Timestamp**: The exact date and time of the event.
- **User ID**: The ID of the user who performed the action.
- **Action**: A description of the action performed (e.g., "Created topic", "Deleted topic").
- **Topic ID**: The ID of the topic involved in the action.
- **IP Address**: The IP address of the user performing the action.

Here is an example of a log entry:




