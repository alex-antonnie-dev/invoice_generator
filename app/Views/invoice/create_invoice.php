<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Create invoice</title>
</head>
<body>
    <h1>Create Invoice</h1>
    <form method='post' action='<?php echo base_url("/invoice/save");?>'>
    <table class="table" id='invoice_create'>
        <thead>
            <tr>
                <th colspan="3">Calculator<th>
                <th>
                    <button type='button' class='btn btn-primary' id='add_item'>Add item</button>
                </th>
            </tr>
            <tr>
                <td>Slno</td>
                <td>Name</td>
                <td>Quantity</td>
                <td>Price</td>
                <td>Tax</td>
                <td>Total</td>
                <td>Actions</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td><input class='form-control' type='text' name='itemName[]'></td>
                <td><input class='form-control calInput quantity' type='text' name='quantity[]'></td>
                <td><input class='form-control calInput unitPrice' type='number' name='unitPrice[]'></td>
                <td><select class='form-control calInput tax' name='tax[]'>
                    <option value=0>0%</option>
                    <option value=1>1%</option>
                    <option value=5>5%</option>
                    <option value=10>10%</option>
                </select></td>
                <td><span class='unitTotal'></span>$</td>
                <td><button type='button' class='btn btn-danger deleteItem'>-</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>SubTotal without tax :</td><td> <span id='totalWithoutTax'></span>$</td>
                <td>SubTotal including tax :</td><td> <span id='totalWithTax'></span>$</td>
                <td>Discount(%) : <input type='number' class='form-control' name='discountPercentage' id='discountPercentage'></td>
            </tr>
            <tr>
                <td><b>Grand Total</b> : <span id='grandTotal'></span>$</td>
                <td><button type='submit' class='btn btn-success'>Submit</button></td>
            </tr>
        </tfoot>
    </table>
    </form>
        <script src='<?= base_url("assets/js/create-invoice.js") ?>'></script>
</body>
</html>