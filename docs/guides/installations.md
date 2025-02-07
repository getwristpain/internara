# **Internara - Internship System Installation Guide**

This guide provides instructions for installing the **Internara (Internship System)**, a Laravel-based application. Instead of following multiple steps, we’ve simplified the process to a single command: `app:install`.

## **Prerequisites**

Before starting, ensure you have the following installed:

- **PHP** >= 8.0
- **Composer** (Dependency Manager for PHP)
- **MySQL** or **MariaDB** (Database management system)
- **Node.js** >= 16.x (For compiling frontend assets)
- **npm** (Node Package Manager)
- **Git** (Version control)

## **Step 1: Clone the Repository**

Start by cloning the repository from GitHub:

```bash
git clone https://github.com/getwristpain/internara.git
```

Then, navigate to the project folder:

```bash
cd internara
```

## **Step 2: Install Dependencies**

### 2.1 Install PHP Dependencies

Ensure **Composer** is installed, and run:

```bash
composer install
```

### 2.2 Install Frontend Dependencies

Install JavaScript dependencies with:

```bash
npm install
```

## **Step 3: Run Installation Command**

Now, instead of manually setting up environment files, migrating the database, and compiling assets, you can run the simplified installation command:

```bash
php artisan app:install
```

This command will:

1. Set up the `.env` file with default values.
2. Run database migrations to create necessary tables.
3. Seed the database with default data (optional).
4. Compile the frontend assets (CSS, JS).
5. Generate the application key.
6. Set up other essential configurations.

## **Step 4: Access the Application**

Once the installation command completes successfully, you can access the application by running the Laravel development server:

```bash
php artisan serve
```

The application should now be accessible at [http://127.0.0.1:8000](http://127.0.0.1:8000).

## **Step 5: Additional Configuration (Optional)**

If you need to modify specific settings, you can:

- Update the `.env` file for your mail and database configurations.
- Set up storage links with:

  ```bash
  php artisan storage:link
  ```

- Configure email settings, if required.

---

**Congratulations!** You’ve installed **Internara** with the simplified `app:install` command.
