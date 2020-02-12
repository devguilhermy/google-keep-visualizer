<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>


<script>
    var glob = require("glob");
    var fs = require("fs");

    var _inArray = function(needle, haystack) {
        for (var k in haystack) {
            if (haystack[k] === needle) {
                return true;
            }
        }
        return false;
    }

    glob("Takeout/Keep/*.json", function(err, files) { // read the folder or folders if you want: example json/**/*.json
        if (err) {
            console.log("cannot read the folder, something goes wrong with glob", err);
        }
        var matters = [];
        files.forEach(function(file) {
            fs.readFile(file, 'utf8', function(err, data) { // Read each file
                if (err) {
                    console.log("cannot read the file, something goes wrong with the file", err);
                }
                var obj = JSON.parse(data);
                alert(obj.title)
            });
        });
    });
</script>

</body>

</html>