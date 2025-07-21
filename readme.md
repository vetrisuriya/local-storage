
---

# Local Storage PHP Application

This project provides a simple local storage system for PHP applications, allowing you to store and retrieve data (such as users and posts) using plain text files. It is designed for lightweight use cases where a full database is unnecessary.

## Features

- Store and retrieve objects (e.g., users, posts) in local text files
- Object-oriented design with helper classes and traits
- Easy integration with existing PHP projects
- Simple autoloading for class management

## Project Structure

```
local-storage/
  ├── class/
  │   ├── localHelpers.php
  │   ├── localObject.php
  │   ├── localStorage.php
  │   ├── traits/
  │   ├── useLocalObject.php
  │   └── viewFilter.php
  ├── inc/
  │   └── autoload.php
  ├── index.php
  ├── storage/
  │   ├── posts.txt
  │   └── users.txt
  └── readme.txt
```

- **class/**: Contains core classes and traits for storage and object management.
- **inc/autoload.php**: Handles class autoloading.
- **storage/**: Stores data files (e.g., `users.txt`, `posts.txt`).
- **index.php**: Example entry point or usage demo.

## Getting Started

1. **Clone or Download the Repository**

   ```
   git clone https://github.com/vetrisuriya/local-storage.git
   ```

2. **Set Up File Permissions**

   Ensure the `storage/` directory is writable by your web server.

3. **Include the Autoloader**

   In your PHP scripts, include the autoloader:

   ```php
   require_once __DIR__ . '/inc/autoload.php';
   ```

4. **Usage Example**

   ```php
   // Example: Storing a new user
   $storage = new localStorage('users');
   $user = new localObject(['username' => 'john', 'email' => 'john@example.com']);
   $storage->save($user);

   // Example: Retrieving all users
   $users = $storage->getAll();
   foreach ($users as $user) {
       echo $user->username;
   }
   ```

## Customization

- Add new data types by creating new text files in the `storage/` directory.
- Extend or modify classes in the `class/` directory to fit your needs.

## License

This project is open-source and available under the MIT License.

---

Let me know if you want to include more specific usage examples or details!
