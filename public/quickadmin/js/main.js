$(document).ready(function () {

    var activeSub = $(document).find('.active-sub');
    if (activeSub.length > 0) {
        activeSub.parent().show();
        activeSub.parent().parent().find('.arrow').addClass('open');
        activeSub.parent().parent().addClass('open');
    }

    $('.datatable').dataTable({
        retrieve: true,
        "iDisplayLength": 100,
        "aaSorting": [],
        "aoColumnDefs": [
            {'bSortable': false, 'aTargets': [0]}
        ]
    });
    $('#product').dataTable({
        retrieve: true,
        "iDisplayLength": 100,
        "aaSorting": [],
        "aoColumnDefs": [
            {'bSortable': false, 'aTargets': [0]}
        ]
    });
    $('#brands').dataTable({
        retrieve: true,
        "iDisplayLength": 100,
        "aaSorting": [],
        "aoColumnDefs": [
            {'bSortable': false, 'aTargets': [0]}
        ]
    });

    $('.ckeditor').each(function () {
        CKEDITOR.replace($(this));
    })

    $('.mass').click(function () {
        if ($(this).is(":checked")) {
            $('.single').each(function () {
                if ($(this).is(":checked") == false) {
                    $(this).click();
                }
            });
        } else {
            $('.single').each(function () {
                if ($(this).is(":checked") == true) {
                    $(this).click();
                }
            });
        }
    });

    $('.page-sidebar').on('click', 'li > a', function (e) {

        if ($('body').hasClass('page-sidebar-closed') && $(this).parent('li').parent('.page-sidebar-menu').size() === 1) {
            return;
        }

        var hasSubMenu = $(this).next().hasClass('sub-menu');

        if ($(this).next().hasClass('sub-menu always-open')) {
            return;
        }

        var parent = $(this).parent().parent();
        var the = $(this);
        var menu = $('.page-sidebar-menu');
        var sub = $(this).next();

        var autoScroll = menu.data("auto-scroll");
        var slideSpeed = parseInt(menu.data("slide-speed"));
        var keepExpand = menu.data("keep-expanded");

        if (keepExpand !== true) {
            parent.children('li.open').children('a').children('.arrow').removeClass('open');
            parent.children('li.open').children('.sub-menu:not(.always-open)').slideUp(slideSpeed);
            parent.children('li.open').removeClass('open');
        }

        var slideOffeset = -200;

        if (sub.is(":visible")) {
            $('.arrow', $(this)).removeClass("open");
            $(this).parent().removeClass("open");
            sub.slideUp(slideSpeed, function () {
                if (autoScroll === true && $('body').hasClass('page-sidebar-closed') === false) {
                    if ($('body').hasClass('page-sidebar-fixed')) {
                        menu.slimScroll({
                            'scrollTo': (the.position()).top
                        });
                    }
                }
            });
        } else if (hasSubMenu) {
            $('.arrow', $(this)).addClass("open");
            $(this).parent().addClass("open");
            sub.slideDown(slideSpeed, function () {
                if (autoScroll === true && $('body').hasClass('page-sidebar-closed') === false) {
                    if ($('body').hasClass('page-sidebar-fixed')) {
                        menu.slimScroll({
                            'scrollTo': (the.position()).top
                        });
                    }
                }
            });
        }
        if (hasSubMenu == true || $(this).attr('href') == '#') {
            e.preventDefault();
        }
    });

    $(document).on('change', 'input[type="checkbox"]', function () {
        if ($(this).is(':checked')) {
            $(this).parent().addClass('checked');
        } else {
            $(this).parent().removeClass('checked');
        }
    });

    $(document).on('click', '.radio-option', function () {
        $('input[type="radio"][name="' + $(this).find("input").attr("name") + '"]').each(function () {
            $(this).closest('.radio-option').removeClass('checked');
        })
        if ($(this).find('input').is(':checked')) {
            $(this).addClass('checked');
        } else {
            $(this).removeClass('checked');
        }
    });

    $('.check-option').each(function () {
        if ($(this).find('input[type="checkbox"]').is(':checked')) {
            $(this).addClass('checked');
        }
    });

    $('.radio-option').each(function () {
        if ($(this).find('input[type="radio"]').is(':checked')) {
            $(this).addClass('checked');
        }
    });

    $(document).on('click', '.opening-time .day', function () {
        $(this).toggleClass('active');
        $(this).siblings('ul').slideToggle(250, function () {
            centerModal('#openingModal');
        });
    });

    $(document).on('change', '.time-table li input[type="checkbox"]', function () {
        if ($(this).is(':checked')) {
            $(this).closest('li').addClass('active-strip');
        } else {
            $(this).closest('li').removeClass('active-strip');
        }
    });

    $(document).on('ready ajaxComplete', function () {
        $('.time-table li input[type="checkbox"]').each(function () {
            if ($(this).is(':checked')) {
                $(this).parent().addClass('checked');
                $(this).closest('li').addClass('active-strip');
            } else {
                $(this).parent().removeClass('checked');
                $(this).closest('li').removeClass('active-strip');
            }
        });
    });

    $(document).on('change', '.time-table .opening-hrs input[type="radio"]', function () {
        var selection_val = $('input[name="schedule"]:checked').val();

        if (selection_val == 'is_closed' || selection_val == 'is_24hrs') {
            $('.active-strip').addClass('save-state');
        } else {
            $('.active-strip').removeClass('save-state');
        }
    });

    $(document).on('ready ajaxComplete', function () {
        $('input[name="schedule"]:checked').closest('label').addClass('checked');
    });

    $('.table-availability').each(function () {
        $(this).addClass('table');
    });

    $(document).on('change', "#product_category", function () {
        var elem = this;
        var catId = $(elem).val();
        
        $.ajax({
            url: '/admin/product/getBrand/' + catId,
            method: 'GET',
            data: {},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (result) {
                var html = "<option value=''>Select Brand</option>";
                if (result.status) {
                    $.each(result.data, function (key, value) {
                        html = html + '<option value=' + key + '>' + value + '</option>';
                    });
                }
                $("#brand").html(html);
                if((result.data).length == 0){
                    $("#flavour").html("<option value=''>Select Flavour</option>");
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                //showMessage('error', error_ajax_general);
                console.log("error");
            },
            complete: function () {
                $(elem).removeAttr('disabled');
            }
        });
    });
   
    if($("#product_category").prop('selectedIndex')==0){
        $("#product_category").prop('selectedIndex',  1).change();
    }else if($("#product_category").prop('selectedIndex')!=0 && $('select#brand option').length > 1==false && $('select#flavour option').length > 1==false){
       
        $("#product_category").prop('selectedIndex',  $("#product_category").prop('selectedIndex')).change();
    }
    
    
    $(document).on('change', "#brand", function () {
        var elem = this;
        var brandId = $(elem).val();
        
        $.ajax({
            url: '/admin/product/getFlavour/' + brandId,
            method: 'GET',
            data: {},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function (result) {
                var html = "<option value=''>Select Flavour</option>";
                if (result.status) {
                    $.each(result.data, function (key, value) {
                        html = html + '<option value=' + key + '>' + value + '</option>';
                    });
                }
                $("#flavour").html(html);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                //showMessage('error', error_ajax_general);
                console.log("error");
            },
            complete: function () {
                $(elem).removeAttr('disabled');
            }
        });
    });
    
   
    $('.multiple-selectbox').select2();
    var invalidFile = {};
    $('input[type="file"]').change(function () {
        
        var name = $(this).attr('name');
        var custom = $(this).attr('custom');
        var ext = $(this).val().split('.').pop().toLowerCase();
       
        if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg','svg','JPG','JPEG','PNG', 'SVG']) == -1) {
            $('#' + name + '-error').show();
            $("#create").attr('disabled', 'disabled');
            $('#' + name + '-error').text('Please upload an image file');
            invalidFile[name] = true;
            return;
        }
        

        var maxwidth = parseInt($('input[name="' + name + '_w"]').val());
        var maxheight = parseInt($('input[name="' + name + '_h"]').val());
        var file = $(this)[0].files[0];
        var _URL = window.URL || window.webkitURL;
        img = new Image();
        var imgwidth = 0;
        var imgheight = 0;

        img.src = _URL.createObjectURL(file);
        img.onload = function () {
            imgwidth = this.width;
            imgheight = this.height;

            $("#width").text(imgwidth);
            $("#height").text(imgheight);
            if (custom == 'category') {
                if (imgwidth != maxwidth && imgheight != maxheight) {
                    $('#' + name + '-error').show();
                    $('#' + name + '-error').text('Please upload image of size ' + maxwidth + ' px x ' + maxheight + ' px');
                    $("#create").attr('disabled', 'disabled');
                } else {
                    $('#' + name + '-error').hide();
                    delete invalidFile[name];
                    
                    if(Object.keys(invalidFile).length === 0){
                         
                        $("#create").removeAttr('disabled');
                    }
                }
            } else {
                if (custom == 'icon') { 
                $('#' + name + '-error').hide();
                    if($.inArray(ext, ['svg', 'SVG']) == -1) {
                        $('#' + name + '-error').show();
                        $('#' + name + '-error').text('Please upload an SVG file');
                        $("#create").attr('disabled', 'disabled');
                    }
                
            } else {

                if (imgwidth < maxwidth || imgheight < maxheight) {
                    $('#' + name + '-error').show();
                    $('#' + name + '-error').text('Please upload image of size more than ' + maxwidth + ' px x ' + maxheight + ' px');
                    $("#create").attr('disabled', 'disabled');
                } else if (imgwidth < maxwidth) {
                    $('#' + name + '-error').show();
                    $('#' + name + '-error').text('Please upload image of size ' + maxwidth + ' px x ' + maxheight + ' px');
                    $("#create").attr('disabled', 'disabled');
                } else if (imgwidth < maxheight) {
                    $('#' + name + '-error').show();
                    $('#' + name + '-error').text('Please upload image of size ' + maxwidth + ' px x ' + maxheight + ' px');
                    $("#create").attr('disabled', 'disabled');
                } else {
                    $('#' + name + '-error').hide();
                   
                    delete invalidFile[name];
                     
                    if(Object.keys(invalidFile).length === 0){
                      
                        $("#create").removeAttr('disabled');
                    }
                }
            }
        }
    }
});
});
