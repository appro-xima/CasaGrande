const rooms = [
  {
    id: 1,
    name: "Supreme Deluxe Room",
    price: "₱612 per night",
    features: ["Bedroom", "Balcony", "Kitchen"],
    facilities: ["WiFi", "Air Conditioner", "Room Heater", "Geyser"],
    guests: { adults: 9, children: 10 },
    rating: 5,
    img: "img/room1.jpg",
  },
  {
    id: 2,
    name: "Luxury Room",
    price: "₱408 per night",
    features: ["Bedroom", "Balcony", "Kitchen"],
    facilities: ["WiFi", "Air Conditioner", "Room Heater"],
    guests: { adults: 8, children: 6 },
    rating: 4,
    img: "img/room2.jpg",
  },
  {
    id: 3,
    name: "Deluxe Room",
    price: "₱340 per night",
    features: ["Bedroom", "Balcony", "Kitchen"],
    facilities: ["Air Conditioner", "Room Heater", "Geyser"],
    guests: { adults: 3, children: 2 },
    rating: 3,
    img: "img/room3.jpg",
  },
  {
    id: 4,
    name: "Executive Suite",
    price: "₱816 per night",
    features: ["Bedroom", "Living Room", "Kitchen"],
    facilities: ["WiFi", "Air Conditioner", "Mini Bar"],
    guests: { adults: 4, children: 2 },
    rating: 5,
    img: "img/executive room.jpg",
  },
  {
    id: 5,
    name: "Family Room",
    price: "₱476 per night",
    features: ["2 Bedrooms", "Balcony"],
    facilities: ["WiFi", "Air Conditioner", "Refrigerator"],
    guests: { adults: 6, children: 4 },
    rating: 4,
    img: "img/family room.jpg",
  },
];

const roomList = document.getElementById("room-list");

rooms.forEach((room) => {
  const roomCard = document.createElement("div");
  roomCard.classList.add("room-card");

  roomCard.innerHTML = `
    <img src="${room.img}" alt="${room.name}">
    <div class="room-details">
      <h3>${room.name}</h3>
      <p class="price">${room.price}</p>
      <p><strong>Features:</strong> ${room.features.join(", ")}</p>
      <p><strong>Facilities:</strong> ${room.facilities.join(", ")}</p>
      <p><strong>Guests:</strong> ${room.guests.adults} Adults, ${room.guests.children} Children</p>
      <p><strong>Rating:</strong> ${"⭐".repeat(room.rating)}</p>
    </div>
    <div class="button-container">
      <button class="book-now" onclick="bookRoom('${room.name}')">Book Now</button>
      <button class="more-details">More Details</button>
    </div>
  `;

  roomList.appendChild(roomCard);
});

function bookRoom(roomName) {
  alert(`You booked the ${roomName}!`); // Fixed quotes here
}
