<html>
    <head>
        <title></title>
        <script>
        function validate_news(){
            var title = document.forms['add_news']['title'].value;
            if (title == ""||title==null) {
                document.getElementById('errors_news').innerHTML = 'Khong duoc bo trong email!';
                $('#errors_news').addClass('alert alert-warning');
            return false;
            }
            
        </script>
    </head>
    <body>
        <form id="add_news" action="" method="post" enctype="multipart/form-data">
                <div class="form-group"  style="font-size: 18px" >
                    <label for="title">Title</label>
                    <input style="font-size: 18px; height: 44px" type="text" class="form-control" id="title" name="title" placeholder="Enter title " />
                    <div id=errors_news" style='font-size: 14px; padding: 5px 5px 5px 12px; margin-top: 15px'>

                    </div>
                    <input type="submit" name="submit" class="btn btn-success" style="font-size: 18px; height: 44px; margin-right: 10px"  onsubmit="return validate_news();" value="Submit">
                </div>     
        </form>
    </body>
</html>
