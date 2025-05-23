(function () {

    const addToCartButtons = document.querySelectorAll('.add-to-cart');

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

             const productId = this.getAttribute('data-productid');
        const quantityInput = document.querySelector(`input.product-quantity[data-productid="${productId}"]`);
        const quantity = quantityInput ? parseInt(quantityInput.value) : 1;

            const formData = new FormData();
            formData.append('productId', productId);
            formData.append('quantity', quantity);

            fetch('/cabatuan-ecommece-website/cart-process.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Rsequested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Product added to cart successfully!');
                    // Optionally update cart UI here
                } else {
                    alert('Failed to add product to cart.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    });
})();