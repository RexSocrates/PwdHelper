<html>
    <head>
        <title>密碼列表</title>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>

    </head>
    <body>
        <!--測試-->
        <table id="test_id_example" class="display">
            <thead>
                <tr>
                    <th>網站名稱</th>
                    <th>帳號</th>
                    <th>密碼</th>
                </tr>
            </thead>

            <tbody>
                @foreach($pwdList as $pwd)
                    <tr>
                        <td>{{ $pwd['websiteName'] }}</td>
                        <td>{{ $pwd['accountName'] }}</td>
                        <td>{{ $pwd['pwd'] }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td>www.fju.edu.tw</td>
                    <td>haha</td>
                    <td>1234</td>
                </tr>
                <tr>
                    <td>www.google.com</td>
                    <td>jaja</td>
                    <td>4321</td>
                </tr>
                <tr>
                    <td>www.mail.google.com</td>
                    <td>jaja</td>
                    <td>abcd</td>
                </tr>
                <tr>
                    <td>www.firstbank.com.tw</td>
                    <td>yoyo</td>
                    <td>1234</td>
                </tr>
                <tr>
                    <td>www.fubanbank.com.tw</td>
                    <td>mama</td>
                    <td>bcad</td>
                </tr>
                <tr>
                    <td>www.im.fju.edu.tw</td>
                    <td>403987987</td>
                    <td>9487</td>
                </tr>
                <tr>
                    <td>www.project.im.fju.edu.tw</td>
                    <td>hello world</td>
                    <td>test1234</td>
                </tr>
                <tr>
                    <td>www.yahoo.com.tw</td>
                    <td>dodo</td>
                    <td>odod</td>
                </tr>
                <tr>
                    <td>www.gdrive.google.com</td>
                    <td>pipi</td>
                    <td>ipip</td>
                </tr>
                <tr>
                    <td>www.github.com</td>
                    <td>wang</td>
                    <td>123456</td>
                </tr>
                <tr>
                    <td>www.gitlab.com</td>
                    <td>wang</td>
                    <td>654321</td>
                </tr>
                <tr>
                    <td>台灣銀行</td>
                    <td>wang</td>
                    <td>654321</td>
                </tr>
                <tr>
                    <td>輔大銀行</td>
                    <td>wang</td>
                    <td>654321</td>
                </tr>
            </tbody>
        </table>

    <script>
        $(document).ready(function () {
            $('#test_id_example').DataTable();
        });

    </script>

    </body>
</html>