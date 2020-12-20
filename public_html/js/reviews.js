let reviews_requested = [];

let fetch_post = (value, callback, ...params) => {
    fetch("api/reviews.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: value
    })
    .then(response => response.json())
    .then(data => {
        callback(data, ...params)
    });
};

// given an author, a score and a review content, makes a review node (div (h4, div, p) ) )

let constructReview = (author, score, content) => {
    let li = $("<li>");
    let div = $("<div>");
    let h4 = $("<h4>").text(author);
    let p_score = $("<p>").text("Voto: " + score + "/5.0");
    let p_content = $("<p>");
    if (content){
        p_content.text(content);
    }else{
        p_content.text( "Nessuna recensione fornita da questo utente");
        p_content.addClass("greyed");
    }
    return li.append(div.append(h4, p_score, p_content));
};

let addReviews = (response, node, prod_id) => {
    let reviews = response.reviews;
    if (!reviews) {
        console.log(" [!!!] Reviews era vuota");
    }

    reviews.forEach(element => {
        if (response.id === Number(element.user_id)) {
            let parent_form = $("#review_text" + prod_id).parent();
            parent_form.remove();
        }

        node.append(constructReview(element.user, element.score, element.content));
    });

    reviews_requested.push(prod_id);
}

// On click event
$(".show-reviews").click((event) => {
    let prod_id = event.target.getAttribute('prod_id');
    if (!prod_id) {
        console.log(" [!!!] Button does not have a prod_id");
        return;
    }
    let ul = $("#reviews" + prod_id)
    let div = ul.parent();
    div.toggleClass('hidden');
    if (!div.hasClass('hidden') && !reviews_requested.includes(prod_id)){
        // fetch reviews with prod_id
        fetch_post("prod_id=" + prod_id, addReviews, ul, prod_id);
    }
});

