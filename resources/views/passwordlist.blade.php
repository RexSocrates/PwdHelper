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
            </tbody>
        </table>

    <script>
        $(document).ready(function () {
            $('#test_id_example').DataTable();
        });

    </script>

    </body>
</html>