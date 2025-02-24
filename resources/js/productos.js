document.addEventListener("DOMContentLoaded", function () {
    console.log("Testing JS");

    document.getElementById("search").addEventListener("keyup", function (event) {
        let query = this.value;

        if (query !== '') {
            // Send AJAX request to the search route
            fetch(`/search-products?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Search Results:', data); // Check the data in the console

                    // Make sure the data is an array
                    if (Array.isArray(data)) {
                        let tableBody = document.querySelector("tbody");
                        tableBody.innerHTML = '';  // Clear the current table content

                        // Loop through the returned products and populate the table
                        data.forEach(product => {
                            let row = `<tr>
                                <td>${product.Nombre_Producto}</td>
                                <td>${product.Marca}</td>
                                <td>${product.Stock || 'N/A'}</td>
                                <td>${product.Descripcion}</td>
                                <td class="text-success fw-bold">₡ ${product.Precio_Compra.toFixed(2)}</td>
                                <td class="text-warning fw-bold">₡ ${product.Precio_Venta.toFixed(2)}</td>
                                <td>${product.created_at ? new Date(product.created_at).toLocaleString() : 'N/A'}</td>
                                <td>${product.updated_at ? new Date(product.updated_at).toLocaleString() : 'N/A'}</td>
                                <td>${product.ubicacion || 'N/A'}</td>
                                <td><span class="badge ${product.Estado ? 'bg-success' : 'bg-danger'}">${product.Estado ? 'Activo' : 'Inactivo'}</span></td>
                                <td class="action-table-data text-center">
                                    <div class="edit-delete-action d-flex justify-content-center gap-2">
                                        <a class="me-2 edit-icon p-2" href="{{ url('product-details') }}">
                                            <i data-feather="eye" class="feather-eye"></i>
                                        </a>
                                        <a class="me-2 p-2" href="/edit-product/${product.Id_Producto}">
                                            <i data-feather="edit" class="feather-edit"></i>
                                        </a>
                                        <a href="#" class="btn-change-state" data-id="${product.Id_Producto}" data-bs-toggle="modal" data-bs-target="#confirmStateModal">
                                            <i data-feather="trash-2" class="feather-trash-2"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>`;
                            tableBody.insertAdjacentHTML('beforeend', row);
                        });
                    } else {
                        console.error('Received data is not an array:', data);
                    }
                })
                .catch(error => {
                    console.error('Error fetching search results:', error);
                });
        } else {
            // Optionally, if the search box is empty, you could reload all products
            fetch("/search-products?query=")
                .then(response => response.json())
                .then(data => {
                    let tableBody = document.querySelector("tbody");
                    tableBody.innerHTML = '';  // Clear the current table content

                    data.forEach(product => {
                        let row = `<tr>
                            <td>${product.Nombre_Producto}</td>
                            <td>${product.Marca}</td>
                            <td>${product.Stock || 'N/A'}</td>
                            <td>${product.Descripcion}</td>
                            <td class="text-success fw-bold">₡ ${product.Precio_Compra.toFixed(2)}</td>
                            <td class="text-warning fw-bold">₡ ${product.Precio_Venta.toFixed(2)}</td>
                            <td>${product.created_at ? new Date(product.created_at).toLocaleString() : 'N/A'}</td>
                            <td>${product.updated_at ? new Date(product.updated_at).toLocaleString() : 'N/A'}</td>
                            <td>${product.ubicacion || 'N/A'}</td>
                            <td><span class="badge ${product.Estado ? 'bg-success' : 'bg-danger'}">${product.Estado ? 'Activo' : 'Inactivo'}</span></td>
                            <td class="action-table-data text-center">
                                <div class="edit-delete-action d-flex justify-content-center gap-2">
                                    <a class="me-2 edit-icon p-2" href="{{ url('product-details') }}">
                                        <i data-feather="eye" class="feather-eye"></i>
                                    </a>
                                    <a class="me-2 p-2" href="/edit-product/${product.Id_Producto}">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <a href="#" class="btn-change-state" data-id="${product.Id_Producto}" data-bs-toggle="modal" data-bs-target="#confirmStateModal">
                                        <i data-feather="trash-2" class="feather-trash-2"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>`;
                        tableBody.insertAdjacentHTML('beforeend', row);
                    });
                })
                .catch(error => {
                    console.error('Error fetching all products:', error);
                });
        }
    });
});
