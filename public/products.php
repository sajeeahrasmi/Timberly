<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Timberly</title>
  <link rel="stylesheet" href="products.css" />
  <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
</head>

<body>
  <!-- Product Modal -->
  <div class="modal" id="productModal">
    <div class="modal-content product-modal">
      <span class="close-modal">&times;</span>
      <div class="product-details-container"></div>
    </div>
  </div>

  <header class="header">
    <a href="#" class="logo"><img src="./images/final_logo.png" style="width: 200px; height: 200px;" /></a>
    <nav class="nav-links">
      <a href="landingPage.php">Home</a>
    </nav>
  </header>

  <section class="featured">
    <div class="section-title">
      <h2>Our Collection</h2>
    </div>

    <div class="filters">
      <button class="filter-btn active" data-category="all">All</button>
      <button class="filter-btn" data-category="Chair">Chair</button>
      <button class="filter-btn" data-category="Table">Table</button>
      <button class="filter-btn" data-category="Wardrobe">Wardrobe</button>
      <button class="filter-btn" data-category="Bookshelf">Bookshelf</button>
      <button class="filter-btn" data-category="Stool">Stool</button>
      <button class="filter-btn" data-category="dining">Dining</button>
      <button class="filter-btn" data-category="seating">Seating</button>
      <button class="filter-btn" data-category="storage">Storage</button>
    </div>

    <div class="products-grid" id="productsGrid"></div>
  </section>

  <script>
    let products = [];

    async function loadProducts() {
      try {
        const response = await fetch('../api/getProducts.php');
        if (!response.ok) throw new Error("HTTP status " + response.status);
        const data = await response.json();
        console.log("Fetched products:", data);
        products = data;
        filterProducts('all');
      } catch (error) {
        console.error('Failed to load products:', error);
      }
    }

    function createProductCard(product) {
      const card = document.createElement('div');
      card.className = 'product-card';

      card.innerHTML = `
        <img src="${product.image.replace('../', '')}" alt="${product.description}" class="product-image" />
        <div class="product-info">
          <h3 class="product-title">${product.description}</h3>
          <p class="product-price">Rs. ${product.unitPrice ?? 'N/A'}</p>
          <button class="view-details-btn" data-id="${product.furnitureId}">View Details</button>
        </div>
      `;
      return card;
    }

    function filterProducts(category) {
      const filtered = category === 'all'
        ? products
        : products.filter(p => p.category.toLowerCase() === category.toLowerCase());

      const grid = document.getElementById('productsGrid');
      grid.innerHTML = '';
      filtered.forEach(p => grid.appendChild(createProductCard(p)));
    }

    function showProductDetails(id) {
        const product = products.find(p => p.furnitureId == id);
        if (!product) return;

        const modal = document.getElementById('productModal');
        const container = modal.querySelector('.product-details-container');

        // Build reviews HTML
        const reviewsHTML = product.reviews && product.reviews.length > 0
            ? product.reviews.map(review => `
                <div class="review-item">
                <p>${review}</p>
                </div>
            `).join('')
            : `<p>No reviews yet.</p>`;

        container.innerHTML = `
            <div class="product-image-section">
                <img src="${product.image.replace('../', '')}" alt="${product.description}" class="product-details-image" />
            </div>
            <div class="product-details-info">
                <h2 class="product-details-title">${product.description}</h2>
                <p class="product-details-price">Rs.${product.unitPrice}</p>

                <div class="product-specs">
                    <h3>Specifications</h3>
                    <div class="spec-grid">
                        <div class="spec-item"><span>Category</span></div>
                        <div class="spec-item">${product.category}<span></div>
                        <div class="spec-item"><span>Type</span></div>
                        <div class="spec-item">${product.type}</span></div>
                        <div class="spec-item"><span>Size</span></div>
                        <div class="spec-item">${product.size}</span></div>
                        <div class="spec-item"><span>Additional</span></div>
                        <div class="spec-item">${product.additionalDetails}</span></div>
                    </div>
                </div>
                <div class="reviews-section">
                    <h3>Customer Reviews</h3>
                    ${reviewsHTML}
                </div>
                <button class="add-to-cart-btn" data-id="${product.furnitureId}">Add to Cart</button>
            </div>
        `;

        modal.style.display = 'block';
    }

    document.addEventListener('DOMContentLoaded', () => {
      loadProducts();

      document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', e => {
          document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
          e.target.classList.add('active');
          filterProducts(e.target.dataset.category);
        });
      });

      document.addEventListener('click', async e => {
        if (e.target.classList.contains('view-details-btn') && e.target.dataset.id) {
            showProductDetails(parseInt(e.target.dataset.id));
        }

        if (e.target.classList.contains('add-to-cart-btn') && e.target.dataset.id) {
            const productId = parseInt(e.target.dataset.id);
            try {
            const res = await fetch('../api/addToCart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ productId })
            });

            const data = await res.json();

            if (res.ok && data.success) {
                alert('Item added to cart!');
            } else {
                if (res.status === 401) {
                    window.location.href = 'login.html';
                } else {
                    alert(data.error || 'Failed to add to cart');
                }
            }
            } catch (err) {
            console.error(err);
            alert('Something went wrong while adding to cart.');
            }
        }
      });

      const modal = document.getElementById('productModal');
      modal.querySelector('.close-modal').addEventListener('click', () => {
        modal.style.display = 'none';
      });
      window.addEventListener('click', e => {
        if (e.target === modal) modal.style.display = 'none';
      });
    });
  </script>
</body>
</html>