const btn = document.getElementById('cart_btn');
const seconds = 5;

/** Counts the elemts inside of the cart variable in
 * sessionStorage
 * 
 * @returns {void}
 */
const count_cart = () => {
    let cart = JSON.parse(sessionStorage.getItem('cart'));
    if (!cart) return;

    let count = cart.length;
    if (count > 0)
        btn.innerHTML = `<i class="counter">${count}</i> Carrello`;
    else
        btn.innerHTML = "Carrello"
}

if (!!btn) {
    count_cart();
    // Updating the counter every `seconds` seconds
    setInterval(count_cart, seconds * 1000)
}
