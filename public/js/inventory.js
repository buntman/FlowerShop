let currentProductId = null;

function fetchProductDetails(id) {
    fetch('/admin/inventory/item-details', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({id})
    })
    .then(response=>response.json())
    .then(data=> {
            document.getElementById('product-image').src = data.image_path;
            document.getElementById('product-name').textContent = data.name;
            document.getElementById('product-description').textContent = data.description;
            const price = data.price;
            const formattedPrice = `₱ ${price} ${"PHP"}`;
            document.getElementById('product-price').textContent = formattedPrice;
        })
    .catch(error=> console.error('Error', error));
}


function fetchProductToEdit(id) {
    currentProductId = id;
    fetch('/admin/inventory/edit/item', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({id})
    })
    .then(response=>response.json())
    .then(data=> {
            document.getElementById("edit-name").value = data.name;
            document.getElementById("edit-stocks").value = data.stock_quantity;
            document.getElementById("edit-description").value = data.description || '';
            document.getElementById("edit-price").value = data.price;
        })
    .catch(error=> console.error('Error', error));
}

function updateProductDetails(event) { 
    event.preventDefault();
    const data = new FormData(event.target);
    const values = Object.fromEntries(data.entries());
    const requestBody = {currentProductId, ...values};

    fetch('/admin/inventory/edit/update-item', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(requestBody)
    })
    .then(response=>response.json())
    .then(data=> {
            if(data.success) {
                const table = document.getElementById('myTable');
                const row = table.querySelector(`tbody tr[data-id="${currentProductId}"]`);
                if(row) {
                    const cells = row.cells;
                    cells[2].innerText = values.name;
                    cells[4].innerText = values.stock;
                    const formattedPrice = `₱ ${values.price}`;
                    cells[5].innerText = formattedPrice;
                    fetchProductDetails(currentProductId);
                    alert("Item successfully edited!");
                }
            }
        })
    .catch(error=> console.error('Error', error));
}

function deleteProduct(id) {
    fetch('/admin/inventory/delete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({id})
    })
    .then(response=>response.json())
    .then(data=> {
            if(data.success) {
                const table = document.getElementById('myTable');
                const row = table.querySelector(`tbody tr[data-id="${id}"]`);
                if(row) {
                    row.remove();
                    refreshItemDisplayed();
                }
            }
            console.log(data.message);
        })
    .catch(error=> console.error('Error', error));
}

function refreshItemDisplayed() {
    fetch('/admin/inventory/refresh')
    .then(response=>response.json())
    .then(data=> {
            if(data.success) {
                document.getElementById('product-image').src = data.product.image_path;
                document.getElementById('product-name').textContent = data.product.name;
                document.getElementById('product-description').textContent = data.product.description;
                const price = data.product.price;
                const formattedPrice = `₱ ${price} ${"PHP"}`;
                document.getElementById('product-price').textContent = formattedPrice;
            }
        })
    .catch(error=> console.error('Error', error));
}
