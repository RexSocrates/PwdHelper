<html>
    <head>
        <title>File upload</title>
    </head>
    <body>
        <form action="fileUpload" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <label>Choose you file to upload : </label>
            <br>
            <input type="text" name="text">
            <br>
            <input type="file" name="keyFile" id="keyFile">
            <br>
            <input type="submit" value="Submit">
        </form>
    </body>
</html>