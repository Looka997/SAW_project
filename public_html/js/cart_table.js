let table = undefined;

/** Calls the cartRemove function and refreshes the table
 * 
 * @param {Number} uid 
 */
const removeRow = (uid) => {
    cartRemove(uid);
    updateTable();
};

/** Does the POST request to the api end point and
 * updates/creates the table if there's at least one
 * item in the cart, writes a message if it's empty
 * 
 * @returns {void}
 */
const updateTable = () => {
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
        if (!!table) table.destroy();
        if (result.length > 0) {
            table = $('#cart').DataTable({
                data: result,
                columns: [
                    { name: 'Nome', data: 'name' },
                    { name: 'Modello', data: 'model' },
                    { name: 'Prezzo', data: 'price' },
                    { name: 'Autore', data: 'username' },
                    { data: "uid" , render : function ( data, type ) {
                        return type === 'display'
                            ? '<button onclick="removeRow(' + data + ')" >Rimuovi</button>'
                            : data;
                    } },
                ]
            });
        } else {
            $('#cont').html("<span>Nessun oggetto nel carrello</span>");
        }
    });
};

window.onload = updateTable;
