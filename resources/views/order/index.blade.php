<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/minishop.css')}}">
    <title>ショッピングサイト</title>
</head>
<body>
    <p>お買い上げありがとうございました。<br>
        またのご利用をお待ちしております。</p>
    <table>
        <tr>
            <th>&nbsp;</th>
            <th>商品名</th>
            <th>メーカー・著者<br>アーティスト</th>
            <th>価格</th>
            <th>注文数</th>
            <th>金額</th>
        </tr>
        @php
            $total = 0;
        @endphp
        @foreach( $carts  as  $cart )
            <tr>
                <td class="td_mini_img"><img class="mini_img" src="{{ asset('images/'.$cart->item->image )}}"></td>
                <td class="td_item_name"> {{ $cart->item->name }} </td>
                <td class="td_item_maker"> {{ $cart->item->maker }} </td>
                <td class="td_right">&yen; {{  number_format( $cart->item->price) }} </td>
                <td class="td_right"> {{ $cart->quantity }} </td>
                <td class="td_right">&yen; {{ number_format( $cart->item->price * $cart->quantity) }}</td>
            </tr>
            @php
                $total += $cart->item->price * $cart->quantity;
            @endphp
        @endforeach
        <tr>
            <th colspan="5">合計金額</th><td class="td_right">&yen; {{ number_format($total) }}</td>
        </tr>
    </table>
    <br>
    <a href="{{ route('index') }}">ジャンル選択に戻る</a>
</body>
</html>
