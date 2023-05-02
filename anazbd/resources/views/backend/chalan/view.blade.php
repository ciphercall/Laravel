<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css" integrity="sha512-oc9+XSs1H243/FRN9Rw62Fn8EtxjEYWHXRvjS43YtueEewbS6ObfXcJNyohjHqVKFPoXXUxwc+q1K7Dee6vv9g==" crossorigin="anonymous" />
<style type="text/css">
    * {margin:0; padding:0; text-indent:0; }
    h1 { color: black; font-family:Calibri, sans-serif; font-style: normal; font-weight: bold; text-decoration: underline; font-size: 14pt; }
    .s1 { color: #212121; font-family:Arial, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 14.5pt; }
    .s2 { color: black; font-family:Calibri, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 11pt; }
    .s3 { color: black; font-family:"Times New Roman", serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 12pt; }
    .s4 { color: #EC4D42; font-family:"Times New Roman", serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 12pt; }
    .s5 { color: #454545; font-family:Arial, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 12pt; }
    .s6 { color: #454545; font-family:Arial, sans-serif; font-style: normal; font-weight: bold; text-decoration: underline; font-size: 8pt; }
    .s7 { color: #454545; font-family:Arial, sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 8pt; }
    p { color: #454545; font-family:Arial, sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 10pt; margin:0pt; }
    table, tbody {vertical-align: top; overflow: visible; }

    @media print {
        #printPageButton {
            display: none;
        }
    }
</style>
<body style="width: fit-content;margin-bottom: 29px;margin-left: 28%;">
<p style="text-indent: 0pt;text-align: left;">
    <br>
</p>

<button class="btn btn-danger" id="printPageButton" onClick="window.print();" style="position: absolute;left: 753pt;">Print</button>
<p style="text-indent: 0pt;text-align: left;">
    <span>
        <img width="127" height="52" alt="image" src="{{asset('backend/assets/images/anazlogo.png')}}">
    </span>
</p>

<h1 style="padding-top: 2pt;padding-left: 0pt;text-indent: 0pt;text-align: center;position: absolute;left: 510pt;">ANAZBD.COM</h1>
<p style="text-indent: 0pt;text-align: left;"><br></p><p style="text-indent: 0pt;text-align: left;">
    <br>
</p>
<table style="border-collapse:collapse" cellspacing="0">
    <tbody>
    <tr style="height:18pt">
        <td style="width: 477pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;" colspan="6">
            <p class="s1" style="padding-left: 109pt;padding-right: 108pt;text-indent: 0pt;line-height: 16pt;text-align: center;">Invoice No.
                {{$chalan->chalan_no}}</p>
        </td>
    </tr>
    <tr style="height:28pt;">
        <td style="width:152pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p class="s2" style="padding-left: 7pt;text-indent: 0pt;text-align: left;">Product Name</p>
        </td>
        <td style="width:45pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p class="s2" style="padding-left: 11pt;padding-right: 9pt;text-indent: 1pt;line-height: 14pt;text-align: left;">Unit Price</p>
        </td>
        <td style="width:45pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p class="s2" style="padding-left: 4pt;padding-right: 4pt;text-indent: 0pt;text-align: center;">Size</p>
        </td>
        <td style="width:40pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p class="s2" style="padding-left: 11pt;text-indent: 0pt;text-align: left;">Qty</p>
        </td>
{{--        <td style="width:50pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">--}}
{{--            <p class="s2" style="padding-left: 16pt;padding-right: 11pt;text-indent: -3pt;line-height: 14pt;text-align: left;">Total Qty</p>--}}
{{--        </td>--}}
        <td style="width:107pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p class="s2" style="padding-left: 4pt;padding-right: 3pt;text-indent: 0pt;text-align: center;">Amount</p>
        </td>
    </tr>

    @foreach($chalan->chalan_items as $item)
{{--@dd($chalan->order)--}}
    <tr style="height:43pt">
        <td style="width:81pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p class="s3" style="padding-left: 8pt;padding-right: 7pt;text-indent: 0pt;line-height: 14pt;text-align: center;">
                {{$item->item->name}}</p>
        </td>
        <td style="width:45pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p style="text-indent: 0pt;text-align: left;">
                <br>
            </p>
            <p class="" style="padding-left: 6pt;text-indent: 0pt;text-align: left;">{{$item->price}}</p>
        </td>
        <td style="width:45pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p style="text-indent: 0pt;text-align: left;">
                <br>
            </p>
            <p class="s3" style="padding-left: 4pt;padding-right: 4pt;text-indent: 0pt;text-align: center;">{{ $item->variant->size != null ? $item->variant->size->name : 'N/A' }}</p>
        </td>
        <td style="width:40pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p style="text-indent: 0pt;text-align: left;">
                <br>
            </p>
            <p class="s3" style="padding-left: 9pt;text-indent: 0pt;text-align: left;">{{$item->qty}}</p>
        </td>
{{--        <td style="width:50pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">--}}
{{--            <p style="text-indent: 0pt;text-align: left;">--}}
{{--                <br>--}}
{{--            </p>--}}
{{--            <p class="s3" style="padding-left: 11pt;text-indent: 0pt;text-align: left;">1 KG</p>--}}
{{--        </td>--}}
        <td style="width:57pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p style="text-indent: 0pt;text-align: left;">
                <br>
            </p>
            <p class="s3" style="padding-left: 4pt;padding-right: 3pt;text-indent: 0pt;text-align: center;">{{$item->subtotal}}/-</p>
        </td>
    </tr>

    @endforeach
    <tr style="height: 16pt;">
        <td style="width:261pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="4">
            <p class="s5" style="padding-left: 95pt;padding-right: 94pt;text-indent: 0pt;line-height: 13pt;text-align: center;">SUB TOTAL</p>
        </td>
        <td style="width: 60pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;" colspan="2">
            <p class="s5" style="padding-left: 5pt;text-indent: 0pt;line-height: 13pt;text-align: left;">{{$chalan->subtotal}}/-</p>
        </td>
    </tr>
    </tbody>
</table>
<table style="border-collapse:collapse;top: 23pt;position: relative;width: 479pt;" cellspacing="0">
    <tbody>
    <tr style="height:126pt">
        <td style="width:160pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p class="s6" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">SUMMARY</p>
            <p style="text-indent: 0pt;text-align: left;">
                <br>
            </p>
            <p class="s7" style="padding-left: 5pt;padding-right: 44pt;text-indent: 0pt;line-height: 166%;text-align: left;">Subtotal ({{$chalan->chalan_items->count()}} items): {{$chalan->subtotal}} TK
                <br> Delivery Charge:
                {{$chalan->shipping_charge}} TK </p>

                @if($chalan->order->user_coupon != null)
                    <p class="s7" style="padding-left: 5pt;padding-right: 44pt;text-indent: 0pt;line-height: 166%;text-align: left;"> Coupon :
                    {{$chalan->order->user_coupon->name}}</p>
                    <p class="s7" style="padding-left: 5pt;padding-right: 44pt;text-indent: 0pt;line-height: 166%;text-align: left;">Coupon Discount:
                    {{ $chalan->order->user_coupon->value}} TK</p><br>
                @else
                <br>
                @endif
            <p class="s7" style="padding-left: 5pt;text-indent: 0pt;line-height: 9pt;text-align: left; font-size: 13pt; font-weight: bold">Total Payable: {{$chalan->total }} TK</p>
        </td>
        <td style="width:211pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
            <p class="s6" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">BILLING DETAILS</p>
            <p style="text-indent: 0pt;text-align: left;">
                <br>
            </p>
            <p class="s7" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">Customer Name: {{$chalan->order->user->name}}</p>
            <p class="s7" style="padding-top: 6pt;padding-left: 5pt;padding-right: 49pt;text-indent: 0pt;text-align: left;">Shipping Address:
                {{$chalan->order->billing_address->complete_address}}</p>
            <p class="s7" style="padding-top: 5pt;padding-left: 5pt;padding-right: 78pt;text-indent: 0pt;line-height: 166%;text-align: left;">Phone Number:
                {{$chalan->order->user->mobile}} <br> Payment Method:

                <b>@switch($chalan->order->type)
                        @case("cash")
                        Cash on delivery
                        @break

                        @case("gateway")
                        Payment Gateway
                        @break

                        @default
                        <span>Something went wrong, please try again</span>
                    @endswitch</b>

            </p>
{{--            <p class="s7" style="padding-left: 5pt;padding-right: 54pt;text-indent: 0pt;text-align: left;">Billing Address:--}}
{{--                {{$chalan->order->billing_address->complete_address}}</p>--}}
        </td>
    </tr>
    </tbody>
</table>
<p style="padding-left: 6pt;text-indent: 0pt;text-align: left;">
    <span style=" color: black; font-family:Calibri, sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 10pt;">
    </span>
</p>
<p style="text-indent: 0pt;text-align: left;">
    <br>
</p>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<p style="padding-left: 5pt;text-indent: 0pt;line-height: 1pt;text-align: left;">
    <span>
        <img width="166" height="1" alt="image" src="{{asset('backend/assets/images/signature_bar.png')}}">
    </span>
</p>
<p style="padding-top: 1pt;padding-left: 6pt;text-indent: 0pt;text-align: left;">CUSTOMER SIGNATURE</p>
<div style="
    margin-left: 356px;
    margin-top: -119px;
"><svg class="barcode" jsbarcode-format="auto" jsbarcode-value={{$chalan->chalan_no}} jsbarcode-textmargin="0" jsbarcode-fontoptions="bold">
    </svg></div>


</body>
<script src="{{asset('backend/js/JsBarcode.all.min.js')}}"></script>
<script>
    JsBarcode(".barcode").init();
</script>
