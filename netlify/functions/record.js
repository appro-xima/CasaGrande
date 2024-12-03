// netlify/functions/record.js

exports.handler = async (event, context) => {
    if (event.httpMethod === "POST") {
        const data = JSON.parse(event.body); // Parse the incoming JSON data

        // Simulate processing the data
        const confirmationMessage = `Reservation confirmed for ${data.name} with email ${data.email}. Check-in: ${data.checkin}, Check-out: ${data.checkout}, Room Type: ${data.roomType}, Room Number: ${data.roomCode}.`;

        return {
            statusCode: 200,
            body: JSON.stringify({ message: confirmationMessage, data }),
        };
    }

    return {
        statusCode: 405,
        body: JSON.stringify({ message: "Method not allowed" }),
    };
};
