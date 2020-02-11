<?php
$arrayFiles = array();

if ($handle = opendir('Takeout/Keep')) {
    while (false !== ($file = readdir($handle))) {
        if (($file != ".")  && strtolower(substr($file, strrpos($file, '.') + 1)) == 'json') {
            $arrayFiles[] = $file;
        }
    }

    closedir($handle);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="resources/style.css">
    <link rel="stylesheet" href="resources/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/grid.css">
    <style>
        .grid-sizer,
        .grid-item {
            width: 22%;
        }

        .gutter-sizer {
            width: 4%;
        }

        /*!
 * Start Bootstrap - Simple Sidebar (https://startbootstrap.com/template-overviews/simple-sidebar)
 * Copyright 2013-2019 Start Bootstrap
 * Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap-simple-sidebar/blob/master/LICENSE)
 */
        body {
            overflow-x: hidden;
        }

        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -15rem;
            -webkit-transition: margin .25s ease-out;
            -moz-transition: margin .25s ease-out;
            -o-transition: margin .25s ease-out;
            transition: margin .25s ease-out;
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 0.875rem 1.25rem;
            font-size: 1.2rem;
        }

        #sidebar-wrapper .list-group {
            width: 15rem;
        }

        #page-content-wrapper {
            min-width: 100vw;
        }

        #wrapper.toggled #sidebar-wrapper {
            margin-left: 0;
        }

        @media (min-width: 768px) {
            #sidebar-wrapper {
                margin-left: 0;
            }

            #page-content-wrapper {
                min-width: 0;
                width: 100%;
            }

            #wrapper.toggled #sidebar-wrapper {
                margin-left: -15rem;
            }
        }

        .card {

            word-break: break-word;
        }

        audio {
            margin-top: 10px;
            width: -webkit-fill-available;
        }

        .sharees img {
            width: 20px;
        }

        .list-group-item {

            padding: 0.5rem !important;
        }

        .morecontent span {
            display: none;
        }

        .morelink {
            display: block;
        }

        .card-footer {
  justify-content: space-between;
}

/*.card:hover .card-footer {
  display: block;
  transition: ease-in-out .1s;
}*/

.labels {
  justify-content: space-evenly;
  display: flex;
  flex-wrap: wrap;
}

.card p {
    margin-bottom: 0px !important;
}


/* fluid 5 columns */
.grid-sizer,
.grid-item { width: 20%; max-height: 500px; }
    </style>
</head>

<body>
    <div class="card-columns m-2" id="pinned-notes">
    </div>
    <div class="grid m-2" id="regular-notes">
    <div class="grid-sizer"></div>
    </div>
