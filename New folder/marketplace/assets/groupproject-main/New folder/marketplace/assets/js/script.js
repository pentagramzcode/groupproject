
const items = [
  { id: 1, name: "Laptop", description: "Used laptop.", price: "£150", image: "images/laptop.jfif" },
  { id: 2, name: "Textbook", description: "CS Textbook.", price: "£30", image: "images/textbook.jfif" },
  { id: 3, name: "Bicycle", description: "Second-hand bike.", price: "£100", image: "images/bicycle.jfif" },
  { id: 4, name: "Headphones", description: "Wireless headphones.", price: "£80", image: "images/headphones.jpg" }
];


function displayItems(items) {
  const itemsList = document.querySelector('.items-list'); 

  if (!itemsList) {
    console.warn("Warning: .items-list not found on this page.");
    return;
  }

  console.log("Displaying items:", items); 

  itemsList.innerHTML = ''; 

  items.forEach(item => {
    const itemCard = document.createElement('div');
    itemCard.classList.add('item-card');
    itemCard.innerHTML = `
      <img src="${item.image}" alt="${item.name}" onerror="this.src='images/placeholder.jpg'">
      <h3>${item.name}</h3>
      <p>${item.description}</p>
      <p><strong>${item.price}</strong></p>
      <button>Buy Now</button>
    `;
    itemsList.appendChild(itemCard);
  });
}

function searchItems(query) {
  const filteredItems = items.filter(item => 
    item.name.toLowerCase().includes(query.toLowerCase())
  );
  displayItems(filteredItems);
}


document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM Loaded - Running JavaScript");
  displayItems(items); 

  const searchBar = document.getElementById('search-bar');
  if (searchBar) {
    searchBar.addEventListener('input', (event) => {
      searchItems(event.target.value);
    });
  }
});