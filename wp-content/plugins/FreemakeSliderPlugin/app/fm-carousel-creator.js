(function($) {
    $(document).ready(function() {
        $(".fm-engine").css({
            display: "none"
        });
        $(".fm-tab-buttons-horizontal").each(function() {
            $(this).find("li").each(function(index) {
                $(this).click(function() {
                    if ($(this).hasClass("fm-tab-button-horizontal-selected")) return;
                    $(this).parent().find("li").removeClass("fm-tab-button-horizontal-selected");
                    $(this).addClass("fm-tab-button-horizontal-selected");
                    var panelsID = $(this).parent().data("panelsid");
                    $("#" + panelsID).children("li").removeClass("fm-tab-horizontal-selected");
                    $("#" + panelsID).children("li").eq(index).addClass("fm-tab-horizontal-selected")
                })
            })
        });
        $("#fm-carousel-fixaspectratio").click(function() {
            if ($(this).is(":checked")) {
                $("#fm-carousel-sameheight").prop("checked", false);
                $("#fm-carousel-fitimage").prop("checked", false)
            }
        });
        $("#fm-carousel-sameheight").click(function() {
            if ($(this).is(":checked")) {
                $("#fm-carousel-fixaspectratio").prop("checked", false);
                $("#fm-carousel-fitimage").prop("checked",
                    false)
            }
        });
        $("#fm-carousel-fitimage").click(function() {
            if ($(this).is(":checked")) {
                $("#fm-carousel-fixaspectratio").prop("checked", false);
                $("#fm-carousel-sameheight").prop("checked", false)
            }
        });
        $("#fm-carousel-toolbar").find("li").each(function(index) {
            $(this).click(function() {
                if ($(this).hasClass("fm-tab-buttons-selected")) return;
                $(this).parent().find("li").removeClass("fm-tab-buttons-selected");
                if (!$(this).hasClass("laststep")) $(this).addClass("fm-tab-buttons-selected");
                $("#fm-carousel-tabs").children("li").removeClass("fm-tab-selected");
                $("#fm-carousel-tabs").children("li").eq(index).addClass("fm-tab-selected");
                $("#fm-carousel-tabs").removeClass("fm-tabs-grey");
                if (index == 3) {
                    previewCarousel();
                    $("#fm-carousel-tabs").addClass("fm-tabs-grey")
                } else if (index == 4) publishCarousel()
            })
        });
        var getURLParams = function(href) {
            var result = {};
            if (href.indexOf("?") < 0) return result;
            var params = href.substring(href.indexOf("?") +
                1).split("&");
            for (var i = 0; i < params.length; i++) {
                var value = params[i].split("=");
                if (value && value.length == 2 && value[0].toLowerCase() != "v") result[value[0].toLowerCase()] = value[1]
            }
            return result
        };
        var addMediaToList = function(data) {
            if ($("#fm-newestfirst").is(":checked")) fm_carousel_config.slides.unshift(data);
            else fm_carousel_config.slides.push(data)
        };
        var slideDialog = function(dialogType, onSuccess, data, dataIndex) {
            var dialogTitle = ["image", "video", "Youtube Video", "Vimeo Video"];
            var dialogCode =
                "<div class='fm-dialog-container'>" + "<div class='fm-dialog-bg'></div>" + "<div class='fm-dialog'>" + "<h3 id='fm-dialog-title'></h3>" + "<div class='error' id='fm-dialog-error' style='display:none;'></div>" + "<table id='fm-dialog-form'>";
            if (dialogType == 2 || dialogType == 3) dialogCode += "<tr>" + "<th>Insert video URL</th>" + "<td><input name='fm-dialog-video' type='text' id='fm-dialog-video' value='' class='regular-text' /> <input type='button' class='button' id='fm-dialog-select-video' value='Enter' /></td>" +
                "</tr>" + "<tr>";
            dialogCode += "<tr>" + "<th>Enter" + (dialogType > 0 ? " poster" : "") + " image URL</th>" + "<td><input name='fm-dialog-image' type='text' id='fm-dialog-image' value='' class='regular-text' /> or <input type='button' class='button' data-textid='fm-dialog-image' id='fm-dialog-select-image' value='Upload' /></td>" + "</tr>" + "<tr id='fm-dialog-image-display-tr' style='display:none;'>" + "<th></th>" + "<td><img id='fm-dialog-image-display' style='width:80px;height:80px;' /></td>" +
                "</tr>" + "<tr>" + "<th>Thumbnail URL</th>" + "<td>" + "<input name='fm-dialog-thumbnail' type='text' id='fm-dialog-thumbnail' value='' class='regular-text' /> or <input type='button' class='button' data-textid='fm-dialog-thumbnail' id='fm-dialog-select-thumbnail' value='Upload' /> <br/>" + "<label><input name='fm-dialog-displaythumbnail' type='checkbox' id='fm-dialog-displaythumbnail' value='' />Use thumbnail in slider</label>" + "</td>" + "</tr>";
            if (dialogType == 1) dialogCode += "<tr>" + "<th>MP4 video URL</th>" + "<td><input name='fm-dialog-mp4' type='text' id='fm-dialog-mp4' value='' class='regular-text' /> or <input type='button' class='button' data-textid='fm-dialog-mp4' id='fm-dialog-select-mp4' value='Upload' /></td>" + "</tr>" + "<tr>" + "<tr>" + "<th>WebM video URL (Optional)</th>" + "<td><input name='fm-dialog-webm' type='text' id='fm-dialog-webm' value='' class='regular-text' /> or <input type='button' class='button' data-textid='fm-dialog-webm' id='fm-dialog-select-webm' value='Upload' /></td>" +
                "</tr>" + "<tr>";
            dialogCode += "<tr>" + "<th>Title</th>" + "<td><input name='fm-dialog-image-title' type='text' id='fm-dialog-image-title' value='' class='large-text' /></td>" + "</tr>" + "<tr>" + "<th>Description</th>" + "<td><textarea name='fm-dialog-image-description' type='' id='fm-dialog-image-description' value='' class='large-text' /></td>" + "</tr>";
            dialogCode += "<tr>" + "<th>Show in Lightbox</th>" + "<td><label><input name='fm-dialog-lightbox' type='checkbox' id='fm-dialog-lightbox' value='' checked /> Open current " +
                dialogTitle[dialogType] + " in Lightbox</label>" + "</tr>" + "<tr><th>Lightbox size</th>" + "<td><label><input name='fm-dialog-lightbox-size' type='checkbox' id='fm-dialog-lightbox-size' value='' /> Set Lightbox size (px) </label>" + " <input name='fm-dialog-lightbox-width' type='text' id='fm-dialog-lightbox-width' value='640' class='small-text' /> / <input name='fm-dialog-lightbox-height' type='text' id='fm-dialog-lightbox-height' value='480' class='small-text' />" +
                "</td>" + "</tr>";
            if (dialogType == 0) dialogCode += "<tr><th>Or click to open web link</th>" + "<td>" + "<input name='fm-dialog-weblink' type='text' id='fm-dialog-weblink' value='' class='large-text' disabled /><br />Uncheck the option \"Open current image in Lightbox\" to enable weblink" + "</td>" + "</tr>" + "<tr><th>Set web link onclick code</th>" + "<td>" + "<input name='fm-dialog-clickhandler' type='text' id='fm-dialog-clickhandler' value='' class='large-text' disabled />" +
                "</td>" + "</tr>" + "<tr><th>Set web link target</th>" + "<td>" + "<div class='select-editable'><select onchange='this.nextElementSibling.value=this.value' id='fm-dialog-linktarget-select' disabled>" + "<option value=''></option>" + "<option value='_blank'>_blank</option>" + "<option value='_self'>_self</option>" + "<option value='_parent'>_parent</option>" + "<option value='_top'>_top</option>" + "</select>" + "<input name='fm-dialog-linktarget' type='text' id='fm-dialog-linktarget' value='' class='regular-text' disabled /></div>" +
                "</td>" + "</tr>" + "<tr><th></th>" + "<td>" + "<label><input name='fm-dialog-weblinklightbox' type='checkbox' id='fm-dialog-weblinklightbox' value='' /> Open web link in Lightbox</label>" + "</td>" + "</tr>";
            dialogCode += "</table>" + "<br /><br />" + "<div class='fm-dialog-buttons'>" + "<input type='button' class='button button-primary' id='fm-dialog-ok' value='OK' />" + "<input type='button' class='button' id='fm-dialog-cancel' value='Cancel' />" + "</div>" + "</div>" + "</div>";
            var $slideDialog = $(dialogCode);
            $("body").append($slideDialog);
            $(".fm-dialog").css({
                "margin-top": String($(document).scrollTop() + 60) + "px"
            });
            $(".fm-dialog-bg").css({
                height: $(document).height() + "px"
            });
            $("#fm-dialog-lightbox").click(function() {
                var is_checked = $(this).is(":checked");
                if ($("#fm-dialog-weblink").length) $("#fm-dialog-weblink").attr("disabled", is_checked);
                if ($("#fm-dialog-clickhandler").length) $("#fm-dialog-clickhandler").attr("disabled",
                    is_checked);
                if ($("#fm-dialog-linktarget").length) $("#fm-dialog-linktarget").attr("disabled", is_checked);
                if ($("#fm-dialog-linktarget-select").length) $("#fm-dialog-linktarget-select").attr("disabled", is_checked);
                if ($("#fm-dialog-weblinklightbox").length) $("#fm-dialog-weblinklightbox").attr("disabled", is_checked)
            });
            $(".fm-dialog").css({
                "margin-top": String($(document).scrollTop() + 60) + "px"
            });
            $(".fm-dialog-bg").css({
                height: $(document).height() +
                    "px"
            });
            $("#fm-dialog-title").html("Add " + dialogTitle[dialogType]);
            if (data) {
                if (dialogType == 2 || dialogType == 3) $("#fm-dialog-video").val(data.video);
                $("#fm-dialog-image").val(data.image);
                if (data.image) {
                    $("#fm-dialog-image-display-tr").css({
                        display: "table-row"
                    });
                    $("#fm-dialog-image-display").attr("src", data.image)
                }
                $("#fm-dialog-thumbnail").val(data.thumbnail);
                if (data.displaythumbnail) $("#fm-dialog-displaythumbnail").attr("checked", true);
                else $("#fm-dialog-displaythumbnail").attr("checked", false);
                $("#fm-dialog-image-title").val(data.title);
                $("#fm-dialog-image-description").val(data.description);
                if (dialogType == 1) {
                    $("#fm-dialog-mp4").val(data.mp4);
                    $("#fm-dialog-webm").val(data.webm)
                }
                if (dialogType == 0) {
                    $("#fm-dialog-weblink").val(data.weblink);
                    $("#fm-dialog-clickhandler").val(data.clickhandler);
                    $("#fm-dialog-linktarget").val(data.linktarget);
                    $("#fm-dialog-weblink").attr("disabled",
                        data.lightbox);
                    $("#fm-dialog-clickhandler").attr("disabled", data.lightbox);
                    $("#fm-dialog-linktarget").attr("disabled", data.lightbox);
                    $("#fm-dialog-linktarget-select").attr("disabled", data.lightbox);
                    if (data.weblinklightbox) $("#fm-dialog-weblinklightbox").attr("checked", true);
                    else $("#fm-dialog-weblinklightbox").attr("checked", false);
                    $("#fm-dialog-weblinklightbox").attr("disabled", data.lightbox)
                }
                if ("lightbox" in data) $("#fm-dialog-lightbox").attr("checked",
                    data.lightbox);
                if ("lightboxsize" in data) $("#fm-dialog-lightbox-size").attr("checked", data.lightboxsize);
                if (data.lightboxwidth) $("#fm-dialog-lightbox-width").val(data.lightboxwidth);
                if (data.lightboxheight) $("#fm-dialog-lightbox-height").val(data.lightboxheight)
            }
            if (dialogType == 2 || dialogType == 3) $("#fm-dialog-select-video").click(function() {
                var videoData = {
                    type: dialogType,
                    video: $.trim($("#fm-dialog-video").val()),
                    image: $.trim($("#fm-dialog-image").val()),
                    thumbnail: $.trim($("#fm-dialog-thumbnail").val()),
                    title: $.trim($("#fm-dialog-image-title").val()),
                    description: $.trim($("#fm-dialog-image-description").val())
                };
                $slideDialog.remove();
                onlineVideoDialog(dialogType, function(items) {
                    items.map(function(data) {
                        addMediaToList({
                            type: dialogType,
                            image: data.image,
                            thumbnail: data.thumbnail ? data.thumbnail : data.image,
                            displaythumbnail: data.displaythumbnail,
                            video: data.video,
                            mp4: data.mp4,
                            webm: data.webm,
                            title: data.title,
                            description: data.description,
                            weblink: data.weblink,
                            clickhandler: data.clickhandler,
                            linktarget: data.linktarget,
                            weblinklightbox: data.weblinklightbox,
                            lightbox: data.lightbox,
                            lightboxsize: data.lightboxsize,
                            lightboxwidth: data.lightboxwidth,
                            lightboxheight: data.lightboxheight
                        })
                    });
                    updateMediaTable()
                }, videoData, true, dataIndex)
            });
            var media_upload_onclick = function(event) {
                event.preventDefault();
                var buttonId = $(this).attr("id");
                var textId = $(this).data("textid");
                var library_title = buttonId == "fm-dialog-select-image" || buttonId == "fm-dialog-select-thumbnail" ?
                    "Add Image" : "Add Video";
                var library_type = buttonId == "fm-dialog-select-image" || buttonId == "fm-dialog-select-thumbnail" ? "image" : "video";
                var media_uploader = wp.media.frames.file_frame = wp.media({
                    title: library_title,
                    library: {
                        type: library_type
                    },
                    button: {
                        text: library_title
                    },
                    multiple: dialogType == 0 && buttonId == "fm-dialog-select-image"
                });
                media_uploader.on("select", function(event) {
                    var selection = media_uploader.state().get("selection");
                    if (dialogType == 0 && buttonId == "fm-dialog-select-image" &&
                        selection.length > 1) {
                        var items = [];
                        selection.map(function(attachment) {
                            attachment = attachment.toJSON();
                            if (attachment.type != "image") return;
                            var thumbnail;
                            var thumbnailsize = $("#fm-carousel-thumbnailsize").text();
                            if (thumbnailsize && thumbnailsize.length > 0 && attachment.sizes && attachment.sizes[thumbnailsize] && attachment.sizes[thumbnailsize].url) thumbnail = attachment.sizes[thumbnailsize].url;
                            else if (attachment.sizes && attachment.sizes.medium && attachment.sizes.medium.url) thumbnail = attachment.sizes.medium.url;
                            else if (attachment.sizes && attachment.sizes.thumbnail && attachment.sizes.thumbnail.url) thumbnail = attachment.sizes.thumbnail.url;
                            else thumbnail = attachment.url;
                            items.push({
                                image: attachment.url,
                                thumbnail: thumbnail,
                                displaythumbnail: false,
                                title: attachment.title,
                                description: attachment.description,
                                weblink: "",
                                clickhandler: "",
                                weblinklightbox: false,
                                linktarget: "",
                                lightbox: true,
                                lightboxsize: false,
                                lightboxwidth: 640,
                                lightboxheight: 480
                            })
                        });
                        $slideDialog.remove();
                        onSuccess(items)
                    } else {
                        attachment = selection.first().toJSON();
                        if (buttonId == "fm-dialog-select-image") {
                            if (attachment.type != "image") {
                                $("#fm-dialog-error").css({
                                    display: "block"
                                }).html("<p>Please select an image file</p>");
                                return
                            }
                            var thumbnail;
                            var thumbnailsize = $("#fm-carousel-thumbnailsize").text();
                            if (thumbnailsize && thumbnailsize.length > 0 && attachment.sizes && attachment.sizes[thumbnailsize] && attachment.sizes[thumbnailsize].url) thumbnail = attachment.sizes[thumbnailsize].url;
                            else if (attachment.sizes && attachment.sizes.medium && attachment.sizes.medium.url) thumbnail =
                                attachment.sizes.medium.url;
                            else if (attachment.sizes && attachment.sizes.thumbnail && attachment.sizes.thumbnail.url) thumbnail = attachment.sizes.thumbnail.url;
                            else thumbnail = attachment.url;
                            $("#fm-dialog-image-display-tr").css({
                                display: "table-row"
                            });
                            $("#fm-dialog-image-display").attr("src", attachment.url);
                            $("#fm-dialog-image").val(attachment.url);
                            $("#fm-dialog-thumbnail").val(thumbnail);
                            if ($.trim($("#fm-dialog-image-title").val()).length <= 0) $("#fm-dialog-image-title").val(attachment.title);
                            if ($.trim($("#fm-dialog-image-description").val()).length <= 0) $("#fm-dialog-image-description").val(attachment.description)
                        } else if (buttonId == "fm-dialog-select-thumbnail") {
                            if (attachment.type != "image") {
                                $("#fm-dialog-error").css({
                                    display: "block"
                                }).html("<p>Please select an image file</p>");
                                return
                            }
                            $("#fm-dialog-thumbnail").val(attachment.url)
                        } else {
                            if (attachment.type != "video") {
                                $("#fm-dialog-error").css({
                                    display: "block"
                                }).html("<p>Please select a video file</p>");
                                return
                            }
                            $("#" + textId).val(attachment.url)
                        }
                    }
                    $("#fm-dialog-error").css({
                        display: "none"
                    }).empty()
                });
                media_uploader.open()
            };
            if (parseInt($("#fm-carousel-wp-history-media-uploader").text()) == 1) {
                var buttonId = "";
                var textId = "";
                var history_media_upload_onclick = function(event) {
                    buttonId = $(this).attr("id");
                    textId = $(this).data("textid");
                    var mediaType = buttonId == "fm-dialog-select-image" || buttonId == "fm-dialog-select-thumbnail" ? "image" : "video";
                    tb_show("Upload " + mediaType, "media-upload.php?referer=fm-carousel&type=" +
                        mediaType + "&TB_iframe=true", false);
                    return false
                };
                window.send_to_editor = function(html) {
                    tb_remove();
                    if (buttonId == "fm-dialog-select-image") {
                        var $img = $("img", html);
                        if (!$img.length) {
                            $("#fm-dialog-error").css({
                                display: "block"
                            }).html("<p>Please select an image file</p>");
                            return
                        }
                        var thumbnail = $img.attr("src");
                        var src = $(html).is("a") ? $(html).attr("href") : thumbnail;
                        $("#fm-dialog-image-display-tr").css({
                            display: "table-row"
                        });
                        $("#fm-dialog-image-display").attr("src", thumbnail);
                        $("#fm-dialog-image").val(src);
                        $("#fm-dialog-thumbnail").val(thumbnail);
                        if ($.trim($("#fm-dialog-image-title").val()).length <= 0) $("#fm-dialog-image-title").val($("img", html).attr("title"))
                    } else if (buttonId == "fm-dialog-select-thumbnail") {
                        var $img = $("img", html);
                        if (!$img.length) {
                            $("#fm-dialog-error").css({
                                display: "block"
                            }).html("<p>Please select an image file</p>");
                            return
                        }
                        var src = $(html).is("a") ? $(html).attr("href") : $img.attr("src");
                        $("#fm-dialog-thumbnail").val(src)
                    } else {
                        if ($("img",
                                html).length) {
                            $("#fm-dialog-error").css({
                                display: "block"
                            }).html("<p>Please select a video file</p>");
                            return
                        }
                        $("#" + textId).val($(html).attr("href"))
                    }
                    $("#fm-dialog-error").css({
                        display: "none"
                    }).empty()
                };
                $("#fm-dialog-select-image").click(history_media_upload_onclick);
                $("#fm-dialog-select-thumbnail").click(history_media_upload_onclick);
                if (dialogType == 1) {
                    $("#fm-dialog-select-mp4").click(history_media_upload_onclick);
                    $("#fm-dialog-select-webm").click(history_media_upload_onclick)
                }
            } else {
                $("#fm-dialog-select-image").click(media_upload_onclick);
                $("#fm-dialog-select-thumbnail").click(media_upload_onclick);
                if (dialogType == 1) {
                    $("#fm-dialog-select-mp4").click(media_upload_onclick);
                    $("#fm-dialog-select-webm").click(media_upload_onclick)
                }
            }
            $("#fm-dialog-ok").click(function() {
                if ($.trim($("#fm-dialog-image").val()).length <= 0) {
                    $("#fm-dialog-error").css({
                        display: "block"
                    }).html("<p>Please select an image file</p>");
                    return
                }
                if (dialogType == 1 && $.trim($("#fm-dialog-mp4").val()).length <=
                    0) {
                    $("#fm-dialog-error").css({
                        display: "block"
                    }).html("<p>Please select a video file</p>");
                    return
                }
                var item = {
                    image: $.trim($("#fm-dialog-image").val()),
                    thumbnail: $.trim($("#fm-dialog-thumbnail").val()),
                    displaythumbnail: $("#fm-dialog-displaythumbnail").is(":checked"),
                    video: $.trim($("#fm-dialog-video").val()),
                    mp4: $.trim($("#fm-dialog-mp4").val()),
                    webm: $.trim($("#fm-dialog-webm").val()),
                    title: $.trim($("#fm-dialog-image-title").val()),
                    description: $.trim($("#fm-dialog-image-description").val()),
                    weblink: $.trim($("#fm-dialog-weblink").val()),
                    clickhandler: $.trim($("#fm-dialog-clickhandler").val()),
                    linktarget: $.trim($("#fm-dialog-linktarget").val()),
                    weblinklightbox: $("#fm-dialog-weblinklightbox").is(":checked"),
                    lightbox: $("#fm-dialog-lightbox").is(":checked"),
                    lightboxsize: $("#fm-dialog-lightbox-size").is(":checked"),
                    lightboxwidth: parseInt($.trim($("#fm-dialog-lightbox-width").val())),
                    lightboxheight: parseInt($.trim($("#fm-dialog-lightbox-height").val()))
                };
                $slideDialog.remove();
                onSuccess([item])
            });
            $("#fm-dialog-cancel").click(function() {
                $slideDialog.remove()
            })
        };
        var youtubePlaylistDialog = function(onSuccess, data, dataIndex) {
            var dialogCode = "<div class='fm-dialog-container'>" + "<div class='fm-dialog-bg'></div>" + "<div class='fm-dialog'>" + "<h3 id='fm-dialog-title'>Add YouTube Playlist</h3>" + "<div class='error' id='fm-dialog-error' style='display:none;'></div>" +
                "<table id='fm-dialog-form'>" + "<tr>" + "<th>YouTube API key</th>" + "<td><input name='fm-dialog-youtubeapikey' type='text' id='fm-dialog-youtubeapikey' value='' class='regular-text' /></td>" + "</tr>" + "<tr>" + "<th>YouTube playlist ID</th>" + "<td><input name='fm-dialog-youtubeplaylistid' type='text' id='fm-dialog-youtubeplaylistid' value='' class='regular-text' /></td>" + "</tr>" + "<tr>" + "<th>Maximum results</th>" + "<td><input name='fm-dialog-youtubeplaylistmaxresults' type='number' id='fm-dialog-youtubeplaylistmaxresults' value='50' class='small-text' /></td>" +
                "</tr>" + "<tr>" + "<th>Click to open Lightbox popup</th>" + "<td><label><input name='fm-dialog-lightbox' type='checkbox' id='fm-dialog-lightbox' value='' checked /> Open YouTube video in Lightbox</label>" + "</tr>" + "<tr><th>Lightbox size</th>" + "<td><label><input name='fm-dialog-lightbox-size' type='checkbox' id='fm-dialog-lightbox-size' value='' /> Set Lightbox size (px) </label>" + " <input name='fm-dialog-lightbox-width' type='text' id='fm-dialog-lightbox-width' value='960' class='small-text' /> / <input name='fm-dialog-lightbox-height' type='text' id='fm-dialog-lightbox-height' value='540' class='small-text' />" +
                "</td>" + "</tr>" + "</table><div class='fm-dialog-buttons'>" + "<input type='button' class='button button-primary' id='fm-dialog-ok' value='OK' />" + "<input type='button' class='button' id='fm-dialog-cancel' value='Cancel' />" + "</div>" + "</div>" +
                "</div>";
            var $playlistDialog = $(dialogCode);
            $("body").append($playlistDialog);
            $(".fm-dialog").css({
                "margin-top": String($(document).scrollTop() + 60) + "px"
            });
            $(".fm-dialog-bg").css({
                height: $(document).height() + "px"
            });
            if (data) {
                $("#fm-dialog-youtubeapikey").val(data.youtubeapikey);
                $("#fm-dialog-youtubeplaylistid").val(data.youtubeplaylistid);
                $("#fm-dialog-youtubeplaylistmaxresults").val(data.youtubeplaylistmaxresults);
                if ("lightbox" in data) $("#fm-dialog-lightbox").attr("checked",
                    data.lightbox);
                if ("lightboxsize" in data) $("#fm-dialog-lightbox-size").attr("checked", data.lightboxsize);
                if (data.lightboxwidth) $("#fm-dialog-lightbox-width").val(data.lightboxwidth);
                if (data.lightboxheight) $("#fm-dialog-lightbox-height").val(data.lightboxheight)
            }
            $("#fm-dialog-ok").click(function() {
                if ($.trim($("#fm-dialog-youtubeapikey").val()).length <= 0) {
                    $("#fm-dialog-error").css({
                        display: "block"
                    }).html("<p>Please enter your YouTube API key</p>");
                    $("#fm-dialog-youtubeapikey").focus();
                    return
                }
                if ($.trim($("#fm-dialog-youtubeplaylistid").val()).length <= 0) {
                    $("#fm-dialog-error").css({
                        display: "block"
                    }).html("<p>Please enter your YouTube playlist ID</p>");
                    $("#fm-dialog-youtubeplaylistid").focus();
                    return
                }
                var item = {
                    youtubeapikey: $.trim($("#fm-dialog-youtubeapikey").val()),
                    youtubeplaylistid: $.trim($("#fm-dialog-youtubeplaylistid").val()),
                    youtubeplaylistmaxresults: $.trim($("#fm-dialog-youtubeplaylistmaxresults").val()),
                    lightbox: $("#fm-dialog-lightbox").is(":checked"),
                    lightboxsize: $("#fm-dialog-lightbox-size").is(":checked"),
                    lightboxwidth: parseInt($.trim($("#fm-dialog-lightbox-width").val())),
                    lightboxheight: parseInt($.trim($("#fm-dialog-lightbox-height").val())),
                    displaythumbnail: false,
                    mp4: "",
                    webm: "",
                    weblink: "",
                    clickhandler: "",
                    linktarget: "",
                    weblinklightbox: false
                };
                $playlistDialog.remove();
                onSuccess([item])
            });
            $("#fm-dialog-cancel").click(function() {
                $playlistDialog.remove()
            })
        };
        var onlineVideoDialog = function(dialogType, onSuccess, videoData, invokeFromSlideDialog, dataIndex) {
            var dialogTitle = ["Image", "Video", "Youtube Video", "Vimeo Video"];
            var dialogExample = ["", "", "https://www.youtube.com/watch?v=wswxQ3mhwqQ", "https://vimeo.com/1084537"];
            var dialogCode = "<div class='fm-dialog-container'>" + "<div class='fm-dialog-bg'></div>" + "<div class='fm-dialog'>" + "<h3 id='fm-dialog-title'></h3>" + "<div class='error' id='fm-dialog-error' style='display:none;'></div>" +
                "<table id='fm-dialog-form'>" + "<tr>" + "<th>Enter " + dialogTitle[dialogType] + " URL</th>" + "<td><input name='fm-dialog-video' type='text' id='fm-dialog-video' value='' class='regular-text' />" + "<For example: " + dialogExample[dialogType] + "<p>" + "</td>" + "</tr>";
            dialogCode += "</table>" + "<div id='fm-carousel-video-dialog-loading'></div>" + "<div class='fm-dialog-buttons'>" + "<input type='button' class='button button-primary' id='fm-dialog-ok' value='OK' />" +
                "<input type='button' class='button' id='fm-dialog-cancel' value='Cancel' />" + "</div>" + "</div>" + "</div>";
            var $videoDialog = $(dialogCode);
            $("body").append($videoDialog);
            $(".fm-dialog").css({
                "margin-top": String($(document).scrollTop() + 60) + "px"
            });
            $(".fm-dialog-bg").css({
                height: $(document).height() + "px"
            });
            if (!videoData) videoData = {
                type: dialogType
            };
            $("#fm-dialog-title").html("Add " + dialogTitle[dialogType]);
            var videoDataReturn = function() {
                $videoDialog.remove();
                slideDialog(dialogType,
                    function(items) {
                        if (items && items.length > 0) {
                            if (typeof dataIndex !== "undefined" && dataIndex >= 0) fm_carousel_config.slides.splice(dataIndex, 1);
                            items.map(function(data) {
                                var result = {
                                    type: dialogType,
                                    image: data.image,
                                    thumbnail: data.thumbnail ? data.thumbnail : data.image,
                                    displaythumbnail: data.displaythumbnail,
                                    video: data.video,
                                    mp4: data.mp4,
                                    webm: data.webm,
                                    title: data.title,
                                    description: data.description,
                                    weblink: data.weblink,
                                    clickhandler: data.clickhandler,
                                    linktarget: data.linktarget,
                                    weblinklightbox: data.weblinklightbox,
                                    lightbox: data.lightbox,
                                    lightboxsize: data.lightboxsize,
                                    lightboxwidth: data.lightboxwidth,
                                    lightboxheight: data.lightboxheight
                                };
                                if (typeof dataIndex !== "undefined" && dataIndex >= 0) fm_carousel_config.slides.splice(dataIndex, 0, result);
                                else addMediaToList(result)
                            });
                            updateMediaTable()
                        }
                    }, videoData, dataIndex)
            };
            $("#fm-dialog-ok").click(function() {
                var href = $.trim($("#fm-dialog-video").val());
                if (href.length <= 0) {
                    $("#fm-dialog-error").css({
                        display: "block"
                    }).html("<p>Please enter a " +
                        dialogTitle[dialogType] + " URL</p>");
                    return
                }
                var protocol = "https:";
                if (dialogType == 2) {
                    var youtubeId = "";
                    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
                    var match = href.match(regExp);
                    if (match && match[7] && match[7].length == 11) youtubeId = match[7];
                    else {
                        $("#fm-dialog-error").css({
                            display: "block"
                        }).html("<p>Please enter a valid Youtube URL</p>");
                        return
                    }
                    var result = protocol + "//www.youtube.com/embed/" + youtubeId;
                    var params = getURLParams(href);
                    var first = true;
                    for (var key in params) {
                        if (first) {
                            result +=
                                "?";
                            first = false
                        } else result += "&";
                        result += key + "=" + params[key]
                    }
                    videoData.video = result;
                    videoData.image = protocol + "//img.youtube.com/vi/" + youtubeId + "/0.jpg";
                    videoData.thumbnail = protocol + "//img.youtube.com/vi/" + youtubeId + "/1.jpg";
                    videoDataReturn()
                } else if (dialogType == 3) {
                    var vimeoId = "";
                    var regExp = /^.*(vimeo\.com\/)((video\/)|(channels\/[A-z]+\/)|(groups\/[A-z]+\/videos\/))?([0-9]+)/;
                    var match = href.match(regExp);
                    if (match && match[6]) vimeoId = match[6];
                    else {
                        $("#fm-dialog-error").css({
                            display: "block"
                        }).html("<p>Please enter a valid Vimeo URL</p>");
                        return
                    }
                    var result = protocol + "//player.vimeo.com/video/" + vimeoId;
                    var params = getURLParams(href);
                    var first = true;
                    for (var key in params) {
                        if (first) {
                            result += "?";
                            first = false
                        } else result += "&";
                        result += key + "=" + params[key]
                    }
                    videoData.video = result;
                    $("#fm-carousel-video-dialog-loading").css({
                        display: "block"
                    });
                    $.ajax({
                        url: protocol + "//www.vimeo.com/api/v2/video/" + vimeoId + ".json?callback=?",
                        dataType: "json",
                        timeout: 3E3,
                        data: {
                            format: "json"
                        },
                        success: function(data) {
                            videoData.image = data[0].thumbnail_large;
                            videoData.thumbnail =
                                data[0].thumbnail_medium;
                            videoDataReturn()
                        },
                        error: function() {
                            videoDataReturn()
                        }
                    })
                }
            });
            $("#fm-dialog-cancel").click(function() {
                $videoDialog.remove();
                if (invokeFromSlideDialog) videoDataReturn()
            })
        };
        var updateMediaTable = function() {
            var mediaType = ["Image", "Video", "YouTube", "Vimeo", "", "", "WordPress Posts", "", "", "", "YouTube Playlist"];
            $("#fm-carousel-media-table").empty();
            for (var i = 0; i < fm_carousel_config.slides.length; i++) {
                var thumbnail = "";
                if (fm_carousel_config.slides[i].type ==
                    6) thumbnail = $("#fm-carousel-pluginfolder").text() + "images/wordpressposts.png";
                else if (fm_carousel_config.slides[i].type == 10) thumbnail = $("#fm-carousel-pluginfolder").text() + "images/youtubeplaylist.png";
                else thumbnail = fm_carousel_config.slides[i].thumbnail;
                $("#fm-carousel-media-table").append("<li>" + "<div class='fm-carousel-media-table-id'>" + (i + 1) + "</div>" + "<div class='fm-carousel-media-table-img'>" + "<img class='fm-carousel-media-table-image' data-order='" +
                    i + "' src='" + thumbnail + "' />" + "</div>" + "<div class='fm-carousel-media-table-type'>" + mediaType[fm_carousel_config.slides[i].type] + "</div>" + "<div class='fm-carousel-media-table-buttons-edit'>" + "<a class='fm-carousel-media-table-button fm-carousel-media-table-edit'>Edit</a>&nbsp;|&nbsp;" + "<a class='fm-carousel-media-table-button fm-carousel-media-table-delete'>Delete</a>" + "</div>" + "<div class='fm-carousel-media-table-buttons-move'>" +
                    "<a class='fm-carousel-media-table-button fm-carousel-media-table-moveup'>Move Up</a>&nbsp;|&nbsp;" + "<a class='fm-carousel-media-table-button fm-carousel-media-table-movedown'>Move Down</a>" + "</div>" + "<div style='clear:both;'></div>" + "</li>")
            }
            $(".fm-carousel-media-table-image").wpdraggable(fmMediaTableMove)
        };
        $("#fm-add-image").click(function() {
            slideDialog(0, function(items) {
                items.map(function(data) {
                    addMediaToList({
                        type: 0,
                        image: data.image,
                        thumbnail: data.thumbnail ? data.thumbnail : data.image,
                        displaythumbnail: data.displaythumbnail,
                        video: data.video,
                        mp4: data.mp4,
                        webm: data.webm,
                        title: data.title,
                        description: data.description,
                        weblink: data.weblink,
                        clickhandler: data.clickhandler,
                        linktarget: data.linktarget,
                        weblinklightbox: data.weblinklightbox,
                        lightbox: data.lightbox,
                        lightboxsize: data.lightboxsize,
                        lightboxwidth: data.lightboxwidth,
                        lightboxheight: data.lightboxheight
                    })
                });
                updateMediaTable()
            })
        });
        $("#fm-add-video").click(function() {
            slideDialog(1,
                function(items) {
                    items.map(function(data) {
                        addMediaToList({
                            type: 1,
                            image: data.image,
                            thumbnail: data.thumbnail ? data.thumbnail : data.image,
                            displaythumbnail: data.displaythumbnail,
                            video: data.video,
                            mp4: data.mp4,
                            webm: data.webm,
                            title: data.title,
                            description: data.description,
                            weblink: data.weblink,
                            clickhandler: data.clickhandler,
                            linktarget: data.linktarget,
                            weblinklightbox: data.weblinklightbox,
                            lightbox: data.lightbox,
                            lightboxsize: data.lightboxsize,
                            lightboxwidth: data.lightboxwidth,
                            lightboxheight: data.lightboxheight
                        })
                    });
                    updateMediaTable()
                })
        });
        $("#fm-add-youtube").click(function() {
            onlineVideoDialog(2, function(items) {
                items.map(function(data) {
                    addMediaToList({
                        type: 2,
                        image: data.image,
                        thumbnail: data.thumbnail ? data.thumbnail : data.image,
                        displaythumbnail: data.displaythumbnail,
                        video: data.video,
                        mp4: data.mp4,
                        webm: data.webm,
                        title: data.title,
                        description: data.description,
                        weblink: data.weblink,
                        clickhandler: data.clickhandler,
                        linktarget: data.linktarget,
                        weblinklightbox: data.weblinklightbox,
                        lightbox: data.lightbox,
                        lightboxsize: data.lightboxsize,
                        lightboxwidth: data.lightboxwidth,
                        lightboxheight: data.lightboxheight
                    })
                });
                updateMediaTable()
            })
        });
        $("#fm-add-vimeo").click(function() {
            onlineVideoDialog(3, function(items) {
                items.map(function(data) {
                    addMediaToList({
                        type: 3,
                        image: data.image,
                        thumbnail: data.thumbnail ? data.thumbnail : data.image,
                        displaythumbnail: data.displaythumbnail,
                        video: data.video,
                        mp4: data.mp4,
                        webm: data.webm,
                        title: data.title,
                        description: data.description,
                        weblink: data.weblink,
                        clickhandler: data.clickhandler,
                        linktarget: data.linktarget,
                        weblinklightbox: data.weblinklightbox,
                        lightbox: data.lightbox,
                        lightboxsize: data.lightboxsize,
                        lightboxwidth: data.lightboxwidth,
                        lightboxheight: data.lightboxheight
                    })
                });
                updateMediaTable()
            })
        });
        $("#fm-add-youtube-playlist").click(function() {
            youtubePlaylistDialog(function(items) {
                items.map(function(data) {
                    addMediaToList({
                        type: 10,
                        youtubeapikey: data.youtubeapikey,
                        youtubeplaylistid: data.youtubeplaylistid,
                        youtubeplaylistmaxresults: data.youtubeplaylistmaxresults,
                        lightbox: data.lightbox,
                        lightboxsize: data.lightboxsize,
                        lightboxwidth: data.lightboxwidth,
                        lightboxheight: data.lightboxheight,
                        displaythumbnail: false,
                        mp4: "",
                        webm: "",
                        weblink: "",
                        clickhandler: "",
                        linktarget: "",
                        weblinklightbox: false
                    })
                });
                updateMediaTable()
            })
        });
        var addPostsDialog = function(dialogType, onSuccess, data, dataIndex) {
            var dialogCode = "<div class='fm-dialog-container'>" + "<div class='fm-dialog-bg'></div>" + "<div class='fm-dialog'>" + "<h3 id='fm-dialog-title'>Add Posts</h3>" + "<div class='error' id='fm-dialog-error' style='display:none;'></div>" +
                "<table id='fm-dialog-form'>" + "<tr>" + "<th>Select Posts</th><td><select name='fm-dialog-postcategory' id='fm-dialog-postcategory'>";
            var catlist = $.parseJSON($("#fm-carousel-catlist").text());
            dialogCode += "<option value='-1'>Recent Posts</option>";
            for (var key in catlist) dialogCode += "<option value='" + catlist[key].ID + "'>Category: " + catlist[key].cat_name + "</option>";
            dialogCode += "</select></td></tr>";
            dialogCode += "<tr><th>Set Maximum</th><td><input style='vertical-align:middle;' name='fm-dialog-postnumber' id='fm-dialog-postnumber' type='number' value='10' class='small-text' /><select name='fm-dialog-postorder' id='fm-dialog-postorder'><option value='DESC'>Descending</option><option value='ASC'>Ascending</option></select></td></tr>";
            dialogCode += "<tr><th>Date Range</th><td><label><input name='fm-dialog-postdaterange' type='checkbox' id='fm-dialog-postdaterange' /> Only get posts from the past <input name='fm-dialog-postdaterangeafter' id='fm-dialog-postdaterangeafter' type='number' value='30' class='small-text' /> days</label></td></tr>";
            dialogCode += "<tr><th>Featured Image Size</th><td><select name='fm-dialog-featuredimagesize' id='fm-dialog-featuredimagesize'><option value='thumbnail'>Thumbnail</option><option value='medium'>Medium</option><option value='large'>Large</option><option value='full'>Full</option></select></td>";
            dialogCode += "<tr><th>Maximum Excerpt Word Length</th><td><input name='fm-dialog-excerptlength' id='fm-dialog-excerptlength' type='number' value='55' class='small-text' /></td></tr>";
            dialogCode += "<tr><th>When clicking on the image</th><td><label><input type='radio' name='fm-dialog-postlightbox' value='1' >Open the featured image in lightbox</label><label style='margin-left:24px;'><input name='fm-dialog-postlightbox-size' type='checkbox' id='fm-dialog-postlightbox-size' value='' /> Set Lightbox size </label><input name='fm-dialog-postlightbox-width' type='number' id='fm-dialog-postlightbox-width' value='960' class='small-text' /> / <input name='fm-dialog-postlightbox-height' type='number' id='fm-dialog-postlightbox-height' value='540' class='small-text' /><br>";
            dialogCode += "<label><input type='radio' name='fm-dialog-postlightbox' value='0' checked>Open the post page</label></td>";
            dialogCode += "<tr><th>Link Target</th><td><div class='select-editable'><select onchange='this.nextElementSibling.value=this.value'><option value=''></option><option value='_blank'>_blank</option><option value='_self'>_self</option><option value='_parent'>_parent</option><option value='_top'>_top</option></select><input type='text' name='fm-dialog-postlinktarget' id='fm-dialog-postlinktarget' value='' /></div></td></tr>";
            dialogCode += "<tr><th>Title</th><td><label><input name='fm-dialog-titlelink' type='checkbox' id='fm-dialog-titlelink' value='' /> Link title to the post page</label></td></tr>";
            dialogCode += "</table>" + "<ul style='margin-left:24px;list-style-position:outside;list-style-type:square;text-align:left;'>" +
                "<li>The title of a post will be used as the title property of the carousel item.</li>" + "<li>The excerpt of a post will be used as the description property of the carousel item. For how to add excerpts for posts, please view <a href='https://codex.wordpress.org/Excerpt' target='_blank'>WordPress Excerpts</a>.</li></ul>" + "<div class='fm-dialog-buttons'>" + "<input type='button' class='button button-primary' id='fm-dialog-ok' value='OK' />" + "<input type='button' class='button' id='fm-dialog-cancel' value='Cancel' />" +
                "</div>" + "</div>" + "</div>";
            var $postsDialog = $(dialogCode);
            $("body").append($postsDialog);
            $(".fm-dialog").css({
                "margin-top": String($(document).scrollTop() + 60) + "px"
            });
            $(".fm-dialog-bg").css({
                height: $(document).height() + "px"
            });
            if (data) {
                $("#fm-dialog-postcategory").val(data.postcategory);
                $("#fm-dialog-postorder").val(data.postorder);
                $("#fm-dialog-postdaterange").attr("checked", data.postdaterange);
                $("#fm-dialog-postdaterangeafter").val(data.postdaterangeafter);
                $("#fm-dialog-postnumber").val(data.postnumber);
                $("#fm-dialog-featuredimagesize").val(data.featuredimagesize);
                $("#fm-dialog-excerptlength").val(data.excerptlength);
                $("#fm-dialog-postlinktarget").val(data.postlinktarget);
                if ("postlightbox" in data) {
                    $("input[name=fm-dialog-postlightbox][value=" + (data.postlightbox ? 1 : 0) + "]").attr("checked", true);
                    $("#fm-dialog-postlightbox-size").attr("checked", data.postlightboxsize);
                    $("#fm-dialog-postlightbox-width").val(data.postlightboxwidth);
                    $("#fm-dialog-postlightbox-height").val(data.postlightboxheight);
                    $("#fm-dialog-titlelink").attr("checked", data.posttitlelink)
                }
            }
            $("#fm-dialog-ok").click(function() {
                var item = {
                    type: dialogType,
                    postcategory: $("#fm-dialog-postcategory").val(),
                    postorder: $("#fm-dialog-postorder").val(),
                    postdaterange: $("#fm-dialog-postdaterange").is(":checked"),
                    postdaterangeafter: $("#fm-dialog-postdaterangeafter").val(),
                    postnumber: $("#fm-dialog-postnumber").val(),
                    featuredimagesize: $("#fm-dialog-featuredimagesize").val(),
                    excerptlength: $("#fm-dialog-excerptlength").val(),
                    postlinktarget: $("#fm-dialog-postlinktarget").val(),
                    postlightbox: $("input[name=fm-dialog-postlightbox]:checked").val() == 1 ? true : false,
                    postlightboxsize: $("#fm-dialog-postlightbox-size").is(":checked"),
                    postlightboxwidth: parseInt($.trim($("#fm-dialog-postlightbox-width").val())),
                    postlightboxheight: parseInt($.trim($("#fm-dialog-postlightbox-height").val())),
                    posttitlelink: $("#fm-dialog-titlelink").is(":checked")
                };
                $postsDialog.remove();
                onSuccess(item)
            });
            $("#fm-dialog-cancel").click(function() {
                $postsDialog.remove()
            })
        };
        $("#fm-add-posts").click(function() {
            addPostsDialog(6, function(data) {
                addMediaToList(data);
                updateMediaTable()
            })
        });
        $("#fm-reverselist").click(function() {
            fm_carousel_config.slides.reverse();
            updateMediaTable()
        });
        $(document).on("click", ".fm-carousel-media-table-edit", function() {
            var index =
                $(this).parent().parent().index();
            var mediaType = fm_carousel_config.slides[index].type;
            if (mediaType == 10) youtubePlaylistDialog(function(items) {
                if (items && items.length > 0) {
                    fm_carousel_config.slides.splice(index, 1);
                    items.map(function(data) {
                        fm_carousel_config.slides.splice(index, 0, {
                            type: 10,
                            youtubeapikey: data.youtubeapikey,
                            youtubeplaylistid: data.youtubeplaylistid,
                            youtubeplaylistmaxresults: data.youtubeplaylistmaxresults,
                            lightbox: data.lightbox,
                            lightboxsize: data.lightboxsize,
                            lightboxwidth: data.lightboxwidth,
                            lightboxheight: data.lightboxheight,
                            displaythumbnail: false,
                            mp4: "",
                            webm: "",
                            weblink: "",
                            clickhandler: "",
                            linktarget: "",
                            weblinklightbox: false
                        })
                    });
                    updateMediaTable()
                }
            }, fm_carousel_config.slides[index], index);
            else if (mediaType == 6) addPostsDialog(6, function(data) {
                fm_carousel_config.slides.splice(index, 1);
                fm_carousel_config.slides.splice(index, 0, data);
                updateMediaTable()
            }, fm_carousel_config.slides[index], index);
            else slideDialog(mediaType, function(items) {
                if (items && items.length >
                    0) {
                    fm_carousel_config.slides.splice(index, 1);
                    items.map(function(data) {
                        fm_carousel_config.slides.splice(index, 0, {
                            type: mediaType,
                            image: data.image,
                            thumbnail: data.thumbnail ? data.thumbnail : data.image,
                            displaythumbnail: data.displaythumbnail,
                            video: data.video,
                            mp4: data.mp4,
                            webm: data.webm,
                            title: data.title,
                            description: data.description,
                            weblink: data.weblink,
                            clickhandler: data.clickhandler,
                            linktarget: data.linktarget,
                            weblinklightbox: data.weblinklightbox,
                            lightbox: data.lightbox,
                            lightboxsize: data.lightboxsize,
                            lightboxwidth: data.lightboxwidth,
                            lightboxheight: data.lightboxheight
                        })
                    });
                    updateMediaTable()
                }
            }, fm_carousel_config.slides[index], index)
        });
        $(document).on("click", ".fm-carousel-media-table-delete", function() {
            var $tr = $(this).parent().parent();
            var index = $tr.index();
            fm_carousel_config.slides.splice(index, 1);
            $tr.remove();
            $("#fm-carousel-media-table").find("li").each(function(index) {
                $(this).find(".fm-carousel-media-table-id").text(index + 1);
                $(this).find("img").data("order",
                    index);
                $(this).find("img").css({
                    top: 0,
                    left: 0
                })
            })
        });
        var fmMediaTableMove = function(i, j) {
            var len = fm_carousel_config.slides.length;
            if (j < 0) j = 0;
            if (j > len - 1) j = len - 1;
            if (i == j) {
                $("#fm-carousel-media-table").find("li").eq(i).find("img").css({
                    top: 0,
                    left: 0
                });
                return
            }
            var $tr = $("#fm-carousel-media-table").find("li").eq(i);
            var data = fm_carousel_config.slides[i];
            fm_carousel_config.slides.splice(i, 1);
            fm_carousel_config.slides.splice(j, 0, data);
            var $trj =
                $("#fm-carousel-media-table").find("li").eq(j);
            $tr.remove();
            if (j > i) $trj.after($tr);
            else $trj.before($tr);
            $("#fm-carousel-media-table").find("li").each(function(index) {
                $(this).find(".fm-carousel-media-table-id").text(index + 1);
                $(this).find("img").data("order", index);
                $(this).find("img").css({
                    top: 0,
                    left: 0
                })
            });
            $tr.find("img").wpdraggable(fmMediaTableMove)
        };
        $(document).on("click", ".fm-carousel-media-table-moveup", function() {
            var $tr = $(this).parent().parent();
            var index = $tr.index();
            var data = fm_carousel_config.slides[index];
            fm_carousel_config.slides.splice(index, 1);
            if (index == 0) {
                fm_carousel_config.slides.push(data);
                var $last = $tr.parent().find("li:last");
                $tr.remove();
                $last.after($tr)
            } else {
                fm_carousel_config.slides.splice(index - 1, 0, data);
                var $prev = $tr.prev();
                $tr.remove();
                $prev.before($tr)
            }
            $("#fm-carousel-media-table").find("li").each(function(index) {
                $(this).find(".fm-carousel-media-table-id").text(index +
                    1);
                $(this).find("img").data("order", index);
                $(this).find("img").css({
                    top: 0,
                    left: 0
                })
            });
            $tr.find("img").wpdraggable(fmMediaTableMove)
        });
        $(document).on("click", ".fm-carousel-media-table-movedown", function() {
            var $tr = $(this).parent().parent();
            var index = $tr.index();
            var len = fm_carousel_config.slides.length;
            var data = fm_carousel_config.slides[index];
            fm_carousel_config.slides.splice(index, 1);
            if (index == len - 1) {
                fm_carousel_config.slides.unshift(data);
                var $first = $tr.parent().find("li:first");
                $tr.remove();
                $first.before($tr)
            } else {
                fm_carousel_config.slides.splice(index + 1, 0, data);
                var $next = $tr.next();
                $tr.remove();
                $next.after($tr)
            }
            $("#fm-carousel-media-table").find("li").each(function(index) {
                $(this).find(".fm-carousel-media-table-id").text(index + 1);
                $(this).find("img").data("order", index);
                $(this).find("img").css({
                    top: 0,
                    left: 0
                })
            });
            $tr.find("img").wpdraggable(fmMediaTableMove)
        });
        var default_options = {
            id: -1,
            newestfirst: false,
            name: "My Slider",
            slides: [],
            skin: "classic",
            fixaspectratio: true,
            centerimage: true,
            fitimage: false,
            fitcenterimage: false,
            sameheight: false,
            sameheightresponsive: false,
            sameheightmediumscreen: 769,
            sameheightmediumheight: 200,
            sameheightsmallscreen: 415,
            sameheightsmallheight: 150,
            fullwidth: false,
            hidecontaineroninit: false,
            hidecontainerbeforeloaded: false,
            spacing: 8,
            imgextraprops: "",
            customcss: "",
            dataoptions: "",
            lightboxresponsive: true,
            lightboxshownavigation: false,
            lightboxnogroup: false,
            lightboxshowtitle: true,
            lightboxshowdescription: false,
            lightboxfullscreenmode: false,
            lightboxcloseonoverlay: true,
            lightboxvideohidecontrols: false,
            lightboxtitlestyle: "bottom",
            lightboximagepercentage: 75,
            lightboxdefaultvideovolume: 1,
            lightboxoverlaybgcolor: "#000",
            lightboxoverlayopacity: 0.9,
            lightboxbgcolor: "#fff",
            lightboxtitleprefix: "%NUM / %TOTAL",
            lightboxtitleinsidecss: "color:#fff; font-size:16px; font-family:Arial,Helvetica,sans-serif; overflow:hidden; text-align:left;",
            lightboxdescriptioninsidecss: "color:#fff; font-size:12px; font-family:Arial,Helvetica,sans-serif; overflow:hidden; text-align:left; margin:4px 0px 0px; padding: 0px;",
            lightboxautoslide: false,
            lightboxslideinterval: 5E3,
            lightboxshowtimer: true,
            lightboxtimerposition: "bottom",
            lightboxtimerheight: 2,
            lightboxtimercolor: "#dc572e",
            lightboxtimeropacity: 1,
            lightboxshowplaybutton: true,
            lightboxalwaysshownavarrows: false,
            lightboxbordersize: 8,
            lightboxshowtitleprefix: true,
            lightboxborderradius: 0,
            lightboximagekeepratio: true,
            lightboxadvancedoptions: "",
            lightboxshowsocial: false,
            lightboxsocialposition: "position:absolute;top:100%;right:0;",
            lightboxsocialpositionsmallscreen: "position:absolute;top:100%;right:0;left:0;",
            lightboxsocialdirection: "horizontal",
            lightboxsocialbuttonsize: 32,
            lightboxsocialbuttonfontsize: 18,
            lightboxsocialrotateeffect: true,
            lightboxshowfacebook: true,
            lightboxshowtwitter: true,
            lightboxshowpinterest: true,
            donotinit: false,
            addinitscript: false,
            doshortcodeontext: false,
            triggerresize: false,
            triggerresizedelay: 100,
            lightboxthumbwidth: 90,
            lightboxthumbheight: 60,
            lightboxthumbtopmargin: 12,
            lightboxthumbbottommargin: 4,
            lightboxbarheight: 64,
            lightboxtitlebottomcss: "{color:#333; font-size:14px; font-family:Armata,sans-serif,Arial; overflow:hidden; text-align:left;}",
            lightboxdescriptionbottomcss: "{color:#333; font-size:12px; font-family:Arial,Helvetica,sans-serif; overflow:hidden; text-align:left; margin:4px 0px 0px; padding: 0px;}"
        };
        var configSkinOptions = ["width", "height", "spacing", "rownumber", "centerimage", "fitimage", "fitcenterimage", "fixaspectratio", "autoplay", "random", "circular", "direction", "responsive", "visibleitems", "pauseonmouseover", "scrollmode", "interval", "transitionduration", "continuous", "continuousduration", "arrowstyle", "arrowimage", "arrowwidth", "arrowheight",
            "navstyle", "navimage", "navwidth", "navheight", "navspacing", "hidecontainerbeforeloaded", "hidecontaineroninit", "fullwidth", "sameheight", "sameheightresponsive", "sameheightmediumscreen", "sameheightmediumheight", "sameheightsmallscreen", "sameheightsmallheight", "showhoveroverlay", "hoveroverlayimage", "screenquery"
        ];
        var defaultSkinOptions = {};
        for (var key in FM_CAROUSEL_SKIN_OPTIONS) {
            defaultSkinOptions[key] = {};
            for (var i = 0; i < configSkinOptions.length; i++)
                if (configSkinOptions[i] in FM_CAROUSEL_SKIN_OPTIONS[key]) defaultSkinOptions[key][configSkinOptions[i]] =
                    FM_CAROUSEL_SKIN_OPTIONS[key][configSkinOptions[i]];
                else if (configSkinOptions[i] in default_options) defaultSkinOptions[key][configSkinOptions[i]] = default_options[configSkinOptions[i]];
            defaultSkinOptions[key]["skintemplate"] = FM_CAROUSEL_SKIN_TEMPLATE[key]["skintemplate"];
            defaultSkinOptions[key]["skincss"] = FM_CAROUSEL_SKIN_TEMPLATE[key]["skincss"];
            defaultSkinOptions[key]["arrowimagemode"] = "defined";
            defaultSkinOptions[key]["navimagemode"] = "defined";
            defaultSkinOptions[key]["hoveroverlayimagemode"] =
                "defined";
            defaultSkinOptions[key]["showhoveroverlayalways"] = false;
            defaultSkinOptions[key]["hidehoveroverlayontouch"] = false;
            defaultSkinOptions[key]["usescreenquery"] = false;
            defaultSkinOptions[key]["showplayvideo"] = true;
            defaultSkinOptions[key]["playvideoimage"] = "playvideo-64-64-0.png";
            defaultSkinOptions[key]["playvideoimagepos"] = "center";
            defaultSkinOptions[key]["playvideoimagemode"] = "defined"
        }
        var printSkinOptions = function(options) {
            $("#fm-carousel-width").val(options.width);
            $("#fm-carousel-height").val(options.height);
            $("#fm-carousel-spacing").val(options.spacing);
            $("#fm-carousel-rownumber").val(options.rownumber);
            $("#fm-carousel-fixaspectratio").attr("checked", options.fixaspectratio);
            $("#fm-carousel-centerimage").attr("checked", options.centerimage);
            $("#fm-carousel-fitimage").attr("checked", options.fitimage);
            $("#fm-carousel-fitcenterimage").attr("checked", options.fitcenterimage);
            $("#fm-carousel-sameheight").attr("checked", options.sameheight);
            $("#fm-carousel-sameheightresponsive").attr("checked", options.sameheightresponsive);
            $("#fm-carousel-sameheightmediumscreen").val(options.sameheightmediumscreen);
            $("#fm-carousel-sameheightmediumheight").val(options.sameheightmediumheight);
            $("#fm-carousel-sameheightsmallscreen").val(options.sameheightsmallscreen);
            $("#fm-carousel-sameheightsmallheight").val(options.sameheightsmallheight);
            $("#fm-carousel-fullwidth").attr("checked", options.fullwidth);
            $("#fm-carousel-hidecontaineroninit").attr("checked", options.hidecontaineroninit);
            $("#fm-carousel-hidecontainerbeforeloaded").attr("checked", options.hidecontainerbeforeloaded);
            $("#fm-carousel-autoplay").attr("checked", options.autoplay);
            $("#fm-carousel-random").attr("checked", options.random);
            $("#fm-carousel-circular").attr("checked", options.circular);
            $("#fm-carousel-responsive").attr("checked", options.responsive);
            $("#fm-carousel-visibleitems").val(options.visibleitems);
            $("#fm-carousel-pauseonmouseover").attr("checked", options.pauseonmouseover);
            $("#fm-carousel-scrollmode").val(options.scrollmode);
            $("#fm-carousel-interval").val(options.interval);
            $("#fm-carousel-transitionduration").val(options.transitionduration);
            $("#fm-carousel-continuous").attr("checked", options.continuous);
            $("#fm-carousel-continuousduration").val(options.continuousduration);
            if (options.usescreenquery) $("input:radio[name=fm-carousel-usescreenquery][value=screensize]").attr("checked",
                true);
            else $("input:radio[name=fm-carousel-usescreenquery][value=fixedsize]").attr("checked", true);
            $("#fm-carousel-screenquery").val(options.screenquery);
            $("#fm-carousel-arrowstyle").val(options.arrowstyle);
            $("input:radio[name=fm-carousel-arrowimagemode][value=" + options.arrowimagemode + "]").attr("checked", true);
            if (fm_carousel_config.arrowimagemode == "custom") {
                $("#fm-carousel-customarrowimage").val(options.arrowimage);
                $("#fm-carousel-displayarrowimage").attr("src",
                    options.arrowimage)
            } else {
                $("#fm-carousel-arrowimage").val(options.arrowimage);
                $("#fm-carousel-displayarrowimage").attr("src", $("#fm-carousel-jsfolder").text() + options.arrowimage)
            }
            $("#fm-carousel-arrowwidth").val(options.arrowwidth);
            $("#fm-carousel-arrowheight").val(options.arrowheight);
            $("#fm-carousel-showhoveroverlay").attr("checked", options.showhoveroverlay);
            $("#fm-carousel-showhoveroverlayalways").attr("checked", options.showhoveroverlayalways);
            $("#fm-carousel-hidehoveroverlayontouch").attr("checked", options.hidehoveroverlayontouch);
            $("input:radio[name=fm-carousel-hoveroverlayimagemode][value=" + options.hoveroverlayimagemode + "]").attr("checked", true);
            if (fm_carousel_config.hoveroverlayimagemode == "custom") {
                $("#fm-carousel-customhoveroverlayimage").val(options.hoveroverlayimage);
                $("#fm-carousel-displayhoveroverlayimage").attr("src", options.hoveroverlayimage)
            } else {
                $("#fm-carousel-hoveroverlayimage").val(options.hoveroverlayimage);
                $("#fm-carousel-displayhoveroverlayimage").attr("src", $("#fm-carousel-jsfolder").text() + options.hoveroverlayimage)
            }
            $("#fm-carousel-navstyle").val(options.navstyle);
            $("input:radio[name=fm-carousel-navimagemode][value=" + options.navimagemode + "]").attr("checked", true);
            if (fm_carousel_config.navimagemode == "custom") {
                $("#fm-carousel-customnavimage").val(options.navimage);
                $("#fm-carousel-displaynavimage").attr("src", options.navimage)
            } else {
                $("#fm-carousel-navimage").val(options.navimage);
                $("#fm-carousel-displaynavimage").attr("src", $("#fm-carousel-jsfolder").text() + options.navimage)
            }
            $("#fm-carousel-navwidth").val(options.navwidth);
            $("#fm-carousel-navheight").val(options.navheight);
            $("#fm-carousel-navspacing").val(options.navspacing);
            $("#fm-carousel-skintemplate").val(options.skintemplate);
            $("#fm-carousel-skincss").val(options.skincss)
        };
        $("input:radio[name=fm-carousel-skin]").click(function() {
            if ($(this).val() ==
                fm_carousel_config.skin) return;
            $(".fm-tab-skin").find("img").removeClass("selected");
            $("input:radio[name=fm-carousel-skin]:checked").parent().find("img").addClass("selected");
            fm_carousel_config.skin = $(this).val();
            printSkinOptions(defaultSkinOptions[$(this).val()])
        });
        $(".fm-carousel-options-menu-item").each(function(index) {
            $(this).click(function() {
                if ($(this).hasClass("fm-carousel-options-menu-item-selected")) return;
                $(".fm-carousel-options-menu-item").removeClass("fm-carousel-options-menu-item-selected");
                $(this).addClass("fm-carousel-options-menu-item-selected");
                $(".fm-carousel-options-tab").removeClass("fm-carousel-options-tab-selected");
                $(".fm-carousel-options-tab").eq(index).addClass("fm-carousel-options-tab-selected")
            })
        });
        var updateCarouselOptions = function() {
            fm_carousel_config.newestfirst = $("#fm-newestfirst").is(":checked");
            fm_carousel_config.name = $.trim($("#fm-carousel-name").val());
            fm_carousel_config.skin =
                $("input:radio[name=fm-carousel-skin]:checked").val();
            fm_carousel_config.width = parseInt($.trim($("#fm-carousel-width").val()));
            fm_carousel_config.height = parseInt($.trim($("#fm-carousel-height").val()));
            fm_carousel_config.spacing = parseInt($.trim($("#fm-carousel-spacing").val()));
            fm_carousel_config.rownumber = parseInt($.trim($("#fm-carousel-rownumber").val()));
            fm_carousel_config.fixaspectratio = $("#fm-carousel-fixaspectratio").is(":checked");
            fm_carousel_config.centerimage = $("#fm-carousel-centerimage").is(":checked");
            fm_carousel_config.fitimage = $("#fm-carousel-fitimage").is(":checked");
            fm_carousel_config.fitcenterimage = $("#fm-carousel-fitcenterimage").is(":checked");
            fm_carousel_config.sameheight = $("#fm-carousel-sameheight").is(":checked");
            fm_carousel_config.sameheightresponsive = $("#fm-carousel-sameheightresponsive").is(":checked");
            fm_carousel_config.sameheightmediumscreen =
                parseInt($.trim($("#fm-carousel-sameheightmediumscreen").val()));
            fm_carousel_config.sameheightmediumheight = parseInt($.trim($("#fm-carousel-sameheightmediumheight").val()));
            fm_carousel_config.sameheightsmallscreen = parseInt($.trim($("#fm-carousel-sameheightsmallscreen").val()));
            fm_carousel_config.sameheightsmallheight = parseInt($.trim($("#fm-carousel-sameheightsmallheight").val()));
            fm_carousel_config.fullwidth = $("#fm-carousel-fullwidth").is(":checked");
            fm_carousel_config.hidecontaineroninit = $("#fm-carousel-hidecontaineroninit").is(":checked");
            fm_carousel_config.hidecontainerbeforeloaded = $("#fm-carousel-hidecontainerbeforeloaded").is(":checked");
            fm_carousel_config.autoplay = $("#fm-carousel-autoplay").is(":checked");
            fm_carousel_config.random = $("#fm-carousel-random").is(":checked");
            fm_carousel_config.circular = $("#fm-carousel-circular").is(":checked");
            fm_carousel_config.responsive = $("#fm-carousel-responsive").is(":checked");
            fm_carousel_config.visibleitems = parseInt($.trim($("#fm-carousel-visibleitems").val()));
            if (isNaN(fm_carousel_config.visibleitems) || fm_carousel_config.visibleitems < 1) fm_carousel_config.visibleitems = 3;
            fm_carousel_config.pauseonmouseover = $("#fm-carousel-pauseonmouseover").is(":checked");
            fm_carousel_config.scrollmode = $("#fm-carousel-scrollmode").val();
            fm_carousel_config.interval = parseInt($.trim($("#fm-carousel-interval").val()));
            fm_carousel_config.transitionduration = parseInt($.trim($("#fm-carousel-transitionduration").val()));
            fm_carousel_config.continuous = $("#fm-carousel-continuous").is(":checked");
            fm_carousel_config.continuousduration = parseInt($.trim($("#fm-carousel-continuousduration").val()));
            fm_carousel_config.imgextraprops = $.trim($("#fm-carousel-imgextraprops").val());
            if ($("input[name=fm-carousel-usescreenquery]:checked").val() == "screensize") fm_carousel_config.usescreenquery = true;
            else fm_carousel_config.usescreenquery = false;
            fm_carousel_config.screenquery = $.trim($("#fm-carousel-screenquery").val());
            fm_carousel_config.arrowstyle = $("#fm-carousel-arrowstyle").val();
            fm_carousel_config.arrowimagemode = $("input[name=fm-carousel-arrowimagemode]:checked").val();
            if (fm_carousel_config.arrowimagemode ==
                "custom") fm_carousel_config.arrowimage = $.trim($("#fm-carousel-customarrowimage").val());
            else fm_carousel_config.arrowimage = $.trim($("#fm-carousel-arrowimage").val());
            fm_carousel_config.arrowwidth = parseInt($.trim($("#fm-carousel-arrowwidth").val()));
            if (isNaN(fm_carousel_config.arrowwidth) || fm_carousel_config.arrowwidth < 0) fm_carousel_config.arrowwidth = defaultSkinOptions[fm_carousel_config.skin]["arrowwidth"];
            fm_carousel_config.arrowheight = parseInt($.trim($("#fm-carousel-arrowheight").val()));
            if (isNaN(fm_carousel_config.arrowheight) || fm_carousel_config.arrowheight < 0) fm_carousel_config.arrowheight = defaultSkinOptions[fm_carousel_config.skin]["arrowheight"];
            fm_carousel_config.showhoveroverlay = $("#fm-carousel-showhoveroverlay").is(":checked");
            fm_carousel_config.showhoveroverlayalways = $("#fm-carousel-showhoveroverlayalways").is(":checked");
            fm_carousel_config.hidehoveroverlayontouch = $("#fm-carousel-hidehoveroverlayontouch").is(":checked");
            fm_carousel_config.hoveroverlayimagemode = $("input[name=fm-carousel-hoveroverlayimagemode]:checked").val();
            if (fm_carousel_config.hoveroverlayimagemode == "custom") fm_carousel_config.hoveroverlayimage = $.trim($("#fm-carousel-customhoveroverlayimage").val());
            else fm_carousel_config.hoveroverlayimage = $.trim($("#fm-carousel-hoveroverlayimage").val());
            fm_carousel_config.showplayvideo = $("#fm-carousel-showplayvideo").is(":checked");
            fm_carousel_config.playvideoimagemode = $("input[name=fm-carousel-playvideoimagemode]:checked").val();
            if (fm_carousel_config.playvideoimagemode == "custom") fm_carousel_config.playvideoimage = $.trim($("#fm-carousel-customplayvideoimage").val());
            else fm_carousel_config.playvideoimage = $.trim($("#fm-carousel-playvideoimage").val());
            fm_carousel_config.playvideoimagepos =
                $("#fm-carousel-playvideoimagepos").val();
            fm_carousel_config.navstyle = $("#fm-carousel-navstyle").val();
            fm_carousel_config.navimagemode = $("input[name=fm-carousel-navimagemode]:checked").val();
            if (fm_carousel_config.navimagemode == "custom") fm_carousel_config.navimage = $.trim($("#fm-carousel-customnavimage").val());
            else fm_carousel_config.navimage = $.trim($("#fm-carousel-navimage").val());
            fm_carousel_config.navwidth =
                parseInt($.trim($("#fm-carousel-navwidth").val()));
            if (isNaN(fm_carousel_config.navwidth) || fm_carousel_config.navwidth < 0) fm_carousel_config.navwidth = defaultSkinOptions[fm_carousel_config.skin]["navwidth"];
            fm_carousel_config.navheight = parseInt($.trim($("#fm-carousel-navheight").val()));
            if (isNaN(fm_carousel_config.navheight) || fm_carousel_config.navheight < 0) fm_carousel_config.navheight = defaultSkinOptions[fm_carousel_config.skin]["navheight"];
            fm_carousel_config.navspacing = parseInt($.trim($("#fm-carousel-navspacing").val()));
            if (isNaN(fm_carousel_config.navspacing)) fm_carousel_config.navspacing = defaultSkinOptions[fm_carousel_config.skin]["navspacing"];
            fm_carousel_config.direction = defaultSkinOptions[fm_carousel_config.skin]["direction"];
            fm_carousel_config.skintemplate = $.trim($("#fm-carousel-skintemplate").val()).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g,
                "&gt;");
            fm_carousel_config.skincss = $.trim($("#fm-carousel-skincss").val());
            fm_carousel_config.customcss = $.trim($("#fm-carousel-custom-css").val());
            fm_carousel_config.dataoptions = $.trim($("#fm-carousel-data-options").val());
            fm_carousel_config.lightboxresponsive = $("#fm-carousel-lightboxresponsive").is(":checked");
            fm_carousel_config.lightboxshownavigation = $("#fm-carousel-lightboxshownavigation").is(":checked");
            fm_carousel_config.lightboxnogroup = $("#fm-carousel-lightboxnogroup").is(":checked");
            fm_carousel_config.lightboxshowtitle = $("#fm-carousel-lightboxshowtitle").is(":checked");
            fm_carousel_config.lightboxshowdescription = $("#fm-carousel-lightboxshowdescription").is(":checked");
            fm_carousel_config.lightboxvideohidecontrols = $("#fm-carousel-lightboxvideohidecontrols").is(":checked");
            fm_carousel_config.lightboxfullscreenmode =
                $("#fm-carousel-lightboxfullscreenmode").is(":checked");
            fm_carousel_config.lightboxcloseonoverlay = $("#fm-carousel-lightboxcloseonoverlay").is(":checked");
            fm_carousel_config.lightboxtitlestyle = $.trim($("#fm-carousel-lightboxtitlestyle").val());
            fm_carousel_config.lightboxdefaultvideovolume = parseFloat($.trim($("#fm-carousel-lightboxdefaultvideovolume").val()));
            fm_carousel_config.lightboximagepercentage = parseInt($.trim($("#fm-carousel-lightboximagepercentage").val()));
            fm_carousel_config.lightboxoverlayopacity = parseFloat($.trim($("#fm-carousel-lightboxoverlayopacity").val()));
            fm_carousel_config.lightboxoverlaybgcolor = $.trim($("#fm-carousel-lightboxoverlaybgcolor").val());
            fm_carousel_config.lightboxbgcolor = $.trim($("#fm-carousel-lightboxbgcolor").val());
            fm_carousel_config.lightboxtitleprefix = $("#fm-carousel-lightboxtitleprefix").val();
            fm_carousel_config.lightboxtitleinsidecss =
                $.trim($("#fm-carousel-lightboxtitleinsidecss").val());
            fm_carousel_config.lightboxdescriptioninsidecss = $.trim($("#fm-carousel-lightboxdescriptioninsidecss").val());
            fm_carousel_config.lightboxadvancedoptions = $.trim($("#fm-carousel-lightboxadvancedoptions").val());
            fm_carousel_config.lightboxautoslide = $("#fm-carousel-lightboxautoslide").is(":checked");
            fm_carousel_config.lightboxshowtimer = $("#fm-carousel-lightboxshowtimer").is(":checked");
            fm_carousel_config.lightboxshowplaybutton = $("#fm-carousel-lightboxshowplaybutton").is(":checked");
            fm_carousel_config.lightboxalwaysshownavarrows = $("#fm-carousel-lightboxalwaysshownavarrows").is(":checked");
            fm_carousel_config.lightboxshowtitleprefix = $("#fm-carousel-lightboxshowtitleprefix").is(":checked");
            fm_carousel_config.lightboxslideinterval = parseInt($.trim($("#fm-carousel-lightboxslideinterval").val()));
            fm_carousel_config.lightboxtimerheight =
                parseInt($.trim($("#fm-carousel-lightboxtimerheight").val()));
            fm_carousel_config.lightboxbordersize = parseInt($.trim($("#fm-carousel-lightboxbordersize").val()));
            fm_carousel_config.lightboxborderradius = parseInt($.trim($("#fm-carousel-lightboxborderradius").val()));
            fm_carousel_config.lightboxtimeropacity = parseFloat($.trim($("#fm-carousel-lightboxtimeropacity").val()));
            fm_carousel_config.lightboxtimerposition = $.trim($("#fm-carousel-lightboxtimerposition").val());
            fm_carousel_config.lightboxtimercolor = $.trim($("#fm-carousel-lightboxtimercolor").val());
            fm_carousel_config.lightboxshowsocial = $("#fm-carousel-lightboxshowsocial").is(":checked");
            fm_carousel_config.lightboxsocialposition = $.trim($("#fm-carousel-lightboxsocialposition").val());
            fm_carousel_config.lightboxsocialpositionsmallscreen = $.trim($("#fm-carousel-lightboxsocialpositionsmallscreen").val());
            fm_carousel_config.lightboxsocialdirection =
                $.trim($("#fm-carousel-lightboxsocialdirection").val());
            fm_carousel_config.lightboxsocialbuttonsize = parseInt($.trim($("#fm-carousel-lightboxsocialbuttonsize").val()));
            fm_carousel_config.lightboxsocialbuttonfontsize = parseInt($.trim($("#fm-carousel-lightboxsocialbuttonfontsize").val()));
            fm_carousel_config.lightboxsocialrotateeffect = $("#fm-carousel-lightboxsocialrotateeffect").is(":checked");
            fm_carousel_config.lightboxshowfacebook =
                $("#fm-carousel-lightboxshowfacebook").is(":checked");
            fm_carousel_config.lightboxshowtwitter = $("#fm-carousel-lightboxshowtwitter").is(":checked");
            fm_carousel_config.lightboxshowpinterest = $("#fm-carousel-lightboxshowpinterest").is(":checked");
            fm_carousel_config.lightboximagekeepratio = $("#fm-carousel-lightboximagekeepratio").is(":checked");
            fm_carousel_config.donotinit = $("#fm-carousel-donotinit").is(":checked");
            fm_carousel_config.addinitscript = $("#fm-carousel-addinitscript").is(":checked");
            fm_carousel_config.doshortcodeontext = $("#fm-carousel-doshortcodeontext").is(":checked");
            fm_carousel_config.triggerresize = $("#fm-carousel-triggerresize").is(":checked");
            fm_carousel_config.triggerresizedelay = parseInt($.trim($("#fm-carousel-triggerresizedelay").val()));
            var val = parseInt($.trim($("#fm-carousel-lightboxthumbwidth").val()));
            fm_carousel_config.lightboxthumbwidth = isNaN(val) ? default_options.lightboxthumbwidth : val;
            val = parseInt($.trim($("#fm-carousel-lightboxthumbheight").val()));
            fm_carousel_config.lightboxthumbheight = isNaN(val) ? default_options.lightboxthumbheight : val;
            val = parseInt($.trim($("#fm-carousel-lightboxthumbtopmargin").val()));
            fm_carousel_config.lightboxthumbtopmargin = isNaN(val) ? default_options.lightboxthumbtopmargin : val;
            val = parseInt($.trim($("#fm-carousel-lightboxthumbbottommargin").val()));
            fm_carousel_config.lightboxthumbbottommargin = isNaN(val) ? default_options.lightboxthumbbottommargin : val;
            val = parseInt($.trim($("#fm-carousel-lightboxbarheight").val()));
            fm_carousel_config.lightboxbarheight = isNaN(val) ? default_options.lightboxbarheight : val;
            fm_carousel_config.lightboxtitlebottomcss = $.trim($("#fm-carousel-lightboxtitlebottomcss").val());
            fm_carousel_config.lightboxdescriptionbottomcss = $.trim($("#fm-carousel-lightboxdescriptionbottomcss").val())
        };
        var previewCarousel = function() {
            updateCarouselOptions();
            $("#fm-carousel-preview-container").empty();
            var previewCode = "<div id='fm-carousel-preview'";
            if (fm_carousel_config.dataoptions && fm_carousel_config.dataoptions.length > 0) previewCode += " " + fm_carousel_config.dataoptions;
            previewCode += "></div>";
            $("#fm-carousel-preview-container").html(previewCode);
            if (fm_carousel_config.slides.length > 0) {
                $("head").find("style").each(function() {
                    if ($(this).data("creator") ==
                        "fmcarouselcreator") $(this).remove()
                });
                var carouselid = fm_carousel_config.id > 0 ? fm_carousel_config.id : 0;
                if (fm_carousel_config.customcss && fm_carousel_config.customcss.length > 0) {
                    var customcss = fm_carousel_config.customcss.replace(/fmcarousel-container-CAROUSELID/g, "fm-carousel-preview-container").replace(/fmcarousel-CAROUSELID/g, "fm-carousel-preview").replace(/CAROUSELID/g, carouselid);
                    $("head").append("<style type='text/css' data-creator='fmcarouselcreator'>" +
                        customcss + "</style>")
                }
                if (fm_carousel_config.skincss && fm_carousel_config.skincss.length > 0) $("head").append("<style type='text/css' data-creator='fmcarouselcreator'>" + fm_carousel_config.skincss.replace(/#amazingcarousel-CAROUSELID/g, "#fm-carousel-preview") + "</style>");
                $("#wpcarousellightbox_advanced_options").remove();
                var code = "";
                if (fm_carousel_config.lightboxadvancedoptions && fm_carousel_config.lightboxadvancedoptions.length > 0) {
                    code +=
                        "<div id='wpcarousellightbox_advanced_options'";
                    code += " " + fm_carousel_config.lightboxadvancedoptions;
                    code += "></div>"
                }
                var i;
                code += '<div class="amazingcarousel-list-container" style="overflow:hidden;">';
                code += '<ul class="amazingcarousel-list">';
                if (isNaN(fm_carousel_config.rownumber) || fm_carousel_config.rownumber < 1) fm_carousel_config.rownumber = 1;
                var hasPosts = false;
                var count = 0;
                for (i = 0; i < fm_carousel_config.slides.length; i++) {
                    if (fm_carousel_config.slides[i].type ==
                        6) {
                        hasPosts = true;
                        continue
                    }
                    if (fm_carousel_config.slides[i].type == 10) {
                        if (count > 0) code += "</li>";
                        code += '<li class="amazingcarousel-item"';
                        fm_carousel_config.slides[i].image = "__IMAGE__";
                        fm_carousel_config.slides[i].thumbnail = "__THUMBNAIL__";
                        fm_carousel_config.slides[i].video = "__VIDEO__";
                        fm_carousel_config.slides[i].title = "__TITLE__";
                        fm_carousel_config.slides[i].description = "__DESCRIPTION__";
                        code += ' data-youtubeapikey="' + fm_carousel_config.slides[i].youtubeapikey +
                            '" data-youtubeplaylistid="' + fm_carousel_config.slides[i].youtubeplaylistid + '" data-youtubeplaylistmaxresults="' + fm_carousel_config.slides[i].youtubeplaylistmaxresults + '"';
                        code += ">"
                    } else if (count == 0) code += '<li class="amazingcarousel-item">';
                    else if (count % fm_carousel_config.rownumber == 0) code += '</li><li class="amazingcarousel-item">';
                    count++;
                    code += '<div class="amazingcarousel-item-container">';
                    var image_code = "";
                    if (fm_carousel_config.slides[i].lightbox) {
                        image_code +=
                            '<a href="';
                        if (fm_carousel_config.slides[i].type == 0) image_code += fm_carousel_config.slides[i].image;
                        else if (fm_carousel_config.slides[i].type == 1) {
                            image_code += fm_carousel_config.slides[i].mp4;
                            if (fm_carousel_config.slides[i].webm) image_code += '" data-webm="' + fm_carousel_config.slides[i].webm
                        } else if (fm_carousel_config.slides[i].type == 2 || fm_carousel_config.slides[i].type == 3 || fm_carousel_config.slides[i].type == 10) image_code +=
                            fm_carousel_config.slides[i].video;
                        if (fm_carousel_config.slides[i].title && fm_carousel_config.slides[i].title.length > 0) image_code += '" title="' + fm_carousel_config.slides[i].title.replace(/"/g, "&quot;");
                        if (fm_carousel_config.slides[i].description && fm_carousel_config.slides[i].description.length > 0) image_code += '" data-description="' + fm_carousel_config.slides[i].description.replace(/"/g, "&quot;");
                        if (fm_carousel_config.slides[i].lightboxsize) image_code +=
                            '" data-width="' + fm_carousel_config.slides[i].lightboxwidth + '" data-height="' + fm_carousel_config.slides[i].lightboxheight;
                        image_code += '" data-thumbnail="' + fm_carousel_config.slides[i].thumbnail;
                        image_code += '" class="wondercarousellightbox wondercarousellightbox-' + carouselid + '"';
                        if (!fm_carousel_config.lightboxnogroup) image_code += ' data-group="wondercarousellightbox-' + carouselid + '"';
                        if (fm_carousel_config.slides[i].type == 10) image_code += " data-ytplaylist=1";
                        image_code += ">"
                    } else if (fm_carousel_config.slides[i].weblink && fm_carousel_config.slides[i].weblink.length > 0) {
                        image_code += '<a href="' + fm_carousel_config.slides[i].weblink + '"';
                        if (fm_carousel_config.slides[i].clickhandler && fm_carousel_config.slides[i].clickhandler.length > 0) image_code += ' onclick="' + fm_carousel_config.slides[i].clickhandler.replace(/"/g, "&quot;") + '"';
                        if (fm_carousel_config.slides[i].linktarget && fm_carousel_config.slides[i].linktarget.length >
                            0) image_code += ' target="' + fm_carousel_config.slides[i].linktarget + '"';
                        if (fm_carousel_config.slides[i].weblinklightbox) {
                            image_code += '" class="wondercarousellightbox wondercarousellightbox-' + carouselid + '"';
                            if (!fm_carousel_config.lightboxnogroup) image_code += ' data-group="wondercarousellightbox-' + carouselid + '"';
                            if (fm_carousel_config.slides[i].lightboxsize) image_code += ' data-width="' + fm_carousel_config.slides[i].lightboxwidth + '" data-height="' + fm_carousel_config.slides[i].lightboxheight +
                                '"'
                        }
                        image_code += ">"
                    }
                    image_code += "<img";
                    if (fm_carousel_config.imgextraprops) image_code += " " + fm_carousel_config.imgextraprops;
                    if (fm_carousel_config.slides[i].type == 10) image_code += ' data-srcyt="';
                    else image_code += ' src="';
                    if (fm_carousel_config.slides[i].displaythumbnail) image_code += fm_carousel_config.slides[i].thumbnail + '"';
                    else image_code += fm_carousel_config.slides[i].image + '"';
                    image_code += ' alt="' + fm_carousel_config.slides[i].title.replace(/"/g,
                        "&quot;") + '"';
                    image_code += ' data-description="' + fm_carousel_config.slides[i].description.replace(/"/g, "&quot;") + '"';
                    if (!fm_carousel_config.slides[i].lightbox)
                        if (fm_carousel_config.slides[i].type == 1) {
                            image_code += ' data-video="' + fm_carousel_config.slides[i].mp4 + '"';
                            if (fm_carousel_config.slides[i].webm) image_code += ' data-videowebm="' + fm_carousel_config.slides[i].webm + '"'
                        } else if (fm_carousel_config.slides[i].type == 2 || fm_carousel_config.slides[i].type ==
                        3 || fm_carousel_config.slides[i].type == 10) image_code += ' data-video="' + fm_carousel_config.slides[i].video + '"';
                    image_code += " />";
                    if (fm_carousel_config.slides[i].lightbox || !fm_carousel_config.slides[i].lightbox && fm_carousel_config.slides[i].weblink && fm_carousel_config.slides[i].weblink.length > 0) image_code += "</a>";
                    var title_code = "";
                    if (fm_carousel_config.slides[i].title && fm_carousel_config.slides[i].title.length > 0) title_code =
                        fm_carousel_config.slides[i].title;
                    var description_code = "";
                    if (fm_carousel_config.slides[i].description && fm_carousel_config.slides[i].description.length > 0) description_code = fm_carousel_config.slides[i].description;
                    var skin_template = fm_carousel_config.skintemplate.replace(/&amp;/g, "&").replace(/&lt;/g, "<").replace(/&gt;/g, ">").replace(/__IMAGE__/g, image_code).replace(/__TITLE__/g, title_code).replace(/__DESCRIPTION__/g, description_code);
                    skin_template =
                        skin_template.replace(/__HREF__/g, fm_carousel_config.slides[i].weblink);
                    skin_template = skin_template.replace(/__CLICKHANDLER__/g, fm_carousel_config.slides[i].clickhandler);
                    skin_template = skin_template.replace(/__TARGET__/g, fm_carousel_config.slides[i].linktarget);
                    code += skin_template;
                    code += "</div>"
                }
                if (count > 0) code += "</li>";
                code += "</ul>";
                code += '<div class="amazingcarousel-prev"></div><div class="amazingcarousel-next"></div>';
                code += "</div>";
                code += '<div class="amazingcarousel-nav"></div>';
                var jsfolder = $("#fm-carousel-jsfolder").text();
                var carouselOptions = $.extend({}, FM_CAROUSEL_SKIN_OPTIONS[fm_carousel_config["skin"]], {
                    carouselid: carouselid,
                    jsfolder: jsfolder
                }, fm_carousel_config);
                var totalwidth;
                if (carouselOptions.direction == "vertical") totalwidth = carouselOptions.width;
                else totalwidth = carouselOptions.width * carouselOptions.visibleitems;
                if (carouselOptions.responsive) $("#fm-carousel-preview").css({
                    display: "none",
                    position: "relative",
                    width: "100%",
                    "max-width": totalwidth + "px"
                });
                else $("#fm-carousel-preview").css({
                    display: "none",
                    position: "relative",
                    width: totalwidth + "px"
                });
                $("#fm-carousel-preview").html(code);
                carouselOptions.screenquery = jQuery.parseJSON(carouselOptions.screenquery);
                $("#fm-carousel-preview").fmcarouselslider(carouselOptions);
                $(window).trigger("resize");
                if (hasPosts) $("#fm-carousel-preview-message").html("The WordPress posts slider is not available in the Preview tab. To view the effect, save and publish the carousel, then clik the View Slider link. Or you can add the provided shortcode to a post or page to view the effect.");
                else $("#fm-carousel-preview-message").empty()
            }
        };
        var postPublish = function(message) {
            $("#fm-carousel-publish-loading").hide();
            var formnonce = $("#fm-carousel-saveformnonce").html();
            var errorHtml = "";
            if (message) {
                errorHtml += "<div class='error'><p>Error message: " + message + "</p></div>";
                errorHtml += "<div class='error'><p>WordPress Ajax call failed. Please click the button below and save with POST method</p></div>"
            } else {
                errorHtml += "<div class='error'><p>WordPress Ajax call failed. Please check your WordPress configuration file and make sure the WP_DEBUG is set to false.</p></div>";
                errorHtml += "<div class='error'><p>Please click the button below and save with POST method</p></div>"
            }
            errorHtml += "<form method='post'>";
            errorHtml += formnonce;
            errorHtml += "<input type='hidden' name='fm-carousel-save-item-post-value' id='fm-carousel-save-item-post-value' value='" + JSON.stringify(fm_carousel_config).replace(/"/g, "&quot;").replace(/'/g, "&#39;") + "' />";
            errorHtml += "<p class='submit'><input type='submit' name='fm-carousel-save-item-post' id='fm-carousel-save-item-post' class='button button-primary' value='Save & Publish with Post Method'  /></p>";
            errorHtml += "</form>";
            $("#fm-carousel-publish-information").html(errorHtml)
        };
        var publishCarousel = function() {
            $("#fm-carousel-publish-loading").show();
            updateCarouselOptions();
            var ajaxnonce = $("#fm-carousel-ajaxnonce").text();
            jQuery.ajax({
                url: ajaxurl,
                type: "POST",
                data: {
                    action: "fm_carousel_save_config",
                    nonce: ajaxnonce,
                    item: JSON.stringify(fm_carousel_config)
                },
                success: function(data) {
                    $("#fm-carousel-publish-loading").hide();
                    if (data && data.success &&
                        data.id >= 0) {
                        fm_carousel_config.id = data.id;
                        $("#fm-carousel-publish-information").html("<div class='updated'><p>The carousel has been saved and published: <a href='" + $("#fm-carousel-viewadminurl").text() + "&itemid=" + data.id + "' target='_blank'>View Slider</a></p></div>" + "<div class='updated'><p>To embed the carousel into your page or post, use shortcode:  [fm_carousel id=\"" + data.id + '"]</p></div>' + "<div class='updated'><p>To embed the carousel into your template, use php code:  &lt;?php echo do_shortcode('[fm_carousel id=\"" +
                            data.id + "\"]'); ?&gt;</p></div>")
                    } else postPublish(data && data.message ? data.message : "")
                },
                error: function() {
                    $("#fm-carousel-publish-loading").hide();
                    postPublish("")
                }
            })
        };
        var fm_carousel_config = $.extend({}, default_options, defaultSkinOptions[default_options["skin"]]);
        var carouselId = parseInt($("#fm-carousel-id").text());
        if (carouselId >= 0) {
            var saved_config = $.parseJSON($("#fm-carousel-id-config").text());
            if (!("fixaspectratio" in saved_config)) saved_config.fixaspectratio =
                false;
            if (!("centerimage" in saved_config)) saved_config.centerimage = false;
            if (!("fitimage" in saved_config)) saved_config.fitimage = false;
            if (!("fitcenterimage" in saved_config)) saved_config.fitcenterimage = false;
            if ("skin" in saved_config && saved_config["skin"] in defaultSkinOptions) $.extend(fm_carousel_config, defaultSkinOptions[saved_config["skin"]]);
            $.extend(fm_carousel_config, saved_config);
            fm_carousel_config.id = carouselId
        }
        var i;
        var j;
        for (i = 0; i < fm_carousel_config.slides.length; i++) {
            if (!("lightboxsize" in
                    fm_carousel_config.slides[i])) fm_carousel_config.slides[i]["lightboxsize"] = false;
            if (!("lightboxwidth" in fm_carousel_config.slides[i])) fm_carousel_config.slides[i]["lightboxwidth"] = 640;
            if (!("lightboxheight" in fm_carousel_config.slides[i])) fm_carousel_config.slides[i]["lightboxheight"] = 480;
            if (!("clickhandler" in fm_carousel_config.slides[i])) fm_carousel_config.slides[i]["clickhandler"] = "";
            if ("postlightbox" in fm_carousel_config.slides[i]) {
                if (fm_carousel_config.slides[i].postlightbox !==
                    true && fm_carousel_config.slides[i].postlightbox !== false) fm_carousel_config.slides[i].postlightbox = fm_carousel_config.slides[i].postlightbox && fm_carousel_config.slides[i].postlightbox.toLowerCase() === "true";
                if (fm_carousel_config.slides[i].postlightboxsize !== true && fm_carousel_config.slides[i].postlightboxsize !== false) fm_carousel_config.slides[i].postlightboxsize = fm_carousel_config.slides[i].postlightboxsize && fm_carousel_config.slides[i].postlightboxsize.toLowerCase() ===
                    "true";
                if (fm_carousel_config.slides[i].posttitlelink !== true && fm_carousel_config.slides[i].posttitlelink !== false) fm_carousel_config.slides[i].posttitlelink = fm_carousel_config.slides[i].posttitlelink && fm_carousel_config.slides[i].posttitlelink.toLowerCase() === "true"
            }
            if (fm_carousel_config.slides[i].type == 6) {
                if (!("postorder" in fm_carousel_config.slides[i])) fm_carousel_config.slides[i].postorder = "DESC";
                if (!("postdaterange" in
                        fm_carousel_config.slides[i])) fm_carousel_config.slides[i].postdaterange = false;
                else if (fm_carousel_config.slides[i].postdaterange !== true && fm_carousel_config.slides[i].postdaterange !== false) fm_carousel_config.slides[i].postdaterange = fm_carousel_config.slides[i].postdaterange && fm_carousel_config.slides[i].postdaterange.toLowerCase() === "true";
                if (!("postdaterangeafter" in fm_carousel_config.slides[i])) fm_carousel_config.slides[i].postdaterangeafter =
                    30
            }
        }
        var slideBoolOptions = ["lightbox", "lightboxsize", "displaythumbnail", "weblinklightbox"];
        for (i = 0; i < fm_carousel_config.slides.length; i++)
            for (j = 0; j < slideBoolOptions.length; j++)
                if (fm_carousel_config.slides[i][slideBoolOptions[j]] !== true && fm_carousel_config.slides[i][slideBoolOptions[j]] !== false) fm_carousel_config.slides[i][slideBoolOptions[j]] = fm_carousel_config.slides[i][slideBoolOptions[j]] && fm_carousel_config.slides[i][slideBoolOptions[j]].toLowerCase() ===
                    "true";
        var boolOptions = ["hidecontainerbeforeloaded", "hidecontaineroninit", "fullwidth", "sameheight", "sameheightresponsive", "newestfirst", "centerimage", "fitimage", "fitcenterimage", "fixaspectratio", "autoplay", "random", "circular", "pauseonmouseover", "continuous", "responsive", "showhoveroverlay", "showhoveroverlayalways", "hidehoveroverlayontouch", "lightboxresponsive", "lightboxshownavigation", "lightboxnogroup", "lightboxshowtitle", "lightboxshowdescription", "usescreenquery", "donotinit", "addinitscript", "lightboxshowsocial",
            "lightboxshowfacebook", "lightboxshowtwitter", "lightboxshowpinterest", "lightboxsocialrotateeffect", "lightboximagekeepratio", "showplayvideo", "triggerresize", "doshortcodeontext", "lightboxfullscreenmode", "lightboxcloseonoverlay", "lightboxvideohidecontrols", "lightboxautoslide", "lightboxshowtimer", "lightboxshowplaybutton", "lightboxalwaysshownavarrows", "lightboxshowtitleprefix"
        ];
        for (i = 0; i < boolOptions.length; i++)
            if (fm_carousel_config[boolOptions[i]] !== true && fm_carousel_config[boolOptions[i]] !==
                false) fm_carousel_config[boolOptions[i]] = fm_carousel_config[boolOptions[i]] && fm_carousel_config[boolOptions[i]].toLowerCase() === "true";
        if (fm_carousel_config.dataoptions && fm_carousel_config.dataoptions.length > 0) fm_carousel_config.dataoptions = fm_carousel_config.dataoptions.replace(/\\"/g, '"').replace(/\\'/g, "'");
        var printConfig = function() {
            $("#fm-newestfirst").attr("checked", fm_carousel_config.newestfirst);
            $("#fm-carousel-name").val(fm_carousel_config.name);
            updateMediaTable();
            $(".fm-tab-skin").find("img").removeClass("selected");
            $("input:radio[name=fm-carousel-skin][value=" + fm_carousel_config.skin + "]").attr("checked", true);
            $("input:radio[name=fm-carousel-skin][value=" + fm_carousel_config.skin + "]").parent().find("img").addClass("selected");
            printSkinOptions(fm_carousel_config);
            $("#fm-carousel-imgextraprops").val(fm_carousel_config.imgextraprops);
            $("#fm-carousel-showplayvideo").attr("checked",
                fm_carousel_config.showplayvideo);
            $("input:radio[name=fm-carousel-playvideoimagemode][value=" + fm_carousel_config.playvideoimagemode + "]").attr("checked", true);
            if (fm_carousel_config.playvideoimagemode == "custom") {
                $("#fm-carousel-customplayvideoimage").val(fm_carousel_config.playvideoimage);
                $("#fm-carousel-displayplayvideoimage").attr("src", fm_carousel_config.playvideoimage)
            } else {
                $("#fm-carousel-playvideoimage").val(fm_carousel_config.playvideoimage);
                $("#fm-carousel-displayplayvideoimage").attr("src", $("#fm-carousel-jsfolder").text() + fm_carousel_config.playvideoimage)
            }
            $("#fm-carousel-playvideoimagepos").val(fm_carousel_config.playvideoimagepos);
            $("#fm-carousel-custom-css").val(fm_carousel_config.customcss);
            $("#fm-carousel-data-options").val(fm_carousel_config.dataoptions);
            $("#fm-carousel-lightboxresponsive").attr("checked", fm_carousel_config.lightboxresponsive);
            $("#fm-carousel-lightboxshownavigation").attr("checked", fm_carousel_config.lightboxshownavigation);
            $("#fm-carousel-lightboxnogroup").attr("checked", fm_carousel_config.lightboxnogroup);
            $("#fm-carousel-lightboxshowtitle").attr("checked", fm_carousel_config.lightboxshowtitle);
            $("#fm-carousel-lightboxshowdescription").attr("checked", fm_carousel_config.lightboxshowdescription);
            $("#fm-carousel-lightboxthumbwidth").val(fm_carousel_config.lightboxthumbwidth);
            $("#fm-carousel-lightboxthumbheight").val(fm_carousel_config.lightboxthumbheight);
            $("#fm-carousel-lightboxthumbtopmargin").val(fm_carousel_config.lightboxthumbtopmargin);
            $("#fm-carousel-lightboxthumbbottommargin").val(fm_carousel_config.lightboxthumbbottommargin);
            $("#fm-carousel-lightboxbarheight").val(fm_carousel_config.lightboxbarheight);
            $("#fm-carousel-lightboxtitlebottomcss").val(fm_carousel_config.lightboxtitlebottomcss);
            $("#fm-carousel-lightboxdescriptionbottomcss").val(fm_carousel_config.lightboxdescriptionbottomcss);
            $("#fm-carousel-lightboxvideohidecontrols").attr("checked", fm_carousel_config.lightboxvideohidecontrols);
            $("#fm-carousel-lightboxfullscreenmode").attr("checked", fm_carousel_config.lightboxfullscreenmode);
            $("#fm-carousel-lightboxcloseonoverlay").attr("checked", fm_carousel_config.lightboxcloseonoverlay);
            $("#fm-carousel-lightboxtitlestyle").val(fm_carousel_config.lightboxtitlestyle);
            $("#fm-carousel-lightboximagepercentage").val(fm_carousel_config.lightboximagepercentage);
            $("#fm-carousel-lightboxdefaultvideovolume").val(fm_carousel_config.lightboxdefaultvideovolume);
            $("#fm-carousel-lightboxoverlaybgcolor").val(fm_carousel_config.lightboxoverlaybgcolor);
            $("#fm-carousel-lightboxoverlayopacity").val(fm_carousel_config.lightboxoverlayopacity);
            $("#fm-carousel-lightboxbgcolor").val(fm_carousel_config.lightboxbgcolor);
            $("#fm-carousel-lightboxtitleprefix").val(fm_carousel_config.lightboxtitleprefix);
            $("#fm-carousel-lightboxtitleinsidecss").val(fm_carousel_config.lightboxtitleinsidecss);
            $("#fm-carousel-lightboxdescriptioninsidecss").val(fm_carousel_config.lightboxdescriptioninsidecss);
            $("#fm-carousel-lightboxadvancedoptions").val(fm_carousel_config.lightboxadvancedoptions);
            $("#fm-carousel-lightboxautoslide").attr("checked",
                fm_carousel_config.lightboxautoslide);
            $("#fm-carousel-lightboxshowtimer").attr("checked", fm_carousel_config.lightboxshowtimer);
            $("#fm-carousel-lightboxshowplaybutton").attr("checked", fm_carousel_config.lightboxshowplaybutton);
            $("#fm-carousel-lightboxalwaysshownavarrows").attr("checked", fm_carousel_config.lightboxalwaysshownavarrows);
            $("#fm-carousel-lightboxshowtitleprefix").attr("checked", fm_carousel_config.lightboxshowtitleprefix);
            $("#fm-carousel-lightboxslideinterval").val(fm_carousel_config.lightboxslideinterval);
            $("#fm-carousel-lightboxtimerposition").val(fm_carousel_config.lightboxtimerposition);
            $("#fm-carousel-lightboxtimerheight").val(fm_carousel_config.lightboxtimerheight);
            $("#fm-carousel-lightboxtimercolor").val(fm_carousel_config.lightboxtimercolor);
            $("#fm-carousel-lightboxtimeropacity").val(fm_carousel_config.lightboxtimeropacity);
            $("#fm-carousel-lightboxbordersize").val(fm_carousel_config.lightboxbordersize);
            $("#fm-carousel-lightboxborderradius").val(fm_carousel_config.lightboxborderradius);
            $("#fm-carousel-lightboximagekeepratio").attr("checked", fm_carousel_config.lightboximagekeepratio);
            $("#fm-carousel-lightboxshowsocial").attr("checked", fm_carousel_config.lightboxshowsocial);
            $("#fm-carousel-lightboxsocialposition").val(fm_carousel_config.lightboxsocialposition);
            $("#fm-carousel-lightboxsocialpositionsmallscreen").val(fm_carousel_config.lightboxsocialpositionsmallscreen);
            $("#fm-carousel-lightboxsocialdirection").val(fm_carousel_config.lightboxsocialdirection);
            $("#fm-carousel-lightboxsocialbuttonsize").val(fm_carousel_config.lightboxsocialbuttonsize);
            $("#fm-carousel-lightboxsocialbuttonfontsize").val(fm_carousel_config.lightboxsocialbuttonfontsize);
            $("#fm-carousel-lightboxsocialrotateeffect").attr("checked",
                fm_carousel_config.lightboxsocialrotateeffect);
            $("#fm-carousel-lightboxshowfacebook").attr("checked", fm_carousel_config.lightboxshowfacebook);
            $("#fm-carousel-lightboxshowtwitter").attr("checked", fm_carousel_config.lightboxshowtwitter);
            $("#fm-carousel-lightboxshowpinterest").attr("checked", fm_carousel_config.lightboxshowpinterest);
            $("#fm-carousel-donotinit").attr("checked", fm_carousel_config.donotinit);
            $("#fm-carousel-addinitscript").attr("checked",
                fm_carousel_config.addinitscript);
            $("#fm-carousel-doshortcodeontext").attr("checked", fm_carousel_config.doshortcodeontext);
            $("#fm-carousel-triggerresize").attr("checked", fm_carousel_config.triggerresize);
            $("#fm-carousel-triggerresizedelay").val(fm_carousel_config.triggerresizedelay)
        };
        printConfig()
    });
    $.fn.wpdraggable = function(callback) {
        this.css("cursor", "move").on("mousedown", function(e) {
            var $dragged = $(this);
            var x = $dragged.offset().left -
                e.pageX;
            var y = $dragged.offset().top - e.pageY;
            var z = $dragged.css("z-index");
            $(document).on("mousemove.wpdraggable", function(e) {
                $dragged.css({
                    "z-index": 999
                }).offset({
                    left: x + e.pageX,
                    top: y + e.pageY
                });
                e.preventDefault()
            }).one("mouseup", function() {
                $(this).off("mousemove.wpdraggable click.wpdraggable");
                $dragged.css("z-index", z);
                var i = $dragged.data("order");
                var coltotal = Math.floor($dragged.parent().parent().parent().innerWidth() / $dragged.parent().parent().outerWidth());
                var row = Math.floor(($dragged.offset().top -
                    $dragged.parent().parent().parent().offset().top) / $dragged.parent().parent().outerHeight());
                var col = Math.floor(($dragged.offset().left - $dragged.parent().parent().parent().offset().left) / $dragged.parent().parent().outerWidth());
                var j = row * coltotal + col;
                callback(i, j)
            });
            e.preventDefault()
        });
        return this
    }
})(jQuery);