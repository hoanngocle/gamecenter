
// Preview Image before upload ========================================================
	function PreviewAvatar() {
	    var oFReader = new FileReader();
	    oFReader.readAsDataURL(document.getElementById("uploadAvatar").files[0]);

	    oFReader.onload = function (oFREvent) {
	        document.getElementById("avatar").src = oFREvent.target.result;
	    };
	};

	// Get image when u chosee file
	function PreviewBanner() {
	    var oFReader = new FileReader();
	    oFReader.readAsDataURL(document.getElementById("uploadBanner").files[0]);

	    oFReader.onload = function (oFREvent) {
	        document.getElementById("banner").src = oFREvent.target.result;
	    };
	};

	// Get image when u chosee file
	function PreviewImage() {
	    var oFReader = new FileReader();
	    oFReader.readAsDataURL(document.getElementById("uploadImage").files[0]);

	    oFReader.onload = function (oFREvent) {
	        document.getElementById("image").src = oFREvent.target.result;
	    };
	};

// CONFIRM DELETE NEWS ======================================================== 
 	function check_delete_news(id){
		var result = confirm("Do You Really Want To Delete?");
		if (result == true) {
		    window.location="delete_news.php?nid="+id;
		    return true;
		    }
		return false;
		}
                
// CONFIRM DELETE VIDEO ======================================================== 
 	function check_delete_video(id){
		var result = confirm("Do You Really Want To Delete?");
		if (result == true) {
		    window.location="delete_video.php?vid="+id;
		    return true;
		    }
		return false;
		}
                
// CONFIRM DELETE IMAGES ======================================================== 
 	function check_delete_image(id){
		var result = confirm("Do You Really Want To Delete?");
		if (result == true) {
		    window.location="delete_image.php?iid="+id;
		    return true;
		    }
		return false;
		}

// DELETE SUCCESS ======================================================== 
	function delete_success(){
			alert('Xóa thành công!');
	}
        
// DELETE FAIL ======================================================== 
	
	// thong bao xoa that bai
	function delete_fail(){
			alert('Xóa chưa thành công!');
			
	}
