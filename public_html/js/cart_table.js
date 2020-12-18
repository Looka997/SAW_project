
window.onload = () => {
    let cart_str = sessionStorage.getItem('cart');
    if (!cart_str) return;
    payload = "cart=" + cart_str;

    fetch("api/cart.php", {
        method: "POST",
        headers: {
            "content-type": "application/x-www-form-urlencoded"
        },
        body: payload
    })
    .then(response => response.json())
    .then(result => {
        $('#cart').DataTable({
            data: result,
            columns: [
                { data: 'name' },
                { data: 'model' },
                { data: 'price' },
                { data: 'username' }
            ]
        });
    });
};
