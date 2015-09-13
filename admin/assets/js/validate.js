// validate news insert form
function validationNews(){
    var title = document.forms['add_news']['title'].value;
    var type = document.forms['add_news']['type'].value;
    var image = document.forms['add_news']['myAvatar'].value;
    var banner = document.forms['add_news']['myBanner'].value;
    var status = document.forms['add_news']['title'].value;
    
    if(title == "" || title == NULL){
        document.getElementById('error_news').innerHTML = "moemeo";
        return false;
    }
}

