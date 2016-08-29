$(function() {
    $(".theme_active").on("click", function() {
        var theme = $(this).data("theme");
        var name  = $(this).data("name");

        if(!confirm(name+" 테마를 적용하시겠습니까?"))
            return false;

        var set_default_skin = 0;
        if($(this).data("set_default_skin") == true) {
            if(confirm("기본환경설정, 1:1문의 스킨을 테마에서 설정된 스킨으로 변경하시겠습니까?\n\n변경을 선택하시면 테마에서 지정된 스킨으로 회원스킨 등이 변경됩니다."))
                set_default_skin = 1;
        }

        $.ajax({
            type: "POST",
            url: "./theme_update.php",
            data: {
                "theme": theme,
                "set_default_skin": set_default_skin
            },
            cache: false,
            async: false,
            success: function(data) {
                if(data) {
                    alert(data);
                    return false;
                }

                document.location.reload();
            }
        });
    });

    $(".theme_deactive").on("click", function() {
        var theme = $(this).data("theme");
        var name  = $(this).data("name");

        if(!confirm(name+" 테마 사용설정을 해제하시겠습니까?\n\n테마 설정을 해제하셔도 게시판 등의 스킨은 변경되지 않으므로 개별 변경작업이 필요합니다."))
            return false;

        $.ajax({
            type: "POST",
            url: "./theme_update.php",
            data: {
                "theme": theme,
                "type": "reset"
            },
            cache: false,
            async: false,
            success: function(data) {
                if(data) {
                    alert(data);
                    return false;
                }

                document.location.reload();
            }
        });
    });

    $(".theme_preview").on("click", function() {
        var theme = $(this).data("theme");

        $("#theme_detail").remove();

        $.ajax({
            type: "POST",
            url: "./theme_detail.php",
            data: {
                "theme": theme
            },
            cache: false,
            async: false,
            success: function(data) {
                $("#theme_list").after(data);
            }
        });
    });

    $('.remote_theme_preview').on('click', function(){
        var theme_detail = null;
        var theme = $(this).data('theme');

        $('#theme_detail').remove();

        $.ajax({
            type: "GET",
            url: "http://api.seohyunco.com/theme/items/id/"+theme,
            success: function(data){
                theme_detail = '<div id="theme_detail"> \
                    <div class="thdt_img"><img src="' + data.screenshot + '" alt="' + data.theme_name + '" /></div> \
                    <div class="thdt_if"> \
                        <h2>' + data.theme_name + '</h2> \
                        <table> \
                            <tr> \
                                <th scope="row">Version</th> \
                                <td>' + data.version + '</td> \
                            </tr> \
                            <tr> \
                                <th scope="row">Maker</th> \
                                <td>' + data.maker + '</td> \
                            </tr> \
                            <tr> \
                                <th scope="row">License</th> \
                                <td>' + data.license + '</td> \
                            </tr> \
                        </table> \
                        <p>' + data.detail + '</p> \
                        <button type="button" class="close_btn">닫기</button> \
                    </div> \
                </div> \
 \
                <script> \
                $(".close_btn").on("click", function() { \
                    $("#theme_detail").remove(); \
                }); \
                </script>';

                $("#theme_list.remote_theme_list").after(theme_detail);
            }
        });
    });

    $('.theme_install').on('click', function(){
        var theme = $(this).data('theme');
        var theme_name = $(this).data('name');
        if (window.confirm('"' + theme_name + '" 테마를 정말 설치하시겠습니까?')) {
            $('body').prepend('<div style="position: fixed;width:100%;height:100%;background-color:rgba(0,0,0,0.5);z-index:9999;"><img src="/adm/img/ajax_loader.gif" alt="loading..." style="position: absolute;top: 50%;left:50%;margin-top: -150px;margin-left: -150px;" /></div>');
            $.ajax({
                type: 'POST',
                url: './theme_install.php',
                data: {theme: theme},
                dataType: 'json',
                success: function(data){
                    if (typeof(data.error) !== 'undefined') {
                        alert(data.error);
                    } else {
                        if (data.success == 'OK') {
                            document.location.href = data.url;
                        } else {
                            alert(data.success);
                            document.location.reload();
                        }
                    }
                }
            });
        }
    });

    $('.theme_uninstall').on('click', function(){
        var theme = $(this).data('theme');
        var theme_name = $(this).data('name');
        if (confirm('설치된 "' + theme_name + '" 테마를 언인스톨하시겠습니까?')) {
            $.ajax({
                type: 'POST',
                url: './theme_uninstall.php',
                data: {theme: theme},
                dataType: 'json',
                success: function(data){
                    if (data.error) {
                        alert(data.error);
                    } else {
                        alert(data.success);
                        document.location.reload();
                    }
                }
            });
        }
    });
});
