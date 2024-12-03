const mysql = require('mysql2/promise');

exports.handler = async (event, context) => {
    if (event.httpMethod === 'POST') {
        const body = JSON.parse(event.body);
        const { name, email, roomType, roomCode, checkin, checkout } = body;

        // Validate inputs
        if (!name || !email || !roomType || !roomCode || !checkin || !checkout) {
            return {
                statusCode: 400,
                body: JSON.stringify({ message: "All fields are required!" }),
            };
        }

        // Validate email format
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            return {
                statusCode: 400,
                body: JSON.stringify({ message: "Invalid email format!" }),
            };
        }

        // Connect to MySQL database
        const connection = await mysql.createConnection({
            host: 'localhost', // Replace with your DB host
            user: 'root', // Replace with your DB username
            database: 'hotel_db', // Replace with your DB name
            password: '', // Replace with your DB password
        });

        // Check for room availability
        const [rows] = await connection.execute("SELECT COUNT(*) as count FROM name WHERE roomCode = ? AND (checkinDate < ? AND checkoutDate > ?)", [roomCode, checkout, checkin]);
        if (rows[0].count > 0) {
            return {
                statusCode: 409,
                body: JSON.stringify({ message: "Room is already booked!" }),
            };
        }

        // Insert booking details
        await connection.execute("INSERT INTO name (`Full Name`, email, roomType, roomCode, checkinDate, checkoutDate) VALUES (?, ?, ?, ?, ?, ?)", [name, email, roomType, roomCode, checkin, checkout]);

        return {
            statusCode: 200,
            body: JSON.stringify({ message: "Booking successful!" }),
        };
    }

    return {
        statusCode: 405,
        body: JSON.stringify({ message: "Method Not Allowed" }),
    };
};
