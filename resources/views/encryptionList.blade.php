<html>
    <head>
        <title>加密列表</title>
    </head>
    <body>
        <form action="encrypt" method="post">
            {{ csrf_field() }}
            
            <label>請輸入密碼：</label>
            <input type="password" name="password">
            
            <br>
            
            <label>加密列表</label>
            
            <select name="encryptionMethod">
                @foreach($encryptions as $encryption)
                    <option value='{{ $encryption }}'>{{ $encryption }}</option>
                @endforeach
            </select>
            <br>
            <input type="submit" name="submit" value="送出">
        </form>
    </body>
</html>
