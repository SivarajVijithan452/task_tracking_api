<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Toastr JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <!-- Include other JS libraries (e.g., Pusher, Echo) -->
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('57a67e28f1405a6ad04b', {
            cluster: 'ap2'
        });

        var channel = pusher.subscribe('products');

        function showNotification(message) {
            toastr.success(message); // Use Toastr to show notifications
        }

        channel.bind('my-event', function (data) {
            console.log('Event received:', data);
            if (data) {
                showNotification(data.product_name + ' updated');
            } else {
                console.log('Data is empty');
            }
        });
    </script>
</head>

<body>
    @include('components.navbar')
    @vite('resources/css/app.css')
    @vite('resources/js/app.js') <!-- or another path to your Echo setup -->
    <!-- Button to Open Add Product Modal -->
    <div class="mb-4 flex justify-end">
        <button class="btn btn-primary" onclick="showAddProductModal()">Add Product</button>
    </div>

    <!-- Add Product Modal -->
    <dialog id="add-product-modal" class="modal">
        <div class="modal-box">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                onclick="closeAddProductModal()">✕</button>
            <h3 class="text-lg font-bold mb-4">Add New Product</h3>
            <form id="add-product-form">
                @csrf
                <input type="hidden" id="add-product-id" name="product_id">
                <div class="mb-4">
                    <label for="add-product_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" id="add-product_name" name="product_name" class="input input-bordered w-full"
                        required>
                </div>
                <div class="mb-4">
                    <label for="add-product_category" class="block text-sm font-medium text-gray-700">Category</label>
                    <input type="text" id="add-product_category" name="product_category"
                        class="input input-bordered w-full" required>
                </div>
                <div class="mb-4">
                    <label for="add-description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="add-description" name="description" class="textarea textarea-bordered w-full"
                        required></textarea>
                </div>
                <div class="mb-4">
                    <label for="add-product_price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" id="add-product_price" name="product_price" class="input input-bordered w-full"
                        required>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </dialog>

    <!-- Edit Product Modal -->
    <dialog id="edit-product-modal" class="modal">
        <div class="modal-box">
            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                onclick="closeEditProductModal()">✕</button>
            <h3 class="text-lg font-bold mb-4">Edit Product</h3>
            <form id="edit-product-form">
                @csrf
                <input type="hidden" id="edit-product-id" name="product_id">
                <div class="mb-4">
                    <label for="edit-product_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" id="edit-product_name" name="product_name" class="input input-bordered w-full"
                        required>
                </div>
                <div class="mb-4">
                    <label for="edit-product_category" class="block text-sm font-medium text-gray-700">Category</label>
                    <input type="text" id="edit-product_category" name="product_category"
                        class="input input-bordered w-full" required>
                </div>
                <div class="mb-4">
                    <label for="edit-description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="edit-description" name="description" class="textarea textarea-bordered w-full"
                        required></textarea>
                </div>
                <div class="mb-4">
                    <label for="edit-product_price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" id="edit-product_price" name="product_price"
                        class="input input-bordered w-full" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </dialog>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="table w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <!-- head -->
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Category</th>
                    <th class="px-6 py-3">Description</th>
                    <th class="px-6 py-3">Price</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody id="product-table" class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                <!-- Data will be injected here by JavaScript -->
            </tbody>
        </table>
    </div>

    <script>

        // Show Add Product Modal
        function showAddProductModal() {
            document.getElementById('add-product-modal').showModal();
        }

        // Close Add Product Modal
        function closeAddProductModal() {
            document.getElementById('add-product-modal').close();
        }

        // Show Edit Product Modal
        function showEditProductModal(product) {
            const modal = document.getElementById('edit-product-modal');
            const form = document.getElementById('edit-product-form');

            // Set the form fields with the product data
            form.product_name.value = product.product_name;
            form.product_category.value = product.product_category;
            form.description.value = product.description;
            form.product_price.value = product.product_price;

            // Set the product ID as a hidden field
            document.getElementById('edit-product-id').value = product.id;

            modal.showModal();
        }

        // Close Edit Product Modal
        function closeEditProductModal() {
            document.getElementById('edit-product-modal').close();
        }

        // Handle Add Product Form Submission
        document.getElementById('add-product-form').addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('/api/products', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        alert(data.message);
                        closeAddProductModal();
                        refreshTable();
                    } else {
                        alert('An error occurred while adding the product.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An unexpected error occurred. Please try again.');
                });
        });

        // Handle Edit Product Form Submission
        document.getElementById('edit-product-form').addEventListener('submit', function (event) {
            event.preventDefault();

            // Get form data and convert to JSON
            const formData = new FormData(this);
            const formDataJson = {};
            formData.forEach((value, key) => {
                formDataJson[key] = value;
            });

            const productId = document.getElementById('edit-product-id').value;

            fetch(`/api/products/${productId}`, {
                method: 'PUT',
                body: JSON.stringify(formDataJson),
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',  // Set content type to JSON
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => {
                    console.log('Response Status:', response.status);  // Log status
                    return response.json();
                })
                .then(data => {
                    console.log('Response Data:', data);  // Log data
                    if (data.message) {
                        alert(data.message);
                        closeEditProductModal();
                        refreshTable();
                    } else {
                        alert('An error occurred while updating the product.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An unexpected error occurred. Please try again.');
                });
        });


        // Fetch and Update Table Data
        function refreshTable() {
            fetch('/api/products', {
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    console.log('Fetch Products Response Status:', response.status); // Log status
                    return response.json();
                })
                .then(data => {
                    console.log('Fetched Products Data:', data); // Debug data
                    let tableHtml = '';

                    // Check if 'data' exists and is an array
                    if (data && Array.isArray(data.data)) {
                        data.data.forEach((product) => {
                            tableHtml += `
                    <tr class="border-b bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">${product.id}</td>
                        <td class="px-6 py-4">${product.product_name}</td>
                        <td class="px-6 py-4">${product.product_category}</td>
                        <td class="px-6 py-4">${product.description}</td>
                        <td class="px-6 py-4">${product.product_price}</td>
                        <td class="px-6 py-4">
                            <button class="btn btn-primary btn-sm mr-2" onclick='showEditProductModal(${JSON.stringify(product)})'>Edit</button>
                            <button class="btn btn-error btn-sm" onclick='deleteProduct(${product.id})'>Delete</button>
                        </td>
                    </tr>`;
                        });
                    } else {
                        tableHtml = '<tr><td colspan="6">No products found.</td></tr>';
                    }
                    document.getElementById('product-table').innerHTML = tableHtml;
                })
                .catch(error => {
                    console.error('Error fetching products:', error);
                    alert('An unexpected error occurred while fetching products. Please try again.');
                });
        }


        // Handle Product Deletion
        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
                fetch(`/api/products/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            alert(data.message);
                            refreshTable();
                        } else {
                            alert('An error occurred while deleting the product.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An unexpected error occurred. Please try again.');
                    });
            }
        }

        // Initial Table Load
        document.addEventListener('DOMContentLoaded', refreshTable);
        // Listen for real-time events
        document.addEventListener('DOMContentLoaded', () => {
            window.Echo.channel('products')
                .listen('ProductCreated', (event) => {
                    console.log('Product Created:', event.product);
                    refreshTable(); // Refresh the table on product creation
                })
                .listen('ProductUpdated', (event) => {
                    console.log('Product Updated:', event.product);
                    refreshTable(); // Refresh the table on product update
                })
                .listen('ProductDeleted', (event) => {
                    console.log('Product Deleted:', event.productId);
                    refreshTable(); // Refresh the table on product deletion
                });

            // Initial Table Load
            refreshTable();
        });



    </script>


</body>

</html>