@forelse($salarys as $key=>$salary)
<tr>
    <th>{{$key+1}}</th>
    <td>{{$salary->date_}}</td>
    <td>{{$salary->reason}}</td>
    <td>{{$salary->createBy->name}}</td>
    <td class="color-primary">{{$salary->amount}}</td>
</tr>
@empty
<tr style="background-color: #e7db2d">
    <td colspan="5" class="text-center">No data Found</td>
</tr>
@endforelse
