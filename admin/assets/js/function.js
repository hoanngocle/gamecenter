    // Preview Image before upload ========================================================
    function PreviewAvatar() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadAvatar").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("avatar").src = oFREvent.target.result;
        };
    }
    ;

    // Get image when u chosee file
    function PreviewBanner() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadBanner").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("banner").src = oFREvent.target.result;
        };
    }
    ;

    // Get image when u chosee file
    function PreviewImage() {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById("image").src = oFREvent.target.result;
        };
    }
    ;

    // CONFIRM DELETE NEWS ========================================================
    function check_delete_news(id) {
        var result = confirm("Do You Really Want To Delete?");
        if (result == true) {
            window.location = "delete_news.php?nid=" + id;
            return true;
        }
        return false;
    }

    // CONFIRM DELETE VIDEO ========================================================
    function check_delete_video(id) {
        var result = confirm("Do You Really Want To Delete?");
        if (result == true) {
            window.location = "delete_video.php?vid=" + id;
            return true;
        }
        return false;
    }

    // CONFIRM DELETE IMAGES ========================================================
    function check_delete_image(id) {
        var result = confirm("Do You Really Want To Delete?");
        if (result == true) {
            window.location = "delete_image.php?iid=" + id;
            return true;
        }
        return false;
    }

    // CONFIRM DELETE NEWS ========================================================
    function check_delete_games(id) {
        var result = confirm("Do You Really Want To Delete?");
        if (result == true) {
            window.location = "delete_games.php?gid=" + id;
            return true;
        }
        return false;
    }

    // CHANGE STATUS USER ========================================================
    function change_status_user(id, stt) {
        if (stt === 1) {
            var result = confirm("Do You Really Want To Block User?");
        } else {
            var result = confirm("Do You Really Want To Unblock User?");
        }

        if (result == true) {
            window.location = "change_user.php?uid=" + id + "&stt=" + stt;
            return true;
        }
        return false;
    }

    // CHANGE STATUS USER ========================================================
    function change_status_news(id, stt) {
        var result = confirm("Do You Really Want To Change Status?");
        if (result == true) {
            window.location = "change_news.php?nid=" + id + "&stt=" + stt;
            return true;
        }
        return false;
    }

    // CHANGE STATUS GAMES ========================================================
    function change_status_game(id, stt) {
        var result = confirm("Do You Really Want To Change Status?");
        if (result == true) {
            window.location = "change_game.php?nid=" + id + "&stt=" + stt;
            return true;
        }
        return false;
    }

    // CHANGE STATUS USER ========================================================
    function change_status_image(id, stt) {
        var result = confirm("Do You Really Want To Change Status?");

        if (result == true) {
            window.location = "change_image.php?iid=" + id + "&stt=" + stt;
            return true;
        }
        return false;
    }

    // CHANGE STATUS USER ========================================================
    function change_status_video(id, stt) {
        var result = confirm("Do You Really Want To Change Status?");

        if (result == true) {
            window.location = "change_video.php?vid=" + id + "&stt=" + stt;
            return true;
        }
        return false;
    }
