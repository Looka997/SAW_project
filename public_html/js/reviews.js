let reviews_requested = [];

let fetch_post = (value, callback, node) => {
    fetch("api/reviews.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: value
    })
    .then(response => response.json())
    .then(data => {
        callback(data, node)
    });
};

// given an author, a score and a review content, makes a review node (div (h5, div(img), p) ) )

let constructReview = (author, score, content) => {
    let li = $("<li>");
    let div = $("<div>");
    let h5 = $("<h5>").text(author);
    let p = $("<p>").text(content);
    return li.append(div.append(h5,p));
};

let addReviews = (reviews, node) => {
    console.log(reviews);
    reviews.forEach(element => {
        node.append(constructReview(element.author, element.score, element.content));
    });
}

// On click event
$(".show-reviews").click((event) => {
    let prod_id = event.target.getAttribute('prod_id');
    if (!prod_id) {
        console.log(" [!!!] Button does not have a prod_id");
        return;
    }
    let ul = $("#reviews" + prod_id)
    ul.toggleClass('hidden');
    if (!ul.hasClass('hidden') && !reviews_requested.includes(prod_id)){
        // fetch reviews with prod_id
        fetch_post("prod_id=" + prod_id, addReviews, ul);
        // should maybe be moved to callback?
        reviews_requested.push(prod_id);
    }
});