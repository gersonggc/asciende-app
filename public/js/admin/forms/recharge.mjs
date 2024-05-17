
if(crud.field){
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

            convertedAmountElement.innerHTML = '<span class="text-success"><b>Total en BS: ' + roundedValue + '</b></span>';

        }

    }).change();

    function disableFormElements() {
        const formInputs = document.forms[0].querySelectorAll('input:not(#search-card-input):not([name="exchange_rate"])');
        const formButtons = document.forms[0].querySelectorAll('button:not(#search-card-btn)');

        formInputs.forEach(input => input.setAttribute('disabled', 'disabled'));
        formButtons.forEach(button => button.setAttribute('disabled', 'disabled'));
      }

      function enableFormElements() {
        // const formInputs = document.forms[0].querySelectorAll('input:not(#search-card-input)');
        const formInputs = document.forms[0].querySelectorAll('input:not(#search-card-input):not([name="exchange_rate"])');

        const formButtons = document.forms[0].querySelectorAll('button:not(#search-card-btn)');

        formInputs.forEach(input => input.removeAttribute('disabled'));
        formButtons.forEach(button => button.removeAttribute('disabled'));
      }


    disableFormElements();

    const searchCardInput = document.querySelector('#search-card-input');
    searchCardInput.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('search-card-input');
        const searchButton = document.getElementById('search-card-btn');
        if (searchInput.value) {
            searchButton.click();
        }
    });

    const btnSearch = document.querySelector('#search-card-btn')
    btnSearch.addEventListener('click', function() {
        let containerCardInfo = document.querySelector('[bp-field-name="card_info"]');
        let cardCode = document.querySelector('#search-card-input').value.trim();
        console.log(cardCode , 'adasdasd')
        fetch(`/admin/recharge/search_card`,{
            headers:{
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              },
              method:'POST',
              body: JSON.stringify({ card_code: cardCode })
        })
        .then(response => response.text())
        .then(data => {
            containerCardInfo.innerHTML = data;
            const cardIdInput = document.querySelector('#card_id');

            if (cardIdInput && cardIdInput.value ) {
                enableFormElements();
            } else {
                disableFormElements();
            }

        })
        .catch(error => {
            console.error(error);
            containerCardInfo.innerHTML = '<p>Hubo un error al buscar la tarjeta</p>';
            disableFormElements();
        });

    });

}
