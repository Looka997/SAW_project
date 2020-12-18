const btn = document.getElementById('cart_btn');
const seconds = 5;

if (!!btn) {
    // Updating the counter every `seconds` seconds
    setInterval(() => {
        let cart = localStorage.getItem('cart');
        if (!cart) return;

        let count = cart.length;
        if (count > 0)
            btn.innerHTML = `<i class="counter">${count}</i> Carrello`;
        else
            btn.innerHTML = "Carrello"
    }, seconds * 1000)
}
