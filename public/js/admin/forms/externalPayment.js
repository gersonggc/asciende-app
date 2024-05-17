if(crud.field){
    const paymentMethodSelect = document.querySelector('#payment_method_id');

     let paymentMethodSelectContainer = paymentMethodSelect.closest('.form-group');
     paymentMethodSelectContainer.innerHTML += '<div class="mt-3" id="payment-method-info"></div>';
     let paymentMethodInfoContainer = document.getElementById('payment-method-info');

    crud.field('payment_method_id').onChange(function(field) {
      if(!field.value)
      {
        paymentMethodInfoContainer.innerHTML = '<p></p>'
      }else{
          var paymentMethodId = field.value;


          fetch(`/admin/external-payment/payment-method/${paymentMethodId}/info`)
            .then(response => response.text())
            .then(data => {

              paymentMethodInfoContainer.innerHTML = data;

            })
            .catch(error => console.error(error));
      }

    }).change();

    crud.field('ammount').onChange(function(field) {
        let convertedAmountElement = document.querySelector('[bp-field-name="converted_amount"]');
        if(!field.value)
        {
            convertedAmountElement.innerHTML = '<p></p>'
        }else{
            const exchangeRateInput = document.querySelector('input[name="exchange_rate"]');

            const exchangeRateValue = new Decimal(exchangeRateInput.value);

            const cleanMask = field.value.replace(/\$/g, "");

            const inputValue = new Decimal(cleanMask.replace(/\./g, "").replace(",", "."));

            const roundedValue = inputValue.mul(exchangeRateValue).toFixed(2).toString();
            // const exchangeRateValue = exchangeRateInput.value;


            // // Obtener el valor del campo de entrada y realizar la conversión
            // const inputValue = parseFloat(field.value);
            // const convertedValue = inputValue * exchangeRateValue;

            // // Redondear el valor resultante a 2 decimales
            // const roundedValue = Math.round(convertedValue * 100) / 100;

            // Actualizar el valor del campo de salida con el valor redondeado
            convertedAmountElement.innerHTML = '<span class="text-success"><b>Total en BS: ' + roundedValue + '</b></span>';

        }

      }).change();
  }
