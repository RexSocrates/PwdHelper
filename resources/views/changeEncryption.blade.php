<html>
    <head>
        <title>改變加密方式</title>
    </head>
    <head>
        <form action="changeEncryptionMethod" method="post">
            {{ csrf_field() }}
            <label>輸入密文 : </label>
            <input type="text" name="cipherText">
            <br>
            <select name="newEncryptionMethod">
                @foreach($encryptions as $encryption)
                    <option value='{{ $encryption }}'>{{ $encryption }}</option>
                @endforeach
            </select>
            <br>
            <input type="submit" name="submit" value="送出">
        </form>
    </head>
</html>