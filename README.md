# CTS – Cyberpunk Transparent Shop

**CTS** is a virtual web shop built with **PHP, HTML, CSS, JavaScript**, and **MySQL**.  
It simulates a futuristic cyberpunk marketplace where players can:

- Browse and purchase in-game items  
- Upgrade their character  
- Manage their inventory  
- See real-time updates when items change  
- Store all data and transactions securely in a **MySQL database**  

---

## 📂 Project Structure

```tree
CTS/
│
├── public/             # Static files (HTML, CSS, JS, media)
│   ├── index.php       # Main entry point
│   ├── style/          # Stylesheets
│   ├── script/         # Client-side scripts
│   ├── media/          # Images, icons, etc.
    └── ...             # Other PHP(html) files
│
├── src/                # Backend PHP scripts
│   ├── db.php          # Database connection
│   ├── shop.php        # Shop logic
│   ├── inventory.php   # Inventory management
│   └── ...             # Other PHP files
│
└──── game_db.sql       # Database schema and seed data
```

## 🚀 Installation & Setup

### 1. Requirements
Before running the project, install:

- [XAMPP](https://www.apachefriends.org/) or [MAMP](https://www.mamp.info/) (for PHP + Apache + MySQL)  
- PHP 8+  
- MySQL 5.7+ or MariaDB  

---

### 2. Clone the Repository
```bash
git clone https://github.com/MaksymSyrotiuk/cts-shop.git
cd cts-shop
```

### 3. Set Up the Database

Start **MySQL** from XAMPP/MAMP.  

Create a new database:

```sql
CREATE DATABASE game_db;
SOURCE database/game_db.sql;
```

### 4. Configure Database Connection

Edit `src/modules/db.php` and update with your local credentials:

```php
<?php
    $host = "localhost"; // Host name
    $dbname = "game_db"; // Database name
    $username = "root";  // DB login
    $password = "";      // Password

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Database connection error: " . $e->getMessage());
    }
?>
```
### 5. Run the Project

Move the project into your web server root:

- **XAMPP** → `htdocs/cts-shop`  
- **MAMP** → `htdocs/cts-shop`  

Start **Apache** and **MySQL** in XAMPP/MAMP.  

Open in your browser: 

http://localhost/cts-shop/public
