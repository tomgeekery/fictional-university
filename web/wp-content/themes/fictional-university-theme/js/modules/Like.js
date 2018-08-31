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

        if (currentLikeBox.data("exists") == "yes") {
            this.deleteLike();
        } else {
            this.createLike();
        }
    }

    createLike() {
        console.log("create");
    }

    deleteLike() {
        console.log("delete");
    }
}

export default Like;
