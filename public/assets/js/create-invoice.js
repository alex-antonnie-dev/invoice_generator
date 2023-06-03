

  var counter = $('#invoice_create > tbody tr').length;

  function updateSerialNumbers() {
    $('#invoice_create > tbody tr').each(function(index) {
      $(this).find('.slno').text(index + 1);
    });
  }

  const createRow = () => {
    counter++;
    var lastRow = $('#invoice_create > tbody tr:last');
    var newRow = $(`<tr><td>${counter}</td>
            <td><input class='form-control' type='text' name='itemName[]'></td>
            <td><input class='form-control calInput quantity' type='text' name='quantity[]'></td>
            <td><input class='form-control calInput unitPrice' type='number' name='unitPrice[]'></td>
            <td><select class='form-control calInput tax' name='tax[]'>
                    <option value=0>0%</option>
                    <option value=1>1%</option>
                    <option value=5>5%</option>
                    <option value=10>10%</option>
                </select></td>
            <td><span class='unitTotal'></span></td>
            <td><button type='button' class='btn btn-danger deleteItem'>-</td>
        </tr>`);
    lastRow.after(newRow);
  }

  const calculateTotalWithoutTax = () => {
    let subTotalWithoutTax = 0;
    $('#invoice_create > tbody tr').each(function(index) {
        let quanity = parseInt($(this).find('.quantity').val());
        let unitPrice = parseFloat($(this).find('.unitPrice').val());
        if(!isNaN(quanity) && !isNaN(unitPrice))
        subTotalWithoutTax += quanity * unitPrice;
      });
      $('#totalWithoutTax').text(subTotalWithoutTax);
  }

  const calculateTotalWithTax = () => {
    let subTotalWithTax = 0;
    $('#invoice_create > tbody tr').each(function(index) {
        let quanity = parseInt($(this).find('.quantity').val());
        let unitPrice = parseFloat($(this).find('.unitPrice').val());
        if(!isNaN(quanity) && !isNaN(unitPrice)){
            let calcTax = parseFloat($(this).find('.tax').val());
            let total = quanity * unitPrice;

            subTotalWithTax += total + ((total * calcTax) /100);
        }
      });
      $('#totalWithTax').text(subTotalWithTax);
  }

  const calculateGrandTotal = () => {
    let total = parseFloat($('#totalWithTax').text());
    let discountPercentage = $('#discountPercentage').val();
    let discount = (total * discountPercentage) /100;
    let grandTotal = total - discount;
    if(!isNaN(grandTotal))
    $('#grandTotal').text(grandTotal);
  }

  $(document).ready(function() {
    $('#add_item').click(function() {
      createRow();
      updateSerialNumbers();
    });

    $(document).on('click', '.deleteItem', function() {
        console.log("clicked")
        $(this).closest('tr').remove();
      });

      $(document).on('keyup change', '.calInput', function(){
        var row = $(this).closest('tr');
        var quantity = parseInt(row.find('.quantity').val());
        var unitPrice = parseFloat(row.find('.unitPrice').val());
        var tax = parseFloat(row.find('.tax').val());
        var lineTotal = quantity * unitPrice;
        lineTotal = lineTotal ? lineTotal : 0;
        var calcTax = tax > 0 ? (lineTotal * tax) /100 : 0;
        let total = lineTotal + calcTax;
        row.find('.unitTotal').text(total.toFixed(2));

        calculateTotalWithoutTax();
        calculateTotalWithTax();
        calculateGrandTotal();
      })

      $(document).on('keyup', '#discountPercentage', function(){
        calculateGrandTotal();
      })
  });