let table = undefined;

/** Calls the cartRemove function and refreshes the table
 * 
 * @param {Number} id 
 */
const removeRow = (id) => {
    cartRemove(id);
    updateTable();
};

/** Does the POST request to the api end point and
 * updates/creates the table if there's at least one
 * item in the cart, writes a message if it's empty
 * 
 * @returns {void}
 */
const updateTable = () => {
    let cart_str = localStorage.getItem('cart');
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
                    { title: 'Nome Design', data: 'name' },
                    { title: 'Modello', data: 'model' },
                    { title: 'Prezzo', data: 'price' },
                    { title: 'Autore', data: 'username' },
                    { title: 'Rimuovi', data: "id" , render : function ( data, type ) {
                        return type === 'display'
                            ? '<button class="btn btn-danger" onclick="removeRow(' + data + ')" >Rimuovi</button>'
                            : data;
                    } },
                ],
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true
            });
        } else {
            $('#buy_btn').hide();
            $('#cont').html("<h1 id='cart'>OPS, non hai oggetti nel carrello. " + 
                "<br> Rendi felice Pablo e aggiungi almeno un design!</h1>" + 
                "<div class='text-center'>" +
                "<img class='cart-img' src='assets/pablo.jpg' alt='Pablo Escobar'>" +
                "</div>"
            );
        }
    });
};

window.onload = updateTable;

$("#buy_btn").click(() => {
    cartCompleteOrder(() => {
        updateTable();
        location.href = "view_designs.php";
    });
});
