# Implementation Plan - Car & Bike Pool Web Application (Ride & Booking Management Module)

Building a clean, beginner-friendly, and professional **Admin Panel** for the **Ride & Booking Management** module in Core PHP, MySQL, HTML5, CSS3, Bootstrap 5, and AdminLTE for XAMPP.

The project follows a standard file structure without frameworks or complex design patterns, making it easy to explain in interviews.

---

## User Review Required

> [!IMPORTANT]
> - **Database Setup (`schema.sql`)**: We will provide a starter SQL script to set up the database `car_pool_db` with tables (`admins`, `users`, `vehicles`, `rides`, `bookings`) and sample test data.
> - **File-by-File Output**: Following your requirement, each file will be delivered one by one along with its Location, Code, Simple Explanation, and Testing Instructions.

---

## Database Schema Overview (`car_pool_db`)

1. **`admins`**: Stores admin credentials (hashed passwords using `password_hash()`).
2. **`users`**: Drivers and passengers registered in the system.
3. **`vehicles`**: Cars and bikes registered by drivers.
4. **`rides`**: Rides published by drivers (Pickup, Destination, Date, Time, Total/Available Seats, Fare, Status: Active/Completed/Cancelled).
5. **`bookings`**: Seat reservations made by passengers (Seats Booked, Total Price, Booking Date, Status: Pending/Confirmed/Completed/Cancelled).

---

## Proposed Sequential File Generation Plan

1. **`schema.sql`** - Database schema & dummy sample data.
2. **`config/database.php`** - Database connection script (using MySQLi prepared statements / PDO).
3. **`admin/includes/session.php`** - Session initialization & authentication check helpers.
4. **`admin/login.php`** - Admin authentication page (form, validation, password verification).
5. **`admin/logout.php`** - Admin logout controller.
6. **`admin/includes/header.php`** - AdminLTE head metadata & stylesheet links (CDN based for easy setup).
7. **`admin/includes/navbar.php`** - AdminLTE top navigation bar.
8. **`admin/includes/sidebar.php`** - Navigation sidebar with active page indicators.
9. **`admin/includes/footer.php`** - Footer elements & JS dependencies.
10. **`admin/dashboard.php`** - Admin Dashboard with metrics cards (Total Rides, Bookings, Users, Vehicles) and recent activity tables.
11. **`admin/rides/ride_list.php`** - Ride List table with Search, Filter by Status, Pagination, and Action Buttons.
12. **`admin/rides/view_ride.php`** - Detailed view of a single ride & its bookings.
13. **`admin/rides/edit_ride.php`** - Edit ride details.
14. **`admin/rides/update_ride_status.php`** - Ride status update action handler.
15. **`admin/bookings/booking_list.php`** - Booking List table with Search, Filter by Status, Pagination.
16. **`admin/bookings/view_booking.php`** - Detailed view of a single booking.
17. **`admin/bookings/update_booking_status.php`** - Booking status update handler.
18. **`index.php`** - Entry point redirecting to login/dashboard.

---

## Verification Plan

### Automated / Local Testing
- Execute SQL scripts in phpMyAdmin or MySQL CLI.
- Run XAMPP (Apache + MySQL).
- Test PHP syntax and query executions.

### Manual Verification
- Test login with valid and invalid credentials.
- Test session protection on all admin pages (attempting direct access without login).
- Verify dashboard counters match actual database counts.
- Test Ride List search, status filtering, and pagination.
- Test status updates for Rides and Bookings.
