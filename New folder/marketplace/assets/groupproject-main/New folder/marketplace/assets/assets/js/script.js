const items = [
  { id: 1, name: "Laptop", description: "Used laptop.", price: "£150", image: "images/laptop.jfif", category: "Electronics" },
  { id: 2, name: "Textbook", description: "CS Textbook.", price: "£30", image: "images/textbook.jfif", category: "Books" },
  { id: 3, name: "Bicycle", description: "Second-hand bike.", price: "£100", image: "images/bicycle.jfif", category: "Transport" },
  { id: 4, name: "Headphones", description: "Wireless headphones.", price: "£80", image: "images/headphones.jpg", category: "Electronics" }
];

function displayItems(itemsToShow, selector = '.items-list') {
  const container = document.querySelector(selector);
  if (!container) return;

  container.innerHTML = '';
  if (itemsToShow.length === 0) {
    container.innerHTML = '<p>No items found.</p>';
    return;
  }

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

function searchItems(query, category) {
  const filteredItems = items.filter(item => {
    const matchQuery = item.name.toLowerCase().includes(query.toLowerCase()) || item.description.toLowerCase().includes(query.toLowerCase());
    const matchCategory = !category || item.category === category;
    return matchQuery && matchCategory;
  });

  displayItems(filteredItems);
}

document.addEventListener("DOMContentLoaded", () => {
  const isIndex = document.querySelector('#items-list');
  const isListing = document.querySelector('.items-list');

  if (isIndex) {
    displayItems(items.slice(0, 3), '#items-list');
  }

  if (isListing && document.getElementById('search-bar')) {
    displayItems(items, '.items-list');

    const searchBar = document.getElementById('search-bar');
    const categoryFilter = document.getElementById('category-filter');

    function updateSearch() {
      const query = searchBar.value;
      const category = categoryFilter.value;
      searchItems(query, category);
    }

    searchBar.addEventListener('input', updateSearch);
    categoryFilter.addEventListener('change', updateSearch);
  }
});