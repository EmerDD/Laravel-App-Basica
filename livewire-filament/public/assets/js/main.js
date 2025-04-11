const products = [
    { id: 1, name: "Producto 1", price: "$10", image: "https://via.placeholder.com/250" },
    { id: 2, name: "Producto 2", price: "$20", image: "https://via.placeholder.com/250" },
    // Agrega más productos aquí
];

let currentPage = 1;
const productsPerPage = 9;

function renderProducts(page = 1, searchTerm = "") {
    const start = (page - 1) * productsPerPage;
    const filteredProducts = products.filter(product =>
        product.name.toLowerCase().includes(searchTerm.toLowerCase())
    );
    const paginatedProducts = filteredProducts.slice(start, start + productsPerPage);

    const container = document.getElementById("productContainer");
    container.innerHTML = paginatedProducts.map(product => `
        <div class="product-card">
            <img src="${product.image}" alt="${product.name}">
            <div class="details">
                <h3>${product.name}</h3>
                <p>${product.price}</p>
            </div>
        </div>
    `).join("");

    document.getElementById("pageIndicator").textContent = page;
    document.getElementById("prevBtn").disabled = page === 1;
    document.getElementById("nextBtn").disabled = start + productsPerPage >= filteredProducts.length;
}

document.getElementById("prevBtn").addEventListener("click", () => {
    currentPage--;
    renderProducts(currentPage, document.getElementById("searchInput").value);
});

document.getElementById("nextBtn").addEventListener("click", () => {
    currentPage++;
    renderProducts(currentPage, document.getElementById("searchInput").value);
});

document.getElementById("searchInput").addEventListener("input", (e) => {
    currentPage = 1;
    renderProducts(currentPage, e.target.value);
});

renderProducts();
