# School Bus Web

Smart IoT-Based Student Attendance and School Bus Tracking System.

## Overview

This repository contains a PHP web application for tracking school buses and managing student attendance using IoT (RFID) scanning. It was created as a UTAS Diploma course project and includes a simple API backend under `api/` and web templates in `Template/`.

## Key Features

- Driver and parent dashboards
- Live bus location endpoints and basic tracking
- Student management (add/update/delete)
- Bus management (add/update/delete)
- Simple authentication helper (`api/Auth.php`)

## Tech Stack

- PHP (server-side)
- MySQL (or compatible) database
- HTML/CSS/JS templates in `Template/`

## Quickstart

1. Requirements: PHP 7.2+ (or compatible), a webserver (Apache/Nginx), and MySQL (or MariaDB).
2. Place the project in your webroot (for example, `htdocs` or `www`).
3. Create a database and import your schema (this project does not include an SQL dump).
4. Update database credentials in `api/config.php`.
5. Access the app in your browser (e.g. `http://localhost/index.php` or `Dashboard.php`).

## Project Layout

- `index.php` — main entry / landing page
- `Dashboard.php` — admin dashboard page
- `unauthorized.php` — shown when access denied
- `api/` — backend API endpoints and helpers
  - `add_bus.php`, `update_bus.php`, `delete_bus.php` — bus management
  - `add_student.php`, `update_student.php`, `delete_student.php` — student management
  - `get_buses.php`, `get_students.php`, `get_parents.php` — retrieval endpoints
  - `get_bus_location.php`, `get_bus_stats.php`, `get_student_stats.php`, `get_stats.php` — stats & tracking
  - `driver_checkin.php`, `iot_rfid_scan.php` — IoT / driver interactions
  - `get_driver_dashboard.php`, `get_parent_dashboard.php` — dashboard data
  - `get_alerts.php` — alerts feed
  - `logout.php`, `set_trip_status.php` — session & trip control
  - `Auth.php` — authentication helper
  - `config.php` — database and configuration settings (edit this file)
- `Template/` — HTML templates and assets used by the UI (dashboard, driver/parent pages, tracking pages)

## Configuration

- Edit `api/config.php` to set your database host, username, password, and database name.
- Ensure your webserver user has permission to read these files and that `config.php` is not served publicly.

## Security Notes

- This project is a learning/demo application. Before production use, add stronger authentication, input validation, prepared statements (if missing), HTTPS, and CSRF protections.

## Development & Testing

- Use PHP's built-in server for local testing:

```bash
php -S localhost:8000
```

- Run API calls with `curl` or Postman against the `api/` endpoints.

## Contact

For questions about this project, check the source files or open an issue in this repository.

## License

This project is licensed under the MIT License — see the `LICENSE` file for details. The MIT License permits commercial use, modification, distribution, and private use while retaining the copyright notice.

Copyright (c) 2025 Suliman Al-Busaidi

