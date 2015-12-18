/* #####################################################################
 #
 #   File          : Login Modal Popup JQuery
 #   Project       : Game Magazine Project
 #   Author        : Béo Sagittarius
 #   Created       : 07/29/2015
 #   Last Change   : 10/14/2015
 #
 ##################################################################### */

$(function () {

    var $formProfile = $('#profile-form');
    var $formUpdate = $('#update-form');
    var $formChangePass = $('#changepass-form');
    var $divFormsProfile = $('#div-forms-profile');
    var $modalAnimateTime = 300;
    var $msgAnimateTime = 150;
    var $msgShowTime = 4000;

    $("form").submit(function () {
        switch (this.id) {
            case "update-form":
                var $upd_firstname = $('#change_firstname').val();
                var $upd_lastname = $('#change_lastname').val();
                var $upd_website = $('#change_website').val();
                var $upd_bio = $('#change_bio').val();
                
                var $upd_day = $('select[name=changeday]').val();
                var $upd_month = $('select[name=changemonth]').val();
                var $upd_year = $('select[name=changeyear]').val();

                var $upd_dateofbirth = "" +$upd_day + '-' + $upd_month + '-' + $upd_year + "";
                var dataString = 'firstname=' + $upd_firstname
                                + '&lastname=' + $upd_lastname 
                                + '&website=' + $upd_website
                                + '&bio=' + $upd_bio
                                + '&dateofbirth=' + $upd_dateofbirth;
                if ($upd_firstname == ""){
                    msgChange($('#div-update-msg'), $('#icon-update-msg'), $('#text-update-msg'), "error", "glyphicon-remove", "Firstname is required");
                } else if ($upd_lastname == ""){
                    msgChange($('#div-update-msg'), $('#icon-update-msg'), $('#text-update-msg'), "error", "glyphicon-remove", "Lastname is required");
                }  else if ($upd_day == "" || $upd_month == "" || $upd_year == ""){
                    msgChange($('#div-update-msg'), $('#icon-update-msg'), $('#text-update-msg'), "error", "glyphicon-remove", "Date Of Birth is required");
                } else if ($upd_day == "31" && ( $upd_month == "4" || $upd_month == "6" || $upd_month == "9" || $upd_month == "11" )){
                    msgChange($('#div-update-msg'), $('#icon-update-msg'), $('#text-update-msg'), "error", "glyphicon-remove", "Date Of Birth is invalid");                    
                } else if ($upd_month == "2" && ( $upd_day == "30" || $upd_day == "31" || $upd_day == "29")){
                    msgChange($('#div-update-msg'), $('#icon-update-msg'), $('#text-update-msg'), "error", "glyphicon-remove", "Date Of Birth is invalid");                   
                } 
                      
                //==========================
                else {
                    $.ajax({
                        type: "POST",
                        url: "change_profile.php",
                        dataType: "json",
                        data: dataString,
                        success: function (response) {
                            if (response.status == "OK" ){
                                msgChange($('#div-update-msg'), $('#icon-update-msg'), $('#text-update-msg'), "success", "glyphicon-ok", "Update profile successfully.");
                                interval = setInterval(
                                        function(){
                                            $('#profile-modal').modal('hide');
                                            location.href = 'index.php';
                                            clearInterval(interval);
                                        }
                                , 1500);             
                            } else if(response.status == "FAIL"){              
                                msgChange($('#div-update-msg'), $('#icon-update-msg'), $('#text-update-msg'), "error", "glyphicon-remove", "Update profile failed.");

                            }
                        }
                    }); 
                }
                return false;
                break;
                
            case "changepass-form":
                var $cg_oldpass = $('#old_pass').val();
                var $cg_newpass = $('#new_pass').val();
                var $cg_renewpass = $('#renew_pass').val();
                var dataString = 'oldpass=' + $cg_oldpass + '&newpass=' + $cg_newpass ;
                if ($cg_oldpass == "") {
                    msgChange($('#div-change-msg'), $('#icon-change-msg'), $('#text-change-msg'), "error", "glyphicon-remove", "Old password is required");
                }else if ($cg_newpass == ""){
                    msgChange($('#div-change-msg'), $('#icon-change-msg'), $('#text-change-msg'), "error", "glyphicon-remove", "New password is required"); 
                }else if($cg_renewpass == ""){
                    msgChange($('#div-change-msg'), $('#icon-change-msg'), $('#text-change-msg'), "error", "glyphicon-remove", "Confirm password is required");
                }else {
                    $.ajax({
                        type: "POST",
                        url: "changepass.php",
                        dataType: "json",
                        data: dataString,
                        success: function (response) {
                            if (response.status == "OK" ){
                                msgChange($('#div-change-msg'), $('#icon-change-msg'), $('#text-change-msg'), "success", "glyphicon-remove", "Change password success!");
                                    interval = setInterval(
                                        function(){
                                            $('#login-modal').modal('hide');
                                            location.href = 'index.php';
                                            clearInterval(interval);
                                        }
                                , 1500);            
                            }else if(response.status == "FAIL"){
                                msgChange($('#div-change-msg'), $('#icon-change-msg'), $('#text-change-msg'), "error", "glyphicon-remove", "Change password failed");
                            }else if(response.status == "CHECK FAIL") {
                                msgChange($('#div-change-msg'), $('#icon-change-msg'), $('#text-change-msg'), "error", "glyphicon-remove", "Old password is incorrect");

                            }
                        }
                    });                  
                }
                return false;
                break;
                
            
            default:
                return false;
        }
        return false;
    });

    $('#profile_update_btn').click(function () {
        modalAnimate($formProfile, $formUpdate)
    });
    $('#profile_changepass_btn').click(function () {
        modalAnimate($formProfile, $formChangePass);
    });
    $('#update_view_btn').click(function () {
        modalAnimate($formUpdate, $formProfile);
    });
    $('#update_changepass_btn').click(function () {
        modalAnimate($formUpdate, $formChangePass);
    });
    $('#changepass_view_btn').click(function () {
        modalAnimate($formChangePass, $formProfile);
    });
    $('#changepass_update_btn').click(function () {
        modalAnimate($formChangePass, $formUpdate);
    });

    function modalAnimate($oldForm, $newForm) {
        var $oldH = $oldForm.height();
        var $newH = $newForm.height();
        $divFormsProfile.css("height", $oldH);
        $oldForm.fadeToggle($modalAnimateTime, function () {
            $divFormsProfile.animate({height: $newH}, $modalAnimateTime, function () {
                $newForm.fadeToggle($modalAnimateTime);
            });
        });
    }

    function msgFade($msgId, $msgText) {
        $msgId.fadeOut($msgAnimateTime, function () {
            $(this).text($msgText).fadeIn($msgAnimateTime);
        });
    }

    function msgChange($divTag, $iconTag, $textTag, $divClass, $iconClass, $msgText) {
        var $msgOld = $divTag.text();
        msgFade($textTag, $msgText);
        $divTag.addClass($divClass);
        $iconTag.removeClass("glyphicon-chevron-right");
        $iconTag.addClass($iconClass + " " + $divClass);
        setTimeout(function () {
            msgFade($textTag, $msgOld);
            $divTag.removeClass($divClass);
            $iconTag.addClass("glyphicon-chevron-right");
            $iconTag.removeClass($iconClass + " " + $divClass);
        }, $msgShowTime);
    }
});