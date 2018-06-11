<html>
    <head>
        <title>加密列表</title>
    </head>
    <body>
        <form action="encrypt" method="post">
            {{ csrf_field() }}
            @if ($update == TRUE)
            
                <label>請輸入網站名稱 : </label>
                <input type="text" name="websiteName" value="{{ $websiteName }}">
                <br>
                
                <label>請輸入帳號名稱 : </label>
                <input type="text" name="accountName" value="{{ $accountName }}">
                <br>
                
                <label>請輸入密碼 : </label>
                <input type="password" name="password" value="{{ $pwd }}">
                <br>
            
            @else
            
                <label>請輸入網站名稱 : </label>
                <input type="text" name="websiteName">
                <br>
                
                <label>請輸入帳號名稱 : </label>
                <input type="text" name="accountName">
                <br>
                
                <label>請輸入密碼 : </label>
                <input type="password" name="password">
                <br>
            
            @endif
<!--
            <label>請輸入網站名稱 : </label>
            <input type="text" name="websiteName">
            <br>
            
            <label>請輸入帳號名稱 : </label>
            <input type="text" name="accountName">
            <br>
            
            <label>請輸入密碼 : </label>
            <input type="password" name="password">
            <br>
-->
            
            <label>加密列表</label>
            
            <select name="encryptionMethod">
                @foreach($encryptions as $encryption)
                    <option value='{{ $encryption }}'>{{ $encryption }}</option>
                @endforeach
            </select>
            <br>
            <input type="submit" name="submit" value="送出">
        </form>
        <a href="/">回主頁面</a>
    </body>
</html>
