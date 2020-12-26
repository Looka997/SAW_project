let fetch_post = (url, value, callback, ...params) => {
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: value
    })
    .then(response => response.json())
    .then(data => {
        callback(data,...params)
    });
};

let removeReviewForm = (prod_id) => {
    let parent_form = $("#review_text" + prod_id).parent();
    parent_form.remove();
};

let getReviewCounterNode = (prod_id) => {
    let parent_div = $('#alert-success' + prod_id).parent().parent();
    return parent_div.children('.show-reviews');
}

let setReviewCounter = (data, prod_id) => {
    let node = getReviewCounterNode(prod_id);
    node.html("Questo design ha " + data.count +" reviews");
}
let updateReviewCounter = (prod_id) => {
    let request = "count=" + "&product=" + prod_id;
    fetch_post("api/reviews.php", request, setReviewCounter, prod_id);
};

let setAverageScore = (data, prod_id) => {
    let node = $('#avg_score' + prod_id);
    node.text("Voto medio: " + data.avg_score);
}
let updateAverageScore = (prod_id) => {
    let request = "avg_score=" + "&product=" + prod_id;
    fetch_post("api/reviews.php", request, setAverageScore, prod_id);
};

// given an author, a score and a review content, makes a review node (div (h4, div, p) ) )

let constructReview = (author, score, content) => {
    let li = $("<li class=\"py-2 my-1\">");
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
