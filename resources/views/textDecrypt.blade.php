<html>
    <head>
        <title>Decryption Page</title>
    </head>
    
    <body>
        <form action="decrypt" method="post">
            {{ csrf_field() }}
            <label>輸入密文：</label>
            <br>
            <input type="text" name="cypherText">
            <br>
            <input type="submit" name="submit" value="送出">
        </form>
    </body>
</html>