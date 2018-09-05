import $ from "jquery";

class Like {
    constructor() {
        this.events();
    }

    events() {
        $(".like-box").on("click", this.ourClickDispatcher.bind(this));
    }

    // Methods
    ourClickDispatcher(event) {
        var currentLikeBox = $(event.target).closest(".like-box");

        if (currentLikeBox.attr("data-exists") == "yes") {
            this.deleteLike(currentLikeBox);
        } else {
            this.createLike(currentLikeBox);
        }
    }

    createLike(currentLikeBox) {
        $.ajax({
            url: universityData.root_url + '/wp-json/university/v1/like',
            type: 'POST',
            data: {"professorId": currentLikeBox.data("professor")},
            error: (response) => console.log(response),
            beforeSend: (xhr) => {
                xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
            },
            success: (response) => {
                var likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10);

                // Increase the like count.
                likeCount++;

                // Modify the like box to show the new like.
                currentLikeBox.attr("data-exists", "yes");
                currentLikeBox.attr("data-like", response);
                currentLikeBox.find(".like-count").html(likeCount);
            },
        });
    }

    deleteLike(currentLikeBox) {
        $.ajax({
            url: universityData.root_url + '/wp-json/university/v1/like',
            data: {"like": currentLikeBox.attr("data-like")},
            type: 'DELETE',
            error: (response) => console.log(response),
            success: (response) => {
                var likeCount = parseInt(currentLikeBox.find(".like-count").html(), 10);

                // Decrease the like count.
                likeCount--;

                // Modify the like box to remove the like.
                currentLikeBox.attr("data-exists", "no");
                currentLikeBox.attr("data-like", '');
                currentLikeBox.find(".like-count").html(likeCount);
            },
            beforeSend: (xhr) => {
                xhr.setRequestHeader("X-WP-Nonce", universityData.nonce);
            },
        });
    }
}

export default Like;
