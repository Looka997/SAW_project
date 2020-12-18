const keyName = "cart";

/** Checks if the cart exists.
 * If it does, it also checks if the content of it is valid.
 * Else it creates an empty cart.
 * 
 * @returns {void}
 */
const checkCreateCart = () => {
    const item = sessionStorage.getItem(keyName);
    if (item && item.length !== 0 && Array.isArray(JSON.parse(item))) {
        return;
    }

    sessionStorage.setItem(keyName, JSON.stringify([]));
};

/** Adds an element to the cart.
 * This function is not responsible to check if the cart exists
 * and will throw an exception if it doesn't.
 * 
 * @param {Number} element 
 */
const cartAdd = (element) => {
    let cart = JSON.parse(sessionStorage.getItem(keyName));
    cart.push({uid: Math.floor(Math.random() * 40000), id: element});
    sessionStorage.setItem(keyName, JSON.stringify(cart));
};

/** Removes an element from the cart using its uid
 * 
 * @param {Number} uid 
 */
const cartRemove = (uid) => {
    let cart = JSON.parse(sessionStorage.getItem(keyName));
    cart = cart.filter(element => element.uid !== uid);
    sessionStorage.setItem(keyName, JSON.stringify(cart));
};

// On click event
$(".prod_btn").click((event) => {
    let prod_id = event.target.getAttribute('prod_id');
    if (!prod_id) {
        console.log(" [!!!] Button does not have a prod_id");
        return;
    }

    checkCreateCart();
    cartAdd(Number(prod_id));
    count_cart();
});