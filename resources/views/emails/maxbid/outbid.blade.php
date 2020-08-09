@include('emails.template.head')

@include('emails.template.header')

<!-- 1 Column Text + Button : BEGIN -->
<tr>
    <td style="background-color: #ffffff;">
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
            <tr>
                <td style="padding: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                    <h1 style="margin: 0 0 10px; font-size: 20px; line-height: 30px; color: #333333; font-weight: normal; text-align:center; text-transform: uppercase;">
                        You have been outbid</h1>
                    <p style="margin: 10px 0; text-align:center; font-size:14px;">
                        <strong>New High Bid: ${{$auction->current_price}}</strong> | Auction
                        ends: {{$auction->end_date}}
                    </p>
                </td>

            </tr>
        </table>
    </td>
</tr>
<!-- 1 Column Text + Button : END -->

<tr>
    <td style="background-color: #ffffff;">
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
            <tr>
                <td style="padding: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                    <h5 style="margin:0">ITEM # {{$product->sku}}</h5>
                    <h2 style="margin: 0; font-size: 15px; line-height: 19px; color: #333333; font-weight: normal;">
                        {{$product->name}}</h2>
                </td>

            </tr>
        </table>
    </td>
</tr>
<!-- 2 Even Columns : BEGIN -->
<tr>
    <td align="center" valign="top" style="font-size:0; padding: 10px; background-color: #ffffff;">
        <!--[if mso]>
        <table role="presentation" border="0" cellspacing="0" cellpadding="0" width="660">
            <tr>
                <td valign="top" width="275">
        <![endif]-->
        <div
            style="display:inline-block; margin: 0 -1px; width:100%; min-width:200px; max-width:275px; vertical-align:top;"
            class="stack-column">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td style="padding: 10px;">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                               style="font-size: 14px; text-align: left;">
                            <tr>
                                <td>
                                    <a href="{{$product->product_url}}">
                                    <img src="https://via.placeholder.com/300" width="310" border="0"
                                         alt="alt_text"
                                         style="width: 100%; max-width: 310px; height: auto; background: #dddddd; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;"
                                         class="center-on-narrow">
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <!--[if mso]>
        </td>
        <td valign="top" width="385">
        <![endif]-->
        <div
            style="display:inline-block; margin: 0 -1px; width:100%; min-width:200px; max-width:385px; vertical-align:top;"
            class="stack-column">
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                <tr>
                    <td style="padding: 10px;">
                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                               style="font-size: 14px;text-align: left;">
                            <tr>
                                <td style="font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555; padding-top: 10px;"
                                    class="stack-column-center">
                                    <h3 style="margin:0 auto 10px;">Current Price: ${{$auction->current_price}} {{$store->currency}}</h3>
                                    <h5 style="margin:0 auto 15px;">This auction ends on {{$auction->end_date}}</h5>
                                    <a class="button-a button-a-primary" href="{{$product->product_url}}"
                                       style="font-family: sans-serif; font-size: 15px; line-height: 15px; text-align:center; text-decoration: none; padding: 13px 17px; display: block;">Place
                                        Bid</a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <!--[if mso]>
        </td>
        </tr>
        </table>
        <![endif]-->
    </td>
</tr>
<!-- 2 Even Columns : END -->

<tr>
    <td style="background-color: #ffffff;">
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
            <tr>
                <td style="padding: 20px; font-family: sans-serif; font-size: 15px; line-height: 20px; color: #555555;">
                    <p>{{$product->description}}</p>
                </td>
            </tr>
        </table>
    </td>
</tr>

<!-- Clear Spacer : BEGIN -->
<tr>
    <td aria-hidden="true" height="40" style="font-size: 0px; line-height: 0px;">
        &nbsp;
    </td>
</tr>
<!-- Clear Spacer : END -->


</table>
<!-- Email Body : END -->

@include('emails.template.footer')
