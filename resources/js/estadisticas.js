document.addEventListener("DOMContentLoaded", function() {

if ($('#topclientes').length > 0) {
    
    fetch('/top-usuarios')
        .then(response => response.json())
        .then(data => {
            let nombres = data.map(user => user.name);
            let puntos = data.map(user => user.total_puntos);

            var sBar = {
                chart: {
                    height: 350,
                    type: 'bar',
                    toolbar: {
                        show: false,
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                series: [{
                    name: "Puntos",
                    data: puntos
                }],
                xaxis: {
                    categories: nombres,
                    max: Math.max(...puntos) + 500 
                },
                colors: ['#4361ee'], 
                title: {
                    align: "center"
                }
            };

            var chart = new ApexCharts(
                document.querySelector("#topclientes"),
                sBar
            );

            chart.render();
        })
        .catch(error => console.error("Error al obtener datos:", error));
}

 if ($('#total-usuarios').length > 0) {
        fetch('/total-usuarios')
            .then(response => response.json())
            .then(data => {
                $('#total-usuarios').text(data.total_usuarios);
            })
            .catch(error => console.error("Error al obtener el total de usuarios:", error));
    }

    if ($('#total-productos-expirados').length > 0) {
        fetch('/total-productos-expirados')
            .then(response => response.json())
            .then(data => {
                $('#total-productos-expirados').text(data.total_productos_expirados);
            })
            .catch(error => console.error("Error al obtener el total de productos expirados:", error));
    }

    if ($('#total-productos-stock-bajo').length > 0) {
        fetch('/total-productos-stock-bajo')
            .then(response => response.json())
            .then(data => {
                $('#total-productos-stock-bajo').text(data.total_productos_stock_bajo);
            })
            .catch(error => console.error("Error al obtener el total de productos con stock bajo:", error));
    }
    
    if ($('#total-productos-por-vencer').length > 0) {
        fetch('/total-productos-por-vencer')  // Llamamos a la ruta que devuelve el total de productos por vencer
            .then(response => response.json())
            .then(data => {
                // Actualizamos el contenido del elemento con el número de productos por vencer
                $('#total-productos-por-vencer').text(data.total_productos_por_vencer);
            })
            .catch(error => console.error("Error al obtener el total de productos por vencer:", error));
    }
    
    

    if ($('#productos-stock-bajo').length > 0) {
        fetch('/productos-stock-bajo')
            .then(response => response.json())
            .then(data => {
                let tbody = $('#productos-stock-bajo table tbody');
                tbody.empty();
    
                if (data.length === 0) {
                    tbody.append('<tr><td colspan="4" class="text-center">No hay productos con stock bajo</td></tr>');
                } else {
                    data.slice(0, 8).forEach((producto, index) => {
                        tbody.append(`
                            <tr class="datanew">
                                <td>${index + 1}</td>
                                <td class="productimgname">
                                    ${producto.Nombre_Producto}
                                </td>
                                <td>${producto.Marca}</td>
                                <td>${producto.Stock}</td>
                            </tr>
                        `);
                    });
                }
            })
            .catch(error => console.error("Error al obtener productos con stock bajo:", error));
            
    }
    
    
    if (document.querySelector('#productos-expiran')) {
        const tablaBody = document.querySelector('#productos-expiran tbody');

        console.log('hola'); // Ahora correctamente posicionado antes del fetch

        fetch('/productos-a-vencer')
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    let html = '';
                    data.forEach(producto => {
                        html += `
                            <tr>
                                <td>${producto.Nombre_Producto}</td>
                                <td>${producto.Marca}</td>
                                <td>${new Date(producto.Fecha_De_Caducidad).toLocaleDateString()}</td>
                            </tr>
                        `;
                    });
                    tablaBody.innerHTML = html;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                tablaBody.innerHTML = `
                    <tr>
                        <td colspan="3" class="text-center">Error al cargar los datos</td>
                    </tr>
                `;
            });
    }


});