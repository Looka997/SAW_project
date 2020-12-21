const keyName = "cart";
const btnText = "Aggiungi al carrello";
const btnTextPressed = "Aggiunto";
const textAnimSeconds = 1;
const ordersAPI = "api/orders.php";

/** Checks if the cart exists.
 * If it does, it also checks if the content of it is valid.
 * Else it creates an empty cart.
 * 
 * @returns {void}
 */
const checkCreateCart = () => {
    const item = localStorage.getItem(keyName);
    if (item && item.length !== 0 && Array.isArray(JSON.parse(item))) {
        return;
    }

    localStorage.setItem(keyName, JSON.stringify([]));
};

/** Adds an element to the cart.
 * This function is not responsible to check if the cart exists
 * and will throw an exception if it doesn't.
 * 
 * @param {Number} element 
 */
const cartAdd = (element) => {
    let cart = JSON.parse(localStorage.getItem(keyName));
    cart.push(element);
    localStorage.setItem(keyName, JSON.stringify(cart));
};

/** Removes an element from the cart
 * 
 * @param {Number} item_id 
 */
const cartRemove = (item_id) => {
    let cart = JSON.parse(localStorage.getItem(keyName));
    let index = cart.indexOf(item_id);
    if (index < 0) {
        console.log(` [!!!] Error removing an item from the cart\nid: ${item_id}`);
        return;
    }
    cart.splice(index, 1);
    localStorage.setItem(keyName, JSON.stringify(cart));
};

/** Overrides the localStorage with an empty cart
 * 
 * @returns {void}
 */
const cartEmpty = () => {
    localStorage.setItem(keyName, JSON.stringify([]));
};

/** Complete order  
 * This does the POST request to add the elements to the orders Table
 * and empties the cart;
 */
const cartCompleteOrder = () => {
    let cartVal = localStorage.getItem(keyName);
    if (!cartVal) {
        console.log(" [!!!] Error fetching cart for cartCompleteOrder");
        return;
    }
    
    let cartArr = JSON.parse(cartVal);
    if (!Array.isArray(cartArr)) {
        console.log(" [!!!] cartCompleteOrder received a value that wasn't an array");
        return;
    }

    let body = "cart=" + cartVal;
    fetch(ordersAPI, {
        method: "POST",
        withCredentials: true,
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: body
    }).then((response) => {
        if (!response.ok) {
            throw new Error(" [!!!] Error on API: HTTP status " + response.status);
        }
    });
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
    event.target.innerHTML = btnTextPressed;
    let interval = setInterval(() => {
        event.target.innerHTML = btnText;
        clearInterval(interval);
    }, textAnimSeconds * 1000);
});