</body>
<script src="resources/jquery-3.4.1.min.js"></script>
<script src="resources/jquery.lazy-master/jquery.lazy.min.js"></script>
<script src="resources/bootstrap/js/bootstrap.min.js"></script>
<script src="resources/script.js"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script type="text/javascript">
    var dir = "Takeout/Keep/";

    $(document).ready(function() {
        // Configure/customize these variables.
        var showChar = 200; // How many characters are shown by default
        var ellipsestext = "...";
        var moretext = "Show more >";
        var lesstext = "Show less";


        $('.more').each(function() {
            var arroz = $(this).innerText();
            alert(arroz.lenght);

        });
    });

    //Solution for the JSON note incorrectly listing JPG attachments as JPEG
    //WHEN THE IMAGE FILE CAN NOT BE FOUND IN THE LOOP, THIS FUNCTION REPLACES THE EXTENSION NAME
    function imgError(tag, file) {
        var filename = file;
        var re = /(?:\.([^.]+))?$/;
        var name = filename.replace(/\.[^/.]+$/, "");
        var ext = re.exec(filename)[1];
        var url = "Takeout/Keep/";

        if (ext == "jpeg") {
            var newFilename = name + ".jpg";
            $(tag).attr("src", url + newFilename);
            //The paramater onError is change so that if the file in src is not found again, it replace it with an generic image
            $(tag).attr("onError", "fileError(this)");
        } else {
            fileError(tag);
        }
    }

    function fileError(tag) {
        $(tag).attr("src", "https://image.freepik.com/free-vector/error-404-found-glitch-effect_8024-4.jpg");
    }

    var files = <?php echo json_encode($arrayFiles) ?>;
    files.forEach(loadJSON);

    var qtFiles = files.lenght;
    var counter = 0;
    var arrayNotes = [];
    var pinned = [];
    var archived = [];
    var trashed = [];

    function loadJSON(file) {
        var url = dir + file;


        $.getJSON(url, function(data) {
            //if (data.isPinned == true) {
            //    pinned.push(data);
            //}

            if (counter == files.length - 1) {
                arrayNotes[counter] = data;

                //SORTS THE NOTES BY LAST EDITED DATE
                arrayNotes.sort(function(a, b) {
                    return b.userEditedTimestampUsec - a.userEditedTimestampUsec;
                });

                arrayNotes.forEach(loadNote);

                $('.grid').masonry({
                    // options
                    itemSelector: '.grid-item',
                    horizontalOrder: true,
                    gutter: 5,
                    fitWidth: true
                });
            } else {
                arrayNotes[counter] = data;
                counter++;
            }

        });

    }



    function loadNote(data) {
        var note = "";

        var color = data.color;
        var isTrashed = data.isTrashed;
        var isPinned = data.isPinned;
        var isArchived = data.isArchived;
        var userEditedTimestampUsec = data.userEditedTimestampUsec;

        var title = "";
        var images = "";
        var content = "";
        var records = "";
        var labels = "";
        var links = "";
        var sharees = "";
        var body = false;

        if ("title" in data) {
            if (data.title != "" && data.title != null) {
                title = "<h5>" + data.title + "</h5>";
            }
        }

        if ("attachments" in data) {
            var attachments = data.attachments;
            for (var index in attachments) {
                var obj = attachments[index];

                if (obj.mimetype == "audio/3gp") {
                    records += "<audio controls><source='" + obj.filePath + "'></audio>";
                    body = true;
                }


                if (obj.mimetype == "image/png" || obj.mimetype == "image/jpeg" || obj.mimetype == "image/jpg") {
                    images += "<img class='card-img-top' src='Takeout/Keep/" + obj.filePath + `' onError="imgError(this, '` + obj.filePath + `')"'>`;
                    body = true;
                }
            }
        }

        //To make the notes image-only when there is no text content or title

        if ("listContent" in data) {
            var listContent = data.listContent;
            var itens = "";
            var index = 1;
            for (var text in listContent) {
                var obj = listContent[text];
                var checked = "";
                if (obj.isChecked == true) {
                    checked = "checked";
                }
                itens += "<div class='form-check'><input type='checkbox' " + checked + " class='form-check-input' id='checkbox" + index + "' onclick='return false'><label class='form-check-label' for='checkbox" + index + "'>" + obj.text + "</label></div>";
                index++;
            }

            content = title + itens;
            body = true;
        }

        if ("textContent" in data) {
            var preContent = data.textContent;
            var textContent = preContent.replace(/(?:\r\n|\r|\n)/g, '<br>');

            if (textContent != "" && textContent != null) {
                content = title +
                    "<p class='card-text'>" +
                    textContent +
                    "</p>";
                body = true;
            } else {
                //IF THERE IS NO TITLE OR CONTENT IN THE NOTE, THE CARD WILL HAVE NO BODY
                if (title != "" && title != null) {
                    content = title;
                    body = true;
                } else {
                    content = "";
                    body = false;
                }
            }
        }


        if ("labels" in data) {
            preLabels = data.labels;
            for (var name in preLabels) {
                var obj = preLabels[name];
                for (var prop in obj) {
                    labels += "<span class='badge badge-dark text-white'>" + obj[prop] + "</span>";
                }
            }
        }

        if ("sharees" in data) {
            people = data.sharees;

            for (var index in people) {
                var obj = people[index];
                var isOwner = obj.isOwner; //needs treatment
                var type = obj.type; //needs treatment
                sharees += "<span class='badge badge-light'><img src='resources/img/person.png' width='15px'>" + obj.email + "</span>";
            }
        }



        if ("annotations" in data) {
            var annotations = data.annotations;

            for (var index in annotations) {
                var obj = annotations[index];
                var description = obj.description;
                var source = obj.source; //needs treatment
                var title = obj.title;
                var url = obj.url;
                links += "<div class='card " + color + "'><a class='mb-3' href='" + obj.url + "'><li class='list-group-item bg-light'><strong>" + title + "</strong><p class='text-muted'>" + obj.url + "</p></li></a></div>";
            }

            body = true;

        }

        note = buildNote(body, color, images, content, records, links, labels, sharees, userEditedTimestampUsec);


        //if (isPinned == true) {
        //    $("#pinned-notes").append(note);
        //} else {
        $("#regular-notes").append(note);
        //}


    }

    function buildNote(body, color, images, content, records, links, labels, sharees, timestamp){
        var note = "";
        var main = "";
        var footer = "";

        var sectionRecords = "";
        var sectionLinks = "";
        var sectionSharees = "";
        var sectionLabels = "";
        var sectionTimestamp = "";

        if(records != ""){
            sectionRecords = "<div class='records mt-1'>" + records + "</div>";
        }

        if(links != ""){
            sectionLinks = "<div class='links mt-1'>" + links + "</div>";
        }

        if(sharees != ""){
            sectionSharees = "<div class='sharees mt-1'>" + sharees + "</div>";
        }

        if(labels != ""){
            sectionLabels = "<div class='labels mt-1'>" + labels + "</div>";
        }

        sectionTimestamp = "<div class='timestamp'><p class='card-text  text-center'><small class='text-muted'> Edited:&nbsp;&nbsp;" + formatTS(timestamp) + "</small></p></div>";

        
        if (body == true) {
            main = "<div class='card-body'>"+
                        "<div class='text'>" + 
                            content + 
                        "</div>" +
                        sectionRecords +
                        sectionLinks +
                    "</div>";
        } else {
            main = "";
        }

        footer = "<div class='card-footer p-1 text-center'>" +
            sectionLabels +
            sectionSharees +
            sectionTimestamp +
            "</div>";
        
         note = "<div class='grid-item'><div class='card " + color + "'>" +
            images +
            main +
            footer +
            "</div></div>";

        return note;
        
    }

    
</script>

</html>