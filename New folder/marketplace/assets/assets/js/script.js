const items = [
  { id: 1, name: "Laptop", description: "Used laptop.", price: "£150", image: "images/laptop.jfif" },
  { id: 2, name: "Textbook", description: "CS Textbook.", price: "£30", image: "images/textbook.jfif" },
  { id: 3, name: "Bicycle", description: "Second-hand bike.", price: "£100", image: "images/bicycle.jfif" },
  { id: 4, name: "Headphones", description: "Wireless headphones.", price: "£80", image: "images/headphones.jpg" }
];

function displayItems(itemsToShow, selector = '.items-list') {
  const container = document.querySelector(selector);
  if (!container) return;

  container.innerHTML = '';
  itemsToShow.forEach(item => {
    const itemCard = document.createElement('div');
    itemCard.className = 'item-card';
    itemCard.innerHTML = `
      <img src="${item.image}" alt="${item.name}" onerror="this.src='images/placeholder.jpg'">
      <div class="item-card-content">
        <h3>${item.name}</h3>
        <p>${item.description}</p>
        <p class="item-price">${item.price}</p>
        <button onclick="window.location.href='item.html?id=${item.id}'" class="btn-modern">
          <i class="fas fa-shopping-cart"></i>
          Buy Now
        </button>
      </div>
    `;
    container.appendChild(itemCard);
  });
}

function searchItems(query) {
  const filteredItems = items.filter(item =>
    item.name.toLowerCase().includes(query.toLowerCase())
  );
  displayItems(filteredItems);
}

document.addEventListener("DOMContentLoaded", () => {
  const isIndex = document.querySelector('#items-list');
  const isListing = document.querySelector('.items-list');

  if (isIndex) {
    displayItems(items.slice(0, 3), '#items-list');
  }

  if (isListing) {
    displayItems(items, '.items-list');
    const searchBar = document.getElementById('search-bar');
    
    if (searchBar) {
      searchBar.addEventListener('input', (event) => {
        searchItems(event.target.value);
      });
    }
  }
});