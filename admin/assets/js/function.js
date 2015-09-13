	// Get image when u chosee file
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

// #########################################################################################

	// comfirm delete request
 	function check_delete(id){
		var result = confirm("Do You Really Want To Delete?");
		if (result == true) {
		    window.location="delete_news.php?nid="+id;
		    return true;
		    }
		return false;
		}

// #########################################################################################

	// thong bao xoa thanh cong
	function delete_success(){
			alert('Xóa thành công!');
	}
        
// #########################################################################################
	
	// thong bao xoa that bai
	function delete_fail(){
			alert('Xóa chưa thành công!');
			
	}
        
// #########################################################################################
