# Parking Lot Management System

## Description
This is a web-based Parking Lot Management System built using PHP, MySQL, HTML/CSS, and JavaScript.  
It allows users to manage vehicles, parking spots, tickets, and payments.

## Technologies Used
- PHP (server-side processing)
- MySQL (database)
- HTML/CSS/JavaScript (front-end)
- XAMPP (local server)

## Features
- Dashboard: View all vehicles, parking spots, tickets, and payments
- Create Ticket: Assign a vehicle to a parking spot and generate a ticket
- Complete Ticket: Record payment and mark ticket as PAID
- Manage Vehicles: Add and view all vehicles
- Manage Parking Spots: Add and view all parking spots

## Database Structure
- **Vehicle**: Stores vehicle ID, plate number, and type
- **ParkingSpot**: Stores spot ID, number, type, and availability
- **EntryLog**: Logs vehicle entries and exits
- **Ticket**: Generates tickets for each entry
- **Payment**: Records payment information

## How to Run Locally
1. Install [XAMPP](https://www.apachefriends.org/index.html)
2. Place the `parking_system` folder in the `htdocs` directory
3. Import `parking_lot_db.sql` into MySQL using phpMyAdmin
4. Open the browser and go to: http://localhost/parking_system/index.php
   
## Pages
- **Dashboard**: `index.php`  
- **Create Ticket**: `create_ticket.php`  
- **Complete Ticket**: `complete_ticket.php`  
- **Manage Vehicles**: `manage_vehicles.php`  
- **Manage Parking Spots**: `manage_spots.php`  

## GitHub Repository
[Link to this repository](https://github.com/JohnnyIQ/ParkingLotSystem)
