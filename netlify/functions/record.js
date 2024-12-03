// netlify/functions/record.js

exports.handler = async (event, context) => {
    if (event.httpMethod === "POST") {
        const data = JSON.parse(event.body); // Parse the incoming JSON data

        // Here you can process the data, e.g., save it to a database
        // For this example, we will just return the data received

        return {
            statusCode: 200,
            body: JSON.stringify({ message: "Reservation successful", data }),
        };
    }

    return {
        statusCode: 405,
        body: JSON.stringify({ message: "Method not allowed" }),
    };
};
