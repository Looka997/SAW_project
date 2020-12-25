let reviewSent = [];
const getOrdersAPI = "api/orders.php";

let displayAlert = (error, prod_id) => {
    let alert_to_show;
    let alert_to_hide;
    if (!!error){
        alert_to_show = $('#alert-danger' + prod_id);
        alert_to_hide = $('#alert-success' + prod_id);
        alert_to_show.children("p").text("La review non è stata inserita correttamente");
    }else{
        alert_to_show = $('#alert-success' + prod_id);
        alert_to_hide = $('#alert-danger' + prod_id);
    }
    if (!alert_to_hide.hasClass('hidden')){
        alert_to_hide.addClass('hidden');
    }
    
    if (alert_to_show.hasClass('hidden')){
        alert_to_show.removeClass('hidden');
    }
}

const showReview = (prod_id) => {
    let author = localStorage.getItem("username");
    if (!author) {
        author = localStorage.getItem("email");
        if (!author) {
            throw new Error(" [!!!] localStorage currupted????");
        }
    }

    let reviewText = $('#review_text' + prod_id).val();
    let reviewScore = $('#review_score' + prod_id).val();

    $("#reviews" + prod_id).append(constructReview(author, reviewScore, reviewText));
}

let onReviewInsert = (response, prod_id) => {
    displayAlert(response.error, prod_id);
    showReview(prod_id);
    removeReviewForm(prod_id);
    updateReviewCounter(prod_id);
    updateAverageScore(prod_id);
};

let submitReview = (reviewScore, reviewText, prod_id) => {
    let request = "score=" + reviewScore + "&content=" + reviewText + "&product=" + prod_id;
    fetch_post("api/send_review.php", request, onReviewInsert, prod_id)
};

$('.review_submit').click((event)=>{
    event.preventDefault();
    let prod_id = event.target.getAttribute('prod_id');

    fetch(getOrdersAPI + "?prod_id=" + prod_id, {
        method: "GET",
        withCredentials: true
    }).then((response) => {
        if (!response.ok) {
            throw new Error(" [!!!] Errore facendo get");
        }
        return response.json();
    }).then((data) => {
        if (!data.confirmed) {
            let alertDiv = $("#alert-danger" + prod_id);
            alertDiv.children("p").text("Per lasciare una review devi prima acquistare questo prodotto");
            alertDiv.removeClass("hidden");
            return;
        }

        if (!reviewSent.includes(prod_id)){
            let reviewText = $('#review_text' + prod_id).val();
            let reviewScore = $('#review_score' + prod_id).val();
            submitReview(reviewScore, reviewText, prod_id);
            reviewSent.push(prod_id);
        }
    });
});

$('.form-range.score-range').on("input", (event) => {
    let review_score = event.target.value;
    let span = $(event.target).parent().children('label.score-review').children("span");
    span.text(review_score);
})