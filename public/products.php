<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timberly</title>
    <link rel="stylesheet" href="products.css">
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    </head>

<!-- Product Details Modal -->
<div class="modal" id="productModal">
    <div class="modal-content product-modal">
        <span class="close-modal">&times;</span>
        <div class="product-details-container">
            <!-- Content will be dynamically inserted here -->
        </div>
    </div>
</div>


<body>
    <header class="header">
        <a href="#" class="logo"><img src="./images/final_logo.png" style="width: 200px; height: 200px;"></a>
        <nav class="nav-links">
            <a href="landingPage.php">Home</a>
        </nav>
        <div class="user-actions">
            
        </div>
    </header>

    <section class="featured">
        <div class="section-title">
            <h2>Our Collection</h2>
        </div>
        
        <div class="filters">
            <button class="filter-btn active" data-category="all">All</button>
            <button class="filter-btn" data-category="dining">Dining</button>
            <button class="filter-btn" data-category="seating">Seating</button>
            <button class="filter-btn" data-category="storage">Storage</button>
            <button class="filter-btn" data-category="storage">Doors/Windows</button>
            <!-- <button class="filter-btn" data-category="storage">Windows</button> -->
        </div>

        <div class="products-grid" id="productsGrid">
            <!-- Products will be dynamically inserted here -->
        </div>
    </section>


    <script>
        
        const products = [
    {
        id: 1,
        name: "Artisan Dining Table",
        category: "dining",
        price: 1299,
        rating: 4.5,
        reviews: [
            ],
        image: "./images/table.jpg",
        description: "Hand-crafted dining table made from solid oak with a natural finish. Perfect for family gatherings and entertaining guests.",
        specs: {
            "Material": "Solid Oak",
            "Finish": "Natural",
            "Dimensions": "72\"L x 36\"W x 30\"H",
        }
    },
    {
        id: 2,
        name: "Modern Lounge Chair",
        category: "seating",
        price: 1299,
        rating: 4.5,
        reviews: [
            { id: 1, user: "Sarah M.",  text: "Sturdy and elegant, but took longer than expected to arrive." }
        ],
        image: "./images/chair.jpg",
        description: "Hand-crafted dining table made from solid oak with a natural finish. Perfect for family gatherings and entertaining guests.",
        specs: {
            "Material": "Solid Oak",
            "Finish": "Natural",
            "Dimensions": "72\"L x 36\"W x 30\"H",
        }
    },
    {
        id: 3,
        name: "Geometric Bookshelf",
        category: "storage",
        price: 1299,
        rating: 4.5,
        reviews: [
            { id: 1, user: "John D.", text: "Beautiful craftsmanship, exactly what I was looking for!" },
            ],
        image: "./images/bookshelf.jpg",
        description: "Hand-crafted dining table made from solid oak with a natural finish. Perfect for family gatherings and entertaining guests.",
        specs: {
            "Material": "Solid Oak",
            "Finish": "Natural",
            "Dimensions": "72\"L x 36\"W x 30\"H",            
        }
    },
    // Add similar detailed data for other products...
];

        let wishlist = new Set();

        // Create product cards
        function createProductCard(product) {
            const card = document.createElement('div');
            card.className = 'product-card';
            
            const isWishlisted = wishlist.has(product.id);
            
            card.innerHTML = `
                <img src="${product.image}" alt="${product.name}" class="product-image">
                <div class="product-info">
                    <h3 class="product-title">${product.name}</h3>
                    <p class="product-price">Rs. ${product.price}</p>
                    <button class="view-details-btn" onclick = "showProductDetails(3)"">View Details</button>
                </div>
            `;
            
            return card;
        }

       
        // Filter products
        function filterProducts(category) {
            const filteredProducts = category === 'all' 
                ? products 
                : products.filter(p => p.category === category);
            
            const grid = document.getElementById('productsGrid');
            grid.innerHTML = '';
            filteredProducts.forEach(product => {
                grid.appendChild(createProductCard(product));
            });
        }

        // Initial render
        filterProducts('all');

        // Event Listeners
        document.addEventListener('DOMContentLoaded', () => {
            // Filter buttons
            const filterBtns = document.querySelectorAll('.filter-btn');
            filterBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    filterBtns.forEach(b => b.classList.remove('active'));
                    e.target.classList.add('active');
                    filterProducts(e.target.dataset.category);
                });
            });
        

                // Product details modal
            const productModal = document.getElementById('productModal');
            
            // Add click handler for "View Details" buttons
            document.addEventListener('click', (e) => {
                if (e.target.classList.contains('view-details-btn')) {
                    const productCard = e.target.closest('.product-card');
                    const productId = parseInt(productCard.querySelector('.heart-btn').dataset.id);
                    showProductDetails(productId);
                }
            });

            // Close product modal
            productModal.querySelector('.close-modal').addEventListener('click', () => {
                productModal.style.display = 'none';
            });

            window.addEventListener('click', (e) => {
                if (e.target === productModal) {
                    productModal.style.display = 'none';
                }
            });
            
        });

        // Function to display product details
        function showProductDetails(productId) {
            const product = products.find(p => p.id === productId);
            const productModal = document.getElementById('productModal');
            const container = productModal.querySelector('.product-details-container');
            
            container.innerHTML = `
                <div class="product-image-section">
                    <img src="${product.image}" alt="${product.name}" class="product-details-image">
                </div>
                <div class="product-details-info">
                    <h2 class="product-details-title">${product.name}</h2>
                    <p class="product-details-price">Rs.${product.price}</p>
                    <p>${product.description}</p>
                    
                    
                    <div class="product-specs">
                        <h3>Specifications</h3>
                        ${Object.entries(product.specs).map(([key, value]) => `
                            <div class="spec-item">
                                <span>${key}</span>
                                <span>${value}</span>
                            </div>
                        `).join('')}
                    </div>
                    <button class="view-details-btn">Add to Cart </button>
                    <div class="reviews-section">
                        <h3>Customer Reviews</h3>
                        ${product.reviews.map(review => `
                            <div class="review-item">
                                <div class="review-header">
                                    <span>${review.user}</span>
                                </div>
                                <p>${review.text}</p>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;

    productModal.style.display = 'block';
}
    </script>
</body>
</html>