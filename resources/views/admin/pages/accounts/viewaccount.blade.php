<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            background-color: #f2f2f2;
        }

        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td,
        #customers th {
            border: 1px solid rgb(150, 137, 137);
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #c9c9c9;
            color: rgb(0, 0, 0);
        }
    </style>
</head>

<body>
    <table id="customers">
        <tr>
            <th width="20%">Head Account</th>
            <th width="20%">Category</th>
            <th width="20%">Sub Category</th>
            <th width="20%">Transactional Head</th>
            <th width="15%">Amount</th>
        </tr>
        @foreach($accounts as $account)
        <tr>
            <td>{{$account->account_name}} - {{$account->head_code}}</td>
            <td colspan="4">
                <table style="width: 100%;">
                    @foreach($account->subAccount as $category)
                    <tr>
                        <td style="width: 26%;">{{$category->account_name}} - {{$category->head_code}}</td>
                        <td>
                            <table style="width: 100%;">
                                @foreach($category->subAccount as $subcategory)
                                <tr>
                                    <td style="width: 36%;">{{$subcategory->account_name}} - {{$subcategory->head_code}}
                                    </td>
                                    <td>
                                        <table style="width: 100%;">
                                            @foreach($subcategory->subAccount as $main)
                                            <tr>
                                                <td style="width: 61%;">{{$main->account_name}} - {{$main->head_code}}
                                                </td>
                                                <td style="text-align: right;">{{$main->amount ?? 00.0}}</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </td>
        </tr>
        @endforeach
    </table>

</body>

</html>
