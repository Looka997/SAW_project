let reviews_requested = [];

let addReviews = (response, node, prod_id) => {
    let reviews = response.reviews;
    if (!reviews) {
        console.log(" [!!!] Reviews era vuota");
    }

    reviews.forEach((element) => {
        if (localStorage.getItem("email")) {
            if (response.id === Number(element.user_id)) {
                removeReviewForm(prod_id);
            }
        }
        node.append(
            constructReview(element.user, element.score, element.content)
        );
    });

    reviews_requested.push(prod_id);
};

// On click event
$(".show-reviews").click((event) => {
    let prod_id = event.target.getAttribute("prod_id");
    if (!prod_id) {
        console.log(" [!!!] Button does not have a prod_id");
        return;
    }
    let ul = $("#reviews" + prod_id);
    let div = ul.parent();
    div.toggleClass("hidden");
    if (!div.hasClass("hidden") && !reviews_requested.includes(prod_id)) {
        // fetch reviews with prod_id
        fetch_post(
            "api/reviews.php",
            "reviews=&product=" + prod_id,
            addReviews,
            ul,
            prod_id
        );
    }
});
