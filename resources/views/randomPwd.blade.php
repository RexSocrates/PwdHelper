<html>
    <head>
        <title>隨機密碼</title>
    </head>
    <body>
        <form action="randomPwd" method="post">
            {{ csrf_field() }}
            <label>網站名稱 : </label>
            <input type="text" name="website">
            <br>
            
            <label>帳號名稱 : </label>
            <input type="text" name="account">
            <br>
            
            <label>密碼長度 : </label>
            <input type="number" name="pwdLength">
            <br>
            
            <input type="checkbox" name="rule[]" value="1">數字<br>
            <input type="checkbox" name="rule[]" value="2">大寫英文字母<br>
            <input type="checkbox" name="rule[]" value="3">小寫英文字母<br>
            <input type="checkbox" name="rule[]" value="4">特殊符號<br>
            <br>
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