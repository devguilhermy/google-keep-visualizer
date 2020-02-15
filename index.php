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
    <link rel="stylesheet" href="resources/light-colors.css">
    <style>
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
            max-height: 700px;
            overflow: hidden;
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

        .breadcrumb {

            padding: .50rem 1rem !important;
            margin-bottom: 0rem !important;
        }

        #labels-list {

            text-align: center !important;
        }

        .body {
            background-color: #202124;
        }


        .card-body {
            padding: 1rem !important;
        }

        .breadcrumb {
            justify-content: center;
        }

        hr {

            margin-top: .5rem;
            margin-bottom: .5rem;
        }
    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="sidebar bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">Notes</div>
            <div class="list-group list-group-flush" id="labels-list">
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">

            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <button class="btn btn-primary" id="menu-toggle">Labels</button>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0 text-center">
                        <li class="nav-item">
                            <button class="btn btn-light" onclick="darkenize()" id="arroz" href="#"><img src="resources/img/theme.png" style="width: 24px"></button>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="mt-4 pl-4 light-dark"><strong>PINNED NOTES</strong></div>
            <hr>

            <div class="card-columns m-4" id="pinned-notes">
                <div class="spinner-grow loading" role="status">
                    <span class="sr-only">Loading...</span>
                    Loading
                </div>
            </div>
            <div class="mt-4 pl-4 light-dark"><strong>REGULAR NOTES</strong></div>
            <hr>
            <div class="card-columns m-4" id="regular-notes">
                <div class="spinner-grow loading" role="status">
                    <span class="sr-only">Loading...</span>
                    Loading
                </div>
            </div>
            <div class="mt-4 pl-4 light-dark"><strong>ARCHIVED NOTES</strong></div>
            <hr>
            <div class="card-columns m-4" id="archived-notes">
                <div class="spinner-grow loading" role="status">
                    <span class="sr-only">Loading...</span>
                    Loading
                </div>
            </div>
        </div>
    </div>
</body>
<script src="resources/jquery-3.4.1.min.js"></script>
<script src="resources/jquery.lazy-master/jquery.lazy.min.js"></script>
<script src="resources/bootstrap/js/bootstrap.min.js"></script>
<script src="resources/script.js"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script type="text/javascript">
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    function darkenize() {
        $("link[href='resources/light-colors.css']").attr("href", "resources/dark-colors.css")
        $(".navbar").removeClass("navbar-light");
        $(".navbar").removeClass("bg-light");
        $(".navbar").addClass("bg-dark");
        $(".navbar").addClass("nav-dark");
        $("#arroz").attr("onclick", "lightenize()");
    }

    function lightenize() {

        $("link[href='resources/dark-colors.css']").attr("href", "resources/light-colors.css")
        $(".navbar").removeClass("navbar-dark");
        $(".navbar").removeClass("bg-dark");
        $(".navbar").addClass("bg-link");
        $(".navbar").addClass("navbar-light");
        $("#arroz").attr("onclick", "darkenize()");
    }

    var dir = "Takeout/Keep/";

    $(document).ready(function() {
        // Configure/customize these variables.
        var showChar = 200; // How many characters are shown by default
        var ellipsestext = "...";
        var moretext = "Show more >";
        var lesstext = "Show less";


        $('.more').each(function() {
            var content = $(this).text();
            if (content.length > showChar) {
                alert($(this).text());
            }

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

    function createNotes(array) {
        //SORTS THE NOTES BY LAST EDITED DATE
        array.sort(function(a, b) {
            return b.userEditedTimestampUsec - a.userEditedTimestampUsec;
        });

        array.forEach(loadNote);
        $(".loading").remove();

        arNotes(array);

        labSort.forEach(createLabel);
        //$("#label-counter").text(labels.length);
    }

    function createLabel(label) {
        $("#labels-list").append(`<a href="#" onclick="notesLabel('` + label + `')" class='list-group-item list-group-item-action bg-light pl-2'>` + label + `</a>`);
    }

    var files = <?php echo json_encode($arrayFiles) ?>;
    files.forEach(loadJSON);
    $("#note-counter").text(files.length);


    var qtFiles = files.lenght;
    var counter = 0;
    var arrayNotes = [];
    var pinned = [];
    var archived = [];
    var trashed = [];
    var labSort = [];

    function loadJSON(file) {
        var url = dir + file;


        $.getJSON(url, function(data) {
            //if (data.isPinned == true) {
            //    pinned.push(data);
            //}

            if (counter == files.length - 1) {
                arrayNotes[counter] = data;

                createNotes(arrayNotes);
                arNotes(arrayNotes);
            } else {
                arrayNotes[counter] = data;
                counter++;
            }

        });

    }

    function arNotes(notes) {
        if (notes != null) {
            $.ajax({
                url: 'arrayNotes.php',
                data: {
                    array: notes
                },
                dataType: 'txt',
                success: function(data) {
                    alert(data)
                },
                type: 'GET'
            });
        } else {
            console.log(notes)
            $.getJSON("notes.json", function(data) {
                return data;
            });
        }
    }



    function notesLabel(label) {
        $("#pinned-notes").empty();
        $("#regular-notes").empty();
        $("#archived-notes").empty();

        var arrayNotes = arNotes(null);

        console.log(arrayNotes)
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
            for (var label in preLabels) {
                var obj = preLabels[label];
                for (var prop in obj) {
                    labels += "<span class='badge badge-dark text-white'>" + obj[prop] + "</span>";
                }

                if (!labSort.includes(obj[prop])) {
                    labSort.push(obj[prop]);
                    labSort.sort();
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
                links += "<div class='mb-1'><a class='mb-3' href='" + obj.url + "'><li class='list-group-item annotation'><img src='resources/img/web.png' style='width: 15px'>&nbsp;<strong>" + title + "</strong></li></a></div>";
            }

            body = true;

        }

        note = buildNote(body, color, images, content, records, links, labels, sharees, userEditedTimestampUsec);
        //NOW YOU HAVE A NOTE WITH TEMPLATE AND CONTENT, TO BE MANAGED AS YOU LIKE

        //no printing docs 
        if (!labels.includes("Docs")) { // REMOVE LINE
            if (isPinned == true) {
                $("#pinned-notes").append(note);
            } else if (isArchived == true) {
                $("#archived-notes").append(note);
            } else if (isTrashed == true) {
                //add code if you want to show trashed notes
            } else {
                $("#regular-notes").append(note);
            }
        }

    }

    function buildNote(body, color, images, content, records, links, labels, sharees, timestamp) {
        var note = "";
        var main = "";
        var footer = "";

        var sectionRecords = "";
        var sectionLinks = "";
        var sectionSharees = "";
        var sectionLabels = "";
        var sectionTimestamp = "";

        if (records != "") {
            sectionRecords = "<div class='records mt-1'>" + records + "</div>";
        }

        if (links != "") {
            sectionLinks = "<div class='links pt-3'>" + links + "</div>";
        }

        if (sharees != "") {
            sectionSharees = "<div class='sharees mt-1'>" + sharees + "</div>";
        }

        if (labels != "") {
            sectionLabels = "<div class='labels mt-1'>" + labels + "</div>";
        }

        sectionTimestamp = "<div class='timestamp'><p class='card-text  text-center'><small class='text-muted'> Edited:&nbsp;&nbsp;" + formatTS(timestamp) + "</small></p></div>";


        if (body == true) {
            main = "<div class='card-body'>" +
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